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
  'description' => 'Mergulhe em um oásis de luxo flutuante. O Sibon Jaya é um iate sofisticado com quatro suítes privativas, desenhado para quem busca o máximo em conforto e exclusividade. Imagine-se em um hotel 5 estrelas, com o oceano como seu quintal e as melhores ondas do mundo ao seu alcance.',
  'specs'     => ['12 people', '6 cabins', '6 berths', '4 bathrooms'],
  'cta_label' => "See Jaya's schedule",
  'cta_url'   => '#enquire',
  'image'     => esc_url(get_template_directory_uri() . '/dist/images/bmp/sibon-jaya.jpg'),
  'image_alt' => 'Sibon Jaya',
]);
cta_boat([
  'eyebrow'   => 'SIBON',
  'name'      => 'BARU',
  'description' => 'Desfrute de um refúgio espaçoso e acessível, onde o valor se encontra com a aventura. O Sibon Baru redefine o que você espera de um barco em sua faixa de preço, oferecendo amplo espaço para relaxar e compartilhar histórias de surf.',
  'specs'     => ['12 people', '6 cabins', '6 berths', '4 bathrooms'],
  'cta_label' => "See Baru's schedule",
  'cta_url'   => '#enquire',
  'image'     => esc_url(get_template_directory_uri() . '/dist/images/bmp/sibon-baru.jpg'),
  'image_alt' => 'Sibon Baru',
  'reversed'  => true
]);
depoiments();
faq();
get_footer();
?>