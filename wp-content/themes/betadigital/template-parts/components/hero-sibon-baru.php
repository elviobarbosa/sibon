<?php
$title_small = $title_small ?? 'SIBON';
$title_large = $title_large ?? 'BARU';
$description = $description ?? '';
$features    = $features    ?? '';
$images      = $images      ?? [];
?>
<div class="hero-charters">
  <div class="hero-charters__content">
    <div class="hero-charters__title">
      <h1>
        <span class="hero-charters__title--small"><?php echo esc_html( $title_small ); ?></span>
        <span class="hero-charters__title--large"><?php echo esc_html( $title_large ); ?></span>
      </h1>
      <div class="hero-charters__description">
        <?php if ( $description ) : ?>
          <p class="hero-charters__description--text">
            <?php echo esc_html( $description ); ?>
          </p>
        <?php endif; ?>
        <?php if ( $features ) : ?>
          <p class="hero-charters__description--features">
            <?php echo esc_html( $features ); ?>
          </p>
        <?php endif; ?>
      </div>
    </div>
  </div>

  <div class="hero-charters__images">
    <?php foreach ( $images as $image ) : ?>
      <div class="hero-charters__image">
        <figure>
          <img src="<?php echo esc_url( $image['src'] ); ?>"
            alt="<?php echo esc_attr( $image['alt'] ); ?>">
        </figure>
      </div>
    <?php endforeach; ?>
  </div>
</div>
