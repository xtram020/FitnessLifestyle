<?php
session_start();

?>

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trainers</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/modal.css">
    <link rel="stylesheet" href="css/trainers.css">
</head>

<body>

<?php require_once __DIR__ . "/inc/navbar.php"; ?>
    <section id="blog">
    <div class="blog-heading">
        <span>Najdi svůj balanc</span>
        <h1>Naši Trenéři</h1>
    </div>


<div class="blog-container">

        <div class="blog-box">
            <div class="blog-img">
                <img src="images/dan.JPG" alt="blog">
            </div>

            <div class="blog-text">
                <span>Kulturistika / Běh / Kardio</span>
                <a href="" class="blog-title">Dan C.</a>
                <div class="trainer-availability">Dostupnost: Po–Pá 8:00–12:00</div>
                <p>Zvedá váhy jako monstrum, běhá jako šelma. Síla, rychlost a vytrvalost v jednom. Přesně takhle vypadá opravdový dříč.</p>
                <?php if (!isset($_SESSION["user_id"])): ?>
    <a class="next-step open-reservation"
       href="contact.php?view=login&next=trainers.php">
       Přihlásit se pro rezervaci
    </a>
<?php else: ?>
    <a class="next-step open-reservation"
       href="create_reservations.php?trainer_id=5"
       data-trainer-id="5"
       data-trainer-name="Dan C.">
       Rezervace
    </a>
<?php endif; ?>
            </div>
        </div>


        <div class="blog-box">
            <div class="blog-img">
                <img src="images/duc.JPG" alt="blog">
            </div>

            <div class="blog-text">
                <span>Kalistenika / Vzpírání / Thaibox</span>
                <a href="" class="blog-title">Duc T.</a>
                <div class="trainer-availability">Dostupnost: Po–Pá 12:00–17:00</div>
                <p>Mladý trenér, který tě posune dál. Pomůže ti růst nejen fyzicky, ale i mentálně. Síla začíná v hlavě.</p>
                    <?php if (!isset($_SESSION["user_id"])): ?>
    <a class="next-step open-reservation"
       href="contact.php?view=login&next=trainers.php">
       Přihlásit se pro rezervaci
    </a>
<?php else: ?>
    <a class="next-step open-reservation"
       href="create_reservations.php?trainer_id=8"
       data-trainer-id="8"
       data-trainer-name="Duc T.">
       Rezervace
    </a>
<?php endif; ?>
            </div> 
        </div>   


        <div class="blog-box">
            <div class="blog-img">
                <img src="images/anita.JPG" alt="blog">
            </div>
    
            <div class="blog-text">
                <span>Funkční trénink / Fyzioterapie / Regenerace</span>
                <a href="" class="blog-title">Anita B.</a>
                <div class="trainer-availability">Dostupnost: So–Ne 8:00–12:00</div>
                <p>Když tě něco bolí, ona ví proč - a hlavně ví, jak to spravit. Ať už jde o tělo nebo mysl, dostane tě zpět do formy.</p>
                    <?php if (!isset($_SESSION["user_id"])): ?>
    <a class="next-step open-reservation"
       href="contact.php?view=login&next=trainers.php">
       Přihlásit se pro rezervaci
    </a>
<?php else: ?>
    <a class="next-step open-reservation"
       href="create_reservations.php?trainer_id=6"
       data-trainer-id="6"
       data-trainer-name="Anita B.">
       Rezervace
    </a>
<?php endif; ?>
            </div>
        </div>
            

        <div class="blog-box">
            <div class="blog-img">
                <img src="images/marco.JPG" alt="blog">
            </div>
    
            <div class="blog-text">
                    <span>Hyrox / Plavání / Disciplína</span>
                    <a href="" class="blog-title">Marco P.</a>
                    <div class="trainer-availability">Dostupnost: Po–Ne 8:00–17:00</div>
                    <p>Chceš mít své tělo pod kontrolou ve všech směrech? Marco ti ukáže cestu. Síla, disciplína a výsledky.</p>
                       <?php if (!isset($_SESSION["user_id"])): ?>
    <a class="next-step open-reservation"
       href="contact.php?view=login&next=trainers.php">
       Přihlásit se pro rezervaci
    </a>
<?php else: ?>
    <a class="next-step open-reservation"
       href="create_reservations.php?trainer_id=9"
       data-trainer-id="9"
       data-trainer-name="Marco P.">
       Rezervace
    </a>
<?php endif; ?>
            </div>         
        </div>


        <div class="blog-box">
            <div class="blog-img">
                <img src="images/hanka.JPG" alt="blog">
            </div>
    
            <div class="blog-text">
                <span>Jóga / Self-Care / Workout</span>
                <a href="" class="blog-title">Hanka K.</a>
                <div class="trainer-availability">Dostupnost: Po, St, Pá 8:00–12:00</div>
                <p>Klid v hlavě, síla v těle. Hanka ti pomůže najít rovnováhu mezi výkonem a regenerací. Protože progres začíná u správného nastavení.</p>
                    <?php if (!isset($_SESSION["user_id"])): ?>
    <a class="next-step open-reservation"
       href="contact.php?view=login&next=trainers.php">
       Přihlásit se pro rezervaci
    </a>
<?php else: ?>
    <a class="next-step open-reservation"
       href="create_reservations.php?trainer_id=7"
       data-trainer-id="7"
       data-trainer-name="Hanka K.">
       Rezervace
    </a>
<?php endif; ?>
            </div>
        </div>
</div>

</section>

    

<div class="modal-overlay" id="reservationModal" aria-hidden="true">
  <div class="modal">
    <button class="modal-close" type="button" id="closeModal">×</button>

    <h2>Vytvořit rezervaci</h2>
    <p class="modal-subtitle" id="modalSubtitle"></p>

    <form action="create_reservations.php" method="POST">
      <input type="hidden" name="trainer_id" id="modalTrainerId">

      <div class="form-row">
            <label>Datum a čas</label>

<input id="reservation_date" type="date" required>

<div id="timeSlots" class="time-slots">
  <div class="slots-placeholder">Vyber datum.</div>
</div>

<input type="hidden" name="start_datetime" id="start_datetime" >
      </div>

      <div class="form-row">
        <label for="note">Poznámka / typ lekce</label>
        <input type="text" id="note" name="note" placeholder="např. silový trénink">
      </div>

      <div class="form-actions">
        <button class="btn" type="submit">Odeslat žádost</button>
        <button class="btn btn-outline" type="button" id="cancelModal">Zrušit</button>
      </div>
    </form>
  </div>
</div>

<script src="js/modal.js"></script>
<script src="js/app.js"></script>

</body>
</html>