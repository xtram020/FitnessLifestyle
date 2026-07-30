<?php
session_start();
require __DIR__ . "/inc/db.php";

$msg = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $email = trim($_POST["email"] ?? "");
  $pass  = $_POST["password"] ?? "";

  $stmt = $pdo->prepare("SELECT id, name, password_hash, role FROM users WHERE email = ?");
  $stmt->execute([$email]);
  $u = $stmt->fetch();

if ($u && password_verify($pass, $u["password_hash"])) {
    $_SESSION["user_id"] = (int)$u["id"];
    $_SESSION["name"] = $u["name"];
    $_SESSION["role"] = $u["role"];

    switch ($u["role"]) {
        case "admin":
            header("Location: admin/index.php");
            break;

        case "trainer":
            header("Location: trainer/reservations.php");
            break;

        default: // user
            header("Location: trainers.php");
            break;
    }
    exit;

  } else {
    $msg = "Špatný email nebo heslo.";
  }
}



?>
<!doctype html>
<html lang="cs">
<head><meta charset="utf-8"><title>Přihlášení</title></head>
<body>
  <h1>Přihlášení</h1>
  <?php if ($msg) echo "<p>$msg</p>"; ?>

  <form method="post">
    <input name="email" type="email" placeholder="Email" required><br><br>
    <input name="password" type="password" placeholder="Heslo" required><br><br>
    <button>Přihlásit</button>
  </form>

  <p><a href="register.php">Registrace</a></p>
</body>
</html>
