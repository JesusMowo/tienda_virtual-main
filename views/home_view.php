<?php
include __DIR__ . '/../components/header.php';
$logged = isset($_SESSION['user_id']);
?>

<?php if ($q === ''): ?>

    <section class="hero is-large" id="hero-banner" style="background: linear-gradient(rgba(11,14,17,0.8), rgba(11,14,17,0.8)), url('assets/img/banner_bg.jpg'); background-size: cover; background-position: center; border-bottom: 2px solid var(--ft-purple);">
        <div class="hero-body has-text-centered">
            <p class="title is-1 is-size-3-mobile has-text-white" style="font-family: 'Montserrat', sans-serif; text-shadow: 0 0 15px rgba(122, 55, 204, 0.5);">
                Descubre Arte Digital Exclusivo
            </p>
            <p class="subtitle is-4 has-text-grey-light mb-5">
                La plataforma segura para coleccionar, comprar y vender tus Flavio Tokens.
            </p>
            <a href="#explore" class="button is-primary is-large is-rounded shadow-hover color">
                <span class="icon"><i class="fas fa-search"></i></span>
                <span>Empezar a Explorar</span>
            </a>
        </div>
    </section>
<?php endif; ?>

<section class="section" id="explore" style="min-height: 60vh; padding-top: 3rem;">
    <div class="container">

        <?php include __DIR__ . '/../components/search_bar.php'; ?>
        <?php if ($q !== ''): ?>
            <h3 class="title is-4 mb-5 has-text-white">
                <span class="icon"><i class="fas fa-search"></i></span> Resultados para "<?= htmlspecialchars($q) ?>"
            </h3>

            <?php if (!empty($users_found)): ?>
                <h2 class="title is-4 has-text-white mt-5 mb-3">
                    <span class="icon has-text-info"><i class="fas fa-users"></i></span> Creadores Encontrados
                </h2>
                <div class="columns is-multiline mb-6">
                    <?php foreach ($users_found as $user): ?>
                        <div class="column is-one-quarter-desktop is-half-tablet">
                            <div class="box has-background-dark p-4 user-card-hover" style="border: 1px solid #3b3b6b; transition: transform 0.3s;">
                                <div class="is-flex is-align-items-center">
                                    <figure class="image is-48x48 mr-3">
                                        <img class="is-rounded" src="https://ui-avatars.com/api/?name=<?= urlencode($user->name) ?>&background=7A37CC&color=fff&size=48" alt="Avatar">
                                    </figure>
                                    <div>
                                        <p class="title is-6 has-text-white mb-0"><?= htmlspecialchars($user->name) ?></p>
                                        <p class="subtitle is-7 has-text-grey-light mt-0">Rol: <strong class="has-text-primary"><?= ucfirst($user->role) ?></strong></p>
                                    </div>
                                </div>
                                <a href="index.php?view=profile&user_id=<?= $user->id ?>" class="button is-small is-primary is-fullwidth mt-3 is-outlined">
                                    Ver Perfil <span class="icon ml-1"><i class="fas fa-arrow-right"></i></span>
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <hr style="border-top: 1px solid rgba(255,255,255,0.1);" />
            <?php endif; ?>

        <?php else: ?>
            <div class="is-flex is-justify-content-space-between is-align-items-center mb-5">
                <h3 class="title is-3 has-text-white">
                    <span class="icon has-text-info"><i class="fas fa-fire"></i></span> Últimos Drops
                </h3>
                <a href="index.php?view=listing" class="has-text-primary has-text-weight-bold">Ver todo →</a>
            </div>
        <?php endif; ?>

        <?php if ($nft_res && $nft_res->num_rows > 0): ?>
            <div class="columns is-multiline">
                <?php while ($n = $nft_res->fetch_object()): ?>
                    <div class="column is-one-quarter-desktop is-one-third-tablet is-full-mobile">
                        <div class="card h-100 nft-card" style="background-color: #1a1a2e; border: 1px solid #3b3b6b; transition: transform 0.3s, box-shadow 0.3s;">

                            <div class="card-image">
                                <figure class="image is-1by1">
                                    <a href="index.php?view=nft&id=<?= intval($n->id) ?>">
                                        <img src="<?= !empty($n->image_path) ? htmlspecialchars($n->image_path) : 'https://bulma.io/images/placeholders/1280x960.png' ?>"
                                            alt="<?= htmlspecialchars($n->name) ?>"
                                            style="object-fit: cover; border-bottom: 1px solid #3b3b6b;">
                                    </a>
                                </figure>
                            </div>

                            <div class="card-content">
                                <div class="media mb-2">
                                    <div class="media-content">
                                        <p class="title is-5 is-size-6-mobile has-text-white mb-1"><?= htmlspecialchars($n->name) ?></p>
                                        <p class="subtitle is-7 has-text-grey mt-4">ID: #<?= $n->id ?></p>
                                    </div>
                                </div>

                                <div class="content is-small">
                                    <div class="is-flex is-justify-content-space-between is-align-items-center mt-4">

                                        <?php if (floatval($n->price) == 0): ?>
                                            <span class="tag is-success is-light is-medium has-text-weight-bold">GRATIS</span>
                                        <?php else: ?>
                                            <span class="tag is-primary is-medium has-text-weight-bold" style="background-color: var(--ft-purple); color: #fff;">
                                                $<?= number_format($n->price, 2) ?>
                                            </span>
                                        <?php endif; ?>

                                        <div class="field has-addons">
                                            <p class="control">
                                                <a href="index.php?view=nft&id=<?= intval($n->id) ?>" class="button is-small is-info is-outlined is-rounded">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </p>

                                            <?php if ($logged): ?>
                                                <p class="control">
                                                <form action="index.php?view=cart" method="POST">
                                                    <input type="hidden" name="action" value="add">
                                                    <input type="hidden" name="product_id" value="<?= $n->id ?>">
                                                    <button type="submit" class="button is-small is-primary is-rounded">
                                                        <i class="fas fa-cart-plus"></i>
                                                    </button>
                                                </form>
                                                </p>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <div class="notification is-dark" style="border-left: 5px solid var(--ft-purple);">
                <p class="has-text-white"><span class="icon"><i class="fas fa-exclamation-triangle"></i></span> No se encontraron NFTs disponibles.</p>
            </div>
        <?php endif; ?>

    </div>
</section>

<?php include __DIR__ . '/../components/footer.php'; ?>