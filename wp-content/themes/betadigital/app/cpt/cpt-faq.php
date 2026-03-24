<?php

function posttype_faq() 
{    
    $labels = array(
        'name'                => ( 'FAQ'),
        'singular_name'       => ( 'FAQ'),
        'menu_name'           => ( 'FAQ'),
        'parent_item_colon'   => ( 'FAQ'),
        'all_items'           => ( 'All'),
        'view_item'           => ( 'View'),
        'add_new_item'        => ( 'Add new'),
        'add_new'             => ( 'Add new'),
        'edit_item'           => ( 'Edit'),
        'update_item'         => ( 'Update'),
        'search_items'        => ( 'Search'),
        'not_found'           => ( 'Not found'),
        'not_found_in_trash'  => ( 'Not found')
    );
    
    register_post_type( 'post_faq',
        array(
            'show_ui' => true,
            'menu_icon'         => 'dashicons-editor-help',
            'labels'            => $labels,
            'public'            => true,
            'show_in_menu'      => true,
            'show_in_nav_menus' => true,
            'menu_position'     => 5,
            'has_archive'       => false,
            'hierarchical'      => true,
            'rewrite'           => array('slug' => 'faq'),
            'supports'          => array( 'title', 'editor'),
        )
    );
}

add_action( 'init', 'posttype_faq' );


/**
 * ACF sub-page under FAQ menu + field group
 */
add_action( 'acf/init', function () {
    if ( ! function_exists( 'acf_add_options_sub_page' ) ) return;

    $page = acf_add_options_sub_page( [
        'page_title'  => 'Configurações do FAQ',
        'menu_title'  => 'Configurações',
        'parent_slug' => 'edit.php?post_type=post_faq',
        'capability'  => 'edit_posts',
        'autoload'    => false,
    ] );

    if ( ! function_exists( 'acf_add_local_field_group' ) ) return;

    acf_add_local_field_group( [
        'key'    => 'group_faq_options',
        'title'  => 'Vídeo do FAQ',
        'fields' => [
            [
                'key'          => 'field_faq_youtube_url',
                'label'        => 'URL do vídeo (YouTube)',
                'name'         => 'faq_youtube_url',
                'type'         => 'url',
                'instructions' => 'Cole o link do YouTube. Ex: https://www.youtube.com/watch?v=XXXXX — Deixe em branco para ocultar o vídeo.',
                'required'     => 0,
                'placeholder'  => 'https://www.youtube.com/watch?v=',
            ],
        ],
        'location' => [
            [ [ 'param' => 'options_page', 'operator' => '==', 'value' => $page['menu_slug'] ] ],
        ],
        'menu_order' => 0,
    ] );
} );