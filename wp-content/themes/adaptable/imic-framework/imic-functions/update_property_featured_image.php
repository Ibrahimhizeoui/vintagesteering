<?php

if ( !function_exists( 'update_property_featured_image' ) )
{
    function update_property_featured_image( )
    {
        $property_id = $_POST[ 'property_id' ];
        $thumb_id    = $_POST[ 'thumb_id' ];
        update_post_meta( $property_id, '_thumbnail_id', $thumb_id );
        echo "success";
        die( );
    }
    add_action( 'wp_ajax_nopriv_update_property_featured_image', 'update_property_featured_image' );
    add_action( 'wp_ajax_update_property_featured_image', 'update_property_featured_image' );
}
