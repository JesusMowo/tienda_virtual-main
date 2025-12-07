<form action="index.php" method="GET" class="mb-5">
    <input type="hidden" name="view" value="<?= htmlspecialchars($_GET['view'] ?? 'home') ?>">

    <div class="field has-addons">
        <div class="control is-expanded has-icons-left">
            <input class="input is-medium is-dark" type="text" name="q"
                placeholder="Buscar por nombre o descripción..."
                value="<?= htmlspecialchars($search_query ?? '') ?>">
            <span class="icon is-left">
                <i class="fas fa-search"></i>
            </span>
        </div>
        <div class="control">
            <button type="submit" class="button is-primary is-medium">
                Buscar
            </button>
        </div>
        <?php if (!empty($search_query)): ?>
            <div class="control">
                <a href="index.php?view=<?= htmlspecialchars($_GET['view'] ?? 'home') ?>" class="button is-danger is-medium is-light">
                    <span class="icon"><i class="fas fa-times"></i></span>
                </a>
            </div>
        <?php endif; ?>
    </div>
</form>