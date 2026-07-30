<?php
declare(strict_types=1);

require __DIR__ . '/inc/auth.php';
require_role(['admin']);          

require __DIR__ . '/inc/db.php';  

$stmt = $pdo->query("
  SELECT id, name, email, message, created_at
  FROM contact_messages
  ORDER BY created_at DESC
");
$messages = $stmt->fetchAll();
?>



<!doctype html>
<html lang="cs">
<head>
  <meta charset="UTF-8">
  <title>Admin – Zprávy</title>
  <style>
    body{font-family:system-ui;background:#141414;color:#fff;padding:24px}
    .card{border:1px solid rgba(199,250,255,.18);border-radius:12px;padding:14px;margin:12px 0}
    .meta{opacity:.8;font-size:.9rem;margin-bottom:8px}
    pre{white-space:pre-wrap;margin:0}
    a{color:#C7FAFF;text-decoration:none}
  </style>
</head>
<body>

  <h1>Příchozí zprávy</h1>
  <p><a href="contact.php">← zpět</a></p>


<?php foreach ($messages as $m): ?>
    <div class="card">
      <div class="meta">
        <strong><?= htmlspecialchars($m['name']) ?></strong>
        • <?= htmlspecialchars($m['email']) ?>
        • <?= htmlspecialchars((string)$m['created_at']) ?>
      </div>
      <pre><?= htmlspecialchars($m['message']) ?></pre>
    </div>
<?php endforeach; ?>

</body>
</html>
