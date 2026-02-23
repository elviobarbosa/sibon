<?php

function posttype_photo_slide()
{
    $labels = array(
        'name'                => ('Photo Slides'),
        'singular_name'       => ('Photo Slide'),
        'menu_name'           => ('Photo Slides'),
        'parent_item_colon'   => ('Photo Slide'),
        'all_items'           => ('All'),
        'view_item'           => ('View'),
        'add_new_item'        => ('Add new'),
        'add_new'             => ('Add new'),
        'edit_item'           => ('Edit'),
        'update_item'         => ('Update'),
        'search_items'        => ('Search'),
        'not_found'           => ('Not found'),
        'not_found_in_trash'  => ('Not found')
    );

    register_post_type('post_photo_slide',
        array(
            'show_ui'           => true,
            'menu_icon'         => 'dashicons-camera',
            'labels'            => $labels,
            'public'            => true,
            'show_in_menu'      => true,
            'show_in_nav_menus' => true,
            'menu_position'     => 5,
            'has_archive'       => false,
            'hierarchical'      => true,
            'supports'          => array('title', 'thumbnail', 'page-attributes'),
        )
    );
}

add_action('init', 'posttype_photo_slide');
