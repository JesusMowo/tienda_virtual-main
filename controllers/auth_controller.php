<?php
require_once __DIR__ . '/../model/conn.php';
require_once __DIR__ . '/../helpers/paths.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../login.php");
    exit();
}

$action = $_POST['action'] ?? '';

if ($action === 'register') {
    $nombre   = trim($_POST['nombre']);
    $email    = trim($_POST['email']);
    $pass1    = $_POST['password'];
    $pass2    = $_POST['confirm_password'];

    if (empty($nombre) || empty($email) || empty($pass1)) {
        header("Location: ../register.php?error=empty");
        exit();
    }

    if ($pass1 !== $pass2) {
        header("Location: ../register.php?error=password_mismatch");
        exit();
    }

    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();

    if ($stmt->get_result()->num_rows > 0) {
        header("Location: ../register.php?error=email_exists");
        exit();
    }

    $hash = password_hash($pass1, PASSWORD_DEFAULT);
    $role = 'user'; 

    $stmt = $conn->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $nombre, $email, $hash, $role);

    if ($stmt->execute()) {
        header("Location: ../login.php?registro=ok");
        exit();
    } else {
        header("Location: ../register.php?error=db_error");
        exit();
    }
}

if ($action === 'login') {
    $email = trim($_POST['email']);
    $pass  = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, name, password, role FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res->num_rows === 1) {
        $user = $res->fetch_object();

        if (password_verify($pass, $user->password)) {
            $_SESSION['user_id'] = $user->id;
            $_SESSION['name']    = $user->name;
            $_SESSION['role']    = $user->role;

            header("Location: ../index.php");
            exit();
        }
    }

    header("Location: ../login.php?error=invalid_credentials");
    exit();
}
