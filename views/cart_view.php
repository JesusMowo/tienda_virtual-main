<?php include __DIR__ . '/../components/header.php'; ?>

<section class="section" style="min-height: 80vh; padding-top: 3rem;">
    <div class="container">

        <h1 class="title is-2 mb-6 has-text-white">
            <span class="icon has-text-primary mr-2"><i class="fas fa-shopping-cart"></i></span> Tu Carrito
        </h1>

        <?php if (isset($_GET['error']) && $_GET['error'] === 'low_balance'): ?>
            <div class="notification is-danger is-light mb-5 p-4" style="border-left: 5px solid #ff3860;">
                <button class="delete"></button>
                <div class="columns is-vcentered">
                    <div class="column">
                        <span class="icon is-large has-text-danger"><i class="fas fa-exclamation-circle fa-2x"></i></span>
                        <span class="is-size-5 has-text-weight-bold ml-2 has-text-danger">¡Ups! Saldo Insuficiente.</span>
                        <p class="ml-6 has-text-danger-dark">
                            Necesitas <strong>$<?= number_format($_GET['missing'] ?? 0, 2) ?> USD</strong> más para completar la compra.
                        </p>
                    </div>
                    <div class="column is-narrow">
                        <a href="index.php?view=wallet" class="button is-danger is-outlined has-text-weight-bold is-rounded">
                            <span class="icon"><i class="fas fa-plus"></i></span>
                            <span>Recargar Billetera</span>
                        </a>
                    </div>
                </div>
            </div>

            <script>
                document.querySelector('.notification .delete').addEventListener('click', function() {
                    this.parentElement.remove();
                });
            </script>
        <?php endif; ?>

        <div class="columns is-variable is-8">

            <div class="column is-8">
                <?php if ($cart_items && $cart_items->num_rows > 0): ?>
                    <div class="box has-background-dark p-0" style="border: 1px solid var(--ft-purple); border-radius: 8px;">
                        <table class="table is-fullwidth has-background-dark has-text-white is-hoverable" style="border-radius: 8px;">
                            <thead>
                                <tr style="border-bottom: 2px solid #3b3b6b;">
                                    <th class="has-text-grey">NFT</th>
                                    <th class="has-text-grey has-text-right">Precio Unitario</th>
                                    <th class="has-text-grey has-text-centered">Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $total = 0;
                                while ($item = $cart_items->fetch_object()):
                                    $subtotal = $item->price * $item->quantity;
                                    $total += $subtotal;
                                ?>
                                    <tr style="border-bottom: 1px solid #2c2c4a;">
                                        <td class="is-vcentered">
                                            <div class="is-flex is-align-items-center">
                                                <figure class="image is-64x64 mr-4">
                                                    <a href="index.php?view=nft&id=<?= $item->product_id ?>">
                                                        <img src="<?= htmlspecialchars($item->image_path) ?>" class="is-rounded" style="object-fit: cover; border: 2px solid var(--ft-green);">
                                                    </a>
                                                </figure>
                                                <div>
                                                    <p class="is-size-5 has-text-weight-bold">
                                                        <a href="index.php?view=nft&id=<?= $item->product_id ?>" class="has-text-white hover-primary">
                                                            <?= htmlspecialchars($item->name) ?>
                                                        </a>
                                                    </p>
                                                    <p class="is-size-7 has-text-grey">ID: #<?= $item->product_id ?></p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="is-vcentered has-text-right has-text-primary is-size-5 has-text-weight-bold">
                                            $<?= number_format($item->price, 2) ?>
                                        </td>
                                        <td class="is-vcentered has-text-centered">
                                            <form action="index.php?view=cart" method="POST">
                                                <input type="hidden" name="action" value="remove">
                                                <input type="hidden" name="cart_id" value="<?= $item->cart_id ?>">
                                                <button type="submit" class="button is-small is-danger is-outlined is-rounded" title="Eliminar NFT">
                                                    <span class="icon"><i class="fas fa-times"></i></span>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="notification is-dark has-text-centered p-6 empty-cart-box" style="border: 2px dashed #3b3b6b;">
                        <span class="icon is-large has-text-primary mb-3"><i class="fas fa-shopping-basket fa-3x"></i></span>
                        <p class="title is-4 has-text-white">Tu carrito está vacío</p>
                        <p class="subtitle is-6 has-text-grey-light">Parece que aún no has encontrado el arte perfecto para coleccionar.</p>
                        <a href="index.php?view=home" class="button is-primary is-rounded mt-4">
                            <span class="icon"><i class="fas fa-store"></i></span>
                            <span>Explorar Marketplace</span>
                        </a>
                    </div>
                <?php endif; ?>
            </div>

            <div class="column is-4">
                <div class="card has-background-dark p-4 summary-card" style="border: 2px solid var(--ft-purple); border-radius: 8px;">
                    <div class="card-content">
                        <h3 class="title is-4 has-text-primary mb-5">
                            <span class="icon mr-1"><i class="fas fa-clipboard-list"></i></span> Resumen de la Orden
                        </h3>

                        <div class="is-flex is-justify-content-space-between mb-2">
                            <span class="has-text-grey-light has-text-weight-bold">Subtotal</span>
                            <span class="has-text-white has-text-weight-bold">$<?= number_format($total, 2) ?></span>
                        </div>
                        <div class="is-flex is-justify-content-space-between mb-4">
                            <span class="has-text-grey-light">Comisión de Plataforma (0%)</span>
                            <span class="has-text-white">$0.00</span>
                        </div>

                        <hr class="has-background-grey-dark" style="margin: 1rem 0;">

                        <div class="is-flex is-justify-content-space-between mb-5">
                            <span class="title is-4 has-text-white">Total a Pagar</span>
                            <span class="title is-4 has-text-success">$<?= number_format($total, 2) ?></span>
                        </div>

                        <?php if ($total > 0): ?>
                            <form action="index.php?view=checkout" method="POST">
                                <input type="hidden" name="total" value="<?= $total ?>">
                                <button type="submit" class="button is-primary is-fullwidth is-medium has-text-weight-bold is-rounded shadow-hover">
                                    <span class="icon mr-2"><i class="fas fa-credit-card"></i></span>
                                    <span>Proceder al Pago</span>
                                </button>
                            </form>
                            <p class="is-size-7 has-text-centered mt-3 has-text-grey">
                                <i class="fas fa-lock"></i> Pago con balance de billetera. 100% seguro.
                            </p>
                        <?php else: ?>
                            <button class="button is-dark is-fullwidth is-medium is-rounded" disabled>
                                 Carrito Vacío
                            </button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<?php include __DIR__ . '/../components/footer.php'; ?>