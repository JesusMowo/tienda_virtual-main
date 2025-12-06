<?php
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <title><?= htmlspecialchars($nft->name) ?> — flavioToken</title>
</head>
<body class="bg-light">
<div class="container py-5">
    <?php require_once __DIR__ . '/../helpers/paths.php'; ?>
    <a href="<?= htmlspecialchars(site_url('index.php')) ?>" class="btn btn-link">← Volver</a>
    <?php if (!empty($_GET['success'])): ?>
        <div class="mt-3 alert alert-success">Compra realizada correctamente.</div>
    <?php endif; ?>
    <?php if (!empty($_GET['error'])): ?>
        <div class="mt-3 alert alert-danger"><?= htmlspecialchars($_GET['error']) ?></div>
    <?php endif; ?>
    <div class="row mt-3">
        <div class="col-md-6">
            <?php if (!empty($nft->image_path)): ?>
                <img src="<?= htmlspecialchars($nft->image_path) ?>" class="img-fluid" alt="<?= htmlspecialchars($nft->image_alt ?? $nft->name) ?>">
            <?php endif; ?>
        </div>
        <div class="col-md-6">
            <h1><?= htmlspecialchars($nft->name) ?></h1>
            <p><?= nl2br(htmlspecialchars($nft->description)) ?></p>
            <p><strong>Precio:</strong> <?= $nft->price ? '$' . htmlspecialchars($nft->price) . ' usd' : '—' ?></p>
            <p><strong>Disponibles:</strong> <?= intval($nft->supply) ?></p>
            <p><strong>Estado:</strong> <?= htmlspecialchars($nft->status) ?></p>
            <?php if ($creator): ?><p><strong>Creador:</strong> <a href="<?= htmlspecialchars(site_url('profile.php?user_id=' . intval($creator->id))) ?>"><?= htmlspecialchars($creator->name) ?></a></p><?php endif; ?>
            <?php if (!empty($owner)): ?><p><strong>Propietario actual:</strong> <a href="<?= htmlspecialchars(site_url('profile.php?user_id=' . intval($owner->id))) ?>"><?= htmlspecialchars($owner->name) ?></a></p><?php endif; ?>

            <?php if (!empty($_SESSION['user_id'])): ?>
                <form action="<?= htmlspecialchars(site_url('purchase.php')) ?>" method="post">
                    <input type="hidden" name="nft_id" value="<?= intval($nft->id) ?>">
                    <?php if (intval($nft->supply) > 0 && $nft->owner_id != intval($_SESSION['user_id'])): ?>
                        <button type="submit" class="btn btn-primary">Comprar</button>
                    <?php elseif ($nft->owner_id == intval($_SESSION['user_id'])): ?>
                        <div class="alert alert-info">Eres el propietario de este NFT.</div>
                    <?php else: ?>
                        <div class="alert alert-secondary">Agotado o no disponible.</div>
                    <?php endif; ?>
                </form>
            <?php else: ?>
                <a href="<?= htmlspecialchars(site_url('login.php')) ?>" class="btn btn-primary">Inicia sesión para comprar</a>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../components/footer.html'; ?>

</body>
</html>
