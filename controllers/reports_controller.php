<?php

if (empty($_SESSION['user_id'])) {
    header("Location: index.php?view=login");
    exit;
}

$current_user_id = intval($_SESSION['user_id']);
$current_user_role = $_SESSION['role'] ?? 'user';

if (($current_user_role === 'admin' || $current_user_role === 'owner') && isset($_GET['user_id'])) {
    $target_user_id = intval($_GET['user_id']);
} else {
    $target_user_id = $current_user_id; 
}

$report_role = $current_user_role;


$sql_user_name = "SELECT name FROM users WHERE id = {$target_user_id}";
$res_user_name = $conn->query($sql_user_name);

if ($res_user_name && $res_user_name->num_rows > 0) {
    $target_user_name = htmlspecialchars($res_user_name->fetch_object()->name);
} else {
    $target_user_name = "Usuario Desconocido";
}

$total_income = 0;
$total_spent = 0;
$transactions = [];
$platform_profit = 0;

if ($current_user_role === 'owner') {
    $sql_profit = "SELECT SUM(amount) as total FROM transactions WHERE type = 'fee'";
    $res = $conn->query($sql_profit);
    $platform_profit = $res->fetch_object()->total ?? 0;

    $sql_trans = "SELECT t.*, 
                          u1.name as user_name, 
                          u2.name as counterparty_name 
                  FROM transactions t 
                  JOIN users u1 ON t.user_id = u1.id 
                  LEFT JOIN users u2 ON t.counterparty_id = u2.id 
                  ORDER BY t.created_at DESC LIMIT 100";
}

else { 
    $sql_income = "SELECT SUM(amount) as total FROM transactions WHERE user_id = {$target_user_id} AND amount > 0 AND type != 'deposit'";
    $res_inc = $conn->query($sql_income);
    $total_income = $res_inc->fetch_object()->total ?? 0;

    $sql_spent = "SELECT SUM(amount) as total FROM transactions WHERE user_id = {$target_user_id} AND type = 'purchase'";
    $res_spd = $conn->query($sql_spent);
    $total_spent = abs($res_spd->fetch_object()->total ?? 0);

    $sql_trans = "SELECT t.*, 
                          u1.name as user_name, 
                          u2.name as counterparty_name 
                  FROM transactions t 
                  JOIN users u1 ON t.user_id = u1.id 
                  LEFT JOIN users u2 ON t.counterparty_id = u2.id 
                  WHERE t.user_id = {$target_user_id} 
                  ORDER BY t.created_at DESC LIMIT 50";
}


$res_list = $conn->query($sql_trans);
if ($res_list) {
    while ($row = $res_list->fetch_object()) {
        $transactions[] = $row;
    }
}

$role = $report_role;

require __DIR__ . '/../views/reports_view.php';
