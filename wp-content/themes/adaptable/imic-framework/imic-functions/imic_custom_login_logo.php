<?php

if ( !function_exists( 'imic_custom_login_logo' ) )
{
    function imic_custom_login_logo( )
    {
        $options     = get_option( 'imic_options' );
        $custom_logo = array(
             "url" => ""
        );
        if ( isset( $options[ 'custom_admin_login_logo' ] ) )
        {
            $custom_logo = $options[ 'custom_admin_login_logo' ];
        }
        echo '<style type="text/css">
			    .login h1 a { background-image:url(' . $custom_logo[ 'url' ] . ') !important; background-size: auto !important; width: auto !important; height: 95px !important; }
			</style>';
    }
    add_action( 'login_head', 'imic_custom_login_logo' );
}
