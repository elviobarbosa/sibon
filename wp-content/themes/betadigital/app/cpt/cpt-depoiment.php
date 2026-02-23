<?php

function posttype_depoiment()
{
    $labels = array(
        'name'               => 'Depoimentos',
        'singular_name'      => 'Depoimento',
        'menu_name'          => 'Depoimentos',
        'all_items'          => 'Todos',
        'add_new_item'       => 'Novo Depoimento',
        'add_new'            => 'Novo',
        'edit_item'          => 'Editar',
        'update_item'        => 'Atualizar',
        'search_items'       => 'Buscar',
        'not_found'          => 'Não encontrado',
        'not_found_in_trash' => 'Não encontrado',
    );

    register_post_type('post_depoiment', array(
        'show_ui'           => true,
        'menu_icon'         => 'dashicons-format-quote',
        'labels'            => $labels,
        'public'            => true,
        'show_in_menu'      => true,
        'show_in_nav_menus' => false,
        'menu_position'     => 6,
        'has_archive'       => false,
        'hierarchical'      => false,
        'supports'          => array('title', 'thumbnail'),
    ));
}

add_action('init', 'posttype_depoiment');
