<?php
session_start();
require_once __DIR__ . "/inc/db.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: contact.php?view=login&next=" . urlencode($_SERVER["REQUEST_URI"]));
    exit;
}


if (($_SESSION['role'] ?? '') !== 'user') {
  http_response_code(403);
  exit("Přístup odepřen.");
}

$userId = (int)$_SESSION['user_id'];
$trainerId = (int)($_POST['trainer_id'] ?? $_GET['trainer_id'] ?? 0);


$stmt = $pdo->prepare("SELECT id, name FROM users WHERE id = ? AND role = 'trainer'");
$stmt->execute([$trainerId]);
$trainer = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$trainer) {
  http_response_code(404);
  exit("Trenér nenalezen.");
}

$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $dt = trim($_POST['start_datetime'] ?? '');
  $note = trim($_POST['note'] ?? '');

  if ($dt === '') {
    $error = "Vyber datum a čas.";
  } else {
    $ins = $pdo->prepare("
      INSERT INTO reservations (user_id, trainer_id, start_datetime, note, status)
      VALUES (?, ?, ?, ?, 'pending')
    ");
    $ins->execute([$userId, $trainerId, $dt, $note]);

    header("Location: reservations.php");
    exit;
  }
}
?>

<!DOCTYPE html>
<html lang="cs">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Vytvořit rezervaci</title>
  <link rel="stylesheet" href="css/create_reservations.css">
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
<?php require_once __DIR__ . "/inc/navbar.php"; ?>

  <section class="reservation-page">
    <div class="reservation-card">
      <h1>Rezervace u trenéra: <?= htmlspecialchars($trainer['name']) ?></h1>

      <?php if ($error): ?>
        <div class="reservation-error"><?= htmlspecialchars($error) ?></div>
      <?php endif; ?>

      <form method="post" class="reservation-form">
        <div class="form-row">
          <label for="start_datetime">Datum a čas</label>
          <input id="reservation_date" type="date" data-trainer="<?= (int)$trainerId ?>" required> 
          <div class="form-hint">Nejprve vyber datum, potom čas.</div>

          <div id="timeSlots" class="time-slots">
          <div class="slots-placeholder">Vyber datum.</div>
          <input type="hidden" name="start_datetime" id="start_datetime" required>
          </div>

        </div>

        <div class="form-row">
          <label for="note">Poznámka / typ lekce</label>
          <input id="note" type="text" name="note" placeholder="např. silový trénink">
        </div>

        <div class="form-actions">
          <button type="submit" class="btn">Odeslat žádost</button>
          <a class="btn" href="reservations.php" style="background: transparent; color: var(--main-color); border: 2px solid var(--main-color); box-shadow: none;">Zpět</a>
        </div>
      </form>
    </div>
  </section>

  <script src="js/app.js"></script>
</body>
</html>
