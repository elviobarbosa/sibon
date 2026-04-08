<?php
/**
 * enquire-form.php
 *
 * Vars esperadas via load_component():
 *   $cf7_title (string) Título do formulário Contact Form 7 — padrão: 'Enquire now'
 *   $headline  (string) Texto menor acima do título
 *   $highlight (string) Título principal em destaque
 */

$cf7_title = $cf7_title ?? 'Enquire now';
$headline  = $headline  ?? 'Book Your Adventure';
$highlight = $highlight ?? 'Enquire Now';
$barco     = $barco     ?? '';
?>
<section class="enquire-form" id="enquire">
  <div class="enquire-form__inner">

    <h2 class="enquire-form__title">
      <span class="enquire-form__title--headline "><?php echo esc_html($headline); ?></span>
      <span class="enquire-form__title--highlight "><?php echo esc_html($highlight); ?></span>
    </h2>

    <div class="enquire-form__form">
      <?php echo do_shortcode('[contact-form-7 title="' . esc_attr($cf7_title) . '"]'); ?>
      <?php if ( $barco ) : ?>
      <script>
        document.addEventListener('DOMContentLoaded', function () {
          var field = document.querySelector('.enquire-form input[name="barco"]');
          if (field) field.value = '<?php echo esc_js($barco); ?>';
        });
      </script>
      <?php endif; ?>
    </div>

  </div>
</section>
