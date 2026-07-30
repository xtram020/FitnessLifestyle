<?php
// inc/auth.php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function require_login(): void {
    if (!isset($_SESSION["user_id"])) {
        header("Location: /login.php");
        exit;
    }
}

function require_role(array $roles): void {
    require_login();
    $role = $_SESSION["role"] ?? null;
    if (!$role || !in_array($role, $roles, true)) {
        http_response_code(403);
        exit("Nemáš oprávnění.");
    }
}
