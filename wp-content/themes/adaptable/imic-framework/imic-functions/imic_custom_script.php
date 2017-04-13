<?php

if ( !function_exists( 'imic_custom_script' ) )
{
    function imic_custom_script( )
    {
        $options   = get_option( 'imic_options' );
        $custom_js = $options[ 'custom_js' ];
        if ( $custom_js )
        {
            echo '<script type ="text/javascript">';
            echo $custom_js;
            echo '</script>';
        }
    }
    add_action( 'wp_footer', 'imic_custom_script' );
}
