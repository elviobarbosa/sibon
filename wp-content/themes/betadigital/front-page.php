<?php
get_header();
hero_parallax();
random_images();
unforgettable();
feature_slide();
experience();
cta_boat([
  'eyebrow'   => 'SIBON',
  'name'      => 'JAYA',
  'description' => 'Dive into a floating luxury oasis. The Sibon Jaya is a sophisticated yacht with four private suites, designed for those seeking the ultimate in comfort and exclusivity. Picture yourself in a 5-star hotel, with the ocean as your backyard and the world\'s best waves at your fingertips.',
  'specs'     => ['12 people', '6 cabins', '6 berths', '4 bathrooms'],
  'cta_label' => "See Jaya's schedule",
  'cta_url'   => '/sibon-jaya',
  'image'     => esc_url(get_template_directory_uri() . '/dist/images/bmp/sibon-jaya.jpg'),
  'image_alt' => 'Sibon Jaya',
]);
cta_boat([
  'eyebrow'   => 'SIBON',
  'name'      => 'BARU',
  'description' => 'Enjoy a spacious and accessible retreat where value meets adventure. The Sibon Baru redefines what you expect from a boat in its price range, offering ample space to relax and share surf stories.',
  'specs'     => ['12 people', '6 cabins', '6 berths', '4 bathrooms'],
  'cta_label' => "See Baru's schedule",
  'cta_url'   => '/sibon-baru',
  'image'     => esc_url(get_template_directory_uri() . '/dist/images/bmp/sibon-baru.jpg'),
  'image_alt' => 'Sibon Baru',
  'reversed'  => true
]);
depoiments();
faq();
get_footer();
?>