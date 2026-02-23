<?php

function posttype_charter_schedule()
{
    $labels = array(
        'name'               => ('Charter Schedule'),
        'singular_name'      => ('Charter Schedule'),
        'menu_name'          => ('Charter Schedule'),
        'all_items'          => ('All'),
        'add_new_item'       => ('Add new'),
        'add_new'            => ('Add new'),
        'edit_item'          => ('Edit'),
        'update_item'        => ('Update'),
        'search_items'       => ('Search'),
        'not_found'          => ('Not found'),
        'not_found_in_trash' => ('Not found'),
    );

    register_post_type('charter_schedule', array(
        'show_ui'           => true,
        'menu_icon'         => 'dashicons-calendar',
        'labels'            => $labels,
        'public'            => true,
        'show_in_menu'      => true,
        'show_in_nav_menus' => true,
        'menu_position'     => 5,
        'has_archive'       => false,
        'hierarchical'      => true,
        'supports'          => array('title', 'page-attributes'),
    ));
}

add_action('init', 'posttype_charter_schedule');

function charter_schedule_flush_rewrite_rules()
{
    if (!get_option('charter_schedule_flushed')) {
        posttype_charter_schedule();
        flush_rewrite_rules();
        update_option('charter_schedule_flushed', true);
    }
}
add_action('after_switch_theme', 'charter_schedule_flush_rewrite_rules');
add_action('init', function () {
    if (!get_option('charter_schedule_flushed')) {
        flush_rewrite_rules();
        update_option('charter_schedule_flushed', true);
    }
}, 99);