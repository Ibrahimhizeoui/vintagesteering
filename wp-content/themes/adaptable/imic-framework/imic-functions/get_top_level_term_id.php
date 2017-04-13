<?php

if (!function_exists('get_top_level_term_id'))
{
    function get_top_level_term_id( $post_id, $taxonomy )
    {

        $terms = wp_get_post_terms( $post_id, $taxonomy );

        $term    = $terms[ 0 ];
        $term_id = $term->term_id;

        while ( $term->parent )
        {
            $term_id = $term->parent;
            $term    = get_term_by( 'id', $term_id, $taxonomy );
        }
        return $term_id;
    }
}
