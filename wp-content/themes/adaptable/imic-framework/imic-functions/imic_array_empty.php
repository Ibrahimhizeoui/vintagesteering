<?php

if ( !function_exists( 'imic_array_empty' ) )
{
    function imic_array_empty( $mixed )
    {
        if ( is_array( $mixed ) )
        {
            foreach ( $mixed as $value )
            {
                if ( !imic_array_empty( $value ) )
                {
                    return false;
                }
            }
        }
        elseif ( !empty( $mixed ) )
        {
            return false;
        }
        return true;
    }
}
