<?php

if ( !function_exists( 'imic_reset_password_init' ) )
{
    function imic_reset_password_init( )
    {
        wp_localize_script( 'ajax-login-script', 'reset_password', array(
             'fillemail' => __( 'Please enter registered email', 'framework' ),
            'invalidemail' => __( 'Email is not registered with us', 'framework' )
        ) );
        add_action( 'wp_ajax_nopriv_imic_reset_password', 'imic_reset_password' );
    }
    if ( !is_user_logged_in() )
    {
        add_action( 'init', 'imic_reset_password_init' );
    }
}
