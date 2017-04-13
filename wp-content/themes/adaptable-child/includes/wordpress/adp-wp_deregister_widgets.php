<?php

/**
 * Deregister widgets that have been set by either wordpress or the parent theme
 */
function adp_deregister_widgets()
{
    // general / WP
    unregister_widget('WP_Widget_Tag_Cloud');
    unregister_widget('WP_Widget_Search');
    unregister_widget('WP_Widget_Meta');
    unregister_widget('WP_Widget_Calendar');
    unregister_widget('WP_Widget_Pages');
    // unregister_widget('WP_Nav_Menu_Widget');
    unregister_widget('WP_Widget_RSS');
    unregister_widget('WP_Widget_Recent_Comments');

    // Parent theme widgets
    unregister_widget('twitter_feeds');
    unregister_widget('imic_cars');
    unregister_widget('imic_agent_registration');
    unregister_widget('imic_mortgage');
    unregister_widget('imic_enquiry_form');
    unregister_widget('imic_reviews');
    unregister_widget('imic_latest_posts');

    // Polylang
    unregister_widget('PLL_Widget_Languages');
    unregister_widget('PLL_Widget_Calendar');

    // Gravity Forms
    unregister_widget('GFLoginWidget');
    unregister_widget('GFWidget');
}
add_action( 'widgets_init', 'adp_deregister_widgets', 11);

/**
 * Shows all available widget classes, useful for finding active widgets
 */
function show_widget_classes() {
    global $wp_registered_widgets;
    $widgets = array();

    if(is_array($wp_registered_widgets)){
        foreach($wp_registered_widgets as $widg){
            if(!empty($widg['callback'])){
                if(!empty($widg['callback'][0])){
                    $class = get_class($widg['callback'][0]);
                    if(!array_key_exists($class, $widgets)){
                        $widgets[$class] = $widg['callback'][0]->name;
                    }
                }
            }
        }
    }

    foreach($widgets as $widget_class  => $widget_title ){
        log_me($widget_class);
    }
}
// uncomment action to run function
//add_action( 'admin_notices', 'show_widget_classes' );
