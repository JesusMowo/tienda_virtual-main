<?php include __DIR__ . '/../components/header.php'; ?>

<section class="section">
    <div class="container">
        <a href="index.php?view=home" class="button is-text has-text-grey-light hover-primary mb-5">
            <span class="icon"><i class="fas fa-arrow-left"></i></span>
            <span>Volver al Marketplace</span>
        </a>

        <div class="columns is-variable is-8">

            <div class="column is-6">
                <figure class="image box has-background-black-ter nft-image-container"
                    style="border: 2px solid var(--ft-purple); padding: 0; aspect-ratio: 1 / 1; width: 100%; overflow: hidden; border-radius: 8px;">
                    <?php
                    $imgSrc = trim($nft->image_path);
                    if ($imgSrc === '') {
                        $finalUrl = 'https://bulma.io/images/placeholders/1280x960.png';
                    } elseif (preg_match('/^https?:\/\//', $imgSrc)) {
                        $finalUrl = $imgSrc;
                    } else {
                        $finalUrl = site_url($imgSrc);
                    }
                    ?>

                    <img src="<?= htmlspecialchars($finalUrl) ?>"
                        alt="<?= htmlspecialchars($nft->name) ?>"
                        style="width:100%; height:100%; object-fit:cover;"
                        onerror="this.onerror=null; this.src='https://bulma.io/images/placeholders/1280x960.png';">
                </figure>
            </div>

            <div class="column is-6">
                <h1 class="title is-2 has-text-white mb-3"><?= htmlspecialchars($nft->name) ?></h1>

                <div class="is-flex is-align-items-center mb-5">
                    <span class="tag is-primary is-medium is-rounded mr-3 has-text-weight-bold">
                        <span class="icon is-small"><i class="fas fa-cube"></i></span>
                        <span><?= isset($nft->supply) ? 'Stock: ' . $nft->supply : 'Único' ?></span>
                    </span>
                    <span class="has-text-grey is-size-6">Token ID: #<?= $nft->id ?></span>
                </div>

                <div class="content is-medium has-text-grey-lighter">
                    <h3 class="title is-5 has-text-white">Descripción</h3>
                    <p><?= nl2br(htmlspecialchars($nft->description)) ?></p>
                </div>

                <hr class="has-background-grey-dark">

                <div class="level is-mobile mb-5">
                    <div class="level-left">
                        <div>
                            <p class="heading has-text-grey-light">Precio de Venta</p>
                            <?php if (floatval($nft->price) == 0): ?>
                                <p class="title is-3 has-text-success has-text-weight-bold">¡GRATIS! (Gift)</p>
                            <?php else: ?>
                                <p class="title is-3 has-text-primary has-text-weight-bold">$<?= number_format($nft->price, 2) ?> USD</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="buttons are-medium mt-5">
                    <?php if (!empty($_SESSION['user_id'])): ?>

                        <form action="index.php?view=cart" method="POST" style="width: 100%;">
                            <input type="hidden" name="action" value="add">
                            <input type="hidden" name="product_id" value="<?= $nft->id ?>">

                            <?php if (isset($nft->owner_id) && $nft->owner_id == $_SESSION['user_id']): ?>
                                <button type="button" class="button is-dark is-fullwidth is-medium is-rounded" disabled style="border: 2px solid var(--ft-green);">
                                    <span class="icon"><i class="fas fa-check"></i></span>
                                    <span>Este NFT ya está en tu colección</span>
                                </button>
                            <?php else: ?>
                                <button type="submit" class="button is-primary is-fullwidth is-medium is-rounded shadow-hover mb-3 has-text-weight-bold">
                                    <span class="icon"><i class="fas fa-cart-plus"></i></span>
                                    <span>
                                        <?= (floatval($nft->price) == 0) ? 'Reclamar Gratis Ahora' : 'Añadir al Carrito' ?>
                                    </span>
                                </button>
                            <?php endif; ?>
                        </form>

                    <?php else: ?>
                        <a href="index.php?view=login" class="button is-primary is-outlined is-fullwidth is-medium is-rounded has-text-weight-bold">
                            <span class="icon"><i class="fas fa-lock"></i></span>
                            <span>Inicia sesión para comprar/reclamar</span>
                        </a>
                    <?php endif; ?>
                </div>

                <div class="box has-background-dark mt-5 p-4" style="border: 2px solid var(--ft-green); border-radius: 8px;">
                    <div class="columns is-mobile">
                        <div class="column">
                            <p class="is-size-7 has-text-grey-light">Creador del Arte</p>
                            <p class="is-size-6 has-text-weight-bold has-text-white">
                                <span class="icon is-small has-text-info mr-1"><i class="fas fa-pencil-alt"></i></span>
                                <?php if ($creator): ?>
                                    <a href="index.php?view=profile&user_id=<?= $creator->id ?>" class="has-text-info hover-primary">
                                        <?= htmlspecialchars($creator->name) ?>
                                    </a>
                                <?php else: ?>
                                    Plataforma Oficial
                                <?php endif; ?>
                            </p>
                        </div>
                        <div class="column">
                            <p class="is-size-7 has-text-grey-light has-text-right">Dueño Actual</p>
                            <p class="is-size-6 has-text-weight-bold has-text-warning has-text-right">
                                <span class="icon is-small has-text-warning mr-1"><i class="fas fa-crown"></i></span>
                                <?php if ($owner): ?>
                                    <a href="index.php?view=profile&user_id=<?= $owner->id ?>" class="has-text-warning hover-primary">
                                        <?= htmlspecialchars($owner->name) ?>
                                    </a>
                                <?php else: ?>
                                    Flavio Tokens
                                <?php endif; ?>
                            </p>
                        </div>
                    </div>
                </div>

                <?php
                $my_role = $_SESSION['role'] ?? 'user';
                if ($my_role === 'admin' || $my_role === 'owner'):
                ?>
                    <div class="notification is-danger is-light mt-5 p-4 staff-tools-box" style="border-left: 5px solid #ff3860; opacity: 1; transition: opacity 0.3s;">
                        <p class="has-text-weight-bold mb-3 is-size-5">
                            <span class="icon"><i class="fas fa-shield-alt"></i></span>
                            Acciones de Moderación
                        </p>
                        <form action="index.php?view=nft&id=<?= $nft->id ?>" method="POST">
                            <input type="hidden" name="action" value="delete_nft">
                            <input type="hidden" name="nft_id" value="<?= $nft->id ?>">
                            <button type="submit" class="button is-danger is-small is-fullwidth is-outlined is-rounded" onclick="return confirm('¿Estás seguro de ELIMINAR este NFT permanentemente? Esta acción no se puede deshacer.');">
                                <span class="icon"><i class="fas fa-trash"></i></span>
                                <span>Eliminar NFT por Infracción/Regulación</span>
                            </button>
                        </form>
                    </div>
                <?php endif; ?>

            </div>
        </div>
    </div>
</section>

<?php include __DIR__ . '/../components/footer.php'; ?>