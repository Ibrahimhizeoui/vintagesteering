<?php

//Get All Post Types
if ( !function_exists( 'imic_get_all_types' ) )
{
    add_action( 'wp_loaded', 'imic_get_all_types' );
    function imic_get_all_types( )
    {
        $args   = array(
             'public' => true
        );
        $output = 'names'; // names or objects, note names is the default
        return $post_types = get_post_types( $args, $output );
    }
}
