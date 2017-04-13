<?php

if ( !function_exists( 'imic_analytics' ) )
{
    function imic_analytics( )
    {
        $options = get_option( 'imic_options' );
        if ( $options[ 'tracking-code' ] != "" )
        {
            echo '<script>';
            echo $options[ 'tracking-code' ];
            echo '</script>';
        }
    }
    add_action( 'wp_head', 'imic_analytics' );
}
