<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>flavioToken — Inicio</title>
    <link rel="stylesheet" href="styles.css">
</head>
<?php
require_once __DIR__ . '/helpers/paths.php';
session_start();
$logged = !empty($_SESSION['user_id']);
$q = htmlspecialchars(trim($_GET['q'] ?? ''), ENT_QUOTES, 'UTF-8');
?>
<body>
  <div style="max-width:900px;margin:40px auto;padding:16px;">
    <h2>flavioToken</h2>

    <form method="get" action="index.php" style="margin-bottom:12px;">
      <input type="search" name="q" placeholder="Buscar..." value="<?= $q ?>" style="width:60%;padding:8px;">
      <button type="submit" style="padding:8px 12px;">Buscar</button>
    </form>

    <div style="display:flex;gap:10px;flex-wrap:wrap;">
      <a href="<?= htmlspecialchars(site_url('profile.php')) ?>" style="padding:10px 14px;background:#007bff;color:#fff;text-decoration:none;">Perfil</a>

      <a href="<?= htmlspecialchars(site_url('menu.php')) ?>" style="padding:10px 14px;background:#6c757d;color:#fff;text-decoration:none;">Menu</a>

      <?php if ($logged): ?>
        <a href="<?= htmlspecialchars(site_url('profile.php')) ?>" style="padding:10px 14px;background:#28a745;color:#fff;text-decoration:none;">Mi perfil</a>
        <a href="<?= htmlspecialchars(site_url('logout.php')) ?>" style="padding:10px 14px;background:#dc3545;color:#fff;text-decoration:none;">Salir</a>
      <?php else: ?>
        <a href="<?= htmlspecialchars(site_url('login.php')) ?>" style="padding:10px 14px;background:#ffc107;color:#000;text-decoration:none;">Iniciar sesión</a>
        <a href="<?= htmlspecialchars(site_url('register.php')) ?>" style="padding:10px 14px;background:#0d6efd;color:#fff;text-decoration:none;">Registrarse</a>
      <?php endif; ?>

      <a href="<?= htmlspecialchars(site_url('create_post.php')) ?>" style="padding:10px 14px;background:#17a2b8;color:#fff;text-decoration:none;">Crear publicación</a>
    </div>

    <p style="margin-top:18px;color:#666;">Vista mínima — funcionalidad básica. Usa los botones para navegar.</p>
    <?php if ($q !== ''): ?>
      <?php
        require_once __DIR__ . '/model/conn.php';
        $q_esc = $conn->real_escape_string($q);
        $nft_res = $conn->query("SELECT id, name, price, image_path FROM nfts WHERE name LIKE '%" . $q_esc . "%' OR description LIKE '%" . $q_esc . "%' LIMIT 50");
        $user_res = $conn->query("SELECT id, name, email FROM users WHERE name LIKE '%" . $q_esc . "%' LIMIT 50");
      ?>
      <div style="margin-top:20px;">
        <h4>Resultados para "<?= $q ?>"</h4>
        <?php if ($user_res && $user_res->num_rows > 0): ?>
          <h5>Usuarios</h5>
          <ul>
            <?php while ($u = $user_res->fetch_object()): ?>
              <li><a href="<?= htmlspecialchars(site_url('profile.php?user_id=' . intval($u->id))) ?>"><?= htmlspecialchars($u->name) ?> (<?= htmlspecialchars($u->email) ?>)</a></li>
            <?php endwhile; ?>
          </ul>
        <?php endif; ?>

        <?php if ($nft_res && $nft_res->num_rows > 0): ?>
          <h5>NFTs</h5>
          <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(200px,1fr));gap:12px;">
            <?php while ($n = $nft_res->fetch_object()): ?>
              <div style="border:1px solid #ddd;padding:8px;">
                <?php if (!empty($n->image_path)): ?><img src="<?= htmlspecialchars($n->image_path) ?>" alt="<?= htmlspecialchars($n->name) ?>" style="width:100%;height:100px;object-fit:cover;margin-bottom:6px;"/><?php endif; ?>
                <div style="font-weight:600"><?= htmlspecialchars($n->name) ?></div>
                <div style="color:#666"><?= $n->price ? '$' . htmlspecialchars($n->price) . ' usd' : '—' ?></div>
                <div style="margin-top:6px"><a href="<?= htmlspecialchars(site_url('nft_details.php?id=' . intval($n->id))) ?>">Ver</a></div>
              </div>
            <?php endwhile; ?>
          </div>
        <?php else: ?>
          <p>No se encontraron NFTs que coincidan.</p>
        <?php endif; ?>
      </div>
    <?php endif; ?>
  </div>
</body>
</html>