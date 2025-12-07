<?php

$limit = 12; 
$current_page = intval($_GET['page'] ?? 1);
if ($current_page < 1) $current_page = 1;
$offset = ($current_page - 1) * $limit;

$search_query = trim($_GET['search'] ?? '');
$search_condition = '';
$params = [];
$types = '';

if (!empty($search_query)) {
    $search_condition = " AND (name LIKE ? OR description LIKE ?) ";
    $search_param = "%" . $search_query . "%";
    $params[] = $search_param;
    $params[] = $search_param;
    $types .= 'ss';
}

$count_sql = "SELECT COUNT(id) AS total FROM nfts WHERE is_listed = 1 " . $search_condition;
$count_stmt = $conn->prepare($count_sql);

if (!empty($types)) {
    $count_stmt->bind_param($types, ...$params);
}
$count_stmt->execute();
$count_res = $count_stmt->get_result()->fetch_assoc();
$total_items = $count_res['total'];
$total_pages = ceil($total_items / $limit);

if ($current_page > $total_pages && $total_pages > 0) {

    $current_page = $total_pages;
    $offset = ($current_page - 1) * $limit;
}

$sql = "SELECT * FROM nfts WHERE is_listed = 1 {$search_condition} ORDER BY created_at DESC LIMIT ? OFFSET ?";
$params[] = $limit;
$params[] = $offset;
$types .= 'ii'; 

$stmt = $conn->prepare($sql);
$stmt->bind_param($types, ...$params);
$stmt->execute();
$nfts = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

require __DIR__ . '/../views/listing_view.php';
