<?php
session_start();
?>

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fitness Lifestyle</title>
    <link rel="stylesheet" href="css/style.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

</head>
<body>
<?php require_once __DIR__ . "/inc/navbar.php"; ?>


<section class="home" id="home">

    <div class="home-content">
        <h1>Rozhodnutí je<span> začátek</span></h1>
        <h2 class="text-animation">Jsem <span></span></h2>
        <p>Hledáš rovnováhu se svým tělem? Tvůj potenciál máš na dosah ruky.</p>
            

    <div class="social-icons">
        <a href="#"><i class='bx bxl-youtube' ></i></a>
        <a href="#"><i class='bx bxl-facebook-square' ></i></a>
        <a href="#"><i class='bx bxl-instagram-alt' ></i></a>
        <a href="#"><i class='bx bxl-twitter' ></i></a>
    </div>
           
    
    <div class="btn-group">
        <a href="trainers.php" class="btn">Trenéři</a>
    </div>
    </div>
</section>


    <br>
    <br>
    <br>
    <br>

        
<div class="training">
<br>
<br>
    <div class="training__container">
        <div class="training__card">
            <h2>První krok k úspěchu</h2>
            <p>Svět fitness a zajímavosti </p>
            <a href="blog.php" class="training_card_btn">Nahlédnout</a>
        </div>

        <div class="training__card">   
            <h2>Cesta k edukaci</h2>
            <p>Strava a jídelníček </p>
            <a href="food.php" class="training_card_btn">Nahlédnout</a>
        </div>
    </div>
</div>



<section class="education" id="education">
    <h2 class="heading">Můj Příběh</h2>
<div class="timeline-items">

    <div class="timeline-item">
        <div class="timeline-dot"></div>
        <div class="timeline-date">2009</div>
        <div class="timeline-content">
            <h3>Základní škola</h3>
            <p>Pohyb byl součástí mého života už od dětství. Ne všechno bylo ale jednoduché. Období základní školy mě naučilo vyrovnávat se s překážkami a hledat vlastní cestu.
            Právě tehdy jsem poprvé našel vášeň ke sportu - karate a později v thajském boxu. Trénink mi postupně pomohl získat nejen fyzickou kondici, ale především seběvědomí a vnitřní sílu. </p>
        </div>    
    </div>


    <div class="timeline-item">
        <div class="timeline-dot"></div>
        <div class="timeline-date">2018</div>
        <div class="timeline-content">
            <h3>Střední škola</h3>
            <p>Právě tehdy nastala první krize. Disciplína, kterou mi dříve dával bojový sport, se začala postupně vytrácet. Thaibox mě přestal naplňovat a dlouho jsem se necitíl ve svém těle dobře.
            Byl jsem spíš drobný, hubený a bez jasného směru. Zlom přišel ve chvíli, kdy jsem poprvé narazil na tvorbu Chris Heria. Zaujala mě myšlenka, že síla nemusí znamenat jen činky, ale kontrola vlastního těla.
            Začal jsem objevovat kalisteniku a s ní i novou vášeň pro pohyb.
            </p>
        </div>        
    </div>

    
    <div class="timeline-item">
        <div class="timeline-dot"></div>
        <div class="timeline-date">2021</div>
        <div class="timeline-content">
            <h3>Univerzita</h3>
            <p>Univerzitní období se neslo ve znamení pandemie, ale zároveň i masivního vzestupu fitness lifestyle.
            Fitness komunita tehdy výrazně rostla. Inspiraci jsem nacházel u osobností jako Chris Bumstead nebo značek typu Gymshark. 
            Jejich přístup k tréninku, konzistenci a životnímu stylu mě pohltil. Postupně se fitness stalo víc než jen cvičením. 
            Začal jsem se zajímat o výživu a práci s kaloriemi. Uvědomil jsem si že výsledky nejsou náhoda, ale dlouhodobá disciplína.
            </p>
        </div>
    </div>


    <div class="timeline-item">
        <div class="timeline-dot"></div>
        <div class="timeline-date">2024</div>
        <div class="timeline-content">
            <h3>Praxe</h3>
            <p>"If you think big, you will get big." Tuto větu mi běžně opakovali moji rodiče. Rozhodl jsem se proto vystoupit ze své komfortní zóny a začal jsem sdílet svou cestu na sociálních sítích.
            Krátka motivační videa, autentický obsah a specifický smysl pro humor se staly prostředkem, jak inspirovat ostatní k pohybu.
            Právě kombinace těchto faktorů a nadsázky vedla k rychlému šíření a krátkodobě výrazným fenoménem v rámci české fitness scény. </p>
        </div>
    </div>


    <div class="timeline-item">
        <div class="timeline-dot"></div>
        <div class="timeline-date">2026</div>
        <div class="timeline-content">
            <h3>Vize a další krok</h3>
            <p>Všechny dosavadní zkušenosti mě postupně dovedly k myšlence vytvořit prostor, který by fitness nevnímal jen jako výkon, ale jako dlouhodbý životní styl.
            Právě proto vznikla tato webová stránka - jako místo, kde chci předávat své poznatky, zkušenosti a pohled na disciplínu a rovnováhu.
            Tato platforma představuje první krok k širší vizi - postupnému rozšiřování obsahu, edukace a propojení komunity lidí.
            </p>
        </div>
    </div>

