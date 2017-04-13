<?php

if ( !function_exists( 'imic_get_all_integer_specifications' ) )
{
    function imic_get_all_integer_specifications( $type )
    {
        $int_specs             = array( );
        $args_specification    = array(
             'post_type' => 'specification',
            'posts_per_page' => -1,
            'meta_query' => array(
                 array(
                     'key' => 'imic_plugin_spec_char_type',
                    'value' => $type,
                    'compare' => '='
                )
            )
        );
        $specification_listing = new WP_Query( $args_specification );
        if ( $specification_listing->have_posts() ):
            while ( $specification_listing->have_posts() ):
                $specification_listing->the_post();
                $int_specs[ ] = imic_the_slug( get_the_ID() );
            endwhile;
        endif;
        wp_reset_postdata();
        return $int_specs;
    }
}
