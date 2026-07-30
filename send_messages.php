<?php
declare(strict_types=1);
require __DIR__ . '/inc/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  header('Location: contact.php');
  exit;
}

$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$message = trim($_POST['message'] ?? '');

if ($name === '' || $email === '' || $message === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
  header('Location: contact.php?sent=0');
  exit;
}

$stmt = $pdo->prepare("
  INSERT INTO contact_messages (name, email, message)
  VALUES (?, ?, ?)
");
$stmt->execute([$name, $email, $message]);

header('Location: contact.php?sent=1');
exit;
