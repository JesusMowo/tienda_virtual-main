<?php
require_once __DIR__ . '/../model/conn.php'; 

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $new_pass = $_POST['password'];

    $check = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();

    if ($check->get_result()->num_rows > 0) {
        $hash = password_hash($new_pass, PASSWORD_DEFAULT);
        $update = $conn->prepare("UPDATE users SET password = ? WHERE email = ?");
        $update->bind_param("ss", $hash, $email);
        $update->execute();
        $success = "¡Contraseña restablecida! Ahora puedes iniciar sesión.";
    } else {
        $error = "Ese correo no está registrado.";
    }
}
require __DIR__ . '/../views/recovery_view.php';
