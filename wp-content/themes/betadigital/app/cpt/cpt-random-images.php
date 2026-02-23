<?php

function posttype_random_images() 
{    
    $labels = array(
        'name'                => ( 'Random images'),
        'singular_name'       => ( 'Random images'),
        'menu_name'           => ( 'Random images'),
        'parent_item_colon'   => ( 'Random images'),
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
    
    register_post_type( 'post_random_images',
        array(
            'show_ui' => true,
            'menu_icon'         => 'dashicons-groups',
            'labels'            => $labels,
            'public'            => true,
            'show_in_menu'      => true,
            'show_in_nav_menus' => true,
            'menu_position'     => 5,
            'has_archive'       => false,
            'hierarchical'      => true,
            'supports'          => array( 'title', 'thumbnail'),
        )
    );
}

add_action( 'init', 'posttype_random_images' );