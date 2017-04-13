<?php

if ( !function_exists( 'imic_encode_spaces' ) )
{
    function imic_encode_spaces( $string )
    {
        return str_replace( ' ', '%20', $string );
    }
}
