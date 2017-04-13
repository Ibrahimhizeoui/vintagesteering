<?php

if ( !function_exists( 'imic_search_array' ) )
{
    function imic_search_array( $needle, $haystack )
    {
        if ( in_array( $needle, $haystack ) )
        {
            return true;
        }
        foreach ( $haystack as $element )
        {
            if ( is_array( $element ) && imic_search_array( $needle, $element ) )
                return true;
        }
        return false;
    }
}
