<?php include 'components/header.php'; ?>

<section class="section" style="padding-top: 3rem;">
    <div class="container">

        <div class="mb-5 p-3" style="background-color: #1a1a2e; border-radius: 8px; border-left: 5px solid var(--ft-purple);">
            <h1 class="title is-3 has-text-white mb-1">
                <span class="icon is-medium mr-2 has-text-primary"><i class="fas fa-store"></i></span>
                Marketplace NFT
            </h1>
            <p class="subtitle is-6 has-text-grey-light mb-0 ml-5 mt-5">Explora y colecciona los Tokens No Fungibles disponibles en nuestro ecosistema.</p>
        </div>

        <?php include __DIR__ . '/../components/search_bar.php'; ?>
        <div class="columns is-multiline mt-5">
            <?php if (!empty($nfts)): ?>
                <?php foreach ($nfts as $nft): ?>
                    <div class="column is-6-tablet is-4-desktop is-3-widescreen is-one-fifth-fullhd">
                        <?php
                        include __DIR__ . '/../components/card_nft.php';
                        ?>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="column is-12">
                    <div class="notification is-dark has-text-centered" style="border: 1px dashed var(--ft-purple);">
                        <span class="icon is-large has-text-primary"><i class="fas fa-search-minus fa-3x"></i></span>
                        <p class="mt-3 is-size-5 has-text-white">No se encontraron NFTs que coincidan con la búsqueda.</p>
                        <p class="is-size-7 has-text-grey">Intenta refinar tus términos de búsqueda o revisa la ortografía.</p>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <?php if (isset($total_pages) && $total_pages > 1): ?>
            <?php include __DIR__ . '/../components/pagination.php'; ?>
        <?php endif; ?>

    </div>
</section>

<?php include 'components/footer.php'; ?>