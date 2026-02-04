<?php
$random_image = new WP_Query([
    'post_type'      => 'post_random_images',
    'posts_per_page' => 1,
    'orderby'        => 'rand',
    'post_status'    => 'publish',
]);

if ($random_image->have_posts()) :
    $random_image->the_post();
    $image = get_the_post_thumbnail_url(get_the_ID(), 'full');
?>

<div class="random-images" data-parallax>
  <?php if ($image) : ?>
  <figure class="random-images__figure">
    <?php echo wp_get_attachment_image(get_post_thumbnail_id(get_the_ID()), 'full', false, ['class' => 'random-images__img']); ?>
  </figure>
  <?php endif; ?>
</div>

<?php
    wp_reset_postdata();
endif;
?>