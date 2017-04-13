<?php

if ( !function_exists( 'imic_value_search_multi_array' ) )
{
    function imic_value_search_multi_array( $value, $array )
    {
        if ( !empty( $array ) )
        {
            if ( in_array( $value, $array ) )
            {
                return true;
            }

            foreach ( $array as $item )
            {
                if ( is_array( $item ) && imic_value_search_multi_array( $value, $item ) )
                    return true;
            }
            return false;
        }
    }
}
