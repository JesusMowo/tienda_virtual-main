<footer class="footer" style="background-color: #1a1a2e; padding: 3rem 1.5rem 1rem;">
    <div class="container">
        <div class="columns is-6">
            <div class="column is-5">
                <h5 class="title is-5 has-text-primary">Acerca de la página</h5>
                <p class="is-size-6 has-text-grey-light">
                    Flavio Tokens es el mercado definitivo para coleccionables digitales exclusivos.
                    Seguridad y estilo en cada transacción.
                </p>
            </div>

            <div class="column is-4 ml-5">
                <h5 class="title is-5 has-text-white">Redes Sociales</h5>
                <div class="is-flex" style="gap: 15px;">
                    <a href="#" class="is-size-4 has-text-grey-light hover-primary"><i class="fa-brands fa-facebook"></i></a>
                    <a href="#" class="is-size-4 has-text-grey-light hover-primary"><i class="fa-brands fa-instagram"></i></a>
                    <a href="#" class="is-size-4 has-text-grey-light hover-primary"><i class="fa-brands fa-twitter"></i></a>
                    <a href="#" class="is-size-4 has-text-grey-light hover-primary"><i class="fa-brands fa-linkedin-in"></i></a>
                </div>
            </div>

            <div class="column is-4">
                <h5 class="title is-5 has-text-white">Contáctanos</h5>
                <ul>
                    <li class="mb-2 has-text-grey-light">
                        <span class="icon has-text-primary"><i class="fas fa-envelope"></i></span>
                        <a href="mailto:tienda@flaviotokens.com" class="has-text-grey-light hover-primary">tienda@flaviotokens.com</a>
                    </li>
                    <li class="mb-2 has-text-grey-light">
                        <span class="icon has-text-primary"><i class="fas fa-phone"></i></span>
                        <a href="tel:+584121234567" class="has-text-grey-light hover-primary">+58 412 123-4567</a>
                    </li>
                    <li class="has-text-grey-light">
                        <span class="icon has-text-primary"><i class="fas fa-map-marker-alt"></i></span>
                        <span>Nueva Esparta, Venezuela</span>
                    </li>
                </ul>
            </div>
        </div>

        <div class="content has-text-centered mt-5 pt-4" style="border-top: 1px solid #3b3b6b;">
            <p class="is-size-7 has-text-grey">
                © <?php echo date("Y"); ?> Flavio Tokens. Todos los derechos reservados.
            </p>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const $navbarBurgers = Array.prototype.slice.call(document.querySelectorAll('.navbar-burger'), 0);
            if ($navbarBurgers.length > 0) {
                $navbarBurgers.forEach(el => {
                    el.addEventListener('click', () => {
                        const target = el.dataset.target;
                        const $target = document.getElementById(target);
                        el.classList.toggle('is-active');
                        $target.classList.toggle('is-active');
                    });
                });
            }
        });
    </script>
</footer>
</body>

</html>