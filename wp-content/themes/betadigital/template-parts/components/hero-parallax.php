<section class="hero-parallax">
  <!-- Container dos pássaros 3D -->
  <div id="birds-3d-container"
       data-bird-texture="<?php echo esc_url(get_template_directory_uri() . '/dist/images/bmp/birdb.png'); ?>"
       style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: 1; pointer-events: none;"></div>

  <!-- Primeira dobra -->
  <div class="hero-parallax__section hero-parallax__section--first" data-section="1">
    <div class="hero-parallax__content">
      <h1 class="hero-parallax__title">
        <span class="hero-parallax__title-line hero-parallax__title-line--headline">Enjoy in the</span>
        <span class="hero-parallax__title-line hero-parallax__title-line--highlight">Wildest nature</span>
      </h1>
    </div>
  </div>

  <!-- Segunda dobra -->
  <div class="hero-parallax__section hero-parallax__section--second" data-section="2">
    <div class="hero-parallax__content">
      <h2 class="hero-parallax__title">
        <span class="hero-parallax__title-line hero-parallax__title-line--headline">Experience the</span>
        <span class="hero-parallax__title-line hero-parallax__title-line--highlight">Adventure of a lifetime</span>
      </h2>
    </div>
  </div>

  <!-- Transição com nuvens -->
  <div class="hero-parallax__transition">
    <div class="hero-parallax__clouds">
      <div class="hero-parallax__cloud hero-parallax__cloud--1"></div>
      <div class="hero-parallax__cloud hero-parallax__cloud--2"></div>
      <div class="hero-parallax__cloud hero-parallax__cloud--3"></div>
    </div>
  </div>

  <!-- Terceira dobra - Barco -->
  <div class="hero-parallax__section hero-parallax__section--boat" data-section="3">
    <div class="hero-parallax__boat-image">
      <img src="<?php echo esc_url(get_template_directory_uri() . '/dist/images/bmp/boat.jpg'); ?>" alt="Boat adventure" class="hero-parallax__boat-img">
    </div>
  </div>
</section>