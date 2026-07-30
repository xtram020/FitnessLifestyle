<?php
session_start();
require __DIR__ . "/inc/db.php"; 

header("Content-Type: application/json; charset=utf-8");


if (!isset($_SESSION["user_id"])) {
    http_response_code(401);
    echo json_encode(["error" => "not_logged_in"]);
    exit;
}


$post_id = (int)($_POST["post_id"] ?? 0);
$user_id = (int)$_SESSION["user_id"];

if ($post_id <= 0) {
    http_response_code(400);
    echo json_encode(["error" => "invalid_post"]);
    exit;
}


$stmt = $pdo->prepare(
    "SELECT 1 FROM post_likes WHERE post_id = ? AND user_id = ?"
);
$stmt->execute([$post_id, $user_id]);
$liked = $stmt->fetchColumn();


if ($liked) {
    $stmt = $pdo->prepare(
        "DELETE FROM post_likes WHERE post_id = ? AND user_id = ?"
    );
    $stmt->execute([$post_id, $user_id]);
    $liked = false;
} else {
    $stmt = $pdo->prepare(
        "INSERT INTO post_likes (post_id, user_id) VALUES (?, ?)"
    );
    $stmt->execute([$post_id, $user_id]);
    $liked = true;
}


$stmt = $pdo->prepare(
    "SELECT COUNT(*) FROM post_likes WHERE post_id = ?"
);
$stmt->execute([$post_id]);
$count = (int)$stmt->fetchColumn();


echo json_encode([
    "liked" => $liked,
    "likes" => $count
]);
