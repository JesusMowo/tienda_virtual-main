<?php include __DIR__ . '/../components/header.php'; ?>

<section class="section" style="min-height: 80vh; display: flex; align-items: center;">
    <div class="container">
        <div class="columns is-centered">
            <div class="column is-5-tablet is-4-desktop">

                <div class="card" style="border: 1px solid var(--ft-purple); box-shadow: 0 0 20px rgba(136, 75, 255, 0.1);">
                    <div class="card-content">

                        <div class="has-text-centered mb-5">
                            <span class="icon is-large has-text-primary mb-2">
                                <i class="fas fa-unlock-alt fa-3x"></i>
                            </span>
                            <h1 class="title is-4">Recuperar Acceso</h1>
                            <p class="subtitle is-6 has-text-grey">Restablece tu contraseña de inmediato</p>
                        </div>

                        <?php if (!empty($error)): ?>
                            <div class="notification is-danger is-light">
                                <button class="delete"></button>
                                <span class="icon mr-2"><i class="fas fa-exclamation-circle"></i></span>
                                <?= $error ?>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($success)): ?>
                            <div class="notification is-success is-light has-text-centered">
                                <span class="icon is-large"><i class="fas fa-check-circle fa-2x"></i></span>
                                <p class="is-size-5 has-text-weight-bold mt-2">¡Listo!</p>
                                <p class="mb-4"><?= $success ?></p>
                                <a href="index.php?view=login" class="button is-success is-fullwidth">
                                    Iniciar Sesión Ahora
                                </a>
                            </div>

                        <?php else: ?>
                            <form action="index.php?view=recovery" method="POST">

                                <div class="field">
                                    <label class="label">Correo Registrado</label>
                                    <div class="control has-icons-left">
                                        <input class="input" type="email" name="email" placeholder="ejemplo@correo.com" required>
                                        <span class="icon is-small is-left">
                                            <i class="fas fa-envelope"></i>
                                        </span>
                                    </div>
                                </div>

                                <div class="field">
                                    <label class="label">Nueva Contraseña</label>
                                    <div class="control has-icons-left">
                                        <input class="input" type="password" name="password" placeholder="Mínimo 6 caracteres" required minlength="6">
                                        <span class="icon is-small is-left">
                                            <i class="fas fa-key"></i>
                                        </span>
                                    </div>
                                </div>

                                <button type="submit" class="button is-primary is-fullwidth mt-5 shadow-hover">
                                    <span class="icon"><i class="fas fa-sync-alt"></i></span>
                                    <span>Cambiar Contraseña</span>
                                </button>

                                <div class="has-text-centered mt-4">
                                    <a href="index.php?view=login" class="is-size-7 has-text-grey-light hover-link">
                                        <i class="fas fa-arrow-left"></i> Volver al Login
                                    </a>
                                </div>

                            </form>
                        <?php endif; ?>

                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

<script>
    document.querySelectorAll('.notification .delete').forEach(($delete) => {
        $delete.addEventListener('click', () => {
            $delete.parentNode.remove();
        });
    });
</script>

<?php include __DIR__ . '/../components/footer.php'; ?>