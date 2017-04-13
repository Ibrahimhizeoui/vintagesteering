<?php

if ( !function_exists( 'imic_count_user_posts_by_type' ) )
{
    function imic_count_user_posts_by_type( $userid, $post_type = 'post' )
    {
        global $wpdb;
        $where = get_posts_by_author_sql( $post_type, true, $userid );
        $count = $wpdb->get_var( "SELECT COUNT(*) FROM $wpdb->posts $where" );
        return apply_filters( 'get_usernumposts', $count, $userid );
    }
}
