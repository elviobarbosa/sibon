<?php
//================== STYLES e SCRIPTS ====================

function wpdocs_theme_name_scripts() {
    wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');
    wp_enqueue_style('site-style', get_stylesheet_directory_uri() . '/dist/styles/frontend.css', array(), filemtime(get_stylesheet_directory() . '/dist/styles/frontend.css'));

    wp_deregister_script('jquery');
    wp_deregister_script('jquery-core');
    wp_deregister_script('jquery-migrate');

    wp_enqueue_script('js-site', get_stylesheet_directory_uri() . '/dist/scripts/frontend-bundle.js', array(), filemtime(get_stylesheet_directory() . '/dist/scripts/frontend-bundle.js'), true);

    wp_localize_script('js-site', 'ajaxData', array(
        'url'   => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('ajax_nonce')
    ));
}

// Remove block-library CSS em páginas sem Gutenberg
add_action('wp_enqueue_scripts', function() {
    if (!is_singular() || !has_blocks()) {
        wp_dequeue_style('wp-block-library');
        wp_dequeue_style('wp-block-library-theme');
        wp_dequeue_style('global-styles');
    }
}, 100);

function admin_style() {
    wp_enqueue_style('sibon-style-admin', get_stylesheet_directory_uri() . '/dist/styles/admin.css', array(), '1.0', true);
    wp_enqueue_script('sibon-script-admin', get_stylesheet_directory_uri() . '/dist/scripts/admin-bundle.js', array(), '1.0', true);
}

function be_gutenberg_scripts() {
	wp_enqueue_style('editor-assets-test', get_stylesheet_directory_uri() . '/dist/styles/admin.css');
}

add_action( 'enqueue_block_editor_assets', 'be_gutenberg_scripts' );
add_action('admin_enqueue_scripts', 'admin_style');
add_action( 'wp_enqueue_scripts', 'wpdocs_theme_name_scripts' );

add_filter( 'wp_script_attributes', static function ( array $attr ) : array {
    if ( 'js-site' !== $attr['id'] ) {
        return $attr;
    }

    $attr['type'] = 'module';

    return $attr;
} );

function async_load_noncritical_css($tag, $handle) {
    $async_handles = ['site-style', 'parent-style'];
    if (in_array($handle, $async_handles)) {
        $tag = str_replace(
            "rel='stylesheet'",
            "rel='stylesheet' media='print' onload=\"this.media='all'\"",
            $tag
        );

        $noscript = str_replace(
            [" media='print'", " onload=\"this.media='all'\""],
            ['', ''],
            $tag
        );
        $tag .= '<noscript>' . $noscript . '</noscript>';
    }
    return $tag;
}
add_filter('style_loader_tag', 'async_load_noncritical_css', 10, 2);

function inline_critical_css() {
    $critical_css_path = get_stylesheet_directory() . '/dist/styles/critical.css';
    if (file_exists($critical_css_path)) {
        echo '<style id="critical-css">' . file_get_contents($critical_css_path) . '</style>';
    }
}
add_action('wp_head', 'inline_critical_css', 1);

function sibon_preconnect_hints() {
    echo '<link rel="preconnect" href="https://img.youtube.com" crossorigin>' . "\n";
    echo '<link rel="dns-prefetch" href="https://img.youtube.com">' . "\n";
}
add_action('wp_head', 'sibon_preconnect_hints', 2);


 //================== STYLES e SCRIPTS ====================