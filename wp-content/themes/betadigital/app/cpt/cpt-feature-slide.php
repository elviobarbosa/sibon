<?php

function posttype_feature_slide()
{
    $labels = array(
        'name'                => ('Feature Slides'),
        'singular_name'       => ('Feature Slide'),
        'menu_name'           => ('Feature Slides'),
        'parent_item_colon'   => ('Feature Slide'),
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

    register_post_type('post_feature_slide',
        array(
            'show_ui'           => true,
            'menu_icon'         => 'dashicons-slides',
            'labels'            => $labels,
            'public'            => true,
            'show_in_menu'      => true,
            'show_in_nav_menus' => true,
            'menu_position'     => 5,
            'has_archive'       => false,
            'hierarchical'      => true,
            'supports'          => array('title', 'thumbnail', 'editor'),
        )
    );
}

add_action('init', 'posttype_feature_slide');

// Metabox para Highlight
function feature_slide_metabox()
{
    add_meta_box(
        'feature_slide_highlight',
        'Highlight Text',
        'feature_slide_highlight_callback',
        'post_feature_slide',
        'normal',
        'high'
    );
}

add_action('add_meta_boxes', 'feature_slide_metabox');

function feature_slide_highlight_callback($post)
{
    wp_nonce_field('feature_slide_highlight_nonce', 'feature_slide_highlight_nonce');

    $highlight = get_post_meta($post->ID, '_feature_slide_highlight', true);
    ?>
    <p>
        <label for="feature_slide_highlight"><strong>Highlight:</strong></label><br>
        <input type="text"
               id="feature_slide_highlight"
               name="feature_slide_highlight"
               value="<?php echo esc_attr($highlight); ?>"
               style="width: 100%; font-size: 16px; padding: 8px;"
               placeholder="Ex: Conforto, Aventura, Luxo...">
    </p>
    <p class="description">Texto grande que aparece atrás do slide (ex: "Conforto")</p>
    <?php
}

function feature_slide_save_metabox($post_id)
{
    if (!isset($_POST['feature_slide_highlight_nonce'])) {
        return;
    }

    if (!wp_verify_nonce($_POST['feature_slide_highlight_nonce'], 'feature_slide_highlight_nonce')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    if (isset($_POST['feature_slide_highlight'])) {
        update_post_meta($post_id, '_feature_slide_highlight', sanitize_text_field($_POST['feature_slide_highlight']));
    }
}

add_action('save_post', 'feature_slide_save_metabox');
