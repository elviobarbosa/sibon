<?php
get_header();
hero_sibon_baru([
  'title_small' => 'SIBON',
  'title_large' => 'BARU',
  'description' => 'Enjoy a spacious and accessible retreat where value meets adventure. The Sibon Baru redefines what you expect from a boat in its price range, offering ample space to relax and share surf stories.',
  'features'    => '12 people · 6 cabins · 6 berths · 4 bathrooms',
  'images'      => [
    [ 'src' => esc_url( get_template_directory_uri() . '/dist/images/bmp/hero-sibon-baru.jpg' ),             'alt' => 'Sibon Baru' ],
    [ 'src' => esc_url( get_template_directory_uri() . '/dist/images/bmp/hero-baru-coqueiros.jpg' ),         'alt' => 'Sibon Baru - Palm Trees' ],
    [ 'src' => esc_url( get_template_directory_uri() . '/dist/images/bmp/hero-baru-pordosol.jpg' ),          'alt' => 'Sibon Baru - Sunset' ],
    [ 'src' => esc_url( get_template_directory_uri() . '/dist/images/bmp/hero-baru-oceano-cristalino.jpg' ), 'alt' => 'Sibon Baru - Crystal Ocean' ],
  ],
]);
random_images();
schedule_booking(['barco' => 'sibon-baru']);
features_charters([
  'headline'  => 'The beauty inside',
  'highlight' => 'Sibon Baru',
  'cta_label' => "See Baru's Schedule",
  'cta_url'   => '#schedule-booking',
  'items'     => [
    [
      'title'       => '62-Foot aluminum powered Catamaran',
      'description' => 'The Sibon Baru is a 62-foot aluminum catamaran designed to deliver the perfect blend of performance, space, and comfort on your surf expedition. Built for adventure, it ensures that every moment at sea is as relaxing as it is thrilling.',
    ],
    [
      'title'       => 'Six large cabins with comfortable twin beds and fully air conditioned',
      'description' => 'On board, you\'ll find six spacious cabins equipped with comfortable beds, guaranteeing a great night\'s sleep after an epic day of waves. All areas of the boat are fully air-conditioned, providing a pleasant escape from the tropical heat.',
    ],
    [
      'title'       => 'Twin Hyundai Marine 260 HP main engines',
      'description' => 'Powered by twin Hyundai Marine 260 HP main engines, the Sibon Baru offers smooth and efficient navigation, quickly taking you to the best surf breaks. For your entertainment and relaxation, we also have a 50-inch LCD TV, perfect for watching footage from your surf sessions or unwinding with a movie.',
    ],
    [
      'title'       => 'Affordable luxury for your surf crew',
      'description' => 'The Sibon Baru is the ideal boat for groups of surfers looking for a high-end experience without breaking the bank. With ample space for socializing and relaxation, it\'s the perfect gathering place to share stories from the waves and create lasting memories. Your private adventure awaits.',
    ],
  ],
]);
experience();
photo_slide();

feature_slide();
cta_boat([
  'eyebrow'   => 'SIBON',
  'name'      => 'JAYA',
  'description' => 'Dive into a floating luxury oasis. The Sibon Jaya is a sophisticated yacht with four private suites, designed for those seeking the ultimate in comfort and exclusivity. Picture yourself in a 5-star hotel, with the ocean as your backyard and the world\'s best waves at your fingertips.',
  'specs'     => ['12 people', '6 cabins', '6 berths', '5 bathrooms'],
  'cta_label' => "See Jaya's schedule",
  'cta_url'   => home_url('/sibon-jaya'),
  'image'     => esc_url(get_template_directory_uri() . '/dist/images/bmp/sibon-jaya.jpg'),
  'image_alt' => 'Sibon Jaya',
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