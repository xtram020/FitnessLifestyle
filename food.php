<?php session_start(); ?>
<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fitness Lifestyle</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/food.css?v=<?= filemtime('food.css') ?>">

    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

</head>

<body>
<?php require_once __DIR__ . "/inc/navbar.php"; ?>
    
<div class="bmi-info">
  <h3 class="bmi-info__heading">Co je to BMI?</h3>
  <p>
    <strong>BMI</strong> 
    (Body Mass Index) je orientační hodnota, která pomáhá posoudit tělesnou hmotnost
    vzhledem k výšce. Vypočítá se podle vzorce: <em>váha (kg) / (výška (m) × výška (m))</em>.
  </p>
          
  <p>
    BMI je rychlý způsob, jak zjistit, zda máte zdravou hmotnost. Nezohledňuje však složení těla,
    věk, pohlaví ani rozložení tukové tkáně, proto by měl sloužit jen jako orientační ukazatel.
  </p>
          
  <h4 class="bmi-info__subheading">Rozmezí hodnot BMI (dle WHO):</h4>
      <ul class="bmi-info__list">
        <li><span class="bmi-info__range">Pod 18,5:</span> Podváha</li>
        <li><span class="bmi-info__range">18,5 – 24,9:</span> Normální váha</li>
        <li><span class="bmi-info__range">25 – 29,9:</span> Nadváha</li>
        <li><span class="bmi-info__range">30 a více:</span> Obezita</li>
      </ul>
          
  <p>
    S konkrétnějšími otázkami se můžete obrátit na naše certifikované trenéry a výživové poradce.
  </p>
</div>

  <br>


<div class="bmi-container">
  <h2>BMI Kalkulačka</h2>
  <label for="weight">Váha (kg):</label>
    <input type="number" id="weight" min="1" required>  
  <label for="height">Výška (cm):</label>
    <input type="number" id="height" min="1" required>
      
  <button type="button" onclick="vypocitejBMI()">Vypočítej BMI</button>
      
  <div id="result"></div>
</div>
      
        <br>

<div class="app">
    <h1>Kalorická tabulka</h1>
    <p class="subtitle">
      Vyber potravinu, zadej množství v gramech a sestav si svůj denní jídelníček. Hodnoty jsou přibližně na 100&nbsp;g.
    </p>

    <!-- meal guide / motivace / funfacts -->
