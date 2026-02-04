<?php
$slides = new WP_Query(array(
    'post_type'      => 'post_feature_slide',
    'posts_per_page' => -1,
    'orderby'        => 'menu_order',
    'order'          => 'ASC',
));

if ($slides->have_posts()) : ?>
<div class="feature-slide">
  <div class="swiper feature-slide__swiper">
    <div class="swiper-wrapper">
      <?php while ($slides->have_posts()) : $slides->the_post();
        $highlight = get_post_meta(get_the_ID(), '_feature_slide_highlight', true);
        $thumbnail = get_the_post_thumbnail_url(get_the_ID(), 'large');
      ?>
      <div class="swiper-slide">
        <?php if ($highlight) : ?>
        <h4 class="feature-slide__highlight"><?php echo esc_html($highlight); ?></h4>
        <?php endif; ?>
        <div class="feature-slide__content">
          <?php if ($thumbnail) : ?>
          <div class="feature-slide__image">
            <figure>
              <img src="<?php echo esc_url($thumbnail); ?>" alt="<?php echo esc_attr(get_the_title()); ?>">
            </figure>
          </div>
          <?php endif; ?>
          <div class="feature-slide__text">
            <h3 class="feature-slide__title"><?php the_title(); ?></h3>
            <div class="feature-slide__description">
              <?php the_content(); ?>
            </div>
          </div>
        </div>
      </div>
      <?php endwhile; ?>
    </div>

    <div class="swiper-button-prev"></div>
    <div class="swiper-button-next"></div>

  </div>
</div>
<?php endif;
wp_reset_postdata();
?>
