<?php

if ( !function_exists( 'imi_remove_ads' ) )
{
    function imi_remove_ads( )
    {
        $ads = ( isset( $_POST[ 'ads' ] ) ) ? $_POST[ 'ads' ] : '';
        foreach ( $ads as $ad )
        {
            wp_delete_post( $ad, true );
        }
        //print_r($saved);
        echo "success";
        die( );
    }
    add_action( 'wp_ajax_nopriv_imi_remove_ads', 'imi_remove_ads' );
    add_action( 'wp_ajax_imi_remove_ads', 'imi_remove_ads' );
}
