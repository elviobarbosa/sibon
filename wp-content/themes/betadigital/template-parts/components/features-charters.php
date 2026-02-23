<?php
$headline  = $headline  ?? 'The beauty inside';
$highlight = $highlight ?? 'Sibon Baru';
$cta_label = $cta_label ?? "See Baru's Schedule";
$cta_url   = $cta_url   ?? '#';
$items     = $items     ?? [];
?>
<div class="feature-charters">
  <div class="feature-charters__header">
    <h2 class="feature-charters__title">
      <span class="feature-charters__title-line feature-charters__title--headline animate-text"><?php echo esc_html($headline); ?></span>
      <span class="feature-charters__title-line feature-charters__title--highlight animate-text"><?php echo esc_html($highlight); ?></span>
    </h2>
  </div>

  <div class="feature-charters__content">
    <?php foreach ($items as $item) : ?>
    <div class="feature-charters__content-item">
      <h3 class="feature-charters__content-title"><?php echo esc_html($item['title']); ?></h3>
      <p class="feature-charters__content-description"><?php echo esc_html($item['description']); ?></p>
    </div>
    <?php endforeach; ?>

    <div class="feature-charters__divider" aria-hidden="true">
      <svg class="feature-charters__star" width="30" height="30">
        <use href="<?php echo SVGPATH; ?>star"></use>
      </svg>
    </div>
  </div>

  <div class="feature-charters__cta">
    <?php load_component('btn', ['variant' => 'outline', 'label' => $cta_label, 'url' => $cta_url]); ?>
  </div>
</div>
