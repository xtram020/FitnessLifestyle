<?php
session_start();
require __DIR__ . "/inc/db.php";

if (!isset($_SESSION["user_id"])) {
  header("Location: contact.php?view=login");
  exit;
}

$userId = (int)$_SESSION["user_id"];

$sql = "
  SELECT
    r.id,
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
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!doctype html>
<html lang="cs">
<head>
  <meta charset="utf-8">
  <title>Moje rezervace</title>
  <link rel="stylesheet" href="css/style.css">
<link rel="stylesheet" href="css/user_reservations.css">
</head>
<body>
   
  <h1>Moje rezervace</h1>
<div class="table-wrap">
  <table class="reservations-table">
    <thead>
      <tr>
        <th>Datum</th>
        <th>Čas</th>
        <th>Trenér</th>
        <th>Poznámka / typ lekce</th>
        <th>Stav</th>
      </tr>
    </thead>
    <tbody>
      <?php if (!$rows): ?>
        <tr><td colspan="5">Zatím žádné rezervace.</td></tr>
      <?php else: ?>
        <?php foreach ($rows as $r): ?>
          <?php $dt = new DateTime($r["start_datetime"]); ?>
          <tr>
            <td><?= $dt->format("d.m.Y") ?></td>
            <td><?= $dt->format("H:i") ?></td>
            <td><?= htmlspecialchars($r["trainer_name"]) ?></td>
            <td><?= htmlspecialchars($r["note"] ?? "") ?></td>
            <td><?= htmlspecialchars($r["status"]) ?></td>
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

</body>
</html>
