<div class="hero-parallax__section hero-parallax__section--explore">
  <div class="hero-parallax__explore-container">
    <div class="hero-parallax__explore-content">
      <h2 class="hero-parallax__title">
        <span class="hero-parallax__title-line hero-parallax__title-line--headline ">
          Explore Indonesia's
        </span>
        <span class="hero-parallax__title-line hero-parallax__title-line--highlight ">
          Legendary surf breaks
        </span>
      </h2>
      <div class="hero-parallax__explore-text">
        <p>Get ready to unlock the secrets of the most epic waves on the planet. Sibon Charters invites you on an
          unforgettable journey to the legendary surf breaks of <strong>Mentawai</strong>, <strong>Telos</strong>,
          <strong>Banyaks</strong> and <strong>Enggano</strong>. More than just a trip, we offer a complete immersion
          in the surf paradise, where every wave is a promise and every sunset, a celebration.
        </p>
        <p>With <strong>Sibon Charters</strong>, your experience goes beyond the conventional. Our two modern
          aluminum catamarans were designed to provide the most comfort and safety while you chase the perfect
          wave.</p>
      </div>
    </div>
    <div class="hero-parallax__explore-image">
      <?php
        $surfer_images = ['woman-surfer-tubo.jpg', 'man-surfer-tubo.jpg'];
        $surfer_img    = $surfer_images[array_rand($surfer_images)];
      ?>
      <img src="<?php echo esc_url(get_template_directory_uri() . '/dist/images/bmp/' . $surfer_img); ?>"
        alt="Surfer on the wave" loading="lazy" width="825" height="550">
    </div>
  </div>
</div>
