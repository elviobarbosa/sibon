<?php
get_header();
hero_sibon_baru([
  'title_small' => 'SIBON',
  'title_large' => 'JAYA',
  'description' => 'Dive into a floating luxury oasis. The Sibon Jaya is a sophisticated yacht with four private suites, designed for those seeking the ultimate in comfort and exclusivity. Picture yourself in a 5-star hotel, with the ocean as your backyard and the world\'s best waves at your fingertips.',
  'features'    => '12 people · 5 cabins · 4 suites · 4 bathrooms',
  'images'      => [
    [ 'src' => esc_url( get_template_directory_uri() . '/dist/images/bmp/hero-jaya.jpg' ),              'alt' => 'Sibon Jaya' ],
    [ 'src' => esc_url( get_template_directory_uri() . '/dist/images/bmp/hero-jaya-aereo.jpg' ),        'alt' => 'Sibon Jaya - Aerial View' ],
    [ 'src' => esc_url( get_template_directory_uri() . '/dist/images/bmp/hero-jaya-por-do-sol.jpg' ),   'alt' => 'Sibon Jaya - Sunset' ],
    [ 'src' => esc_url( get_template_directory_uri() . '/dist/images/bmp/hero-jaya-por-do-sol-2.jpg' ), 'alt' => 'Sibon Jaya - Sunset 2' ],
  ],
]);
random_images();
features_charters([
  'headline'  => 'The LUXURY inside',
  'highlight' => 'Sibon Jaya',
  'cta_label' => "See Jaya's Schedule",
  'cta_url'   => '#schedule-booking',
  'items'     => [
    [
      'title'       => 'A 2015\u2019 70-foot Aluminum Powered Catamaran',
      'description' => 'The Sibon Jaya is a 70-foot aluminum catamaran, built in 2015, that redefines the concept of luxury and comfort on your surf adventures. Designed to deliver an exclusive experience, it combines cutting-edge engineering with a sophisticated interior, ensuring an unforgettable journey through the waters of Indonesia.',
    ],
    [
      'title'       => '4 privates suites and 1 big cabin on the top',
      'description' => 'On board, you\'ll find four elegantly decorated private suites, plus a spacious additional cabin on the upper deck, offering privacy and comfort for all guests. All interior spaces are fully air-conditioned, providing a cool and refreshing retreat in any tropical climate.',
    ],
    [
      'title'       => 'Twin Cummins QSB 6.7 main engines and 4 x Solar Panels',
      'description' => 'For powerful and reliable navigation, the Sibon Jaya is equipped with twin Cummins QSB 6.7 main engines, ensuring you reach the most remote surf breaks with efficiency and safety. With sustainability in mind, the boat also features four solar panels, contributing to a cleaner and more efficient operation.',
    ],
    [
      'title'       => 'Your 5-Star floating hotel',
      'description' => 'The Sibon Jaya is more than a boat; it\'s a floating 5-star hotel, where every detail is carefully crafted to deliver the utmost comfort, luxury, and an unparalleled surf experience. Your premium adventure awaits.',
    ],
  ],
]);
experience();
photo_slide();
schedule_booking(['barco' => 'sibon-jaya']);
feature_slide();
cta_boat([
  'eyebrow'   => 'SIBON',
  'name'      => 'BARU',
  'description' => 'Enjoy a spacious and accessible retreat where value meets adventure. The Sibon Baru redefines what you expect from a boat in its price range, offering ample space to relax and share surf stories.',
  'specs'     => ['12 people', '6 cabins', '6 berths', '4 bathrooms'],
  'cta_label' => "See Baru's schedule",
  'cta_url'   => '/sibon-baru',
  'image'     => esc_url(get_template_directory_uri() . '/dist/images/bmp/sibon-jaya.jpg'),
  'image_alt' => 'Sibon Baru',
]);
depoiments();
enquire_form([
  'headline'  => 'Book Your Experience',
  'highlight' => 'Enquire Now',
]);
faq();
get_footer();
?>
<div id="wave-lines-container"></div>