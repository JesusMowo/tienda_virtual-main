<?php

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php?view=login");
    exit;   
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $description = trim($_POST['description'] ?? '');

    $price_type = $_POST['price_type'] ?? 'paid';
    $price = ($price_type === 'free') ? 0 : floatval($_POST['price'] ?? 0);

    if ($name === '') {
        $error = "¡El nombre del NFT es obligatorio!";
    } elseif (empty($_FILES['image']['name'])) {
        $error = "Debes subir una imagen para el NFT.";
    } elseif ($price < 0) {
        $error = "El precio no puede ser negativo.";
    } else {

        $uploadDir = __DIR__ . '/../assets/products/';

        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $fileName = basename($_FILES['image']['name']);
        $fileType = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $allowTypes = array('jpg', 'png', 'jpeg', 'gif', 'webp');

        if (in_array($fileType, $allowTypes)) {

            $uniqueName = 'nft_' . uniqid() . '.' . $fileType;
            $targetFilePath = $uploadDir . $uniqueName;

            $dbPath = 'assets/products/' . $uniqueName;

            if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFilePath)) {

                $user_id = $_SESSION['user_id'];

                $stmt = $conn->prepare("INSERT INTO nfts (name, description, price, image_path, creator_id, owner_id, user_id, is_listed, status, supply) VALUES (?, ?, ?, ?, ?, ?, ?, 1, 'active', 1)");

                $stmt->bind_param("ssdsiii", $name, $description, $price, $dbPath, $user_id, $user_id, $user_id);

                if ($stmt->execute()) {
                    $success = "¡NFT creado exitosamente!";
                    $name = '';
                    $description = '';
                    $price = '';
                } else {
                    $error = "Error de Base de Datos: " . $conn->error;
                }
            } else {
                $error = "Hubo un error al subir el archivo al servidor.";
            }
        } else {
            $error = "Solo se permiten archivos JPG, JPEG, PNG, GIF y WEBP.";
        }
    }
}

require __DIR__ . '/../views/post_view.php';
