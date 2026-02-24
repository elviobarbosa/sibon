<?php
$slide_post = get_posts(array(
    'post_type'      => 'post_photo_slide',
    'posts_per_page' => 1,
    'orderby'        => 'menu_order',
    'order'          => 'ASC',
));

if (empty($slide_post)) return;

$gallery = get_field('Fotos', $slide_post[0]->ID);

if (empty($gallery)) return;

$chunks = array_chunk($gallery, 6);
?>
<section class="photo-slide">
  <div class="swiper photo-slide__swiper">
    <div class="swiper-wrapper">
      <?php foreach ($chunks as $chunk) : ?>
      <div class="swiper-slide photo-slide__slide">
        <div class="photo-slide__mosaic">
          <?php foreach ($chunk as $image_id) :
            $image_url = wp_get_attachment_image_url($image_id, 'large');
            $image_alt = get_post_meta($image_id, '_wp_attachment_image_alt', true);
            if (!$image_url) continue;
          ?>
          <figure class="photo-slide__mosaic-item">
            <a href="<?php echo esc_url(wp_get_attachment_image_url($image_id, 'full')); ?>" data-fancybox="photo-slide-gallery" data-caption="<?php echo esc_attr($image_alt); ?>">
              <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($image_alt); ?>">
            </a>
          </figure>
          <?php endforeach; ?>
        </div>
      </div>
      <?php endforeach; ?>
    </div>

    <button class="photo-slide__btn photo-slide__btn--prev" aria-label="Previous slide">
      <svg width="48" height="24" viewBox="0 0 48.442 24.35" aria-hidden="true">
        <use href="<?php echo SVGPATH; ?>arrow"></use>
      </svg>
    </button>

    <button class="photo-slide__btn photo-slide__btn--next" aria-label="Next slide">
      <svg width="48" height="24" viewBox="0 0 48.442 24.35" aria-hidden="true">
        <use href="<?php echo SVGPATH; ?>arrow"></use>
      </svg>
    </button>

    <div class="photo-slide__pagination"></div>
  </div>
</section>
