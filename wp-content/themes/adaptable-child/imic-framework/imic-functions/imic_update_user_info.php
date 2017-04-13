<?php

if ( !function_exists( 'imic_update_user_info' ) )
{
    function imic_update_user_info( )
    {
        $uid        = ( isset( $_POST[ 'uid' ] ) ) ? $_POST[ 'uid' ] : '';
        $uinfo      = ( isset( $_POST[ 'uinfo' ] ) ) ? $_POST[ 'uinfo' ] : '';
        $fname      = ( isset( $_POST[ 'fname' ] ) ) ? $_POST[ 'fname' ] : '';
        $lname      = ( isset( $_POST[ 'lname' ] ) ) ? $_POST[ 'lname' ] : '';
        $uphone     = ( isset( $_POST[ 'phone' ] ) ) ? $_POST[ 'phone' ] : '';
        $ucity      = ( isset( $_POST[ 'city' ] ) ) ? $_POST[ 'city' ] : '';
        $uzip       = ( isset( $_POST[ 'zip' ] ) ) ? $_POST[ 'zip' ] : '';
        $ustate     = ( isset( $_POST[ 'state' ] ) ) ? $_POST[ 'state' ] : '';
        $tandcs     = ( isset( $_POST[ 'tandc' ] ) ) ? $_POST[ 'tandc' ] : '';
        $current_id = ( isset( $_POST[ 'currentid' ] ) ) ? $_POST[ 'currentid' ] : '';
        $query_var  = ( isset( $_POST[ 'queryv' ] ) ) ? $_POST[ 'queryv' ] : array( );
        $cat_slug   = '';

        if ( !empty( $query_var ) )
        {
            foreach ( $query_var as $key => $value )
            {
                if ( $key == "list-cat" )
                {
                    $cat_slug = $value;
                }
            }
        }
        $category_id = get_term_by( 'slug', $cat_slug, 'listing-category' );
        $term_id     = $category_id->term_id;
        $parents     = get_ancestors( $term_id, 'listing-category' );
        $list_terms  = array( );
        foreach ( $parents as $parent )
        {
            $list_term     = get_term_by( 'id', $parent, 'listing-category' );
            $list_terms[ ] = $list_term->slug;
        }
        $list_terms[ ] = $cat_slug;
        wp_set_object_terms( $current_id, $list_terms, 'listing-category' );
        if ( !empty( $uid ) )
        {
            wp_set_object_terms( $uinfo, $ustate, 'user-city' );
            wp_update_user( array(
                'ID' => $uid,
                'first_name' => $fname,
                'last_name' => $lname
            ) );
            update_post_meta( $uinfo, 'imic_user_city', $ucity );
            update_post_meta( $uinfo, 'imic_user_zip_code', $uzip );
            update_post_meta( $uinfo, 'imic_user_telephone', $uphone );
            update_post_meta( $uinfo, 'imic_user_tandc', $tandcs );
        }
        echo esc_attr( $fname );
        die( );
    }
    add_action( 'wp_ajax_nopriv_imic_update_user_info', 'imic_update_user_info' );
    add_action( 'wp_ajax_imic_update_user_info', 'imic_update_user_info' );
}
