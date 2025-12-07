<?php
$nft_id = intval($nft['id'] ?? $nft->id);
$nft_name = htmlspecialchars($nft['name'] ?? $nft->name);
$nft_price = htmlspecialchars($nft['price'] ?? $nft->price);
$nft_image_path = htmlspecialchars($nft['image_path'] ?? $nft->image_path);
$nft_is_listed = $nft['is_listed'] ?? $nft->is_listed;

$imgSrc = $nft_image_path;
if (strpos($imgSrc, 'http') === false) {
    $imgSrc = site_url($imgSrc);
}
?>

<div class="card h-100">
    <div class="card-image">
        <figure class="image is-1by1">
            <a href="index.php?view=nft&id=<?= $nft_id ?>">
                <img src="<?= $imgSrc ?>" alt="<?= $nft_name ?>" style="object-fit: cover;">
            </a>
        </figure>
    </div>
    <div class="card-content p-4">
        <p class="title is-6 mb-2"><?= $nft_name ?></p>

        <div class="mb-3">
            <?php if ($nft_is_listed): ?>
                <span class="tag is-success is-light">💰 Precio: $<?= $nft_price ?></span>
            <?php else: ?>
                <span class="tag is-warning is-light">🔒 No Listado</span>
            <?php endif; ?>
        </div>

        <a href="index.php?view=nft&id=<?= $nft_id ?>" class="button is-primary is-small is-fullwidth">
            Ver Detalles
        </a>
    </div>
</div>