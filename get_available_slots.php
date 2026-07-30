<?php
session_start();
require_once __DIR__ . "/inc/db.php";

header('Content-Type: application/json; charset=utf-8');

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['error' => 'Nepřihlášený uživatel.']);
    exit;
}

if (($_SESSION['role'] ?? '') !== 'user') {
    http_response_code(403);
    echo json_encode(['error' => 'Přístup odepřen.']);
    exit;
}

$trainerId = (int)($_GET['trainer_id'] ?? 0);
$date = trim($_GET['date'] ?? '');

if ($trainerId <= 0 || $date === '') {
    http_response_code(400);
    echo json_encode(['error' => 'Chybí trainer_id nebo date.']);
    exit;
}

$selectedDate = DateTime::createFromFormat('Y-m-d', $date);
if (!$selectedDate || $selectedDate->format('Y-m-d') !== $date) {
    http_response_code(400);
    echo json_encode(['error' => 'Neplatný formát data.']);
    exit;
}

/*
  1 = pondělí
  2 = úterý
  7 = neděle
*/
$dayOfWeek = (int)$selectedDate->format('N');


$sqlAvailability = "
    SELECT start_time, end_time, slot_length
    FROM trainer_availability
    WHERE trainer_id = ?
      AND day_of_week = ?
    ORDER BY start_time ASC
";
$stmtAvailability = $pdo->prepare($sqlAvailability);
$stmtAvailability->execute([$trainerId, $dayOfWeek]);
$availabilityRows = $stmtAvailability->fetchAll(PDO::FETCH_ASSOC);

if (!$availabilityRows) {
    echo json_encode([]);
    exit;
}

/*
  Pending i confirmed blokují termín.
  Cancel termín neblokuje
*/
$sqlBusy = "
    SELECT start_datetime
    FROM reservations
    WHERE trainer_id = ?
      AND DATE(start_datetime) = ?
      AND status IN ('pending', 'confirmed')
";
$stmtBusy = $pdo->prepare($sqlBusy);
$stmtBusy->execute([$trainerId, $date]);
$busyRows = $stmtBusy->fetchAll(PDO::FETCH_ASSOC);

$busyTimes = [];
foreach ($busyRows as $row) {
    $busyTimes[] = (new DateTime($row['start_datetime']))->format('H:i');
}

/*
  3) Vygenerování slotů z dostupnosti
*/
$availableSlots = [];

foreach ($availabilityRows as $row) {
    $startTime = $row['start_time'];          
    $endTime = $row['end_time'];              
    $slotLength = (int)($row['slot_length'] ?? 60);

    if ($slotLength <= 0) {
        $slotLength = 60;
    }

    $slotStart = new DateTime($date . ' ' . $startTime);
    $availabilityEnd = new DateTime($date . ' ' . $endTime);

    while ($slotStart < $availabilityEnd) {
        $slotEnd = clone $slotStart;
        $slotEnd->modify("+{$slotLength} minutes");

       
        if ($slotEnd <= $availabilityEnd) {
            $slotLabel = $slotStart->format('H:i');

            if (!in_array($slotLabel, $busyTimes, true)) {
                $availableSlots[] = $slotLabel;
            }
        }

        $slotStart->modify("+{$slotLength} minutes");
    }
}

$availableSlots = array_values(array_unique($availableSlots));

echo json_encode($availableSlots);