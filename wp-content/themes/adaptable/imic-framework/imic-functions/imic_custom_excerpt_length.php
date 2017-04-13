<?php

/* Change Excerpt Length*/
if ( !function_exists( 'imic_custom_excerpt_length' ) )
{
    function imic_custom_excerpt_length( $length )
    {
        return 520;
    }
    add_filter( 'excerpt_length', 'imic_custom_excerpt_length', 999 );
}
