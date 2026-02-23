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
  <div class="hero-parallax__transition">
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
  </div>

  <!-- Céu com degradê -->
  <div class="hero-parallax__sky">
    <img src="<?php echo esc_url(get_template_directory_uri() . '/dist/images/bmp/cloud1.png'); ?>" alt="Cloud"
      class="hero-parallax__cloud-1">
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
      <!-- Imagem original como fallback (hidden quando WebGL ativo) -->
      <img src="<?php echo esc_url(get_template_directory_uri() . '/dist/images/bmp/sibon-baru-jaya-cover.jpg'); ?>"
        alt="Boat adventure" class="hero-parallax__boat-img hero-parallax__boat-img--fallback">
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
          <p>Prepare-se para desvendar os segredos das ondas mais épicas do planeta. A Sibon Charters convida você a uma
            jornada inesquecível pelos lendários picos de surf de <strong>Mentawai</strong>, <strong>Telos</strong>,
            <strong>Banyaks</strong> e <strong>Enggano</strong>. Mais do que uma simples viagem, oferecemos uma imersão
            completa no paraíso do surf, onde cada onda é uma promessa e cada pôr do sol, uma celebração.
          </p>
          <p>Com a <strong>Sibon Charters</strong>, sua experiência vai além do convencional. Nossos dois catamarãs
            modernos, construídos em alumínio, foram projetados para proporcionar o máximo conforto e segurança enquanto
            você busca a onda perfeita.</p>
        </div>
      </div>
      <div class="hero-parallax__explore-image">
        <img src="<?php echo esc_url(get_template_directory_uri() . '/dist/images/bmp/surfer.jpg'); ?>"
          alt="Surfista na onda">
      </div>
    </div>
  </div>
</section>