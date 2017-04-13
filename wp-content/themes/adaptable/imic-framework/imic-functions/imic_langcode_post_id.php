<?php

if ( !function_exists( 'imic_langcode_post_id' ) )
{
    function imic_langcode_post_id( $post_id )
    {
        if ( class_exists( 'SitePress' ) )
        {
            global $wpdb;

            $query      = $wpdb->prepare( 'SELECT language_code FROM ' . $wpdb->prefix . 'icl_translations WHERE element_id="%d"', $post_id );
            $query_exec = $wpdb->get_row( $query );

            return $query_exec->language_code;
        }
    }
}
