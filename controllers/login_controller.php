    <?php
    if (isset($_SESSION['user_id'])) {
        header("Location: index.php");
        exit;
    }

    $error = '';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        if (empty($email) || empty($password)) {
            $error = "Por favor completa todos los campos.";
        } else {

            $stmt = $conn->prepare("SELECT id, name, password, role, status, banned_until FROM users WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $res = $stmt->get_result();

            if ($res->num_rows === 1) {
                $user = $res->fetch_object();

                if (password_verify($password, $user->password)) {

                    if (isset($user->status) && $user->status === 'banned') {

                        if ($user->banned_until) {
                            $now = new DateTime();
                            $banned_date = new DateTime($user->banned_until);

                            if ($now < $banned_date) {
                                $error = "🚫 Tu cuenta está suspendida temporalmente hasta: " . $banned_date->format('d/m/Y H:i');
                            } else {
                                $conn->query("UPDATE users SET status = 'active', banned_until = NULL WHERE id = " . $user->id);
                            }
                        } else {
                            $error = "🚫 Tu cuenta ha sido vetada permanentemente.";
                        }
                    }

                    if (empty($error)) {
                        $_SESSION['user_id'] = $user->id;
                        $_SESSION['user_name'] = $user->name;
                        $_SESSION['role'] = $user->role;

                        header("Location: index.php");
                        exit;
                    }
                } else {
                    $error = "Contraseña incorrecta";
                }
            } else {
                $error = "Este correo no está registrado.";
            }
        }
    }

    require __DIR__ . '/../views/login_view.php';
