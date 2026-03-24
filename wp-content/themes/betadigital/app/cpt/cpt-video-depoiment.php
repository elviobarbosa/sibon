<?php

function posttype_video_depoiment() {
    $labels = array(
        'name'               => 'Depoimentos em Vídeo',
        'singular_name'      => 'Depoimento em Vídeo',
        'menu_name'          => 'Vídeo Depoimentos',
        'all_items'          => 'Todos',
        'add_new_item'       => 'Novo Depoimento em Vídeo',
        'add_new'            => 'Novo',
        'edit_item'          => 'Editar',
        'update_item'        => 'Atualizar',
        'search_items'       => 'Buscar',
        'not_found'          => 'Não encontrado',
        'not_found_in_trash' => 'Não encontrado',
    );

    register_post_type( 'post_video_depoiment', array(
        'show_ui'           => true,
        'menu_icon'         => 'dashicons-video-alt3',
        'labels'            => $labels,
        'public'            => true,
        'show_in_menu'      => true,
        'show_in_nav_menus' => false,
        'menu_position'     => 7,
        'has_archive'       => false,
        'hierarchical'      => false,
        'supports'          => array( 'title', 'page-attributes' ),
    ) );
}

add_action( 'init', 'posttype_video_depoiment' );


/**
 * ACF fields for post_video_depoiment
 */
add_action( 'acf/init', function () {
    if ( ! function_exists( 'acf_add_local_field_group' ) ) return;

    acf_add_local_field_group( array(
        'key'      => 'group_video_depoiment',
        'title'    => 'Dados do Vídeo',
        'fields'   => array(
            array(
                'key'           => 'field_video_depoiment_url',
                'label'         => 'URL do YouTube',
                'name'          => 'youtube_url',
                'type'          => 'url',
                'instructions'  => 'Cole aqui o link do vídeo no YouTube (ex: https://www.youtube.com/watch?v=XXXXXXX)',
                'required'      => 1,
                'placeholder'   => 'https://www.youtube.com/watch?v=',
            ),
            array(
                'key'           => 'field_video_depoiment_thumbnail',
                'label'         => 'Imagem de capa (opcional)',
                'name'          => 'thumbnail',
                'type'          => 'image',
                'instructions'  => 'Se não enviada, será usada a miniatura automática do YouTube.',
                'required'      => 0,
                'return_format' => 'url',
                'preview_size'  => 'medium',
                'library'       => 'all',
            ),
            array(
                'key'          => 'field_video_depoiment_page',
                'label'        => 'Exibir nas páginas',
                'name'         => 'page',
                'type'         => 'checkbox',
                'instructions' => 'Marque em quais páginas este vídeo deve aparecer.',
                'required'     => 1,
                'choices'      => array(
                    'front-page' => 'Home',
                    'sibon-baru' => 'Sibon Baru',
                    'sibon-jaya' => 'Sibon Jaya',
                ),
                'default_value' => array(),
                'layout'        => 'horizontal',
                'return_format' => 'value',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param'    => 'post_type',
                    'operator' => '==',
                    'value'    => 'post_video_depoiment',
                ),
            ),
        ),
        'menu_order' => 0,
    ) );
} );
