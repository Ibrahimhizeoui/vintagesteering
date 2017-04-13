<?php

if (!function_exists('get_last_child_term_id'))
{
    function get_last_child_term_id( $post_id, $taxonomy, $output_single = false )
    {

        $terms = wp_get_post_terms( $post_id, $taxonomy );
        if ( ( !is_wp_error( $terms ) ) && ( !empty( $terms ) ) )
        {
            $new_terms = array( );
            foreach ( $terms as $term )
            {
                $i        = 0;
                $new_term = $term;
                while ( $term->parent )
                {
                    $term_id = $term->parent;
                    $term    = get_term_by( 'id', $term_id, $taxonomy );
                    $i++;
                }
                if ( $output_single )
                {
                    $new_terms[ $i ] = $new_term;
                }
                else
                {
                    $new_terms[ $i ][ ] = $new_term;
                }
            }

            $array_last_index = count( $new_terms ) - 1;

            $terms = $new_terms[ $array_last_index ];

            if ( $output_single )
            {
                $term    = $terms;
                $term_id = $term->slug;
                return $term_id;
            }
            else
            {
                $term_ids = array( );
                foreach ( $terms as $term )
                {
                    $term_ids[ ] = $term->slug;
                }
                return $term_ids;
            }
        }
    }
}
