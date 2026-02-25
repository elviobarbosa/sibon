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

if ( ! function_exists( 'hero_spline' ) ) {
  function hero_spline( $args = [] ) {
    load_component( 'hero-spline', $args );
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

if ( ! function_exists( 'unforgettable' ) ) {
  function unforgettable( $args = [] ) {
    load_component( 'unforgettable', $args );
  }
}

if ( ! function_exists( 'feature_slide' ) ) {
  function feature_slide( $args = [] ) {
    load_component( 'feature-slide', $args );
  }
}

if ( ! function_exists( 'experience' ) ) {
  function experience( $args = [] ) {
    load_component( 'experience', $args );
  }
}

if ( ! function_exists( 'hero_sibon_baru' ) ) {
  function hero_sibon_baru( $args = [] ) {
    load_component( 'hero-sibon-baru', $args );
  }
}

if ( ! function_exists( 'features_charters' ) ) {
  function features_charters( $args = [] ) {
    load_component( 'features-charters', $args );
  }
}

if ( ! function_exists( 'photo_slide' ) ) {
  function photo_slide( $args = [] ) {
    load_component( 'photo-slide', $args );
  }
}

if ( ! function_exists( 'schedule_booking' ) ) {
  function schedule_booking( $args = [] ) {
    load_component( 'schedule-booking', $args );
  }
}

if ( ! function_exists( 'cta_boat' ) ) {
  function cta_boat( $args = [] ) {
    load_component( 'cta-boat', $args );
  }
}

if ( ! function_exists( 'depoiments' ) ) {
  function depoiments( $args = [] ) {
    load_component( 'depoiments', $args );
  }
}

if ( ! function_exists( 'enquire_form' ) ) {
  function enquire_form( $args = [] ) {
    load_component( 'enquire-form', $args );
  }
}