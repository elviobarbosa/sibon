<?php
/**
 * Botões padronizados do tema.
 *
 * Variantes disponíveis:
 *   outline  — pill com borda colorida (secundária)
 *   solid    — pill preenchido (secundária)
 *   ghost    — pill com borda neutra
 *   primary  — pill com borda + cor primária (azul) — usado em schedule-booking
 *
 * Parâmetros:
 *   $variant  string  Variante visual. Default: 'outline'
 *   $label    string  Texto do botão.
 *   $url      string  href do link.
 *   $class    string  Classes extras opcionais.
 *   $target   string  _self | _blank. Default: '_self'
 */
$variant = $variant ?? 'outline';
$label   = $label   ?? '';
$url     = $url     ?? '#';
$class   = $class   ?? '';
$target  = $target  ?? '_self';
?>
<a
  href="<?php echo esc_url($url); ?>"
  class="btn btn--<?php echo esc_attr($variant); ?><?php echo $class ? ' ' . esc_attr($class) : ''; ?>"
  target="<?php echo esc_attr($target); ?>"
  <?php echo $target === '_blank' ? 'rel="noopener"' : ''; ?>
>
  <?php echo esc_html($label); ?>
</a>
