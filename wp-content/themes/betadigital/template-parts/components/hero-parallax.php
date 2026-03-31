<section class="hero-parallax">
  <div class="hero-parallax__section hero-parallax__section--boat" data-section="3">
    <div class="hero-parallax__hero-content">
      <h2 class="hero-parallax__title">
        <span class="hero-parallax__title-line hero-parallax__title-line--headline "><strong>Surfing</strong></span>
        <span class="hero-parallax__title-line hero-parallax__title-line--headline">In the</span>
        <span class="hero-parallax__title-line hero-parallax__title-line--headline">paradise</span>
      </h2>

      <div class="hero-parallax__boat-select">
        <select class="hero-parallax__experience-select" aria-label="Choose your Sibon experience"
          onchange="if(this.value) window.location.href=this.value">
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

    <img src="<?php echo esc_url(get_template_directory_uri() . '/dist/images/bmp/hero-sibon-charters.jpg'); ?>"
      alt="Sibon Charters" class="hero-parallax__bg hero-parallax__bg--desktop" fetchpriority="high">

    <img src="<?php echo esc_url(get_template_directory_uri() . '/dist/images/bmp/hero-mobile.jpg'); ?>"
      alt="Sibon Charters" class="hero-parallax__bg hero-parallax__bg--mobile" fetchpriority="high">

  </div>
</section>