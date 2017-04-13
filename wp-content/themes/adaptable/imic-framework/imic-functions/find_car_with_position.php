<?php

if ( !function_exists( 'find_car_with_position' ) )
{
    function find_car_with_position( $cars, $position )
    {
        foreach ( $cars as $index => $car )
        {
            if ( $car[ 'imic_plugin_specification_values' ] == $position )
                return $index;
        }
        return FALSE;
    }
}
