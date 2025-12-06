<?php
?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Menu - flavioToken</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body style="padding:20px;">
  <h2>Menú</h2>
  <ul>
    <li><a href="index.php">Inicio</a></li>
    <li><a href="profile.php">Perfil</a></li>
    <li><a href="create_post.php">Crear publicación</a></li>
    <li><a href="login.php">Iniciar sesión</a></li>
  </ul>

  <h3>NFTs enlistados</h3>
  <?php
  require_once __DIR__ . '/model/conn.php';
  require_once __DIR__ . '/helpers/paths.php';
  $res = $conn->query("SELECT id, name, price, image_path FROM nfts WHERE is_listed = 1 ORDER BY created_at DESC LIMIT 50");
  if ($res && $res->num_rows > 0): ?>
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(180px,1fr));gap:12px;">
      <?php while ($row = $res->fetch_object()): ?>
        <div style="border:1px solid #ddd;padding:8px;">
          <?php if (!empty($row->image_path)): ?><img src="<?= htmlspecialchars($row->image_path) ?>" alt="<?= htmlspecialchars($row->name) ?>" style="width:100%;height:100px;object-fit:cover;margin-bottom:6px;"/><?php endif; ?>
          <div style="font-weight:600"><?= htmlspecialchars($row->name) ?></div>
          <div style="color:#666"><?= $row->price ? '$' . htmlspecialchars($row->price) . ' usd' : '—' ?></div>
          <div style="margin-top:6px"><a href="<?= htmlspecialchars(site_url('nft_details.php?id=' . intval($row->id))) ?>">Ver</a></div>
        </div>
      <?php endwhile; ?>
    </div>
  <?php else: ?>
    <p>No hay NFTs enlistados.</p>
  <?php endif; ?>

</body>
</html>
