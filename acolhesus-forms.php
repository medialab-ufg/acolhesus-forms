<?php
/**
 * Plugin Name: Formulários para AcolheSUS RHS
 * Plugin URI: https://github.com/medialab-ufg/acolhesus-forms
 * Description: Formulários customizados para aplicação da CGPNH
 * Author: L3P/UFG
 * Version: 0.1
 * Author URI: https://github.com/medialab-ufg/
 * Text Domain: acolhesus-rhs
 */

/*
 * Inicialmente, depende de https://br.wordpress.org/plugins/caldera-forms/ (versao free)
 */

function form_matriz_cenario()
{
    register_post_type('matriz_cenario', array(
        'labels' => array(
            'name' => ('Matriz de Cenário'),
            'singular_name' => ('Formulário de Matriz de Cenário')
        ),
        'public' => true,
        'has_archive' => true,
        'rewrite' => array('slug' => 'matriz_cenario'),
        'capability_type' => 'post',
        'menu_position' => 20
    ));
}
add_action('init', 'form_matriz_cenario');

add_filter('the_content', function ($content) {
    global $post;

    $saved_form_id = get_post_meta($post->ID, '_entry_id', true);

    if ($post->post_type == 'matriz_cenario') {

        $caldera_plugin = get_class_methods(Caldera_Forms::class );

        if (is_array($caldera_plugin) && in_array("render_form", $caldera_plugin)) {
            $form = Caldera_Forms::render_form([
                'id' => 'CF5adf2fc505a49', // hard coded apenas por enquanto
            ], $saved_form_id);
        }
    }

    return $content . " <br>" . $form;
});


add_action('caldera_forms_entry_saved', function ($entryid, $new_entry, $form) {
        global $post;
        update_post_meta($post->ID, '_entry_id', $entryid);
    }, 10, 3);


if (!function_exists('load_forms_template')) {
    function load_forms_template($template)
    {
        global $post;

        if ($post->post_type == 'matriz_cenario') {
            return plugin_dir_path( __FILE__ ) . "templates/single_acolhesus.php";
        }
    }

    add_filter('single_template', 'load_forms_template');
}
