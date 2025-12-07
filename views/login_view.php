<?php include __DIR__ . '/../components/header.php'; ?>

<section class="section" style="min-height: 80vh; display: flex; align-items: center;">
    <div class="container">
        <div class="columns is-centered">
            <div class="column is-5-tablet is-4-desktop">

                <div class="card" style="border: 1px solid var(--ft-purple);">
                    <div class="card-content">
                        <div class="has-text-centered mb-5">
                            <h1 class="title is-3">Iniciar Sesión</h1>
                            <p class="subtitle is-6 has-text-grey">Bienvenido de nuevo a Flavio Tokens</p>
                        </div>

                        <?php if (!empty($error)): ?>
                            <div class="notification is-danger is-light is-size-7">
                                <?= $error ?>
                            </div>
                        <?php endif; ?>

                        <?php if (isset($_GET['registered'])): ?>
                            <div class="notification is-success is-light is-size-7">
                                ¡Cuenta creada! Por favor inicia sesión.
                            </div>
                        <?php endif; ?>

                        <form action="index.php?view=login" method="POST">

                            <div class="field">
                                <label class="label">Correo Electrónico</label>
                                <div class="control has-icons-left">
                                    <input class="input" type="email" name="email" placeholder="ejemplo@correo.com" required>
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

                            <div class="field mt-5">
                                <button class="button is-primary is-fullwidth has-text-weight-bold">
                                    Entrar
                                </button>
                            </div>
                        </form>

                        <p class="has-text-centered mt-3">
                            <a href="index.php?view=recovery" class="is-size-7 has-text-grey">¿Olvidaste tu contraseña?</a>
                        </p>

                        <div class="has-text-centered mt-4 is-size-7">
                            <p>¿No tienes cuenta?</p>
                            <a href="index.php?view=register" class="has-text-primary has-text-weight-bold">Regístrate aquí</a>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

<?php include __DIR__ . '/../components/footer.php'; ?>