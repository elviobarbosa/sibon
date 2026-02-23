<?php

function posttype_experience_item()
{
    $labels = array(
        'name'                => ('Experience Items'),
        'singular_name'       => ('Experience Item'),
        'menu_name'           => ('Experience Items'),
        'parent_item_colon'   => ('Experience Item'),
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

    register_post_type('post_experience_item',
        array(
            'show_ui'           => true,
            'menu_icon'         => 'dashicons-list-view',
            'labels'            => $labels,
            'public'            => true,
            'show_in_menu'      => true,
            'show_in_nav_menus' => true,
            'menu_position'     => 5,
            'has_archive'       => false,
            'hierarchical'      => true,
            'supports'          => array('title', 'editor', 'page-attributes'),
        )
    );
}

add_action('init', 'posttype_experience_item');
