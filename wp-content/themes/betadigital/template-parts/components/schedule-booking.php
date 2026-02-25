<?php
/**
 * schedule-booking.php
 *
 * Vars esperadas via load_component():
 *   $barco       (string) slug do post charter_schedule — obrigatório
 *   $enquire_url (string) URL do botão ENQUIRE NOW — padrão: '#enquire'
 */

$enquire_url = $enquire_url ?? '#enquire';

if (empty($barco)) return;

$boat_posts = get_posts([
  'post_type'      => 'charter_schedule',
  'name'           => $barco,
  'posts_per_page' => 1,
]);
// var_dump($boat_posts);
if (empty($boat_posts)) return;

$boat_id   = $boat_posts[0]->ID;
$calendario = get_field('calendario', $boat_id);


if (empty($calendario)) return;

$today = date('Ymd');

// Ordena por periodo_inicio ASC
usort($calendario, function ($a, $b) {
  return strcmp($a['periodo_inicio'], $b['periodo_inicio']);
});

// Agrupa por ano
$posts_by_year = [];
foreach ($calendario as $entry) {
  $year = $entry['periodo_inicio'] ? substr($entry['periodo_inicio'], 0, 4) : date('Y');
  $posts_by_year[$year][] = $entry;
}
ksort($posts_by_year);

$years        = array_keys($posts_by_year);
$current_year = (string) date('Y');
$active_year  = in_array($current_year, $years) ? $current_year : $years[0];

$status_labels = [
  'closed'    => 'Closed',
  'sold-out'  => 'Sold Out',
  'few-spots' => 'Few Spots',
  'on-hold'   => 'On Hold',
  'open'      => 'Open',
];

$season_labels = [
  'low_season'  => 'Low',
  'high_season' => 'High',
];

$local_labels = [
  'mentawai' => 'Mentawai',
  'telos'    => 'Telos',
  'papua'    => 'Papua',
  'komodo'   => 'Komodo',
];

