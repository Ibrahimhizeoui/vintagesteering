<?php
if ( !function_exists( 'imic_add_nofollow_cat' ) )
{
    function imic_add_nofollow_cat( $text )
    {
        $text = str_replace( 'rel="category tag"', "", $text );
        return $text;
    }
    add_filter( 'the_category', 'imic_add_nofollow_cat' );
}
