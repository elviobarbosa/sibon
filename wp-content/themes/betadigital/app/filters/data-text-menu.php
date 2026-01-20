<?php
add_filter('nav_menu_link_attributes', 'add_data_text_to_menu_items', 10, 3);

function add_data_text_to_menu_items($atts, $item, $args) {
  error_log('Filtro executado!');
  if ($args->theme_location == 'header-menu') {
    $atts['data-text'] = $item->title;
  }
  return $atts;
}