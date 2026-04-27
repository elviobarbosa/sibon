<?php
/**
 * Video Testimonials Carousel
 *
 * @param string $barco  'sibon-baru' | 'sibon-jaya'
 */

$barco = isset( $barco ) ? $barco : '';

// ACF stores checkbox as a serialized array — use LIKE to match a specific value.
// e.g. stored as: a:2:{i:0;s:9:"sibon-baru";i:1;s:10:"sibon-jaya";}
$meta_query = [];
if ( $barco ) {
    $meta_query = [
        [
            'key'     => 'page',
            'value'   => '"' . $barco . '"',
            'compare' => 'LIKE',
        ],
    ];
}

$video_depoiments = new WP_Query( [
    'post_type'      => 'post_video_depoiment',
    'posts_per_page' => -1,
    'orderby'        => 'menu_order',
    'order'          => 'ASC',
    'post_status'    => 'publish',
    'meta_query'     => $meta_query ?: [],
] );

if ( ! $video_depoiments->have_posts() ) {
    wp_reset_postdata();
    return;
}

/**
 * Extract YouTube video ID from various URL formats:
 * https://www.youtube.com/watch?v=VIDEO_ID
 * https://youtu.be/VIDEO_ID
 * https://www.youtube.com/embed/VIDEO_ID
 * https://www.youtube.com/shorts/VIDEO_ID
 */
function get_youtube_id( $url ) {
    preg_match(
        '/(?:youtube\.com\/(?:watch\?.*v=|embed\/|shorts\/)|youtu\.be\/)([a-zA-Z0-9_-]{11})/',
        $url,
        $matches
    );
    return isset( $matches[1] ) ? $matches[1] : '';
}

$swiperParams = [
    'slidesPerView'            => 'auto',
    'centeredSlides'           => true,
    'spaceBetween'             => 20,
    'loop'                     => true,
    'preventClicks'            => false,
    'preventClicksPropagation' => false,
    'navigation'               => [
        'nextEl' => '.video-depoiments__next',
        'prevEl' => '.video-depoiments__prev',
    ],
    'pagination'               => [
        'el'        => '.video-depoiments__pagination',
        'clickable' => true,
    ],
];
$params = 'data-params=\'' . wp_json_encode( $swiperParams ) . '\'';
?>

<section class="video-depoiments">
  <div class="video-depoiments__inner">

    <div class="swiper video-depoiments__swiper" <?php echo $params; ?> data-manual>
      <div class="swiper-wrapper">
        <?php while ( $video_depoiments->have_posts() ) : $video_depoiments->the_post();
          $youtube_url = get_field( 'youtube_url' );
          $video_id    = get_youtube_id( $youtube_url );
          $custom_thumb   = get_field( 'thumbnail' );
          $thumbnail      = $custom_thumb ?: ( $video_id ? "https://img.youtube.com/vi/{$video_id}/maxresdefault.jpg" : '' );
          $thumb_fallback = $custom_thumb ? '' : ( $video_id ? "https://img.youtube.com/vi/{$video_id}/hqdefault.jpg" : '' );
          $embed_url      = $video_id ? "https://www.youtube.com/embed/{$video_id}?autoplay=1&rel=0" : '';
          if ( ! $video_id ) continue;
        ?>
        <div class="swiper-slide video-depoiments__slide">
          <a
            href="<?php echo esc_url( $embed_url ); ?>"
            class="video-depoiments__card"
            data-fancybox="video-depoiments"
            aria-label="<?php echo esc_attr( get_the_title() ); ?>"
          >
            <figure class="video-depoiments__thumb">
              <img
                src="<?php echo esc_url( $thumbnail ); ?>"
                <?php if ( $thumb_fallback ) : ?>
                onload="if(this.naturalWidth===120){this.src='<?php echo esc_url( $thumb_fallback ); ?>';}"
                <?php endif; ?>
                alt="<?php echo esc_attr( get_the_title() ); ?>"
                loading="lazy"
              >
            </figure>

            <div class="video-depoiments__overlay">
              <span class="video-depoiments__play">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                  <path d="M8 5v14l11-7z"/>
                </svg>
              </span>
              <p class="video-depoiments__caption"><?php the_title(); ?></p>
            </div>
          </a>
        </div>
        <?php endwhile; wp_reset_postdata(); ?>
      </div>
    </div>

    <div class="video-depoiments__pagination"></div>

    <div class="video-depoiments__navigation">
      <button class="video-depoiments__prev" aria-label="Previous">
        <?php echo file_get_contents( get_template_directory() . '/dist/images/svg/arrow.svg' ); ?>
      </button>
      <button class="video-depoiments__next" aria-label="Next">
        <?php echo file_get_contents( get_template_directory() . '/dist/images/svg/arrow.svg' ); ?>
      </button>
    </div>

  </div>
</section>
