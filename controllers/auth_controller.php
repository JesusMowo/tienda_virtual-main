<?php

require_once __DIR__ . '/../model/conn.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../helpers/paths.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ' . site_url('login.php'));
    exit;
}

$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';

if (!$email || !$password) {
    header('Location: ' . site_url('login.php?error=1'));
    exit;
}

$user = User::findByEmail($conn, $email);
if (!$user) {
    header('Location: ' . site_url('login.php?error=1'));
    exit;
}

$stored = $user->password;
$valid = false;
if ($stored && (substr($stored,0,4) === '$2y$' || substr($stored,0,4) === '$2a$')) {
    $valid = password_verify($password, $stored);
} else {
    $valid = ($password === $stored);
}

if ($valid) {
    $_SESSION['user_id'] = intval($user->id);
    header('Location: ' . site_url('profile.php'));
    exit;
} else {
    header('Location: ' . site_url('login.php?error=1'));
    exit;
}
