<?php

if (empty($_SESSION['user_id'])) {
    header("Location: index.php?view=login");
    exit;
}

$buyer_id = $_SESSION['user_id'];
$owner_id = 1; 
$commission_rate = 0.05;

$sql = "SELECT c.id as cart_id, c.product_id, c.quantity, p.price, p.name, p.owner_id as seller_id 
        FROM cart c 
        JOIN nfts p ON c.product_id = p.id 
        WHERE c.user_id = $buyer_id";

$res = $conn->query($sql);
$cart_items = [];
$total_to_pay = 0;

while ($row = $res->fetch_object()) {
    $cart_items[] = $row;
    $total_to_pay += ($row->price * $row->quantity);
}

if ($total_to_pay <= 0) {
    header("Location: index.php?view=cart");
    exit;
}

$stmt_bal = $conn->prepare("SELECT wallet_balance FROM users WHERE id = ?");
$stmt_bal->bind_param("i", $buyer_id);
$stmt_bal->execute();
$buyer_balance = $stmt_bal->get_result()->fetch_object()->wallet_balance;

if ($buyer_balance < $total_to_pay) {
    $missing = $total_to_pay - $buyer_balance;

    header("Location: index.php?view=cart&error=low_balance&missing=" . $missing);
    exit;
}

$conn->query("UPDATE users SET wallet_balance = wallet_balance - $total_to_pay WHERE id = $buyer_id");

foreach ($cart_items as $item) {
    $price = $item->price;

    $fee = $price * $commission_rate;
    $net = $price - $fee;

    if ($item->seller_id != $owner_id) {
        $conn->query("UPDATE users SET wallet_balance = wallet_balance + $net WHERE id = {$item->seller_id}");

        $desc_seller = "Venta de NFT: " . $item->name;
        $stmt_s = $conn->prepare("INSERT INTO transactions (type, user_id, amount, description, reference_id, counterparty_id) VALUES ('sale', ?, ?, ?, ?, ?)");
        $stmt_s->bind_param("idsii", $item->seller_id, $net, $desc_seller, $item->product_id, $buyer_id);
        $stmt_s->execute();
    } else {
        $fee = $price; 
    }

    if ($item->seller_id != $owner_id) {
        $conn->query("UPDATE users SET wallet_balance = wallet_balance + $fee WHERE id = $owner_id");

        $desc_fee = "Comisión (5%) por venta de: " . $item->name;
        $stmt_f = $conn->prepare("INSERT INTO transactions (type, user_id, amount, description, reference_id, counterparty_id) VALUES ('fee', ?, ?, ?, ?, ?)");
        $stmt_f->bind_param("idsii", $owner_id, $fee, $desc_fee, $item->product_id, $buyer_id);
        $stmt_f->execute();
    }

    $desc_buy = "Compra de NFT: " . $item->name;
    $neg_price = -$price; 
    $stmt_b = $conn->prepare("INSERT INTO transactions (type, user_id, amount, description, reference_id, counterparty_id) VALUES ('purchase', ?, ?, ?, ?, ?)");
    $stmt_b->bind_param("idsii", $buyer_id, $neg_price, $desc_buy, $item->product_id, $item->seller_id);
    $stmt_b->execute();

    $conn->query("UPDATE nfts SET owner_id = $buyer_id, is_listed = 0 WHERE id = {$item->product_id}");
}

$conn->query("INSERT INTO invoices (user_id, total_price, created_at) VALUES ($buyer_id, $total_to_pay, NOW())");
$invoice_id = $conn->insert_id;

$conn->query("DELETE FROM cart WHERE user_id = $buyer_id");

header("Location: index.php?view=invoice&id=" . $invoice_id);
exit;
