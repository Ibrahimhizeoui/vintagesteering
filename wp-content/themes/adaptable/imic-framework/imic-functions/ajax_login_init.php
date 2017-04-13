<?php

if ( !function_exists( 'ajax_login_init' ) )
{
    function ajax_login_init( )
    {
        wp_register_script( 'ajax-login-script', get_template_directory_uri() . '/js/ajax-login-script.js', array(
             'jquery'
        ) );
        wp_enqueue_script( 'ajax-login-script' );
        wp_localize_script( 'ajax-login-script', 'ajax_login_object', array(
             'ajaxurl' => admin_url( 'admin-ajax.php' ),
            'loadingmessage' => __( 'Sending user info, please wait...', 'framework' )
        ) );
        add_action( 'wp_ajax_nopriv_ajaxlogin', 'ajax_login' );
    }
    if ( !is_user_logged_in() )
    {
        add_action( 'init', 'ajax_login_init' );
    }
}