<section class="meal-guide" aria-label="Jak si složit jídelníček">
  <header class="meal-guide__header">
    <h2 class="meal-guide__title">Jak si složit jídelníček (rychle a bez stresu)</h2>
    <p class="meal-guide__lead">
      Nehledej dokonalost. Hledej <strong>konzistenci</strong> — malý krok denně porazí velký plán jednou za měsíc.
    </p>
  </header>

  <div class="meal-guide__grid">
    <!-- Levý sloupec: kroky -->
    <div class="meal-card">
      <div class="meal-card__top">
        <span class="meal-chip">Praktický postup</span>
        <span class="meal-mini">cca 2 min čtení</span>
      </div>

      <ol class="meal-steps">
        <li>
          <strong>Vyber si cíl dne</strong>
          <span class="meal-muted">hubnutí / udržení / nabírání — od toho se odvíjí množství.</span>
        </li>
        <li>
          <strong>Začni bílkovinou</strong>
          <span class="meal-muted">kuře, tvaroh, tofu, vejce… bílkoviny drží sytost i regeneraci.</span>
        </li>
        <li>
          <strong>Doplň sacharidy a tuky</strong>
          <span class="meal-muted">rýže, brambory, vločky + olivový olej, ořechy… dle energie a chuti.</span>
        </li>
        <li>
          <strong>Přidej “objem”</strong>
          <span class="meal-muted">zelenina/ovoce = víc jídla za méně kalorií (a víc vlákniny).</span>
        </li>
      </ol>

      <div class="meal-callout">
        <div class="meal-callout__icon">💡</div>
        <div class="meal-callout__text">
          <strong>Mini pravidlo talíře:</strong>
          <span>½ zelenina, ¼ bílkovina, ¼ příloha + trocha kvalitních tuků.</span>
        </div>
      </div>
    </div>

    <!-- Pravý sloupec - tipy + fun facts -->
    <div class="meal-stack">
      <div class="meal-card">
        <div class="meal-card__top">
          <span class="meal-chip meal-chip--accent">Motivace</span>
          <span class="meal-mini">pro dny “nemám náladu”</span>
        </div>

        <ul class="meal-list">
          <li><span class="dot"></span> Dnes stačí být o <strong>1&nbsp;% lepší</strong> než včera.</li>
          <li><span class="dot"></span> Když je to “na 80 %”, je to pořád <strong>výhra</strong>.</li>
          <li><span class="dot"></span> Nevyšlo jídlo? Nevadí — <strong>další volba</strong> je hned další sousto.</li>
        </ul>

        <div class="meal-quote">
          „Nejsi produkt jedné večeře. Jsi součet návyků.“
        </div>
      </div>

      <div class="meal-card meal-card--glass">
        <div class="meal-card__top">
          <span class="meal-chip meal-chip--fun">Fun facts</span>
          <span class="meal-mini">krátce a zajímavě</span>
        </div>

        <div class="funfacts">
          <div class="funfact">
            <div class="funfact__emoji">🔥</div>
            <div>
              <strong>Trávení taky “pálí” energii</strong>
              <div class="meal-muted">Tělo spotřebuje část kalorií jen na zpracování jídla.</div>
            </div>
          </div>
          <div class="funfact">
            <div class="funfact__emoji">🥗</div>
            <div>
              <strong>Vláknina = delší sytost</strong>
              <div class="meal-muted">Často pomůže víc než “tvrdá vůle”.</div>
            </div>
          </div>
          <div class="funfact">
            <div class="funfact__emoji">💧</div>
            <div>
              <strong>Žízeň se umí tvářit jako hlad</strong>
              <div class="meal-muted">Zkus nejdřív sklenici vody.</div>
            </div>
          </div>
        </div>

        <div class="meal-tiprow">
          <span class="meal-tip">Tip:</span>
          <span>V tabulce si nejdřív poskládej “kostru” (bílkovina + příloha) a až pak dolaď zbytek.</span>
        </div>
      </div>
    </div>
  </div>
</section>


    <form id="food-form">


    <label for="food-filter">Vyhledat v seznamu</label>
    <input id="food-filter" type="text" placeholder="Napiš třeba: chléb, kuře…" autocomplete="off">

      <div class="form-row">
        <div class="field">
          <label for="food-select">Potravina</label>
          <select id="food-select" required>
          <option value="">Vyber potravinu</option>
          </select>
        </div>

        <div class="field" style="max-width: 140px;">
          <label for="amount">Množství (g)</label>
          <input type="number" id="amount" min="1" step="1" value="100" required >
          <div id="amount-error" class="error" style="display:none;"></div>
        </div>

        <button type="submit">
          ➕ Přidat do jídelníčku
        </button>
      </div>


      <table>
      <thead>
        <tr>
          <th>Potravina</th>
          <th class="align-right">Množství (g)</th>
          <th class="align-right">kcal</th>
          <th class="align-right">Bílkoviny (g)</th>
          <th class="align-right">Sacharidy (g)</th>
          <th class="align-right">Tuky (g)</th>
          <th></th>
        </tr>
      </thead>
      <tbody id="meal-body">
      </tbody>
      <tfoot>
        <tr>
          <td>Celkem</td>
          <td class="align-right" id="total-grams">0</td>
          <td class="align-right" id="total-kcal">0</td>
          <td class="align-right" id="total-protein">0</td>
          <td class="align-right" id="total-carbs">0</td>
          <td class="align-right" id="total-fat">0</td>
          <td></td>
        </tr>
      </tfoot>
    </table>
        <div class="totals-card">
      <div class="totals-item">
        <strong>Celkové kalorie</strong>
        <span id="total-kcal-label">0 kcal</span>
      </div>
      <div class="totals-item">
        <strong>Bílkoviny</strong>
        <span id="total-protein-label">0 g</span>
      </div>
      <div class="totals-item">
        <strong>Sacharidy</strong>
        <span id="total-carbs-label">0 g</span>
      </div>
      <div class="totals-item">
        <strong>Tuky</strong>
        <span id="total-fat-label">0 g</span>
      </div>
        </div>
  </form>
</div>


  
    <script src="js/script.js"></script>
    </body>
    </html>