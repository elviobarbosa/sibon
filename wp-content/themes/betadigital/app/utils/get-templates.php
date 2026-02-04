<?php
/**
 * Helpers para carregar templates com parâmetros
 */

if ( ! function_exists( 'load_component' ) ) {
  function load_component( $slug, $args = [] ) {
    if ( ! empty( $args ) && is_array( $args ) ) {
      extract( $args, EXTR_SKIP );
    }

    $template = locate_template( "template-parts/components/{$slug}.php" );

    if ( ! empty( $template ) ) {
      include $template;
    }
  }
}

if ( ! function_exists( 'birds-3d' ) ) {
  function birds_3d( $args = [] ) {
    load_component( 'birds-3d', $args );
  }
}

if ( ! function_exists( 'hero_parallax' ) ) {
  function hero_parallax( $args = [] ) {
    load_component( 'hero-parallax', $args );
  }
}

if ( ! function_exists( 'random_images' ) ) {
  function random_images( $args = [] ) {
    load_component( 'random-images', $args );
  }
}


if ( ! function_exists( 'faq' ) ) {
  function faq( $args = [] ) {
    load_component( 'faq', $args );
  }
}
