        <footer id="footer" class="footer">
            <div class="footer__wrapper">

                <div class="footer__info">
                    <div class="footer__contact-item">
                        <span class="footer__contact-icon">
                            <img src="<?php echo esc_url(get_template_directory_uri() . '/dist/images/svg/ico-address.svg'); ?>" alt="" aria-hidden="true" width="32" height="32">
                        </span>
                        <address class="footer__address">
                            Jl. Pulau Karam, Berok Nipah, Kec. Padang Bar., Kota Padang,<br>
                            Sumatera Barat 25119, Indonésia
                        </address>
                    </div>

                    <div class="footer__contact-item">
                        <span class="footer__contact-icon">
                            <img src="<?php echo esc_url(get_template_directory_uri() . '/dist/images/svg/ico-phone.svg'); ?>" alt="" aria-hidden="true" width="32" height="32">
                        </span>
                        <a class="footer__phone" href="tel:+628126703935">+62 812-6703-935</a>
                    </div>
                </div>

                <div class="footer__social">
                    <a class="footer__social-link" href="https://instagram.com/siboncharters" target="_blank" rel="noopener" aria-label="Instagram">
                        <img src="<?php echo esc_url(get_template_directory_uri() . '/dist/images/svg/ico-instagram.svg'); ?>" alt="Instagram" width="33" height="33">
                    </a>
                    <a class="footer__social-link" href="https://facebook.com/siboncharters" target="_blank" rel="noopener" aria-label="Facebook">
                        <img src="<?php echo esc_url(get_template_directory_uri() . '/dist/images/svg/ico-facebook.svg'); ?>" alt="Facebook" width="33" height="33">
                    </a>
                </div>

            </div>

            <div class="footer__bottom">
                <p class="footer__copyright">Copyright &copy; 2010-<?php echo date('Y'); ?> Sibon Charters. All rights reserved.</p>
            </div>
        </footer>

    </body>
    <?php wp_footer() ?>

</html>
