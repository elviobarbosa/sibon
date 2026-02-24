<section class="hero-parallax">
  <!-- Container das linhas ondulantes (camada de fundo) -->
  <div id="wave-lines-container"></div>

  <!-- Container dos pássaros 3D -->
  <div id="birds-3d-container"
    data-bird-texture="<?php echo esc_url(get_template_directory_uri() . '/dist/images/bmp/birdb.png'); ?>"
    style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: 3; pointer-events: none;"></div>

  <!-- Primeira dobra -->
  <div class="hero-parallax__section hero-parallax__section--first" data-section="1">
    <div class="hero-parallax__content">
      <h1 class="hero-parallax__title">
        <span class="hero-parallax__title-line hero-parallax__title-line--headline animate-text">Enjoy in the</span>
        <span class="hero-parallax__title-line hero-parallax__title-line--highlight animate-text">Wildest nature</span>
      </h1>
    </div>
  </div>

  <!-- Segunda dobra -->
  <div class="hero-parallax__section hero-parallax__section--second" data-section="2">
    <div class="hero-parallax__content">
      <h2 class="hero-parallax__title">
        <span class="hero-parallax__title-line hero-parallax__title-line--headline animate-text">Experience the</span>
        <span class="hero-parallax__title-line hero-parallax__title-line--highlight animate-text">
          Adventure of a lifetime</span>
      </h2>
    </div>
  </div>

  <!-- Transição com nuvens -->
  <!-- <div class="hero-parallax__transition">
    <div class="hero-parallax__clouds">
      <div class="hero-parallax__cloud hero-parallax__cloud--1">
        <img src="<?php echo esc_url(get_template_directory_uri() . '/dist/images/bmp/cloud-out.png'); ?>">
      </div>
      <div class="hero-parallax__cloud hero-parallax__cloud--2">
        <img src="<?php echo esc_url(get_template_directory_uri() . '/dist/images/bmp/cloud-out.png'); ?>">
      </div>
      <div class="hero-parallax__cloud hero-parallax__cloud--3">
        <img src="<?php echo esc_url(get_template_directory_uri() . '/dist/images/bmp/cloud-out.png'); ?>">
      </div>
      <div class="hero-parallax__cloud hero-parallax__cloud--4">
        <img src="<?php echo esc_url(get_template_directory_uri() . '/dist/images/bmp/cloud-out.png'); ?>">
      </div>
      <div class="hero-parallax__cloud hero-parallax__cloud--5">
        <img src="<?php echo esc_url(get_template_directory_uri() . '/dist/images/bmp/cloud-out.png'); ?>">
      </div>
    </div>
  </div> -->

  <!-- Céu com degradê -->
  <div class="hero-parallax__sky">
    <!-- <img src="<?php echo esc_url(get_template_directory_uri() . '/dist/images/bmp/cloud1.png'); ?>" alt="Cloud"
      class="hero-parallax__cloud-1"> -->
  </div>

  <!-- Terceira dobra - Barco -->
  <div class="hero-parallax__section hero-parallax__section--boat" data-section="3">
    <h2 class="hero-parallax__title">
      <span class="hero-parallax__title-line hero-parallax__title-line--headline animate-text">Surfing</span>
      <span class="hero-parallax__title-line hero-parallax__title-line--highlight animate-text">In the paradise</span>
    </h2>
    <div class="hero-parallax__boat-image">
      <!-- Container para efeito WebGL de água -->
      <div id="water-effect-container"
        data-boat-image="<?php echo esc_url(get_template_directory_uri() . '/dist/images/bmp/sibon-baru-jaya-cover.jpg'); ?>"
        data-water-mask="<?php echo esc_url(get_template_directory_uri() . '/dist/images/bmp/sibon-water-mask.png'); ?>">
      </div>
      <!-- Barcos em PNG transparente sobre o efeito de água -->
      <img src="<?php echo esc_url(get_template_directory_uri() . '/dist/images/bmp/hero-parallax-boats.png'); ?>"
        alt="Sibon boats" class="hero-parallax__boat-overlay"
        fetchpriority="high">

      <!-- Select de experiência -->
      <div class="hero-parallax__boat-select">
        <select class="hero-parallax__experience-select" onchange="if(this.value) window.location.href=this.value">
          <option value="" selected disabled>CHOOSE YOUR SIBON EXPERIENCE</option>
          <option value="<?php echo esc_url(home_url('/sibon-baru')); ?>">Sibon Baru</option>
          <option value="<?php echo esc_url(home_url('/sibon-jaya')); ?>">Sibon Jaya</option>
        </select>
        <svg class="hero-parallax__select-arrow" xmlns="http://www.w3.org/2000/svg" width="12" height="8"
          viewBox="0 0 12 8" fill="none">
          <path d="M1 1L6 6L11 1" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
        </svg>
      </div>
    </div>
  </div>

  <!-- Quarta dobra - Explore Indonesia -->
  <div class="hero-parallax__section hero-parallax__section--explore" data-section="4">
    <div class="hero-parallax__explore-container">
      <div class="hero-parallax__explore-content">
        <h2 class="hero-parallax__title">
          <span class="hero-parallax__title-line hero-parallax__title-line--headline animate-text">
            Explore Indonesia's
          </span>
          <span class="hero-parallax__title-line hero-parallax__title-line--highlight animate-text">
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
            aluminum catamarans were designed to provide the utmost comfort and safety while you chase the perfect
            wave.</p>
        </div>
      </div>
      <div class="hero-parallax__explore-image">
        <img src="<?php echo esc_url(get_template_directory_uri() . '/dist/images/bmp/surfer.jpg'); ?>"
          alt="Surfer on the wave" loading="lazy">
      </div>
    </div>
  </div>
</section>