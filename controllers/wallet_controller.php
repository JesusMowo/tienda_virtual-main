<?php

if (empty($_SESSION['user_id'])) {
    header("Location: index.php?view=login");
    exit;
}

$user_id = $_SESSION['user_id'];
$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $amount = floatval($_POST['amount'] ?? 0);
    $method = $_POST['method'] ?? 'credit_card';

    if ($amount < 5) {
        $error = "El monto mínimo de recarga es $5.00 USD.";
    } else {
        $stmt = $conn->prepare("UPDATE users SET wallet_balance = wallet_balance + ? WHERE id = ?");
        $stmt->bind_param("di", $amount, $user_id);

        if ($stmt->execute()) {
            $stmt_log = $conn->prepare("INSERT INTO transactions (type, user_id, amount, description, created_at) VALUES ('deposit', ?, ?, ?, NOW())");
            $desc = "Recarga de saldo vía " . ucfirst(str_replace('_', ' ', $method));
            $stmt_log->bind_param("ids", $user_id, $amount, $desc);
            $stmt_log->execute();

            $success = "¡Recarga de $$amount exitosa! Tu saldo ha sido actualizado.";
        } else {
            $error = "Error en el sistema bancario. Intente más tarde.";
        }
    }
}

$stmt_balance = $conn->prepare("SELECT wallet_balance FROM users WHERE id = ?");
$stmt_balance->bind_param("i", $user_id);
$stmt_balance->execute();
$current_balance = $stmt_balance->get_result()->fetch_object()->wallet_balance;

require __DIR__ . '/../views/wallet_view.php';
