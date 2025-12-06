<?php
// Controlador de perfil: carga datos del usuario y listas de NFTs (poseídos/creados)
require_once __DIR__ . '/../model/conn.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Nft.php';
require_once __DIR__ . '/../helpers/paths.php';
session_start();


$user_id = null;
if (!empty($_GET['user_id'])) {
    $user_id = intval($_GET['user_id']);
} elseif (!empty($_SESSION['user_id'])) {
    $user_id = intval($_SESSION['user_id']);
}

if (!$user_id) {
    header('Location: ' . site_url('login.php'));
    exit;
}

$user = User::findById($conn, $user_id);
$is_own_profile = (!empty($_SESSION['user_id']) && intval($_SESSION['user_id']) === $user_id);
if ($is_own_profile) {
    // Si es el propio perfil, mostramos lo que posee y lo que creó
    $owned_nfts = Nft::findOwnedByUser($conn, $user_id);
    $created_nfts = Nft::findCreatedByUser($conn, $user_id);
} else {
    // Perfil de otro usuario: sólo mostramos lo que posee
    $owned_nfts = Nft::findOwnedByUser($conn, $user_id);
    $created_nfts = [];
}

require_once __DIR__ . '/../views/profile_view.php';
