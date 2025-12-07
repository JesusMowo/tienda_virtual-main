<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete_nft') {

    if (empty($_SESSION['user_id'])) {
        header("Location: index.php?view=login");
        exit;
    }

    $my_role = $_SESSION['role'] ?? 'user';

    if ($my_role === 'admin' || $my_role === 'owner') {
        $nft_id = intval($_POST['nft_id']);

        $q_check = $conn->query("SELECT * FROM nfts WHERE id = $nft_id");
        $nft = $q_check->fetch_object();

        if ($nft) {
            $owner_id = $nft->owner_id;
            $creator_id = $nft->creator_id;

            $stmt_ban = $conn->prepare("UPDATE nfts SET status = 'banned', is_listed = 0, name = CONCAT(name, ' [BANEADO]') WHERE id = ?");
            $stmt_ban->bind_param("i", $nft_id);

            if ($stmt_ban->execute()) {

                $conn->query("UPDATE users SET status = 'banned' WHERE id = $creator_id");

                if ($owner_id != $creator_id && $owner_id != 1) {

                    $sql_price = "SELECT ABS(amount) as paid FROM transactions 
                                  WHERE user_id = $owner_id AND reference_id = $nft_id AND type = 'purchase' 
                                  ORDER BY id DESC LIMIT 1";
                    $res_p = $conn->query($sql_price);
                    $refund_amount = ($res_p && $res_p->num_rows > 0) ? $res_p->fetch_object()->paid : $nft->price;

                    if ($refund_amount > 0) {
                        $conn->query("UPDATE users SET wallet_balance = wallet_balance + $refund_amount WHERE id = $owner_id");

                        $conn->query("UPDATE users SET wallet_balance = wallet_balance - $refund_amount WHERE id = $creator_id");

                        $desc = "Reembolso por Fraude (Se confiscó al estafador)";
                        $stmt_l1 = $conn->prepare("INSERT INTO transactions (type, user_id, amount, description, reference_id) VALUES ('deposit', ?, ?, ?, ?)");
                        $stmt_l1->bind_param("idsi", $owner_id, $refund_amount, $desc, $nft_id);
                        $stmt_l1->execute();

                        $desc_scam = "Confiscación por Estafa (Devolución a usuario #$owner_id)";
                        $neg_amt = -$refund_amount;
                        $stmt_l2 = $conn->prepare("INSERT INTO transactions (type, user_id, amount, description, reference_id) VALUES ('fine', ?, ?, ?, ?)");
                        $stmt_l2->bind_param("idsi", $creator_id, $neg_amt, $desc_scam, $nft_id);
                        $stmt_l2->execute();
                    }
                }

                $conn->query("DELETE FROM cart WHERE product_id = $nft_id");

                header("Location: index.php?view=home&success=NFT baneado. Se aplicó la política de protección al usuario.");
                exit;
            }
        }
    } else {
        echo "Acceso denegado.";
        exit;
    }
}


$id = intval($_GET['id'] ?? 0);
if (!$id) {
    header('Location: index.php');
    exit;
}

$stmt = $conn->prepare("SELECT * FROM nfts WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$res = $stmt->get_result();

if ($res->num_rows === 0) {
    echo "<div class='notification is-danger'>NFT no encontrado. <a href='index.php'>Volver</a></div>";
    exit;
}
$nft = $res->fetch_object();

if ($nft->status === 'banned') {
}

$creator = null;
if (!empty($nft->creator_id)) {
    $stmt_c = $conn->prepare("SELECT id, name FROM users WHERE id = ?");
    $stmt_c->bind_param("i", $nft->creator_id);
    $stmt_c->execute();
    $creator = $stmt_c->get_result()->fetch_object();
}

$owner = null;
if (!empty($nft->owner_id)) {
    $stmt_o = $conn->prepare("SELECT id, name FROM users WHERE id = ?");
    $stmt_o->bind_param("i", $nft->owner_id);
    $stmt_o->execute();
    $owner = $stmt_o->get_result()->fetch_object();
}

require __DIR__ . '/../views/nft_view.php';
