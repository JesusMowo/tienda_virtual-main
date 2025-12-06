<?php
// Vista de perfil: muestra listas de NFTs (poseídos y creados) y controles básicos
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Perfil de <?= htmlspecialchars($user->name ?? 'Usuario') ?></title>
</head>
<body class="bg-light">
<div class="container py-5">
    <?php if (!empty($_GET['error'])): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($_GET['error']) ?></div>
    <?php endif; ?>
        <div class="d-flex justify-content-between align-items-center mb-4">
        <?php require_once __DIR__ . '/../helpers/paths.php'; ?>
        <h2>Perfil de <?= htmlspecialchars($user->name ?? 'Usuario') ?></h2>
        <a href="<?= htmlspecialchars(site_url('index.php')) ?>" class="btn btn-secondary">Volver</a>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <p><strong>Email:</strong> <?= htmlspecialchars($user->email ?? '-') ?></p>
            <p><strong>Rol:</strong> <?= htmlspecialchars($user->role ?? '-') ?></p>
            <p><strong>Miembro desde:</strong> <?= htmlspecialchars($user->created_at ?? '-') ?></p>
        </div>
    </div>

    <?php
        $session_user = $_SESSION['user_id'] ?? null;
        $is_own = $is_own_profile ?? false;
    ?>

    <div>
        <?php if ($is_own): ?>
            <div style="margin-bottom:12px;">
                <button id="tab-owned" type="button" onclick="showTab('owned')" style="margin-right:6px;">Poseídos</button>
                <button id="tab-created" type="button" onclick="showTab('created')">Creados</button>
            </div>
        <?php else: ?>
            <h4>Poseídos</h4>
        <?php endif; ?>

        <div id="section-owned">
            <div class="row">
                <?php if (!empty($owned_nfts) && count($owned_nfts) > 0):
                    foreach ($owned_nfts as $nft): ?>
                        <div class="col-md-4 mb-4">
                            <div class="card">
                                <?php if (!empty($nft->image_path)): ?>
                                    <img src="<?= htmlspecialchars($nft->image_path) ?>" class="card-img-top" alt="<?= htmlspecialchars($nft->image_alt ?? $nft->name) ?>">
                                <?php endif; ?>
                                <div class="card-body">
                                    <h5 class="card-title"><?= htmlspecialchars($nft->name) ?></h5>
                                    <p class="card-text one-line"><?= htmlspecialchars(substr($nft->description,0,120)) ?></p>
                                    <p class="mb-1"><strong>Precio:</strong> <?= $nft->price ? '$' . htmlspecialchars($nft->price) . ' usd' : '—' ?></p>
                                    <p class="mb-1"><strong>Estado:</strong> <?= htmlspecialchars($nft->status) ?></p>
                                    <a href="<?= htmlspecialchars(site_url('nft_details.php?id=' . intval($nft->id))) ?>" class="btn btn-primary btn-sm">Ver</a>

                                    <?php
                                        $can_manage = $session_user && ($nft->creator_id == $session_user || $nft->uploader_id == $session_user || $nft->owner_id == $session_user);
                                    ?>

                                    <?php if ($can_manage): ?>
                                        <?php if (intval($nft->is_listed)): ?>
                                            <form method="post" action="<?= htmlspecialchars(site_url('listing.php')) ?>" style="display:inline-block;margin-left:6px;">
                                                <input type="hidden" name="nft_id" value="<?= intval($nft->id) ?>">
                                                <input type="hidden" name="action" value="unlist">
                                                <button type="submit" class="btn btn-warning btn-sm">Deslistar</button>
                                            </form>
                                        <?php else: ?>
                                            <?php if (intval($nft->supply) === 0 && intval($nft->owner_id) !== $session_user): ?>
                                                <div style="display:inline-block;margin-left:6px;color:#666;">No puedes listar (agotado y no eres propietario)</div>
                                            <?php else: ?>
                                                <form method="post" action="<?= htmlspecialchars(site_url('listing.php')) ?>" style="display:inline-block;margin-left:6px;">
                                                    <input type="hidden" name="nft_id" value="<?= intval($nft->id) ?>">
                                                    <input type="hidden" name="action" value="list">
                                                    <input type="number" step="0.0001" name="price" placeholder="Precio" style="width:90px;display:inline-block;"> 
                                                    <button type="submit" class="btn btn-success btn-sm">Listar</button>
                                                </form>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach;
                else: ?>
                    <div class="col-12">
                        <div class="alert alert-info">No se encontraron NFTs poseídos por este usuario.</div>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <?php if ($is_own): ?>
            <div id="section-created" style="display:none;">
                <h4>Creados</h4>
                <div class="row">
                    <?php if (!empty($created_nfts) && count($created_nfts) > 0):
                        foreach ($created_nfts as $nft): ?>
                            <div class="col-md-4 mb-4">
                                <div class="card">
                                    <?php if (!empty($nft->image_path)): ?>
                                        <img src="<?= htmlspecialchars($nft->image_path) ?>" class="card-img-top" alt="<?= htmlspecialchars($nft->image_alt ?? $nft->name) ?>">
                                    <?php endif; ?>
                                    <div class="card-body">
                                        <h5 class="card-title"><?= htmlspecialchars($nft->name) ?></h5>
                                        <p class="card-text one-line"><?= htmlspecialchars(substr($nft->description,0,120)) ?></p>
                                        <p class="mb-1"><strong>Precio:</strong> <?= $nft->price ? '$' . htmlspecialchars($nft->price) . ' usd' : '—' ?></p>
                                        <p class="mb-1"><strong>Estado:</strong> <?= htmlspecialchars($nft->status) ?></p>
                                        <a href="<?= htmlspecialchars(site_url('nft_details.php?id=' . intval($nft->id))) ?>" class="btn btn-primary btn-sm">Ver</a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach;
                    else: ?>
                        <div class="col-12">
                            <div class="alert alert-info">No se encontraron NFTs creados por este usuario.</div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>

</div>

<?php include __DIR__ . '/../components/footer.html'; ?>

</body>
<script>
function showTab(tab){
    document.getElementById('section-owned').style.display = (tab==='owned') ? 'block' : 'none';
    var created = document.getElementById('section-created');
    if(created) created.style.display = (tab==='created') ? 'block' : 'none';
}
if(document.getElementById('section-owned')) showTab('owned');
</script>
</html>
