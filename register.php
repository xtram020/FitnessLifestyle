<?php
session_start();
require __DIR__ . "/inc/db.php";

$msg = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $name  = trim($_POST["name"] ?? "");
  $email = trim($_POST["email"] ?? "");
  $pass  = $_POST["password"] ?? "";

  if ($name && $email && $pass) {
    $hash = password_hash($pass, PASSWORD_DEFAULT);

    try {
      $stmt = $pdo->prepare("INSERT INTO users (name, email, password_hash) VALUES (?, ?, ?)");
      $stmt->execute([$name, $email, $hash]);
      $msg = "Registrace OK. Teď se přihlaš.";
    } catch (Throwable $e) {
      $msg = "Registrace se nepovedla (možná email už existuje).";
    }
  } else {
    $msg = "Vyplň všechna pole.";
  }
}
?>
<!doctype html>
<html lang="cs">
<head><meta charset="utf-8"><title>Registrace</title></head>
<body>
  <h1>Registrace</h1>
  <?php if ($msg) echo "<p>$msg</p>"; ?>

  <form method="post">
    <input name="name" placeholder="Jméno" required><br><br>
    <input name="email" type="email" placeholder="Email" required><br><br>
    <input name="password" type="password" placeholder="Heslo" required><br><br>
    <button>Registrovat</button>
  </form>

  <p><a href="login.php">Přihlášení</a></p>
</body>
</html>
