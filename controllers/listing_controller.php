<?php
// Controlador para listar y deslistar NFTs desde el perfil
require_once __DIR__ . '/../model/conn.php';
require_once __DIR__ . '/../models/Nft.php';
require_once __DIR__ . '/../helpers/paths.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ' . site_url('profile.php'));
    exit;
}

$user_id = !empty($_SESSION['user_id']) ? intval($_SESSION['user_id']) : null;
$nft_id = intval($_POST['nft_id'] ?? 0);
$action = $_POST['action'] ?? '';

if (!$user_id) {
    header('Location: ' . site_url('login.php'));
    exit;
}

if (!$nft_id) {
    header('Location: ' . site_url('profile.php'));
    exit;
}

$nft = Nft::findById($conn, $nft_id);
if (!$nft) {
    header('Location: ' . site_url('profile.php'));
    exit;
}


// Sólo el creador, uploader o propietario pueden gestionar la publicación
$allowed = ($nft->creator_id == $user_id || $nft->uploader_id == $user_id || $nft->owner_id == $user_id);
if (!$allowed) {
    header('Location: ' . site_url('profile.php'));
    exit;
}

if ($action === 'list') {
    $price = $_POST['price'] ?? null;

    if ($price === '' || $price === null) $price = null;
    if ($price !== null) $price = floatval($price);

    if (intval($nft->supply) === 0 && intval($nft->owner_id) !== $user_id) {
        header('Location: ' . site_url('profile.php?error=' . urlencode('No puedes listar: el NFT ya se vendió y no eres el propietario.')));
        exit;
    }

    $stmt = $conn->prepare("UPDATE nfts SET is_listed = 1, status = 'listed', price = ? WHERE id = ?");
    $stmt->bind_param('di', $price, $nft_id);
    if ($stmt->execute()) {
        header('Location: ' . site_url('profile.php'));
        exit;
    } else {
        header('Location: ' . site_url('profile.php?error=' . urlencode('No se pudo listar')));
        exit;
    }
} elseif ($action === 'unlist') {
    $stmt = $conn->prepare("UPDATE nfts SET is_listed = 0, status = 'unlisted' WHERE id = ?");
    $stmt->bind_param('i', $nft_id);
    if ($stmt->execute()) {
        header('Location: ' . site_url('profile.php'));
        exit;
    } else {
        header('Location: ' . site_url('profile.php?error=' . urlencode('No se pudo deslistar')));
        exit;
    }
} else {
    header('Location: ' . site_url('profile.php'));
    exit;
}
