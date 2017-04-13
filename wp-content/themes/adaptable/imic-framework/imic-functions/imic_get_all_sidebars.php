<?php

//Get all Sidebars
if ( !function_exists( 'imic_get_all_sidebars' ) )
{
    function imic_get_all_sidebars( )
    {
        $all_sidebars = array( );
        global $wp_registered_sidebars;
        $all_sidebars = array(
             '' => ''
        );
        foreach ( $wp_registered_sidebars as $sidebar )
        {
            $all_sidebars[ $sidebar[ 'id' ] ] = $sidebar[ 'name' ];
        }
        return $all_sidebars;
    }
}
