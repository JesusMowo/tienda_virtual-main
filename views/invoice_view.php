<?php include __DIR__ . '/../components/header.php'; ?>

<section class="section" style="min-height: 80vh;">
    <div class="container">
        <div class="columns is-centered">
            <div class="column is-6-desktop">

                <div class="box has-background-white has-text-black p-6 invoice-box" id="printableArea" style="border-top: 5px solid var(--ft-purple); box-shadow: 0 0 20px rgba(0,0,0,0.3);">

                    <div class="has-text-centered mb-5">
                        <h1 class="title is-3 has-text-black" style="font-family: 'Montserrat', sans-serif;">
                            <span class="has-text-primary">FLAVIO</span> TOKENS
                        </h1>
                        <p class="subtitle is-6 has-text-grey">Comprobante de Pago Oficial</p>
                    </div>

                    <hr class="has-background-grey-lighter">

                    <div class="columns is-mobile is-multiline">
                        <div class="column is-half">
                            <p class="is-size-7 has-text-grey">Fecha de Emisión</p>
                            <p class="has-text-weight-bold has-text-dark is-size-6"><?= date("d/m/Y H:i", strtotime($invoice->created_at)) ?></p>
                        </div>
                        <div class="column is-half has-text-right">
                            <p class="is-size-7 has-text-grey">N° Factura</p>
                            <p class="has-text-weight-bold has-text-primary is-size-5">#<?= str_pad($invoice->id, 6, "0", STR_PAD_LEFT) ?></p>
                        </div>
                        <div class="column is-full mt-3">
                            <p class="is-size-7 has-text-grey">Cliente</p>
                            <p class="has-text-weight-bold has-text-dark is-size-6"><?= htmlspecialchars($invoice->customer_name ?? 'N/A') ?></p>
                        </div>
                    </div>

                    <h4 class="title is-5 mt-5 mb-3 has-text-dark">Detalle de la Compra</h4>

                    <div class="table-container mt-4">
                        <table class="table is-fullwidth is-striped" style="border-radius: 4px; overflow: hidden;">
                            <thead>
                                <tr style="background-color: #f5f5f5;">
                                    <th class="has-text-dark">Descripción</th>
                                    <th class="has-text-right has-text-dark">Monto (USD)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Compra de Coleccionables Digitales (NFTs)</td>
                                    <td class="has-text-right">$<?= number_format($invoice->total_price, 2) ?></td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th class="is-size-5 has-text-dark">TOTAL PAGADO</th>
                                    <th class="has-text-right is-size-5 has-text-success">$<?= number_format($invoice->total_price, 2) ?></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <div class="content is-small has-text-centered mt-5 has-text-grey">
                        <p><span class="has-text-dark has-text-weight-bold">¡Transacción Completa!</span> <br> Gracias por confiar en Flavio Tokens. Este documento es un comprobante válido de su transacción.</p>
                        <p class="is-size-7 mt-3">
                            <span class="icon is-small has-text-primary"><i class="fas fa-link"></i></span> Referencia Blockchain: <a href="#" class="has-text-info is-italic">Ver Hash (simulado)</a>
                        </p>
                    </div>
                </div>

                <div class="buttons is-centered mt-5 no-print">
                    <button onclick="window.print()" class="button is-primary is-rounded has-text-weight-bold shadow-hover">
                        <span class="icon"><i class="fas fa-print"></i></span>
                        <span>Imprimir Factura</span>
                    </button>
                    <a href="index.php?view=home" class="button is-text has-text-light hover-primary">
                        <span class="icon"><i class="fas fa-arrow-left"></i></span>
                        <span>Volver a la Tienda</span>
                    </a>
                </div>

            </div>
        </div>
    </div>
</section>

<?php include __DIR__ . '/../components/footer.php'; ?>