<?php
// Lógica y formulario para crear una publicación con subida de imagen
require_once __DIR__ . '/model/conn.php';
require_once __DIR__ . '/helpers/paths.php';
session_start();

if (empty($_SESSION['user_id'])){
    header('Location: login.php');
    exit;
}

$user_id = intval($_SESSION['user_id']);
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST'){
  $name = trim($_POST['name'] ?? '');
  $description = trim($_POST['description'] ?? '');
  $price = $_POST['price'] ?? null;

  if ($name === ''){
    $message = 'El nombre es requerido.';
  } else {
    $image_path = null;
    $file_size = null;
    $width = null;
    $height = null;
    $allowed = ['image/jpeg' => '.jpg', 'image/png' => '.png', 'image/gif' => '.gif', 'image/webp' => '.webp'];

    // Manejo simple de subida: valida tipo, tamaño y guarda en assets/products
    if (!empty($_FILES['image']) && $_FILES['image']['error'] !== UPLOAD_ERR_NO_FILE) {
      $f = $_FILES['image'];
      if ($f['error'] === UPLOAD_ERR_OK) {
        $maxSize = 5 * 1024 * 1024; // 5 MB
        if ($f['size'] > $maxSize) {
          $message = 'El archivo es demasiado grande (max 5MB).';
        } else {
          $tmp = $f['tmp_name'];
          $finfo = finfo_open(FILEINFO_MIME_TYPE);
          $mime = finfo_file($finfo, $tmp);
          finfo_close($finfo);
          if (!array_key_exists($mime, $allowed)) {
            $message = 'Tipo de archivo no permitido.';
          } else {
            $imginfo = @getimagesize($tmp);
            if ($imginfo === false) {
              $message = 'El archivo no parece ser una imagen válida.';
            } else {
              $width = intval($imginfo[0]);
              $height = intval($imginfo[1]);
              $ext = $allowed[$mime];
              $uploadDir = __DIR__ . '/assets/products';
              if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);
              $filename = time() . '_' . bin2hex(random_bytes(6)) . $ext;
              $dest = $uploadDir . DIRECTORY_SEPARATOR . $filename;
              if (move_uploaded_file($tmp, $dest)) {
                $image_path = 'assets/products/' . $filename;
                $file_size = filesize($dest);
              } else {
                $message = 'Error al mover el archivo subido.';
              }
            }
          }
        }
      } else {
        $message = 'Error en la subida de archivo. Código: ' . intval($_FILES['image']['error']);
      }
    }

    if ($message === '') {
      $status = 'draft';
      $is_listed = 0;
      $supply = 1;
      if ($image_path !== null) {
        $stmt = $conn->prepare("INSERT INTO nfts (name, description, image_path, creator_id, uploader_id, owner_id, price, is_listed, supply, status, file_size, width, height) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)");
        $stmt->bind_param('sssiiidiisiii', $name, $description, $image_path, $user_id, $user_id, $user_id, $price, $is_listed, $supply, $status, $file_size, $width, $height);
      } else {
        $stmt = $conn->prepare("INSERT INTO nfts (name, description, creator_id, uploader_id, owner_id, price, is_listed, supply, status) VALUES (?,?,?,?,?,?,?,?,?)");
        $stmt->bind_param('sssiiidiis', $name, $description, $user_id, $user_id, $user_id, $price, $is_listed, $supply, $status);
      }

        if ($stmt->execute()){
        $message = 'Publicación creada correctamente.';
        header('Location: ' . site_url('profile.php'));
        exit;
      } else {
        $message = 'Error al crear la publicación: ' . $conn->error;
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
  <title>Crear publicación</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body style="padding:20px;">
  <h2>Crear publicación</h2>
  <?php if ($message): ?><div style="color:green"><?= htmlspecialchars($message) ?></div><?php endif; ?>
  <form method="post" enctype="multipart/form-data">
      <div>
        <label>Nombre<br><input type="text" name="name" required></label>
      </div>
      <div>
        <label>Descripción<br><textarea name="description"></textarea></label>
      </div>
      <div>
        <label>Imagen (sube un archivo JPG/PNG/GIF/WebP)<br><input type="file" name="image" accept="image/*"></label>
      </div>
      <div>
        <label>Precio (opcional)<br><input type="number" step="0.0001" name="price"></label>
      </div>
      <div style="margin-top:8px"><button type="submit">Crear</button></div>
    </form>
  <p><a href="index.php">Volver</a></p>
</body>
</html>
