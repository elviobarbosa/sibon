<?php
$swiperParams = [
    'slidesPerView' => 'auto',
    'centeredSlides' => true,
    'spaceBetween'   => 24,
    'loop'           => true,
    'navigation'     => [
        'nextEl' => '.depoiments__next',
        'prevEl' => '.depoiments__prev',
    ],
];
$params = 'data-params=\'' . wp_json_encode($swiperParams) . '\'';

$depoiments = new WP_Query([
    'post_type'      => 'post_depoiment',
    'posts_per_page' => -1,
    'orderby'        => 'menu_order',
    'order'          => 'ASC',
    'post_status'    => 'publish',
]);
?>

<section class="depoiments">

  <div class="depoiments__header">
    <h2 class="depoiments__title">
      <span class="depoiments__title-line depoiments__title-line--1">Guests</span>
      <span class="depoiments__title-line depoiments__title-line--2">Say About</span>
      <span class="depoiments__title-line depoiments__title-line--3">Sibon charters</span>
    </h2>
  </div>

  <div class="depoiments__content">
    <figure class="depoiments__bg">
      <img src="<?php echo esc_url(get_template_directory_uri() . '/dist/images/bmp/vista-aerea-mentawai.jpg'); ?>"
        alt="Mentawai">
    </figure>

    <?php if ($depoiments->have_posts()) : ?>
    <div class="depoiments__slider-wrap">

      <div class="swiper depoiments__swiper" <?php echo $params; ?>>
        <div class="swiper-wrapper">
          <?php while ($depoiments->have_posts()) : $depoiments->the_post();
            $role  = get_field('role');
            $quote = get_field('quote');
            $photo = get_the_post_thumbnail_url(get_the_ID(), 'medium');
          ?>
          <div class="swiper-slide depoiments__slide">
            <div class="depoiments__card">

              <div class="depoiments__card-header">
                <?php if ($photo) : ?>
                <figure class="depoiments__avatar">
                  <img src="<?php echo esc_url($photo); ?>" alt="<?php echo esc_attr(get_the_title()); ?>">
                </figure>
                <?php endif; ?>
                <div class="depoiments__card-info">
                  <strong class="depoiments__name"><?php the_title(); ?></strong>
                  <?php if ($role) : ?>
                  <span class="depoiments__role"><?php echo esc_html($role); ?></span>
                  <?php endif; ?>
                </div>
              </div>

              <?php if ($quote) : ?>
              <div class="depoiments__quote">
                <span class="depoiments__aspas">
                  <?php echo file_get_contents(get_template_directory() . '/dist/images/svg/aspas-depoimentos.svg'); ?>
                </span>
                <div class="depoiments__quote-text"><?php echo wp_kses_post($quote); ?></div>
              </div>
              <?php endif; ?>

            </div>
          </div>
          <?php endwhile; wp_reset_postdata(); ?>
        </div>
      </div>

      <div class="depoiments__navigation">
        <button class="depoiments__prev" aria-label="Anterior">
          <?php echo file_get_contents(get_template_directory() . '/dist/images/svg/arrow.svg'); ?>
        </button>
        <button class="depoiments__next" aria-label="Próximo">
          <?php echo file_get_contents(get_template_directory() . '/dist/images/svg/arrow.svg'); ?>
        </button>
      </div>

    </div>
    <?php endif; ?>
  </div>

</section>