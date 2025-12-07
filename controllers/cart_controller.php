<?php
if (empty($_SESSION['user_id'])) {
    header("Location: index.php?view=login");
    exit;
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $action = $_POST['action'] ?? '';

    if ($action === 'add') {
        $product_id = intval($_POST['product_id']);

        $check = $conn->query("SELECT id FROM cart WHERE user_id = $user_id AND product_id = $product_id");

        if ($check->num_rows > 0) {
            $conn->query("UPDATE cart SET quantity = quantity + 1 WHERE user_id = $user_id AND product_id = $product_id");
        } else {
            $stmt = $conn->prepare("INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, 1)");
            $stmt->bind_param("ii", $user_id, $product_id);
            $stmt->execute();
        }

        header("Location: index.php?view=cart");
        exit;
    }

    if ($action === 'remove') {
        $cart_id = intval($_POST['cart_id']);

        $stmt = $conn->prepare("DELETE FROM cart WHERE id = ? AND user_id = ?");
        $stmt->bind_param("ii", $cart_id, $user_id);
        $stmt->execute();

        header("Location: index.php?view=cart");
        exit;
    }
}

$sql = "SELECT c.id as cart_id, c.quantity, p.id as product_id, p.name, p.price, p.image_path 
        FROM cart c 
        JOIN nfts p ON c.product_id = p.id 
        WHERE c.user_id = $user_id";

$cart_items = $conn->query($sql);
$total = 0;

require __DIR__ . '/../views/cart_view.php';
