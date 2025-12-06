<?php
// Registro de usuarios: guarda una cuenta y redirige a iniciar sesión
require_once __DIR__ . '/model/conn.php';
require_once __DIR__ . '/helpers/paths.php';
session_start();

$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($name === '' || $email === '' || $password === '') {
        $message = 'Todos los campos son obligatorios.';
    } else {
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            $message = 'El email ya está registrado.';
            $stmt->close();
        } else {
            $stmt->close();
            // Hasheamos la contraseña antes de guardar
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO users (name,email,password,role) VALUES (?,?,?,?)");
            $role = 'user';
            $stmt->bind_param('ssss', $name, $email, $hash, $role);
            if ($stmt->execute()) {
                header('Location: ' . site_url('login.php'));
                exit;
            } else {
                $message = 'No se pudo crear el usuario: ' . $conn->error;
            }
        }
    }
}

?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Registro - flavioToken</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body style="padding:20px;">
  <h2>Registro</h2>
  <?php if ($message): ?><div style="color:red"><?= htmlspecialchars($message) ?></div><?php endif; ?>
  <form method="post">
    <div><label>Nombre<br><input type="text" name="name" required></label></div>
    <div><label>Email<br><input type="email" name="email" required></label></div>
    <div><label>Password<br><input type="password" name="password" required></label></div>
    <div style="margin-top:8px"><button type="submit">Crear cuenta</button></div>
  </form>
  <p><a href="<?= htmlspecialchars(site_url('login.php')) ?>">Volver a iniciar sesión</a></p>
</body>
</html>
