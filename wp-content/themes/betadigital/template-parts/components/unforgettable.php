<?php
/**
 * Seção "Let's Create Something Unforgettable"
 */
?>

<section class="unforgettable">
  <!-- Círculos decorativos com blur -->
  <div class="unforgettable__glow unforgettable__glow--blue"></div>
  <div class="unforgettable__glow unforgettable__glow--yellow"></div>

  <div class="unforgettable__container">
    <header class="unforgettable__header">
      <h2 class="unforgettable__title">
        <span class="unforgettable__title-line unforgettable__title-line--headline animate-text">LET'S CREATE</span>
        <span class="unforgettable__title-line unforgettable__title-line--highlight animate-text">Something unforgettable</span>
      </h2>
      <p class="unforgettable__description">
        Deixe a Sibon Charters ser seu guia para uma experiência de surf
        que transcende o comum. Navegue por águas cristalinas, explore
        ilhas intocadas e surfe ondas que você sonhou a vida toda.
        A lenda aguarda você.
      </p>
    </header>

    <div class="unforgettable__gallery">
      <figure class="unforgettable__image unforgettable__image--1" data-parallax-speed="0.15">
        <img src="<?php echo esc_url(get_template_directory_uri() . '/dist/images/bmp/unforgettable-1.jpg'); ?>" alt="Aurora boreal">
      </figure>
      <figure class="unforgettable__image unforgettable__image--2" data-parallax-speed="0.25">
        <img src="<?php echo esc_url(get_template_directory_uri() . '/dist/images/bmp/unforgettable-2.jpg'); ?>" alt="Barco no mar cristalino">
      </figure>
      <figure class="unforgettable__image unforgettable__image--3" data-parallax-speed="0.35">
        <img src="<?php echo esc_url(get_template_directory_uri() . '/dist/images/bmp/unforgettable-3.jpg'); ?>" alt="Pôr do sol no barco">
      </figure>
    </div>
  </div>
</section>