// Pré-computa as datas disponíveis para o select do formulário
$dates_for_select = [];
foreach ($calendario as $_entry) {
  $_start_raw = $_entry['periodo_inicio'] ?? '';
  $_end_raw   = $_entry['periodo_fim']    ?? '';
  $_local     = $_entry['local']          ?? '';
  $_booked    = (int)  ($_entry['booked']    ?? 0);
  $_available = (int)  ($_entry['available'] ?? 0);
  $_on_hold   = (bool) ($_entry['on_hold']   ?? false);

  if ($_on_hold) {
    $_st = 'on-hold';
  } elseif ($_end_raw && $_end_raw < $today) {
    $_st = 'closed';
  } elseif ($_available <= 0 || $_booked >= $_available) {
    $_st = 'sold-out';
  } elseif ($_available > 0 && ($_booked / $_available) > 0.5) {
    $_st = 'few-spots';
  } else {
    $_st = 'open';
  }

  if (in_array($_st, ['open', 'few-spots', 'on-hold'])) {
    $_dt_start     = $_start_raw ? DateTime::createFromFormat('Ymd', $_start_raw) : null;
    $_dt_end       = $_end_raw   ? DateTime::createFromFormat('Ymd', $_end_raw)   : null;
    $_period_label = ($_dt_start && $_dt_end)
      ? $_dt_start->format('M d') . ' - ' . $_dt_end->format('M d')
      : '';
    if ($_period_label) {
      $_local_name = $local_labels[$_local] ?? ucfirst($_local);
      $dates_for_select[] = [
        'value' => $_period_label,
        'label' => $_period_label . ' · ' . $_local_name,
      ];
    }
  }
}
?>
<section class="schedule-booking" id="schedule-booking"
  data-dates="<?php echo esc_attr(wp_json_encode($dates_for_select)); ?>">
  <h2 class="schedule-booking__title">
    <span class="schedule-booking__title--headline animate-text"><?php echo $boat_posts[0]->post_title; ?></span>
    <span class="schedule-booking__title--highlight animate-text">Schedule & Bookings</span>
  </h2>

  <div class="schedule-booking__legend">
    <?php foreach ($status_labels as $key => $label) : ?>
    <div class="schedule-booking__legend-item schedule-booking__legend-item--<?php echo $key; ?>">
      <span><?php echo $label; ?></span>
      <svg width="33" height="13" viewBox="0 0 33.697 13.035" aria-hidden="true">
        <use href="<?php echo SVGPATH; ?>booking-wave"></use>
      </svg>

    </div>
    <?php endforeach; ?>
  </div>

  <div class="schedule-booking__table-header">
    <span>Schedule</span>
    <span>Destination</span>
    <span>Status</span>
    <span>Booked</span>
    <span>Available</span>
    <span>Season</span>
    <span></span>
  </div>

  <?php foreach ($posts_by_year as $year => $entries) : ?>
  <div class="schedule-booking__grid" data-year="<?php echo esc_attr($year); ?>"
    <?php echo (string) $year !== $active_year ? 'hidden' : ''; ?>>

    <?php foreach ($entries as $entry) :
      $start_raw = $entry['periodo_inicio'] ?? '';
      $end_raw   = $entry['periodo_fim']    ?? '';
      $local     = $entry['local']          ?? '';
      $booked    = (int)  ($entry['booked']    ?? 0);
      $available = (int)  ($entry['available'] ?? 0);
      $temporada = $entry['temporada']      ?? '';
      $on_hold   = (bool) ($entry['on_hold']   ?? false);

      if ($on_hold) {
        $status = 'on-hold';
      } elseif ($end_raw && $end_raw < $today) {
        $status = 'closed';
      } elseif ($available <= 0 || $booked >= $available) {
        $status = 'sold-out';
      } elseif ($available > 0 && ($booked / $available) > 0.5) {
        $status = 'few-spots';
      } else {
        $status = 'open';
      }

      $dt_start     = $start_raw ? DateTime::createFromFormat('Ymd', $start_raw) : null;
      $dt_end       = $end_raw   ? DateTime::createFromFormat('Ymd', $end_raw)   : null;
      $period_label = ($dt_start && $dt_end)
        ? $dt_start->format('M d') . ' - ' . $dt_end->format('M d')
        : '';
      $remaining = max(0, $available - $booked);
    ?>
    <div class="schedule-booking__card schedule-booking__card--<?php echo $status; ?>">
      <p class="schedule-booking__period"><?php echo esc_html($period_label); ?></p>

      <p class="schedule-booking__local"><?php echo esc_html($local_labels[$local] ?? ucfirst($local)); ?></p>

      <p class="schedule-booking__status"><?php echo esc_html($status_labels[$status] ?? ucfirst($status)); ?></p>

      <p class="schedule-booking__booked"><?php echo $booked; ?></p>

      <p class="schedule-booking__available"><?php echo $remaining; ?></p>

      <p class="schedule-booking__season">
        <?php echo esc_html($season_labels[$temporada] ?? ''); ?>
      </p>

      <svg class="schedule-booking__star-icon" width="20" height="20" viewBox="0 0 20 20" aria-hidden="true">
        <use href="<?php echo SVGPATH; ?>star"></use>
      </svg>

      <?php if (in_array($status, ['few-spots', 'on-hold', 'open'])) : ?>
      <a href="<?php echo esc_url($enquire_url); ?>" class="schedule-booking__cta"
        data-period="<?php echo esc_attr($period_label); ?>">
        ENQUIRE NOW
      </a>
      <?php endif; ?>
    </div>
    <?php endforeach; ?>

  </div>
  <?php endforeach; ?>

  <?php if (count($years) > 1) : ?>
  <div class="schedule-booking__year-tabs">
    <?php foreach ($years as $index => $year) :
      if ($index > 0) : ?>
    <span class="schedule-booking__year-divider" aria-hidden="true"></span>
    <?php endif; ?>
    <button class="schedule-booking__year-tab <?php echo (string) $year === $active_year ? 'is-active' : ''; ?>"
      data-year="<?php echo esc_attr($year); ?>"
      aria-pressed="<?php echo $year === $active_year ? 'true' : 'false'; ?>">
      <?php echo esc_html($year); ?>
    </button>
    <?php endforeach; ?>
  </div>
  <?php endif; ?>

  <div class="schedule-booking__enquire-wrap">
    <div class="schedule-booking__divider" aria-hidden="true">
      <svg class="schedule-booking__divider-star" width="40" height="40" viewBox="0 0 40 40.114">
        <use href="<?php echo SVGPATH; ?>star"></use>
      </svg>
    </div>
    <?php load_component('btn', ['variant' => 'primary', 'label' => 'ENQUIRE NOW', 'url' => $enquire_url]); ?>
  </div>

</section>