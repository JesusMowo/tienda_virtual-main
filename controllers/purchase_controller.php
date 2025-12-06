<?php
// Controlador de compra: recibe POST y delega la operación a Nft::purchase
require_once __DIR__ . '/../model/conn.php';
require_once __DIR__ . '/../models/Nft.php';
require_once __DIR__ . '/../helpers/paths.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ' . site_url('index.php'));
    exit;
}

$buyer_id = !empty($_SESSION['user_id']) ? intval($_SESSION['user_id']) : null;
$nft_id = intval($_POST['nft_id'] ?? 0);

if (!$buyer_id) {
    // Redirige a login si no hay sesión
    header('Location: ' . site_url('login.php'));
    exit;
}

if (!$nft_id) {
    header('Location: ' . site_url('index.php'));
    exit;
}

$result = Nft::purchase($conn, $nft_id, $buyer_id);

if ($result['success']) {
    header('Location: ' . site_url('nft_details.php?id=' . $nft_id . '&success=1'));
} else {
    header('Location: ' . site_url('nft_details.php?id=' . $nft_id . '&error=' . urlencode($result['message'])));
}
exit;
