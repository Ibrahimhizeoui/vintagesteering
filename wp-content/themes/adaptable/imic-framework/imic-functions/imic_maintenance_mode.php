<?php
if ( !function_exists( 'imic_maintenance_mode' ) )
{
    function imic_maintenance_mode( )
    {
        $options            = get_option( 'imic_options' );
        $custom_logo        = array(
             "url" => ""
        );
        $custom_logo_output = $maintenance_mode = "";
        if ( isset( $options[ 'custom_admin_login_logo' ] ) )
        {
            $custom_logo = $options[ 'custom_admin_login_logo' ];
        }
        $custom_logo_output = '<img src="' . $custom_logo[ 'url' ] . '" alt="maintenance" style="height: 62px!important;margin: 0 auto; display: block;" />';
        if ( isset( $options[ 'enable_maintenance' ] ) )
        {
            $maintenance_mode = $options[ 'enable_maintenance' ];
        }
        else
        {
            $maintenance_mode = false;
        }
        if ( $maintenance_mode )
        {
            if ( !current_user_can( 'edit_themes' ) || !is_user_logged_in() )
            {
                wp_die( $custom_logo_output . '<p style="text-align:center">' . __( 'We are currently in maintenance mode, please check back shortly.', 'framework' ) . '</p>', __( 'Maintenance Mode', 'framework' ) );
            }
        }
    }
    add_action( 'get_header', 'imic_maintenance_mode' );
}
