<?php

if ( !function_exists( 'imic_cat_count_flag' ) )
{
    function imic_cat_count_flag( )
    {
        $term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
        $flag = 1;
        if ( !empty( $term ) )
        {
            $flag = $output = ( $term->count == 0 ) ? 0 : 1;
        }
        global $cat;
        if ( !empty( $cat ) )
        {
            $cat_data = get_category( $cat );
            $flag     = ( $cat_data->count == 0 ) ? 0 : 1;
        }
        return $flag;
    }
}
