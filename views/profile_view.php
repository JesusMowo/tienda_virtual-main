<?php include 'components/header.php'; ?>

<section class="section">
    <div class="container">

        <div class="columns is-variable is-8">

            <div class="column is-4-desktop">

                <div class="card mb-5">
                    <div class="card-content has-text-centered">
                        <figure class="image is-128x128 is-inline-block mb-3">
                            <img class="is-rounded" src="https://ui-avatars.com/api/?name=<?= urlencode($user->name) ?>&background=884BFF&color=fff&size=128" alt="Avatar">
                        </figure>
                        <h1 class="title is-4"><?= htmlspecialchars($user->name) ?></h1>
                        <p class="subtitle is-6 has-text-grey"><?= htmlspecialchars($user->email) ?></p>

                        <div class="tags is-centered mt-3">
                            <span class="tag is-dark">Miembro desde <?= date("Y", strtotime($user->created_at ?? 'now')) ?></span>

                            <?php
                            $role = $user->role ?? 'user';
                            if ($role === 'owner'):
                            ?>
                                <span class="tag is-black has-text-warning has-text-weight-bold" style="border: 1px solid gold;">
                                    👑 CEO / Dueño
                                </span>
                            <?php elseif ($role === 'admin'): ?>
                                <span class="tag is-warning has-text-weight-bold">
                                    🛡️ Administrador
                                </span>
                            <?php else: ?>
                                <span class="tag is-info">
                                    🎨 Coleccionista
                                </span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <?php
                $my_role = $_SESSION['role'] ?? 'user';

                if (!$is_own_profile && ($my_role === 'admin' || $my_role === 'owner')):
                ?>
                    <div class="box has-background-danger-dark mt-4" style="border: 1px solid red;">
                        <h3 class="title is-6 has-text-white mb-3">
                            <span class="icon mr-1"><i class="fas fa-gavel"></i></span>
                            Zona de Moderación
                        </h3>

                        <div class="buttons is-centered is-block">
                            <form action="index.php?view=profile&user_id=<?= $user->id ?>" method="POST" style="width: 100%;" class="mb-2">
                                <input type="hidden" name="target_user_id" value="<?= $user->id ?>">

                                <?php if ($user->status === 'banned'): ?>
                                    <input type="hidden" name="action" value="unban_user">
                                    <button class="button is-success is-small is-fullwidth">
                                        <span class="icon"><i class="fas fa-check"></i></span>
                                        <span>Reactivar Usuario</span>
                                    </button>
                                <?php else: ?>
                                    <input type="hidden" name="action" value="ban_user">
                                    <button class="button is-danger is-small is-fullwidth" onclick="return confirm('¿Estás seguro de vetar a este usuario?');">
                                        <span class="icon"><i class="fas fa-ban"></i></span>
                                        <span>Vetar Usuario</span>
                                    </button>
                                <?php endif; ?>
                            </form>

                            <a href="index.php?view=reports&user_id=<?= $user->id ?>" class="button is-dark is-small is-fullwidth mb-2" style="border: 1px solid #fff;">
                                <span class="icon"><i class="fas fa-search-dollar"></i></span>
                                <span>Auditar Finanzas</span>
                            </a>

                            <?php if ($my_role === 'owner'): ?>
                                <form action="index.php?view=profile&user_id=<?= $user->id ?>" method="POST" style="width: 100%;">
                                    <input type="hidden" name="target_user_id" value="<?= $user->id ?>">

                                    <?php if (($user->role ?? 'user') === 'admin'): ?>
                                        <input type="hidden" name="action" value="demote_admin">
                                        <button class="button is-warning is-light is-small is-fullwidth">
                                            <span class="icon"><i class="fas fa-user-minus"></i></span>
                                            <span>Quitar Admin</span>
                                        </button>
                                    <?php else: ?>
                                        <input type="hidden" name="action" value="promote_admin">
                                        <button class="button is-warning is-small is-fullwidth">
                                            <span class="icon"><i class="fas fa-shield-alt"></i></span>
                                            <span>Hacer Admin</span>
                                        </button>
                                    <?php endif; ?>
                                </form>
                            <?php endif; ?>

                        </div>
                    </div>
                <?php endif; ?>

                <?php if ($is_own_profile): ?>
                    <div class="box has-background-dark" style="border: 1px solid var(--ft-green);">
                        <h3 class="title is-5 has-text-white mb-4">
                            <span class="icon is-small mr-2"><i class="fas fa-lock"></i></span>
                            Seguridad
                        </h3>

                        <?php if (!empty($_GET['error'])): ?>
                            <div class="notification is-danger is-light is-size-7 mb-3">
                                <?= htmlspecialchars($_GET['error']) ?>
                            </div>
                        <?php endif; ?>
                        <?php if (!empty($_GET['success'])): ?>
                            <div class="notification is-success is-light is-size-7 mb-3">
                                Contraseña actualizada.
                            </div>
                        <?php endif; ?>

                        <form action="index.php?view=profile" method="POST">
                            <input type="hidden" name="action" value="update_password">

                            <div class="field">
                                <label class="label is-small">Nueva Contraseña</label>
                                <div class="control has-icons-left">
                                    <input class="input is-small" type="password" name="password" required placeholder="********">
                                    <span class="icon is-small is-left"><i class="fas fa-key"></i></span>
                                </div>
                            </div>
                            <div class="field">
                                <label class="label is-small">Confirmar Contraseña</label>
                                <div class="control has-icons-left">
                                    <input class="input is-small" type="password" name="confirm_password" required placeholder="********">
                                    <span class="icon is-small is-left"><i class="fas fa-check-double"></i></span>
                                </div>
                            </div>
                            <button class="button is-primary is-small is-fullwidth mt-3">
                                Actualizar Contraseña
                            </button>
                        </form>
                    </div>
                <?php endif; ?>

                <?php
                $userRole = $user->role ?? 'user';
                if ($is_own_profile && ($userRole === 'admin' || $userRole === 'owner')):
                ?>
                    <div class="box has-background-dark mt-5" style="border: 1px solid var(--ft-purple);">
                        <h3 class="title is-5 has-text-warning">
                            <span class="icon is-small mr-2"><i class="fas fa-crown"></i></span>
                            Panel de Control
                        </h3>
                        <div class="buttons">
                            <a href="index.php?view=create_post" class="button is-primary is-fullwidth mb-2">
                                <span class="icon"><i class="fas fa-plus"></i></span>
                                <span>Crear Nuevo NFT</span>
                            </a>

                            <a href="index.php?view=reports" class="button is-info is-fullwidth">
                                <span class="icon"><i class="fas fa-chart-line"></i></span>
                                <span>Reportes Financieros</span>
                            </a>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if ($is_own_profile && $userRole === 'user'): ?>
                    <div class="box has-background-dark mt-5" style="border: 1px solid var(--ft-purple);">
                        <h3 class="title is-5 has-text-primary">
                            <span class="icon is-small mr-2"><i class="fas fa-paint-brush"></i></span>
                            Estudio de Creación
                        </h3>
                        <p class="is-size-7 mb-3 has-text-grey-light">Sube tu arte a la Blockchain.</p>
                        <div class="buttons">
                            <a href="index.php?view=create_post" class="button is-primary is-fullwidth mb-2">
                                <span class="icon"><i class="fas fa-plus"></i></span>
                                <span>Crear Nuevo NFT</span>
                            </a>

                            <a href="index.php?view=reports" class="button is-info is-light is-fullwidth">
                                <span class="icon"><i class="fas fa-chart-pie"></i></span>
                                <span>Mis Finanzas</span>
                            </a>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <div class="column is-8-desktop">

                <div class="tabs is-boxed is-medium mb-4">
                    <ul>
                        <li id="tab-owned-li" class="is-active">
                            <a onclick="showTab('owned')">
                                <span class="icon is-small"><i class="fas fa-wallet"></i></span>
                                <span>Poseídos</span>
                            </a>
                        </li>
                        <?php if ($is_own_profile): ?>
                            <li id="tab-created-li">
                                <a onclick="showTab('created')">
                                    <span class="icon is-small"><i class="fas fa-paint-brush"></i></span>
                                    <span>Creados</span>
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>

                <div id="section-owned">
                    <?php if (!empty($owned_nfts) && count($owned_nfts) > 0): ?>
                        <div class="columns is-multiline">
                            <?php foreach ($owned_nfts as $nft): ?>
                                <div class="column is-6-tablet is-4-desktop">
                                    <div class="card h-100">
                                        <div class="card-image">
                                            <figure class="image is-1by1">
                                                <a href="<?= htmlspecialchars(site_url('index.php?view=nft&id=' . intval($nft->id))) ?>">
                                                    <?php
                                                    $imgSrc = $nft->image_path;
                                                    if (strpos($imgSrc, 'http') === false) $imgSrc = site_url($imgSrc);
                                                    ?>
                                                    <img src="<?= htmlspecialchars($imgSrc) ?>" alt="<?= htmlspecialchars($nft->name) ?>" style="object-fit: cover;">
                                                </a>
                                            </figure>
                                        </div>
                                        <div class="card-content p-4">
                                            <p class="title is-6 mb-2"><?= htmlspecialchars($nft->name) ?></p>

                                            <div class="mb-3">
                                                <?php if ($nft->is_listed): ?>
                                                    <span class="tag is-success is-light">🟢 En Venta: $<?= $nft->price ?></span>
                                                <?php else: ?>
                                                    <span class="tag is-warning is-light">🔒 Privado</span>
                                                <?php endif; ?>
                                            </div>

                                            <?php if ($is_own_profile): ?>
                                                <div class="field is-grouped is-flex-wrap-wrap">

                                                    <p class="control is-expanded mb-2">
                                                        <a href="<?= htmlspecialchars(site_url('index.php?view=nft&id=' . intval($nft->id))) ?>" class="button is-small is-fullwidth">Ver</a>
                                                    </p>

                                                    <form action="index.php?view=profile" method="POST" class="control" style="width: 100%;">
                                                        <input type="hidden" name="action" value="toggle_sale">
                                                        <input type="hidden" name="nft_id" value="<?= $nft->id ?>">

                                                        <?php if ($nft->is_listed): ?>
                                                            <input type="hidden" name="is_listed" value="0">
                                                            <input type="hidden" name="price" value="<?= $nft->price ?>">
                                                            <button type="submit" class="button is-small is-danger is-light is-fullwidth" title="Quitar de la tienda">
                                                                <span class="icon is-small"><i class="fas fa-eye-slash"></i></span>
                                                                <span>Quitar</span>
                                                            </button>
                                                        <?php else: ?>
                                                            <div class="field has-addons">
                                                                <p class="control is-expanded">
                                                                    <input class="input is-small" type="number" name="price" placeholder="$ Precio" required min="0" step="0.01">
                                                                    <input type="hidden" name="is_listed" value="1">
                                                                </p>
                                                                <p class="control">
                                                                    <button type="submit" class="button is-small is-success">
                                                                        Vender
                                                                    </button>
                                                                </p>
                                                            </div>
                                                        <?php endif; ?>
                                                    </form>
                                                </div>
                                            <?php else: ?>
                                                <a href="<?= htmlspecialchars(site_url('index.php?view=nft&id=' . intval($nft->id))) ?>" class="button is-small is-fullwidth is-info is-light">Ver Detalles</a>
                                            <?php endif; ?>

                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div class="notification is-dark has-text-centered p-6">
                            <span class="icon is-large has-text-grey"><i class="fas fa-box-open fa-3x"></i></span>
                            <p class="mt-3 is-size-5">No tienes NFTs en tu colección.</p>
                            <a href="index.php?view=home" class="button is-primary mt-3">Explorar Tienda</a>
                        </div>
                    <?php endif; ?>
                </div>

                <?php if ($is_own_profile): ?>
                    <div id="section-created" style="display:none;">
                        <?php if (!empty($created_nfts) && count($created_nfts) > 0): ?>
                            <div class="columns is-multiline">
                                <?php foreach ($created_nfts as $nft): ?>
                                    <div class="column is-6-tablet is-4-desktop">
                                        <div class="card">
                                            <div class="card-image">
                                                <figure class="image is-1by1">
                                                    <?php
                                                    $imgSrc = $nft->image_path;
                                                    if (strpos($imgSrc, 'http') === false) $imgSrc = site_url($imgSrc);
                                                    ?>
                                                    <img src="<?= htmlspecialchars($imgSrc) ?>" alt="<?= htmlspecialchars($nft->name) ?>" style="object-fit: cover;">
                                                </figure>
                                            </div>
                                            <div class="card-content p-3">
                                                <p class="title is-6"><?= htmlspecialchars($nft->name) ?></p>
                                                <p class="subtitle is-7 has-text-grey">Stock: <?= $nft->supply ?></p>
                                                <a href="<?= htmlspecialchars(site_url('index.php?view=nft&id=' . intval($nft->id))) ?>" class="button is-small is-fullwidth is-text">
                                                    Ver Detalles
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php else: ?>
                            <div class="notification is-dark has-text-centered p-6">
                                <p class="is-size-5">Aún no has creado ningún arte digital.</p>
                                <a href="index.php?view=create_post" class="button is-primary mt-3">Crear mi primer NFT</a>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

            </div>
        </div>
    </div>
</section>

<script>
    function showTab(tabName) {
        document.getElementById('section-owned').style.display = 'none';
        const sectionCreated = document.getElementById('section-created');
        if (sectionCreated) sectionCreated.style.display = 'none';

        document.getElementById('tab-owned-li').classList.remove('is-active');
        const tabCreatedLi = document.getElementById('tab-created-li');
        if (tabCreatedLi) tabCreatedLi.classList.remove('is-active');

        document.getElementById('section-' + tabName).style.display = 'block';
        document.getElementById('tab-' + tabName + '-li').classList.add('is-active');
    }
</script>

<?php include 'components/footer.php'; ?>