</div>
</section>

        <br>
        <br>
        <br>
        <br>
        <br>

<div class="videomp">
    <video src="videoMP2.MOV" width="300" controls></video>
</div>



<div class="main_philosophy">
    <h2 class="heading2">Naše Filozofie</h2>
</div>

<div class="philosophy-section">
    <div class="philosophy-text">
        <p>
        V dnešním světě, kde trávíme nespočet hodin před obrazovkou, se naše tělo často stává tichou obětí ambicí. Práce například v IT vyžaduje soustředění, kreativitu a preciznost — a právě proto je pohyb naprosto zásadní. 
        Pomáhá restartovat mysl, dodat tělu energii a obnovit rovnováhu v životě plném termínů a dlouhého sezení.
        </p>

        <p>
        Pohyb je víc než jen cvičení. Je formou mentálního restartu — způsobem, jak se znovu propojit se sebou samým a budovat odolnost. 
        Každý krok, každý opakovaný pohyb a každý nádech během tréninku připomíná, že nejcennějším nástrojem není počítač, ale vlastní tělo.
        </p>

        <p>
        V IT světě pracuje mysl nepřetržitě. Právě fyzická aktivita ji však udržuje svěží, kreativní a výkonnou. Silné tělo buduje silnou mysl. 
        A silná mysl vede k lepší práci, vyšší motivaci a naplněnějšímu životu.
        </p>

        <p>
        Nemusíš trávit hodiny denně tréninkem. Stačí jedno rozhodnutí — začít, hýbat se a růst. 
        Fitness není jen o svalech, ale o postupném zlepšování sebe sama, krok za krokem.
        </p>

        <p>
        <strong>Naše filozofie je jednoduchá: pohyb, růst, vývoj. Tělo ti poděkuje — a mysl se ti odmění.</strong>
        </p>
    </div>
</div>



<div class="footer__container">
    <div class="footer__links">
    <div class="footer__link--wrapper">
    <div class="footer__link--items">
        <h2>Více o Nás</h2>
        <a href="index.php">Hlavní</a>
        <a href="blog.php">Blog</a>
        <a href="trainers.php">Trenéři</a>
    </div>

    <div class="footer__link--items">
        <h2>Napište nám</h2>
        <a href="https://www.instagram.com/zlutasek_duc/">Instagram</a>
        <a href="https://www.youtube.com/@ductranminh938">Youtube</a>
        <a href="contact.php">Registrace</a>
    </div>
    </div> 

    <div class="footer__link--items">
        <h2>Podpora</h2>
        <a href="contact.php">Nápady</a>
        <a href="contact.php">Otázky</a>
        <a href="blog.php">Informace</a>
    </div>
    </div>
</div>

    <script src="js/app.js"></script>
</body>
</html>