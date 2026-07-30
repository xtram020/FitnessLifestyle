<?php
session_start();
require_once __DIR__ . "/inc/db.php";

$msg  = "";
$view = $_GET["view"] ?? "login"; // login, register

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $action = $_POST["action"] ?? "";

  
  if ($action === "login") {
    $email = trim($_POST["email"] ?? "");
    $pass  = $_POST["password"] ?? "";

    $stmt = $pdo->prepare("SELECT id, name, password_hash, role FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $u = $stmt->fetch();

    if ($u && password_verify($pass, $u["password_hash"])) {
      $_SESSION["user_id"] = (int)$u["id"];
      $_SESSION["name"]    = $u["name"];
      $_SESSION["role"]    = $u["role"];

      switch ($u["role"]) {
        case "admin":
          header("Location: index.php");
          break;
        case "trainer":
          header("Location: trainers.php");
          break;
        default:
          header("Location: trainers.php");
          break;
      }
      exit;
    } else {
      $msg = "Špatný email nebo heslo.";
      $view = "login";
    }
  }

  
  if ($action === "register") {
    $name  = trim($_POST["name"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $pass  = $_POST["password"] ?? "";

    if ($name && $email && $pass) {
      $hash = password_hash($pass, PASSWORD_DEFAULT);

      try {
        $stmt = $pdo->prepare("INSERT INTO users (name, email, password_hash) VALUES (?, ?, ?)");
        $stmt->execute([$name, $email, $hash]);
        $msg = "Registrace OK. Teď se přihlaš.";
        $view = "login";
      } catch (Throwable $e) {
        $msg = "Registrace se nepovedla (možná email už existuje).";
        $view = "register";
      }
    } else {
      $msg = "Vyplň všechna pole.";
      $view = "register";
    }
  }
}
?>

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/contact.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" >

</head>


<body>
<?php require_once __DIR__ . "/inc/navbar.php"; ?>
    
<section class="contact">
  <div class="content">
    <h2>Kontaktuje nás</h2>
    <p>Máte pocit, že se neposouváte tak rychle, jak byste chtělí? Ozvěte se nám a společně najdeme řešení. </p>
  </div>
                            
  <div class="container">
    <div class="info">

      <div class="box">
      <div class="icon"><b></b><i class="fa-solid fa-map-pin"></i></div>
        <div class="text">
          <h3>Address</h3>
          <p>Svornosti 9,<br>Prague 5, 160 00</p>
        </div>
      </div>


      <div class="box">
      <div class="icon"><b></b><i class="fa-solid fa-phone"></i></div>
        <div class="text">
          <h3>Phone</h3>
          <p>606728649</p>
        </div>
      </div>


      <div class="box">
      <div class="icon"><b></b><i class="fa-solid fa-envelope"></i></div>
        <div class="text">
          <h3>Email</h3>
          <p>fitnesslifestyle@email.cz</p>
        </div>
      </div>

          <h2 class="txt">Connect with us</h2>
          <ul class="sci">
            <li><a href="#"><i class="fa-brands fa-facebook"></i></a></li>
            <li><a href="#"><i class="fa-brands fa-instagram"></i></a></li>
            <li><a href="#"><i class="fa-brands fa-linkedin"></i></a></li>
          </ul>


<div class="map">
  <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2560.995545314557!2d14.406877776660142!3d50.067645071521554!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x470b9500475b6717%3A0x89df34deeadcaa89!2sNext.Move%20Fitness%20Club%20Sm%C3%ADchov!5e0!3m2!1scs!2scz!4v1734561793161!5m2!1scs!2scz" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
</div>
        
  </div>

<div class="rightCol">
  <div class="contactForm auth">

  <?php if ($msg): ?>
    <div class="auth__msg">
      <?= htmlspecialchars($msg) ?>
    </div>
  <?php endif; ?>

  <?php if ($view === "register"): ?>
    <form method="post" class="auth__form">
      <h2>Registrace</h2>
      <input type="hidden" name="action" value="register">

    <div class="inputBox">
      <input type="text" name="name" required>
      <span>Jméno</span>
    </div>

    <div class="inputBox">
      <input type="email" name="email" required>
      <span>Email</span>
    </div>

    <div class="inputBox">
      <input type="password" name="password" required>
      <span>Heslo</span>
    </div>

      <button type="submit" class="auth__btn">Registrovat</button>
      <p class="auth__switch">
        Už máš účet? <a href="contact.php?view=login">Přihlášení</a>
      </p>
    </form>

  <?php else: ?>
    <form method="post" class="auth__form">
      <h2>Přihlášení</h2>
      <input type="hidden" name="action" value="login">

    <div class="inputBox">
      <input type="email" name="email" required>
      <span>Email</span>
    </div>

    <div class="inputBox">
      <input type="password" name="password" required>
      <span>Heslo</span>
    </div>

      <button type="submit" class="auth__btn">Přihlásit</button>
      <p class="auth__switch">
        Nemáš účet? <a href="contact.php?view=register">Registrace</a>
      </p>
    </form>
<?php endif; ?>

</div>


  <div class="contactForm auth">
    <form action="send_messages.php" method="POST" class="auth__form">
    <h2>Napište nám</h2>
    <p class="auth__msg">
      Máte dotaz ke spolupráci, tréninku nebo stravě?<br>
      Ozveme se vám co nejdříve.
    </p>

    <div class="inputBox">
      <input type="text" name="name" required placeholder=" ">
      <span>Vaše jméno</span>
    </div>

    <div class="inputBox">
      <input type="email" name="email" required placeholder=" ">
      <span>Email</span>
    </div>

    <div class="inputBox">
      <textarea name="message" rows="4" required placeholder=" "></textarea>
      <span>Zpráva</span>
    </div>

    <button type="submit" class="auth__btn">
      Odeslat zprávu
    </button>
  </form>
</div>
</div>
</div>
</section>


        <script src="js/app.js"></script>

    </body>
</html>