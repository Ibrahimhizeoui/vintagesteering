<?php

if ( !function_exists( 'imic_sight' ) )
{
    function imic_sight( $file_handler, $post_id, $set_thu = false )
    {
        // check to make sure its a successful upload
        if ( $_FILES[ $file_handler ][ 'error' ] !== UPLOAD_ERR_OK ) {
            __return_false();
        }

        require_once( ABSPATH . 'wp-admin/includes/image.php' );
        require_once( ABSPATH . 'wp-admin/includes/file.php' );
        require_once( ABSPATH . 'wp-admin/includes/media.php' );
        
        return media_handle_upload( $file_handler, $post_id );
    }
}
