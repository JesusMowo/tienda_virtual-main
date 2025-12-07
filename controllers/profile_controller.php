<?php
if (empty($_SESSION['user_id'])) {
    header("Location: index.php?view=login");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'toggle_sale') {

    $nft_id = intval($_POST['nft_id']);
    $new_status = intval($_POST['is_listed']); 
    $new_price = floatval($_POST['price']);

    $check = $conn->prepare("SELECT id FROM nfts WHERE id = ? AND owner_id = ?");
    $check->bind_param("ii", $nft_id, $_SESSION['user_id']);
    $check->execute();

    if ($check->get_result()->num_rows > 0) {
        $update = $conn->prepare("UPDATE nfts SET is_listed = ?, price = ? WHERE id = ?");
        $update->bind_param("idi", $new_status, $new_price, $nft_id);

        if ($update->execute()) {
            header("Location: index.php?view=profile&success=Estado actualizado");
            exit;
        }
    } else {
        header("Location: index.php?view=profile&error=No eres el dueño");
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {

    $target_user_id = intval($_POST['target_user_id'] ?? 0);
    $my_role = $_SESSION['role'] ?? 'user';
    $action = $_POST['action'];

    if (($action === 'ban_user' || $action === 'unban_user') && ($my_role === 'admin' || $my_role === 'owner')) {

        if ($target_user_id != $_SESSION['user_id'] && $target_user_id != 1) {
            $new_status = ($action === 'ban_user') ? 'banned' : 'active';
            $conn->query("UPDATE users SET status = '$new_status' WHERE id = $target_user_id");
            header("Location: index.php?view=profile&user_id=$target_user_id&success=Estado actualizado");
            exit;
        }
    }

    if (($action === 'promote_admin' || $action === 'demote_admin') && $my_role === 'owner') {

        $new_role = ($action === 'promote_admin') ? 'admin' : 'user';
        $conn->query("UPDATE users SET role = '$new_role' WHERE id = $target_user_id");
        header("Location: index.php?view=profile&user_id=$target_user_id&success=Rol actualizado");
        exit;
    }
}

$user_id = isset($_GET['user_id']) ? intval($_GET['user_id']) : $_SESSION['user_id'];

$stmt = $conn->prepare("SELECT id, name, email, role, created_at, status, wallet_balance FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$res = $stmt->get_result();

if ($res->num_rows === 0) {
    echo "Usuario no encontrado.";
    exit;
}
$user = $res->fetch_object();

$is_own_profile = ($user_id === intval($_SESSION['user_id']));

$owned_nfts = [];
$sql_owned = "SELECT * FROM nfts WHERE owner_id = $user_id ORDER BY id DESC";
$res_owned = $conn->query($sql_owned);
if ($res_owned) {
    while ($row = $res_owned->fetch_object()) {
        $owned_nfts[] = $row;
    }
}

$created_nfts = [];
if ($is_own_profile) {
    $sql_created = "SELECT * FROM nfts WHERE creator_id = $user_id ORDER BY id DESC";
    $res_created = $conn->query($sql_created);
    if ($res_created) {
        while ($row = $res_created->fetch_object()) {
            $created_nfts[] = $row;
        }
    }
}

require __DIR__ . '/../views/profile_view.php';
