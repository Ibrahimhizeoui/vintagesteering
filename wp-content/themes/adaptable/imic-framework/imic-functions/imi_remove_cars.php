<?php

if ( !function_exists( 'imi_remove_cars' ) )
{
    function imi_remove_cars( )
    {
        $saved           = ( isset( $_POST[ 'saved' ] ) ) ? $_POST[ 'saved' ] : '';
        $new_val         = array( );
        $user_id         = get_current_user_id();
        $user_info_id    = get_user_meta( $user_id, 'imic_user_info_id', true );
        $saved_cars_user = get_post_meta( $user_info_id, 'imic_user_saved_cars', true );
        foreach ( $saved_cars_user as $save )
        {
            if ( !in_array( $save[ 0 ], $saved ) )
            {
                $new_val[ ] = $save;
            }
        }
        update_post_meta( $user_info_id, 'imic_user_saved_cars', $new_val );
        print_r( $saved );
        die( );
    }
    add_action( 'wp_ajax_nopriv_imi_remove_cars', 'imi_remove_cars' );
    add_action( 'wp_ajax_imi_remove_cars', 'imi_remove_cars' );
}
