<?php
get_header();
hero_sibon_baru([
  'title_small' => 'SIBON',
  'title_large' => 'JAYA',
  'description' => 'Mergulhe em um oásis de luxo flutuante. O Sibon Jaya é um iate sofisticado com quatro suítes privativas, desenhado para quem busca o máximo em conforto e exclusividade. Imagine-se em um hotel 5 estrelas, com o oceano como seu quintal e as melhores ondas do mundo ao seu alcance.',
  'features'    => '12 people · 5 cabins · 4 suites · 4 bathrooms',
  'images'      => [
    [ 'src' => esc_url( get_template_directory_uri() . '/dist/images/bmp/hero-jaya.jpg' ),           'alt' => 'Sibon Jaya' ],
    [ 'src' => esc_url( get_template_directory_uri() . '/dist/images/bmp/hero-jaya-aereo.jpg' ),     'alt' => 'Sibon Jaya - Vista aérea' ],
    [ 'src' => esc_url( get_template_directory_uri() . '/dist/images/bmp/hero-jaya-por-do-sol.jpg' ), 'alt' => 'Sibon Jaya - Por do sol' ],
    [ 'src' => esc_url( get_template_directory_uri() . '/dist/images/bmp/hero-jaya-por-do-sol-2.jpg' ), 'alt' => 'Sibon Jaya - Por do sol 2' ],
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
      'title'       => 'A 2015’ 70-foot Aluminum Powered Catamaran',
      'description' => 'O Sibon Jaya é um catamarã de 70 pés, construído em 2015 em alumínio, que redefine o conceito de luxo e conforto em suas aventuras de surf. Projetado para oferecer uma experiência exclusiva, ele combina engenharia de ponta com um design interior sofisticado, garantindo uma viagem inesquecível pelas águas da Indonésia.',
    ],
    [
      'title'       => '4 privates suites and 1 big cabin on the top',
      'description' => 'A bordo, você encontrará quatro suítes privativas elegantemente decoradas, além de uma ampla cabine adicional no convés superior, oferecendo privacidade e conforto para todos os hóspedes. Todos os espaços internos são totalmente climatizados, proporcionando um refúgio de frescor e bem-estar em qualquer clima tropical.',
    ],
    [
      'title'       => 'Twin Cummins QSB 6.7 main engines and 4 x Solar Panels',
      'description' => 'Para uma navegação potente e confiável, o Sibon Jaya é equipado com dois motores principais Cummins QSB 6.7, assegurando que você chegue aos picos de surf mais remotos com eficiência e segurança. Pensando na sustentabilidade, o barco também conta com quatro painéis solares, contribuindo para uma operação mais limpa e eficiente.',
    ],
    [
      'title'       => 'Your 5-Star floating hotel',
      'description' => 'O Sibon Jaya é mais do que um barco; é um hotel 5 estrelas flutuante, onde cada detalhe é cuidadosamente pensado para proporcionar o máximo de conforto, luxo e uma experiência de surf incomparável. Sua aventura premium espera por você.',
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
  'description' => 'Desfrute de um refúgio espaçoso e acessível, onde o valor se encontra com a aventura. O Sibon Baru redefine o que você espera de um barco em sua faixa de preço, oferecendo amplo espaço para relaxar e compartilhar histórias de surf.',
  'specs'     => ['12 people', '6 cabins', '6 berths', '4 bathrooms'],
  'cta_label' => "See Baru's schedule",
  'cta_url'   => '#enquire',
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