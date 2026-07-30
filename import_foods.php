<?php
declare(strict_types=1);

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

echo "IMPORT START<br>";


require __DIR__ . "/inc/db.php"; 

$csvPath = __DIR__ . "/NutriDatabaze-v9.24-data-export.csv";
if (!file_exists($csvPath)) {
    exit("CSV nenalezeno: $csvPath");
}

$h = fopen($csvPath, "rb");
if (!$h) exit("Nelze otevrit CSV.");

$delimiter = ";";


$header = fgetcsv($h, 0, $delimiter);
if (!$header) exit("CSV je prazdne.");

$header = array_map(fn($x) => trim((string)$x), $header);


$need = [
  "OrigFdCd",      // kod
  "OrigFdNm",      // název
  "ENERC [kcal]",  // kcal
  "PROT [g]",      // bílkoviny
  "CHOT [g]",      // sacharidy
  "FAT [g]"        // tuky
];

$idx = [];
foreach ($need as $col) {
    $pos = array_search($col, $header, true);
    if ($pos === false) exit("Chybi sloupec v CSV: $col");
    $idx[$col] = (int)$pos;
}

// 3) priprava insertu
$stmt = $pdo->prepare("
  INSERT INTO foods (name, kcal, protein, carbs, fat, source, source_id)
  VALUES (:name, :kcal, :protein, :carbs, :fat, 'nutri', :source_id)
");

// prevod na cislo 
$toFloat = function($v): float {
    $v = trim((string)$v);
    if ($v === '') return 0.0;
    $v = str_replace(',', '.', $v);
    return (float)$v;
};

// pokus o prevod na UTF-8 pro hacky/carky
$toUtf8 = function(string $s): string {
    $s = trim($s);
    $c = @iconv("CP1250", "UTF-8//TRANSLIT", $s);
    return $c !== false ? $c : $s;
};

$ok = 0; $skip = 0;

while (($row = fgetcsv($h, 0, $delimiter)) !== false) {
    $nameRaw = $row[$idx["OrigFdNm"]] ?? '';
    $code    = trim((string)($row[$idx["OrigFdCd"]] ?? ''));

    $name = $toUtf8((string)$nameRaw);
    if ($name === '') { $skip++; continue; }

    $kcal  = $toFloat($row[$idx["ENERC [kcal]"]] ?? 0);
    $prot  = $toFloat($row[$idx["PROT [g]"]] ?? 0);
    $carbs = $toFloat($row[$idx["CHOT [g]"]] ?? 0);
    $fat   = $toFloat($row[$idx["FAT [g]"]] ?? 0);

    $stmt->execute([
        ":name" => $name,
        ":kcal" => $kcal,
        ":protein" => $prot,
        ":carbs" => $carbs,
        ":fat" => $fat,
        ":source_id" => $code
    ]);

    $ok++;
}

fclose($h);

echo "Import hotovy. Vlozeno: $ok, preskoceno: $skip";
