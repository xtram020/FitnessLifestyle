<nav class="navbar">
  <div class="navbar__container">
    <a href="index.php" id="navbar__logo">the Aesthetics</a>

    <div class="navbar__toggle" id="mobile-menu">
      <span class="bar"></span>
      <span class="bar"></span>
      <span class="bar"></span>
    </div>

    <ul class="navbar__menu">
      <li class="navbar__item"><a href="index.php" class="navbar__links">Domů</a></li>
      <li class="navbar__item"><a href="blog.php" class="navbar__links">Blog</a></li>
      <li class="navbar__item"><a href="food.php" class="navbar__links">Strava</a></li>
      <li class="navbar__item"><a href="trainers.php" class="navbar__links">Trenéři</a></li>

      <?php if (isset($_SESSION["user_id"]) && (($_SESSION["role"] ?? "") === "user")): ?>
        <li class="navbar__item">
          <a href="user_reservations.php" class="navbar__links">Rezervace</a>
        </li>
      <?php endif; ?>

      <?php if (isset($_SESSION["user_id"]) && in_array($_SESSION["role"] ?? "", ["trainer", "admin"], true)): ?>
        <li class="navbar__item">
          <a href="reservations.php" class="navbar__links">Rozvrh</a>
        </li>
      <?php endif; ?>

      <?php if (isset($_SESSION["user_id"]) && ($_SESSION["role"] ?? "") === "admin"): ?>
        <li class="navbar__item">
        <a href="admin_messages.php" class="navbar__links">Zprávy</a>
        </li>
      <?php endif; ?>


      <?php if (!isset($_SESSION["user_id"])): ?>
        <li class="navbar__btn"><a href="contact.php?view=login" class="button">Přihlášení</a></li>
      <?php else: ?>
        <li class="navbar__btn"><a href="logout.php" class="button">Odhlásit se</a></li>
      <?php endif; ?>
    </ul>
  </div>
</nav>
