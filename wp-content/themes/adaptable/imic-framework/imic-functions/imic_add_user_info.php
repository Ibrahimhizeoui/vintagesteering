<?php

if ( !function_exists( 'imic_add_user_info' ) )
{
    function imic_add_user_info( $user_id )
    {
        $user_info = get_userdata( $user_id );
        $my_post   = array(
             'post_title' => $user_info->user_login,
            'post_type' => 'user',
            'post_status' => 'publish'
            //'tax_input'	=> array('user-category'=>array('subsscriber'))
            //'post_category' => array(8,39)
        );
        if ( isset( $_POST[ 'first_name' ] ) )
        {
            // Insert the post into the database
            $post_id = wp_insert_post( $my_post );
            update_user_meta( $user_id, 'imic_user_info_id', $post_id );
            wp_set_object_terms( $post_id, $user_info->roles, 'user-category' );
            update_post_meta( $post_id, 'imic_user_reg_id', $user_id );
        }
    }
    add_action( 'user_register', 'imic_add_user_info' );
}
