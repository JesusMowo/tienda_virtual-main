<?php
$logged = !empty($_SESSION['user_id']);
$user_role = $_SESSION['role'] ?? 'user';
$q = htmlspecialchars(trim($_GET['q'] ?? ''), ENT_QUOTES, 'UTF-8');

if ($q !== '') {
    $q_esc = $conn->real_escape_string($q);
    $nft_res = $conn->query("SELECT id, name, price, image_path FROM nfts WHERE is_listed = 1 AND (name LIKE '%" . $q_esc . "%' OR description LIKE '%" . $q_esc . "%') LIMIT 50");

    $q_esc = $conn->real_escape_string($q);
    $sql_u = "SELECT id, name, role FROM users WHERE name LIKE '%$q_esc%' OR email LIKE '%$q_esc%' LIMIT 5";
    $user_res = $conn->query($sql_u);

    $users_found = [];
    if ($user_res && $user_res->num_rows > 0) {
        while ($user = $user_res->fetch_object()) {
            $users_found[] = $user;
        }
        $user_res->free(); 
    }
} else {
    $nft_res = $conn->query("SELECT id, name, price, image_path FROM nfts WHERE is_listed = 1 ORDER BY id DESC LIMIT 12");
    $users_found = [];
}

require __DIR__ . '/../views/home_view.php';