<?php
get_header();
hero_sibon_baru();
random_images();
features_charters([
  'headline'  => 'The beauty inside',
  'highlight' => 'Sibon Baru',
  'cta_label' => "See Baru's Schedule",
  'cta_url'   => '#schedule-booking',
  'items'     => [
    [
      'title'       => '62-Foot aluminum powered Catamaran',
      'description' => 'O Sibon Baru é um catamarã de 62 pés construído em alumínio, projetado para oferecer uma combinação perfeita de desempenho, espaço e conforto em sua expedição de surf. Pensado para a aventura, ele garante que cada momento em alto mar seja tão relaxante quanto emocionante.',
    ],
    [
      'title'       => 'Six large cabins with comfortable twin beds and fully air conditioned',
      'description' => 'A bordo, você encontrará seis cabines amplas, equipadas com camas confortáveis, garantindo uma boa noite de sono após um dia épico de ondas. Todas as áreas do barco são totalmente climatizadas, proporcionando um refúgio agradável do calor tropical.',
    ],
    [
      'title'       => 'Twin Hyundai Marine 260 HP main engines',
      'description' => 'Impulsionado por dois motores principais Hyundai Marine de 260 HP, o Sibon Baru oferece uma navegação suave e eficiente, levando você rapidamente aos melhores picos de surf. Para o seu entretenimento e relaxamento, contamos com uma TV LCD de 50 polegadas, perfeita para assistir a vídeos das suas sessões de surf ou descontrair com um filme.',
    ],
    [
      'title'       => 'Affordable luxury for your surf crew',
      'description' => 'O Sibon Baru é o barco ideal para grupos de surfistas que buscam uma experiência de alto nível sem abrir mão da economia. Com amplo espaço para socialização e relaxamento, ele é o ponto de encontro perfeito para compartilhar histórias das ondas e criar memórias duradouras. Sua aventura privativa espera por você.',
    ],
  ],
]);
experience();
photo_slide();
schedule_booking(['barco' => 'sibon-baru']);
feature_slide();
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
depoiments();
enquire_form([
  'headline'  => 'Book Your Experience',
  'highlight' => 'Enquire Now',
]);
faq();
get_footer();
?>
<div id="wave-lines-container"></div>