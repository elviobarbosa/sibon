<?php

function posttype_tools() 
{    
    $labels = array(
        'name'                => ( 'Herramientas'),
        'singular_name'       => ( 'Herramientas'),
        'menu_name'           => ( 'Herramientas'),
        'parent_item_colon'   => ( 'Herramientas'),
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
    
    register_post_type( 'post_tools',
        array(
            'show_ui' => true,
            'menu_icon'         => 'dashicons-heart',
            'labels'            => $labels,
            'public'            => true,
            'show_in_menu'      => true,
            'show_in_nav_menus' => true,
            'menu_position'     => 5,
            'has_archive'       => false,
            'hierarchical'      => true,
            'rewrite'           => array('slug' => 'Herramientas'),
            'supports'          => array( 'title', 'editor', 'thumbnail'),
        )
    );
}

add_action( 'init', 'posttype_tools' );