<?php
/**
 * 1. dequeue/deregister scripts/styles from parent theme
 */
function vts0561_scripts_styles()
{
    if (!is_admin()) {
        // remove IMIC framework colour css
        wp_deregister_style('imic_colors');
        wp_dequeue_style('imic_colors');
        wp_deregister_style('imic_custom_css');
        wp_dequeue_style('imic_custom_css');

        // remove Theme for owl carousel, only need defaults
        wp_deregister_style('imic_owl_theme');
        wp_dequeue_style('imic_owl_theme');
        // remove nivoslider
        wp_deregister_style('imic_nivo_default');
        wp_dequeue_style('imic_nivo_default');
        wp_deregister_style('imic_nivo_slider');
        wp_dequeue_style('imic_nivo_slider');
        wp_deregister_script('imic_nivo_slider');
        wp_dequeue_script('imic_nivo_slider');

        // remove pretty photo styles/scripts
        wp_deregister_style('imic_prettyPhoto');
        wp_dequeue_style('imic_prettyPhoto');
        wp_deregister_script('imic_jquery_prettyphoto');
        wp_dequeue_script('imic_jquery_prettyphoto');

        // remove google map
        // wp_deregister_script('imic_google_map');
        // wp_dequeue_script('imic_google_map');
        // wp_deregister_script('imic_gmap');
        // wp_dequeue_script('imic_gmap');
        // wp_deregister_script('imic_contact_map');
        // wp_dequeue_script('imic_contact_map');

       wp_enqueue_script( 'adp_google_translate', '//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit', array(), null, true);
       wp_add_inline_script( 'adp_google_translate', "function googleTranslateElementInit() {new google.translate.TranslateElement({pageLanguage: 'en', includedLanguages: 'de, en', layout: google.translate.TranslateElement.InlineLayout.SIMPLE}, 'google_translate_element'); }" );
    }
}
add_action('wp_enqueue_scripts', 'vts0561_scripts_styles', 100);

/**
 * Register Custom CSS/JS assets
 */
function vts23135_custom_assets()
{
    wp_enqueue_script( 'wp-api' );

    wp_enqueue_script('bundle', get_stylesheet_directory_uri().'/js/bundle.js', array('wp-api', 'imic_common_scripts'), '1.0', true);
}
add_action('wp_enqueue_scripts', 'vts23135_custom_assets');


// pre render script to reload the selectpicker, waits till page has loaded
function vts23135_gravity_form_select_fix($form)
{
    $output = [
        "<script>\n",
            "jQuery(document).bind('gform_post_render', function(){\n",
                "jQuery('.gform_wrapper selectpicker select').addClass('form-control');\n",
                "jQuery('.gform_wrapper selectpicker select').selectpicker('render');\n",
                "return;\n",
            "});\n",
        "</script>"
    ];

    echo implode($output);

    return $form;
}
add_action('gform_pre_render', 'vts23135_gravity_form_select_fix');
