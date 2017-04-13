<?php

if ( !function_exists( 'imic_custom_taxonomies_terms_links' ) )
{
    function imic_custom_taxonomies_terms_links( $id )
    {
        global $post;
        $out        = '';
        // get post by post id
        $post       = get_post( $id );
        // get post type by post
        $post_type  = $post->post_type;
        // get post type taxonomies
        $taxonomies = get_object_taxonomies( $post_type );
        foreach ( $taxonomies as $taxonomy )
        {
            // get the terms related to post
            $terms = get_the_terms( $post->ID, $taxonomy );
            if ( !empty( $terms ) )
            {
                foreach ( $terms as $term )
                {
                    $out = $term->name;
                }
            }
        }
        return $out;
    }
}
