<?php
$header_balance = 0.00;
$logged = isset($_SESSION['user_id']);
$user_name = $_SESSION['user_name'] ?? 'Usuario'; 

if ($logged && isset($conn)) {
    $hid = $_SESSION['user_id'];
    $stmt = $conn->prepare("SELECT wallet_balance, name FROM users WHERE id = ?");
    $stmt->bind_param("i", $hid);
    $stmt->execute();
    $hres = $stmt->get_result();

    if ($hres && $hrow = $hres->fetch_object()) {
        $header_balance = $hrow->wallet_balance;
        $user_name = $hrow->name;
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flavio Tokens - NFT Store</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="icon" type="image/png" href="/tienda_virtual-main/assets/img/FlavioTokens-Logo.png">
    <link rel="stylesheet" href="css/estilos.css">
</head>

<body class="has-navbar-fixed-top">
    <nav class="navbar is-fixed-top" role="navigation" aria-label="main navigation" style="background-color: #1a1a2e;">
        <div class="container">
            <div class="navbar-brand">
                <a class="navbar-item" href="index.php?view=home">
                    <h1 class="title is-4 has-text-primary mb-0">FLAVIO TOKENS</h1>
                </a>

                <a role="button" class="navbar-burger has-text-white" aria-label="menu" aria-expanded="false" data-target="navbarBasicExample">
                    <span aria-hidden="true"></span>
                    <span aria-hidden="true"></span>
                    <span aria-hidden="true"></span>
                </a>
            </div>

            <div id="navbarBasicExample" class="navbar-menu">
                <div class="navbar-start">
                    <a href="index.php?view=home" class="navbar-item has-text-white">
                        <span class="icon mr-1"><i class="fas fa-home"></i></span> Inicio
                    </a>
                    <a href="index.php?view=listing" class="navbar-item has-text-white">
                        <span class="icon mr-1"><i class="fas fa-store"></i></span> Explorar NFTs
                    </a>
                </div>

                <div class="navbar-end">
                    <div class="navbar-item">
                        <div class="buttons">
                            <?php if ($logged): ?>

                                <a href="index.php?view=cart" class="button is-warning is-light is-rounded">
                                    <span class="icon"><i class="fas fa-shopping-cart"></i></span>
                                </a>

                                <a href="index.php?view=wallet" class="button is-dark ft-balance is-rounded is-hidden-mobile" style="border: 1px solid var(--ft-green);">
                                    <span class="icon has-text-success"><i class="fas fa-wallet"></i></span>
                                    <span class="has-text-weight-bold has-text-success">
                                        $<?= number_format($header_balance, 2) ?>
                                    </span>
                                </a>

                                <div class="navbar-item has-dropdown is-hoverable p-0">
                                    <a class="navbar-link is-primary is-rounded p-4" style="background-color: var(--ft-purple); color: #fff;">
                                        <span class="icon"><i class="fas fa-user-circle"></i></span>
                                        <span class="is-hidden-touch ml-1"><?= htmlspecialchars($user_name) ?></span>
                                    </a>

                                    <div class="navbar-dropdown is-right" style="background-color: #2c2c4a; border-top: none;">
                                        <div class="navbar-item is-hidden-desktop" style="border-bottom: 1px solid #3b3b6b;">
                                            <span class="icon has-text-success mr-2"><i class="fas fa-wallet"></i></span>
                                            <strong class="has-text-success">$<?= number_format($header_balance, 2) ?></strong>
                                        </div>
                                        <a href="index.php?view=profile" class="navbar-item ft-dropdown-link has-text-white">
                                            <span class="icon mr-2"><i class="fas fa-user-cog"></i></span> Mi Perfil
                                        </a>
                                        <a href="index.php?view=wallet" class="navbar-item ft-dropdown-link has-text-white">
                                            <span class="icon mr-2"><i class="fas fa-exchange-alt"></i></span> Transacciones
                                        </a>
                                        <hr class="navbar-divider" style="background-color: #3b3b6b;">
                                        <?php if (isset($_SESSION['role']) && ($_SESSION['role'] === 'admin' || $_SESSION['role'] === 'owner')): ?>
                                            <a href="index.php?view=reports" class="navbar-item ft-dropdown-link has-text-info">
                                                <span class="icon mr-2"><i class="fas fa-chart-line"></i></span> Reportes
                                            </a>
                                            <hr class="navbar-divider" style="background-color: #3b3b6b;">
                                        <?php endif; ?>
                                        <a href="index.php?view=logout" class="navbar-item ft-dropdown-link has-text-danger">
                                            <span class="icon mr-2"><i class="fas fa-sign-out-alt"></i></span> Salir
                                        </a>
                                    </div>
                                </div>

                            <?php else: ?>

                                <a href="index.php?view=register" class="button is-primary is-rounded">
                                    <strong><span class="icon"><i class="fas fa-user-plus mr-4"></i></span> Registrarse</strong>
                                </a>

                                <a href="index.php?view=login" class="button is-light is-outlined is-rounded">
                                    <span class="icon"><i class="fas fa-sign-in-alt mr-5"></i></span> Ingresar
                                </a>

                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>