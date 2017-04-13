<?php
if ( !function_exists( 'imic_admin_bar_menu' ) )
{
    function imic_admin_bar_menu( )
    {
        global $wp_admin_bar;
        if ( current_user_can( 'manage_options' ) )
        {
            $theme_customizer = array(
                 'id' => '2',
                'title' => __( 'Color Customizer', 'framework' ),
                'href' => admin_url( '/customize.php' ),
                'meta' => array(
                     'target' => 'blank'
                )
            );
            $wp_admin_bar->add_menu( $theme_customizer );
        }
    }
    add_action( 'admin_bar_menu', 'imic_admin_bar_menu', 99 );
}
