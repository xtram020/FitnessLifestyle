<?php
session_start();
require __DIR__ . "/../inc/db.php";

header("Content-Type: application/json; charset=utf-8");

$stmt = $pdo->query("SELECT id, name, kcal, protein, carbs, fat FROM foods ORDER BY name ASC");
echo json_encode($stmt->fetchAll(), JSON_UNESCAPED_UNICODE);
