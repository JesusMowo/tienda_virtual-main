<?php include __DIR__ . '/../components/header.php'; ?>

<section class="section" style="min-height: 80vh; display: flex; align-items: center;">
    <div class="container">
        <div class="columns is-centered">
            <div class="column is-5-tablet is-4-desktop">

                <div class="card" style="border: 1px solid var(--ft-purple);">
                    <div class="card-content">
                        <div class="has-text-centered mb-5">
                            <h1 class="title is-3">Crear Cuenta</h1>
                            <p class="subtitle is-6 has-text-grey">Únete a la comunidad del Decano</p>
                        </div>

                        <?php if (!empty($error)): ?>
                            <div class="notification is-danger is-light is-size-7">
                                <?= $error ?>
                            </div>
                        <?php endif; ?>

                        <form action="index.php?view=register" method="POST">

                            <div class="field">
                                <label class="label">Nombre Completo</label>
                                <div class="control has-icons-left">
                                    <input class="input" type="text" name="name" placeholder="Ej. Flavio Decano" required value="<?= htmlspecialchars($name ?? '') ?>">
                                    <span class="icon is-small is-left">
                                        <i class="fas fa-user"></i>
                                    </span>
                                </div>
                            </div>

                            <div class="field">
                                <label class="label">Correo Electrónico</label>
                                <div class="control has-icons-left">
                                    <input class="input" type="email" name="email" placeholder="usuario@email.com" required value="<?= htmlspecialchars($email ?? '') ?>">
                                    <span class="icon is-small is-left">
                                        <i class="fas fa-envelope"></i>
                                    </span>
                                </div>
                            </div>

                            <div class="field">
                                <label class="label">Contraseña</label>
                                <div class="control has-icons-left">
                                    <input class="input" type="password" name="password" placeholder="********" required>
                                    <span class="icon is-small is-left">
                                        <i class="fas fa-lock"></i>
                                    </span>
                                </div>
                            </div>

                            <div class="field">
                                <label class="label">Confirmar Contraseña</label>
                                <div class="control has-icons-left">
                                    <input class="input" type="password" name="confirm_password" placeholder="********" required>
                                    <span class="icon is-small is-left">
                                        <i class="fas fa-check-circle"></i>
                                    </span>
                                </div>
                            </div>

                            <div class="field mt-5">
                                <button class="button is-primary is-fullwidth has-text-weight-bold">
                                    Registrarse
                                </button>
                            </div>
                        </form>

                        <div class="has-text-centered mt-4 is-size-7">
                            <p>¿Ya tienes cuenta?</p>
                            <a href="index.php?view=login" class="has-text-primary has-text-weight-bold">Inicia sesión aquí</a>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

<?php include __DIR__ . '/../components/footer.php'; ?>