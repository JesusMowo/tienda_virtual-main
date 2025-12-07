<?php

if (empty($_SESSION['user_id'])) {
    header("Location: index.php?view=login");
    exit;
}

$invoice_id = intval($_GET['id'] ?? 0);
$user_id = $_SESSION['user_id'];

if (!$invoice_id) {
    header("Location: index.php?view=home");
    exit;
}

$stmt = $conn->prepare("SELECT * FROM invoices WHERE id = ? AND user_id = ?");
$stmt->bind_param("ii", $invoice_id, $user_id);
$stmt->execute();
$res = $stmt->get_result();

if ($res->num_rows === 0) {
    echo "Factura no encontrada o acceso denegado.";
    exit;
}

$invoice = $res->fetch_object();

require __DIR__ . '/../views/invoice_view.php';
