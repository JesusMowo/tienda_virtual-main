<?php

require_once __DIR__ . '/../model/conn.php';
require_once __DIR__ . '/../models/Nft.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../helpers/paths.php';
session_start();

$id = intval($_GET['id'] ?? 0);
if (!$id) {
    header('Location: ' . site_url('index.php'));
    exit;
}

$nft = Nft::findById($conn, $id);
if (!$nft) {
    echo "<div class='container py-5'><div class='alert alert-danger'>NFT no encontrado.</div><a href='" . htmlspecialchars(site_url('index.php')) . "' class='btn btn-secondary'>Volver</a></div>";
    exit;
}

$creator = null;
if (!empty($nft->creator_id)) {
    $creator = User::findById($conn, $nft->creator_id);
}


$owner = null;
if (!empty($nft->owner_id)) {
    $owner = User::findById($conn, $nft->owner_id);
}


require_once __DIR__ . '/../views/nft_view.php';
