<?php

if ( !function_exists( 'imic_afterSavePost' ) )
{
    function imic_afterSavePost( )
    {
        global $imic_options;
        $title = ( isset( $imic_options[ 'highlighted_specs' ] ) ) ? $imic_options[ 'highlighted_specs' ] : array( );
        if ( ( isset( $_GET[ 'post' ] ) ) && ( !empty( $title ) ) )
        {
            $postId    = $_GET[ 'post' ];
            $post_type = get_post_type( $postId );
            if ( $post_type == 'cars' )
            {
                $listing_end_date = get_post_meta( $postId, 'imic_plugin_listing_end_dt', true );
                if ( $listing_end_date == '' )
                {
                    update_post_meta( $postId, 'imic_plugin_listing_end_dt', '2020-01-01' );
                }
                $specifications = get_post_meta( $postId, 'feat_data', true );
                $new_title      = imic_vehicle_title( $postId, $title, $specifications );
                $my_post        = array(
                     'ID' => $postId,
                    'post_title' => $new_title
                );
                wp_update_post( $my_post );
            }
        }
    }
    add_action( 'save_post', 'imic_afterSavePost' );
}
