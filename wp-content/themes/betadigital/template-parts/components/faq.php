<?php
$faqs = new WP_Query([
    'post_type'      => 'post_faq',
    'posts_per_page' => -1,
    'orderby'        => 'menu_order',
    'order'          => 'ASC',
    'post_status'    => 'publish',
]);
?>

<section class="faq">

  <div class="faq__container">

    <h2 class="faq__title">FAQ</h2>

    <?php
    $faq_video_url = function_exists('get_field') ? get_field('faq_youtube_url', 'option') : '';
    if ($faq_video_url) :
        preg_match(
            '/(?:youtube\.com\/(?:watch\?.*v=|embed\/|shorts\/)|youtu\.be\/)([a-zA-Z0-9_-]{11})/',
            $faq_video_url,
            $yt_matches
        );
        $faq_video_id = isset($yt_matches[1]) ? $yt_matches[1] : '';
        if ($faq_video_id) :
    ?>
    <div class="faq__video">
      <div class="faq__video-wrap">
        <iframe
          src="https://www.youtube.com/embed/<?php echo esc_attr($faq_video_id); ?>?rel=0"
          title="FAQ Video"
          frameborder="0"
          allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
          allowfullscreen
          loading="lazy"
        ></iframe>
      </div>
    </div>
    <?php endif; endif; ?>

    <?php if ($faqs->have_posts()) : ?>
    <div class="faq__list">
      <?php while ($faqs->have_posts()) : $faqs->the_post(); ?>
      <div class="faq__item">
        <label class="faq__label" for="faq-<?php the_ID(); ?>">
          <input class="faq__toggle" type="checkbox" id="faq-<?php the_ID(); ?>">
          <span class="faq__question"><?php the_title(); ?></span>
          <span class="faq__arrow">
            <?php echo file_get_contents(get_template_directory() . '/dist/images/svg/arrow-faq.svg'); ?>
          </span>
        </label>
        <?php if (get_the_content()) : ?>
        <div class="faq__answer">
          <div class="faq__answer-inner">
            <?php the_content(); ?>
          </div>
        </div>
        <?php endif; ?>
      </div>
      <?php endwhile; wp_reset_postdata(); ?>
    </div>
    <?php endif; ?>

  </div>

</section>
