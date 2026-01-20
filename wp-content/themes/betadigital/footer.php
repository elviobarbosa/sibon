        <footer id="footer" class="footer">
            <div class="footer__wrapper">
                <div class="footer__logo">
                    <svg role="img" aria-labelledby="logo-title">
                        <title id="logo-title">Hub Mercantil</title>
                        <use href="<?php echo SVGPATH ?>logo-hub-mercantil"></use>
                    </svg>
                </div>
               
                <div class="footer__menu">
                    <?php
                    wp_nav_menu(
                        array(
                            'theme_location' => 'footer-menu',
                            'container' => false,
                            'menu_class' => 'footer__list',
                            'menu_id' => 'footer-menu'
                        )
                    );
                    ?>
                </div>
                
                <ul class="redes-sociais">
                    <li>
                        <svg role="img" aria-labelledby="logo-title">
                            <title id="logo-facebook">Facebook</title>
                            <use href="<?php echo SVGPATH ?>facebook"></use>
                        </svg>
                    </li>
                    <li>
                        <svg role="img" aria-labelledby="logo-title">
                            <title id="logo-instagram">Instagram</title>
                            <use href="<?php echo SVGPATH ?>instagram"></use>
                        </svg>
                    </li>
                    <li>
                        <svg role="img" aria-labelledby="logo-title">
                            <title id="logo-instagram">X</title>
                            <use href="<?php echo SVGPATH ?>x"></use>
                        </svg>
                    </li>
                </ul>
            </div>
        </footer>

        

    </body>
    <?php wp_footer() ?>
    
</html>