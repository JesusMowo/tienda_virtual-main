<?php include __DIR__ . '/../components/header.php'; ?>

<section class="section">
    <div class="container">

        <div class="level">
            <div class="level-left">
                <div>
                    <h1 class="title is-2 has-text-white">
                        <span class="icon mr-2 has-text-info"><i class="fas fa-chart-line"></i></span>
                        <?php if ($target_user_id === $current_user_id): ?>
                            Tu Reporte Financiero
                        <?php else: ?>
                            Reporte de <?= $target_user_name ?>
                        <?php endif; ?>
                    </h1>

                    <p class="subtitle is-6 has-text-grey-light">
                        <?php if ($role === 'owner'): ?>
                            Vista Global de la Plataforma (Modo CEO)
                        <?php elseif ($target_user_id !== $current_user_id): ?>
                            Resumen de actividad para el usuario <?= $target_user_name ?>
                        <?php else: ?>
                            Resumen de tu actividad personal
                        <?php endif; ?>
                    </p>
                </div>
            </div>
            <div class="level-right">
                <a href="index.php?view=wallet" class="button is-primary is-medium shadow-hover">
                    <span class="icon"><i class="fas fa-wallet"></i></span>
                    <span>Ir a mi Billetera</span>
                </a>
            </div>
        </div>

        <hr class="has-background-grey-dark">

        <div class="columns is-variable is-6 mb-6">

            <?php if ($role === 'owner'): ?>
                <div class="column">
                    <div class="box has-background-black-ter has-text-centered" style="border: 2px solid #FFD700;">
                        <p class="heading has-text-warning has-text-weight-bold is-size-6">Ganancia Neta (Web)</p>
                        <p class="title is-1 has-text-warning" style="text-shadow: 0 0 10px rgba(255, 215, 0, 0.3);">
                            $<?= number_format($platform_profit, 2) ?>
                        </p>
                        <p class="is-size-7 has-text-grey-light">Comisiones acumuladas (5%)</p>
                    </div>
                </div>
            <?php else: ?>
                <div class="column">
                    <div class="box has-background-black-ter has-text-centered" style="border: 2px solid #48c774;">
                        <p class="heading has-text-success has-text-weight-bold is-size-6">Ingresos (Ventas)</p>
                        <p class="title is-1 has-text-success" style="text-shadow: 0 0 10px rgba(72, 199, 116, 0.3);">
                            +$<?= number_format($total_income, 2) ?>
                        </p>
                    </div>
                </div>
                <div class="column">
                    <div class="box has-background-black-ter has-text-centered" style="border: 2px solid #f14668;">
                        <p class="heading has-text-danger has-text-weight-bold is-size-6">Gastos (Compras)</p>
                        <p class="title is-1 has-text-danger" style="text-shadow: 0 0 10px rgba(241, 70, 104, 0.3);">
                            -$<?= number_format($total_spent, 2) ?>
                        </p>
                    </div>
                </div>
            <?php endif; ?>

        </div>

        <div class="box has-background-dark" style="border: 1px solid var(--ft-purple);">
            <h3 class="title is-4 has-text-white mb-4">
                <span class="icon is-small mr-2"><i class="fas fa-list"></i></span>
                Historial de Movimientos
            </h3>

            <div class="table-container">
                <table class="table is-fullwidth is-hoverable has-background-dark has-text-light">
                    <thead>
                        <tr>
                            <th class="has-text-grey-light">ID</th>
                            <th class="has-text-grey-light">Fecha</th>
                            <th class="has-text-grey-light">Detalle Transacción</th>
                            <th class="has-text-grey-light">Tipo</th>
                            <th class="has-text-grey-light">Descripción</th>
                            <th class="has-text-right has-text-grey-light">Monto</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($transactions as $t): ?>
                            <tr>
                                <td><small class="has-text-grey">#<?= $t->id ?></small></td>
                                <td class="has-text-white-ter"><?= date("d/m/y H:i", strtotime($t->created_at)) ?></td>

                                <td>
                                    <?php

                                    $is_self = ($target_user_id === $current_user_id);
                                    $self_ref = $is_self ? "Tú" : $target_user_name;

                                    if ($role === 'owner' && $t->user_id != $current_user_id) {
                                        echo "<strong class='has-text-info'>" . htmlspecialchars($t->user_name) . "</strong>";

                                        if ($t->counterparty_id) {
                                            echo " <span class='has-text-grey is-size-7'><i class='fas fa-arrow-right'></i></span> " . htmlspecialchars($t->counterparty_name ?? "Sistema");
                                        } elseif ($t->type === 'fee') {
                                            echo " <span class='has-text-grey is-size-7'><i class='fas fa-arrow-right'></i></span> Plataforma";
                                        }
                                    }
                                    
                                    elseif ($t->user_id === $target_user_id) {
                                        if ($t->type === 'purchase') {
                                            echo "<span class='tag is-dark'>" . $self_ref . "</span>";
                                            echo " <small class='has-text-grey'>pagaste a</small> ";
                                            echo "<strong class='has-text-white'>" . ($t->counterparty_name ? htmlspecialchars($t->counterparty_name) : "Tienda") . "</strong>";
                                        } elseif ($t->type === 'sale') {

                                            echo "<strong class='has-text-white'>" . ($t->counterparty_name ? htmlspecialchars($t->counterparty_name) : "Alguien") . "</strong>";

                                            if ($is_self) {
                                                echo " <small class='has-text-grey'>te pagó</small>";
                                            } else {
                                                echo " <small class='has-text-grey'>pagó a</small> ";
                                                echo "<span class='tag is-dark'>" . $self_ref . "</span>";
                                            }
                                        } elseif ($t->type === 'deposit') {
                                            echo "<span class='has-text-grey-light'><i class='fas fa-university'></i> Banco / Sistema</span>";
                                        } elseif ($t->type === 'fee') { 

                                            echo "<span class='has-text-warning'>Comisión de Venta</span> ";
                                            echo "<small class='has-text-grey'>pagada por</small> ";
                                            echo "<span class='tag is-dark'>" . $self_ref . "</span>";
                                        } else {
                                            echo "Sistema";
                                        }
                                    }

                                    else {

                                        echo "<span class='has-text-grey'>Transacción de Sistema o No Clasificada</span>";
                                    }
                                    ?>
                                </td>

                                <td>
                                    <?php
                                    switch ($t->type) {
                                        case 'deposit':
                                            echo '<span class="tag is-info">Recarga</span>';
                                            break;
                                        case 'purchase':
                                            echo '<span class="tag is-danger">Compra</span>';
                                            break;
                                        case 'sale':
                                            echo '<span class="tag is-success">Venta</span>';
                                            break;
                                        case 'fee':
                                            echo '<span class="tag is-warning has-text-black">Comisión</span>';
                                            break;
                                        default:
                                            echo $t->type;
                                    }
                                    ?>
                                </td>
                                <td class="has-text-grey-lighter"><?= htmlspecialchars($t->description) ?></td>
                                <td class="has-text-right is-size-5 font-monospace">
                                    <?php if ($t->amount > 0): ?>
                                        <span class="has-text-success">+$<?= number_format($t->amount, 2) ?></span>
                                    <?php else: ?>
                                        <span class="has-text-danger">$<?= number_format($t->amount, 2) ?></span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>

                        <?php if (empty($transactions)): ?>
                            <tr>
                                <td colspan="6" class="has-text-centered p-5 has-text-grey">
                                    No hay movimientos registrados aún.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</section>

<?php include __DIR__ . '/../components/footer.php'; ?>s