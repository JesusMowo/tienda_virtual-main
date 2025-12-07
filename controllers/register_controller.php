<?php
if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $pass = $_POST['password'] ?? '';
    $confirm = $_POST['confirm_password'] ?? '';

    if (empty($name) || empty($email) || empty($pass) || empty($confirm)) {
        $error = "Todos los campos son obligatorios.";
    } elseif ($pass !== $confirm) {
        $error = "Las contraseñas no coinciden.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "El formato del correo no es válido.";
    } else {

        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $error = "Ese correo ya está registrado.";
        } else {
            $hash = password_hash($pass, PASSWORD_DEFAULT);
            $role = 'user';

            $stmt_ins = $conn->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
            $stmt_ins->bind_param("ssss", $name, $email, $hash, $role);

            if ($stmt_ins->execute()) {
                header("Location: index.php?view=login&registered=1");
                exit;
            } else {
                $error = "Error en la base de datos. Intente más tarde.";
            }
        }
    }
}

require __DIR__ . '/../views/register_view.php';
