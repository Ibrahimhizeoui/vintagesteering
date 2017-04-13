<?php

if ( !function_exists( 'imic_is_decimal' ) )
{
    function imic_is_decimal( $val )
    {
        return is_numeric( $val ) && floor( $val ) != $val;
    }
}
