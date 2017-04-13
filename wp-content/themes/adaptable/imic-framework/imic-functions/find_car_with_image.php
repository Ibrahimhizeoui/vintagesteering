<?php

if ( !function_exists( 'find_car_with_image' ) )
{
    function find_car_with_image( $cars, $position )
    {
        foreach ( $cars as $index => $car )
        {
            if ( $car[ 'imic_plugin_spec_image' ] == $position )
                return $index;
        }
        return FALSE;
    }
}
