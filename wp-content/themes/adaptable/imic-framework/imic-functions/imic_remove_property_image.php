<?php

if ( !function_exists( 'imic_remove_property_image' ) )
{
    function imic_remove_property_image( )
    {
        $thumb    = $_POST[ 'thumb_id' ];
        $property = $_POST[ 'property_id' ];
        delete_post_meta( $property, 'imic_plugin_vehicle_images', $thumb );
        die( );
    }
    add_action( 'wp_ajax_nopriv_imic_remove_property_image', 'imic_remove_property_image' );
    add_action( 'wp_ajax_imic_remove_property_image', 'imic_remove_property_image' );
}
