<?php include __DIR__ . '/../components/header.php'; ?>

<section class="section">
    <div class="container">
        <div class="columns is-centered">
            <div class="column is-6-desktop is-8-tablet">

                <div class="card" style="border: 1px solid var(--ft-purple);">
                    <div class="card-content">

                        <div class="has-text-centered mb-5">
                            <span class="icon is-large has-text-primary mb-2">
                                <i class="fas fa-wallet fa-3x"></i>
                            </span>
                            <h1 class="title is-3">Mi Billetera</h1>
                            <p class="subtitle is-6 has-text-grey">Gestiona tus fondos en Flavio Tokens</p>
                        </div>

                        <div class="notification is-dark has-text-centered mb-5" style="border: 1px solid var(--ft-green);">
                            <p class="heading has-text-grey-light">Saldo Disponible</p>
                            <h2 class="title is-2 has-text-success">$<?= number_format($current_balance, 2) ?> USD</h2>
                        </div>

                        <?php if ($success): ?>
                            <div class="notification is-success is-light">
                                <button class="delete"></button>
                                <?= $success ?>
                            </div>
                        <?php endif; ?>

                        <?php if ($error): ?>
                            <div class="notification is-danger is-light">
                                <button class="delete"></button>
                                <?= $error ?>
                            </div>
                        <?php endif; ?>

                        <form action="index.php?view=wallet" method="POST">

                            <label class="label">Método de Recarga</label>
                            <div class="columns is-mobile is-multiline mb-4">
                                <div class="column is-4">
                                    <label class="box has-text-centered p-3 is-clickable radio-box selected" onclick="selectMethod(this)">
                                        <input type="radio" name="method" value="credit_card" checked style="display:none;">
                                        <span class="icon is-medium has-text-info"><i class="fas fa-credit-card fa-2x"></i></span>
                                        <p class="is-size-7 mt-1">Tarjeta</p>
                                    </label>
                                </div>
                                <div class="column is-4">
                                    <label class="box has-text-centered p-3 is-clickable radio-box" onclick="selectMethod(this)">
                                        <input type="radio" name="method" value="paypal" style="display:none;">
                                        <span class="icon is-medium has-text-link"><i class="fab fa-paypal fa-2x"></i></span>
                                        <p class="is-size-7 mt-1">PayPal</p>
                                    </label>
                                </div>
                                <div class="column is-4">
                                    <label class="box has-text-centered p-3 is-clickable radio-box" onclick="selectMethod(this)">
                                        <input type="radio" name="method" value="crypto" style="display:none;">
                                        <span class="icon is-medium has-text-warning"><i class="fab fa-bitcoin fa-2x"></i></span>
                                        <p class="is-size-7 mt-1">Cripto</p>
                                    </label>
                                </div>
                            </div>

                            <div class="field">
                                <label class="label">Monto a Recargar ($)</label>
                                <div class="control has-icons-left">
                                    <input class="input is-medium" type="number" name="amount" placeholder="100.00" min="5" step="0.01" required>
                                    <span class="icon is-left">
                                        <i class="fas fa-dollar-sign"></i>
                                    </span>
                                </div>
                                <p class="help">Mínimo $5.00</p>
                            </div>

                            <button type="submit" class="button is-primary is-fullwidth is-medium mt-4">
                                <span class="icon"><i class="fas fa-plus-circle"></i></span>
                                <span>Procesar Recarga</span>
                            </button>
                        </form>

                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

<script>
    function selectMethod(element) {
        document.querySelectorAll('.radio-box').forEach(el => el.classList.remove('selected'));
        element.classList.add('selected');
        element.querySelector('input').checked = true;
    }

    document.querySelectorAll('.notification .delete').forEach(($delete) => {
        $delete.addEventListener('click', () => {
            $delete.parentNode.remove();
        });
    });
</script>

<?php include __DIR__ . '/../components/footer.php'; ?>