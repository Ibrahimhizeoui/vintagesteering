<?php

if ( !function_exists( 'imi_update_status_ads' ) )
{
    function imi_update_status_ads( )
    {
        $ad_id       = $_POST[ 'ads' ];
        $next_status = $_POST[ 'next_status' ];
        if ( $next_status == 3 )
        {
            echo __( "Inactive", "framework" );
        }
        elseif ( $next_status == 1 )
        {
            echo __( "Active", "framework" );
        }
        elseif ( $next_status == 2 )
        {
            $post_author_id = get_post_field( 'post_author', $ad_id );
            $user_info_id   = get_user_meta( $post_author_id, 'imic_user_info_id', true );
            $cu             = get_post_meta( $user_info_id, 'imic_user_sold_cars', true );
            update_post_meta( $user_info_id, 'imic_user_sold_cars', $cu + 1 );
            echo __( "Sold", "framework" );
        }
        update_post_meta( $ad_id, 'imic_plugin_ad_payment_status', $next_status );
        die( );
    }
    add_action( 'wp_ajax_nopriv_imi_update_status_ads', 'imi_update_status_ads' );
    add_action( 'wp_ajax_imi_update_status_ads', 'imi_update_status_ads' );
}
