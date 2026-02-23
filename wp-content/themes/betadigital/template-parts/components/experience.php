<?php
$item = new WP_Query(array(
    'post_type'      => 'post_experience_item',
    'posts_per_page' => 1,
));
?>
<section class="experience">
  <div class="experience__container">
    <div class="experience__content">
      <header class="experience__header">
        <h2 class="experience__title">
          <span class="experience__title-line experience__title-line--headline animate-text">THE SIBON CHARTERS</span>
          <span class="experience__title-line experience__title-line--highlight animate-text">Experience</span>
        </h2>
        <p class="experience__intro">
          Nossas viagens com a Sibon Charters são pensadas para que você desfrute de cada momento sem preocupações.
          Veja o que está incluído em sua jornada:
        </p>
      </header>
    </div>

    <div class="experience__image">
      <figure>
        <img src="<?php echo esc_url(get_template_directory_uri() . '/dist/images/bmp/experience.jpg'); ?>"
          alt="Sibon Charters Experience">
      </figure>
    </div>
    <?php if ($item->have_posts()) : $item->the_post(); ?>
    <div class="experience__list">
      <?php echo wp_kses_post(get_the_content()); ?>
    </div>
    <?php endif; ?>
  </div>


</section>
<?php wp_reset_postdata(); ?>