<!doctype html>
<html <?php language_attributes(); ?>>

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <meta name=viewport content="width=device-width">
  <meta charset="UTF-8">
  <title><?php wp_title('|', true, 'right'); bloginfo('name'); ?></title>
  <link rel="shortcut icon" href="<?php bloginfo('wpurl');?>/favicon.ico" />
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Bodoni+Moda:ital,wght@1,500&amp;family=Manrope:wght@200..800&amp;display=swap" rel="stylesheet">
  <?php if (is_front_page()) : ?>
  <link rel="preload" href="<?php echo esc_url(get_template_directory_uri()); ?>/dist/images/bmp/hero-mobile.jpg" as="image" fetchpriority="high">
  <link rel="preload" href="<?php echo esc_url(get_template_directory_uri()); ?>/dist/images/bmp/hero-parallax-boats.png" as="image">
  <?php endif; ?>

  <?php wp_head() ?>

</head>

<body <?php body_class() ?>>

  <div id="page-loader" aria-hidden="true"></div>

  <div class="nav-container">
    <div class="container nav-container__container">
      <?php 
			// if ( is_front_page() ) {
				get_template_part('template-parts/headers/header-primary');
			// } else {
			// 	get_template_part('template-parts/headers/header-secondary');
			// }
		?>
    </div>
  </div>