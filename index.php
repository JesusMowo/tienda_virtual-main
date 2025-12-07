<?php

require_once __DIR__ . '/model/conn.php';   
require_once __DIR__ . '/helpers/paths.php'; 

session_start();

$page = $_GET['view'] ?? 'home';

switch ($page) {

  case 'home':
    require __DIR__ . '/controllers/home_controller.php';
    break;

  case 'login':
    require __DIR__ . '/controllers/login_controller.php';
    break;

  case 'register':
    require __DIR__ . '/controllers/register_controller.php';
    break;

  case 'logout':
    require __DIR__ . '/controllers/logout_controller.php';
    break;

  case 'profile':
    require __DIR__ . '/controllers/profile_controller.php';
    break;

  case 'nft':
    require __DIR__ . '/controllers/nft_controller.php';
    break;

  case 'create_post':
    if (!isset($_SESSION['user_id'])) {
      header("Location: index.php?view=login");
      exit;
    }
    require __DIR__ . '/controllers/post_controller.php'; 
    break;

  case 'cart':
    require __DIR__ . '/controllers/cart_controller.php';
    break;

  case 'checkout':
    require __DIR__ . '/controllers/checkout_controller.php';
    break;

  case 'invoice':
    require __DIR__ . '/controllers/invoice_controller.php';
    break;

  case 'wallet':
    require __DIR__ . '/controllers/wallet_controller.php';
    break;

  case 'reports':
    require __DIR__ . '/controllers/reports_controller.php';
    break;

  case 'recovery':
    require __DIR__ . '/controllers/recovery_controller.php';
    break;

  case 'listing':
    require __DIR__ . '/controllers/listing_controller.php';
    break;

  default:
    http_response_code(404);
    echo "<h1 style='color:white; text-align:center; margin-top:50px;'>Error 404: Página no encontrada</h1>";
    echo "<center><a href='index.php' style='color:#884BFF;'>Volver al inicio</a></center>";
    break;
}
