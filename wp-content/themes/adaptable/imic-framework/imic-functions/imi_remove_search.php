<?php

if ( !function_exists( 'imi_remove_search' ) )
{
    function imi_remove_search( )
    {
        $searches      = ( isset( $_POST[ 'search_items' ] ) ) ? $_POST[ 'search_items' ] : '';
        $new_val       = array( );
        $user_id       = get_current_user_id();
        $user_info_id  = get_user_meta( $user_id, 'imic_user_info_id', true );
        $user_searches = get_post_meta( $user_info_id, 'imic_user_saved_search', true );
        foreach ( $user_searches as $search )
        {
            $res = preg_replace( "/[^a-zA-Z]/", "", $search[ 0 ] );
            if ( !in_array( $res, $searches ) )
            {
                $new_val[ ] = $search;
            }
        }
        update_post_meta( $user_info_id, 'imic_user_saved_search', $new_val );
        //print_r($saved);
        echo "success";
        die( );
    }
    add_action( 'wp_ajax_nopriv_imi_remove_search', 'imi_remove_search' );
    add_action( 'wp_ajax_imi_remove_search', 'imi_remove_search' );
}
