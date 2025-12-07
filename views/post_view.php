<?php include __DIR__ . '/../components/header.php'; ?>

<section class="section" style="min-height: 80vh;">
    <div class="container">
        <div class="columns is-centered">
            <div class="column is-6-desktop">

                <div class="card has-background-dark p-4 post-card" style="border: 2px solid var(--ft-purple); border-radius: 8px;">
                    <div class="card-content">
                        <h2 class="title is-3 has-text-centered mb-5 has-text-white">
                            <span class="icon is-large has-text-primary mr-2"><i class="fas fa-upload"></i></span>
                            <span class="has-text-primary">Nuevo</span> Drop NFT
                        </h2>

                        <?php if (!empty($error)): ?>
                            <div class="notification is-danger is-light mb-4">
                                <button class="delete"></button>
                                <?= $error ?>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($success)): ?>
                            <div class="notification is-success is-light mb-4">
                                <button class="delete"></button>
                                <span class="icon mr-1"><i class="fas fa-check-circle"></i></span>
                                <?= $success ?> <a href="index.php" class="has-text-success-dark has-text-weight-bold">Ver en tienda</a>
                            </div>
                        <?php endif; ?>

                        <form action="index.php?view=create_post" method="POST" enctype="multipart/form-data">

                            <div class="field">
                                <label class="label has-text-white">Nombre del NFT <span class="has-text-primary">*</span></label>
                                <div class="control">
                                    <input class="input is-dark" type="text" name="name" placeholder="Ej. El Decano #001 (Máximo 50 caracteres)" maxlength="50" required>
                                </div>
                            </div>

                            <div class="field">
                                <label class="label has-text-white">Descripción</label>
                                <div class="control">
                                    <textarea class="textarea is-dark" name="description" placeholder="Cuenta la historia detrás de tu token, los beneficios que incluye, etc."></textarea>
                                </div>
                            </div>

                            <div class="field">
                                <label class="label has-text-white">Archivo de Imagen (JPG, PNG) <span class="has-text-primary">*</span></label>
                                <div class="file has-name is-fullwidth is-primary is-boxed upload-box" style="border: 1px dashed var(--ft-green);">
                                    <label class="file-label" style="justify-content: center;">
                                        <input class="file-input" type="file" name="image" id="fileInput" accept="image/jpeg, image/png, image/gif" required>
                                        <span class="file-cta is-centered"> <span class="file-icon"><i class="fas fa-cloud-upload-alt"></i></span>

                                        <span class="file-name has-text-white" id="fileName">Aún no se ha cargado la imagen</span>
                                    </label>
                                </div>
                                <p class="help has-text-grey is-size-7 mt-2">Formatos aceptados: JPG, PNG, GIF. Tamaño máximo: 5MB.</p>
                            </div>

                            <hr class="has-background-grey-dark">

                            <div class="field mt-4">
                                <label class="label has-text-white">Tipo de Listado</label>
                                <div class="control has-text-grey-light">
                                    <label class="radio mr-5">
                                        <input type="radio" name="price_type" value="paid" checked onchange="togglePrice(true)">
                                        <span class="has-text-weight-bold has-text-white">Pago</span>
                                    </label>
                                    <label class="radio">
                                        <input type="radio" name="price_type" value="free" onchange="togglePrice(false)">
                                        <span class="has-text-success has-text-weight-bold">Gratis (Gift)</span>
                                    </label>
                                </div>
                            </div>

                            <div class="field" id="priceContainer">
                                <label class="label has-text-white">Precio (USD) <span class="has-text-primary">*</span></label>
                                <div class="control has-icons-left">
                                    <input class="input is-dark" type="number" step="0.01" name="price" id="priceInput" placeholder="10.00" value="0.00" min="0.01">
                                    <span class="icon is-small is-left has-text-primary"><i class="fas fa-dollar-sign"></i></span>
                                </div>
                            </div>

                            <div class="buttons mt-5">
                                <button type="submit" class="button is-primary is-fullwidth is-medium has-text-weight-bold shadow-hover is-rounded">
                                    <span class="icon"><i class="fas fa-bolt"></i></span>
                                    <span>Publicar NFT en el Marketplace</span>
                                </button>
                                <a href="index.php?view=profile" class="button is-text is-fullwidth has-text-grey hover-primary">
                                    <span class="icon"><i class="fas fa-times"></i></span>
                                    <span>Cancelar y Volver</span>
                                </a>
                            </div>

                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

<script>
    const fileInput = document.querySelector('#fileInput');
    const fileName = document.querySelector('#fileName');
    fileInput.addEventListener('change', () => {
        if (fileInput.files.length > 0) fileName.textContent = fileInput.files[0].name;
    });

    function togglePrice(isPaid) {
        const container = document.getElementById('priceContainer');
        const input = document.getElementById('priceInput');

        if (isPaid) {
            container.style.display = 'block';
            input.disabled = false;
            input.required = true;
            input.min = "0.01";
            if (input.value === '0.00') input.value = '';
        } else {
            container.style.display = 'none';
            input.disabled = true;
            input.required = false;
            input.value = '0.00';
            input.min = "0.00";
        }
    }
    document.addEventListener('DOMContentLoaded', () => {
        togglePrice(document.querySelector('input[name="price_type"][value="paid"]').checked);
    });

    document.querySelectorAll('.notification .delete').forEach(($delete) => {
        $delete.addEventListener('click', () => $delete.parentNode.remove());
    });
</script>

<?php include __DIR__ . '/../components/footer.php'; ?>