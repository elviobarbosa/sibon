<?php
/**
 * CTA Boat - reutilizável para Sibon Jaya e Sibon Barú
 *
 * @param array $args {
 *   @type string $eyebrow     Label acima do nome (ex: "SIBON")
 *   @type string $name        Nome do barco em destaque (ex: "JAYA")
 *   @type string $description Parágrafo descritivo
 *   @type array  $specs       Lista de especificações (ex: ['12 people', '6 cabins'])
 *   @type string $cta_label   Texto do botão CTA
 *   @type string $cta_url     URL do botão CTA
 *   @type string $image       URL da imagem do barco
 *   @type string $image_alt   Alt text da imagem
 *   @type string $modifier    Modificador BEM opcional (ex: 'baru')
 * }
 */

$eyebrow     = $args['eyebrow']     ?? '';
$name        = $args['name']        ?? '';
$description = $args['description'] ?? '';
$specs       = $args['specs']       ?? [];
$cta_label   = $args['cta_label']   ?? '';
$cta_url     = $args['cta_url']     ?? '#';
$image       = $args['image']       ?? '';
$image_alt   = $args['image_alt']   ?? $name;
$modifier    = $args['modifier']    ?? '';
?>

<section class="cta-boat<?php echo $modifier ? ' cta-boat--' . esc_attr($modifier) : ''; ?>">

  <header class="cta-boat__header">
    <?php if ($eyebrow) : ?>
    <span class="cta-boat__eyebrow"><?php echo esc_html($eyebrow); ?></span>
    <?php endif; ?>

    <?php if ($name) : ?>
    <h2 class="cta-boat__name"><?php echo esc_html($name); ?></h2>
    <?php endif; ?>
  </header>

  <div class="cta-boat__body">
    <?php if ($description) : ?>
    <p class="cta-boat__description"><?php echo wp_kses_post($description); ?></p>
    <?php endif; ?>

    <?php if (!empty($specs)) : ?>
    <ul class="cta-boat__specs">
      <?php foreach ($specs as $spec) : ?>
      <li class="cta-boat__spec"><?php echo esc_html($spec); ?></li>
      <?php endforeach; ?>
    </ul>
    <?php endif; ?>

    <?php if ($cta_label) : ?>
    <!-- <a href="<?php echo esc_url($cta_url); ?>" class="cta-boat__cta">
      <?php echo esc_html($cta_label); ?>
    </a> -->

    <?php load_component('btn', ['variant' => 'primary', 'label' => $cta_label, 'url' => $cta_url]); ?>
    <?php endif; ?>
  </div>

  <?php if ($image) : ?>
  <div class="cta-boat__image">
    <figure>
      <img src="<?php echo esc_url($image); ?>" alt="<?php echo esc_attr($image_alt); ?>">
    </figure>
  </div>
  <?php endif; ?>

</section>