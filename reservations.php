<?php
session_start();
require_once __DIR__ . "/inc/db.php";






// změna stavu rezervace (trainer/admin) 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $role = $_SESSION['role'] ?? '';
    $userId = (int)($_SESSION['user_id'] ?? 0);

    if (!in_array($role, ['trainer', 'admin'], true)) {
        http_response_code(403);
        exit('Přístup odepřen.');
    }

    $resId = (int)($_POST['reservation_id'] ?? 0);
    $action = $_POST['action'] ?? '';

    if (!in_array($action, ['confirm', 'cancel'], true)) {
        http_response_code(400);
        exit('Neplatná akce.');
    }

    $newStatus = ($action === 'confirm') ? 'confirmed' : 'cancelled';

    if ($role === 'admin') {
        $upd = $pdo->prepare("UPDATE reservations SET status = ? WHERE id = ?");
        $upd->execute([$newStatus, $resId]);
    } else {
        // trainer_id = jeho id
        $upd = $pdo->prepare("UPDATE reservations SET status = ? WHERE id = ? AND trainer_id = ?");
        $upd->execute([$newStatus, $resId, $userId]);
    }

    header("Location: reservations.php");
    exit;
}



if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit;
}

$userId = (int)$_SESSION['user_id'];
$role = $_SESSION['role'] ?? 'user';

if ($role === 'trainer') {
  $sql = "
    SELECT
      r.id AS id,   
      r.start_datetime,
      r.status,
      r.note,
      u.name AS client_name
    FROM reservations r
    JOIN users u ON u.id = r.user_id
    WHERE r.trainer_id = ?
    ORDER BY r.start_datetime DESC
  ";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([$userId]);
} else {
  $sql = "
    SELECT
      r.id AS id, 
      r.start_datetime,
      r.status,
      r.note,
      t.name AS trainer_name
    FROM reservations r
    JOIN users t ON t.id = r.trainer_id
    WHERE r.user_id = ?
    ORDER BY r.start_datetime DESC
  ";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([$userId]);
}

$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!doctype html>
<html lang="cs">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Rezervace</title>
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/reservations.css">

</head>
<body>
<div class="wrap">
  <h1>Rezervace</h1>

  <div class="table-wrap">
  <table>
    <thead>
      <tr>
        <th>Datum</th>
        <th>Čas</th>
        <th>Poznámka / typ lekce</th>
        <?php if ($role === 'trainer'): ?>
          <th>Klient</th>
        <?php else: ?>
          <th>Trenér</th>
        <?php endif; ?>
        <th>Stav</th>

        <?php if (in_array($role, ['trainer','admin'], true)): ?>
        <th>Akce</th>
        <?php endif; ?>

      </tr>
    </thead>

    <tbody>
    <?php if (!$rows): ?>
     <tr><td colspan="<?= in_array($role, ['trainer','admin'], true) ? 6 : 5 ?>">Zatím žádné rezervace.</td></tr>
    <?php else: ?>
      <?php foreach ($rows as $r): 
        $dt = new DateTime($r['start_datetime']);
      ?>
        <tr>
          <td><?= $dt->format('d.m.Y') ?></td>
          <td><?= $dt->format('H:i') ?></td>
          <td><?= htmlspecialchars($r['note'] ?? '') ?></td>

          <?php if ($role === 'trainer'): ?>
            <td><?= htmlspecialchars($r['client_name']) ?></td>
          <?php else: ?>
            <td><?= htmlspecialchars($r['trainer_name']) ?></td>
          <?php endif; ?>

          <td><?= htmlspecialchars($r['status']) ?></td>

          <?php if (in_array($role, ['trainer','admin'], true)): ?>
  <td>
    <?php if ($r['status'] === 'pending'): ?>
     <form method="post" style="display:inline;">
  <input type="hidden" name="reservation_id" value="<?= (int)($r['id'] ?? 0) ?>">
  <input type="hidden" name="action" value="confirm">
  <button type="submit">Potvrdit</button>
</form>

<form method="post" style="display:inline;">
  <input type="hidden" name="reservation_id" value="<?= (int)($r['id'] ?? 0) ?>">
  <input type="hidden" name="action" value="cancel">
  <button type="submit">Zrušit</button>
</form>

    <?php else: ?>
      —
    <?php endif; ?>
  </td>
<?php endif; ?>

        </tr>
      <?php endforeach; ?>
    <?php endif; ?>
    </tbody>
  </table>
  </div>


  <div class="bottom-actions">
  <a href="trainers.php" class="btn-back">← Zpět na trenéry</a>
  <a href="logout.php" class="btn-logout">Logout</a>
</div>

</div>

</body>

</html>
