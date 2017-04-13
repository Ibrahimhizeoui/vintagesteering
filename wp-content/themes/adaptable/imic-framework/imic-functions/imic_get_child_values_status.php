<?php

if ( !function_exists( 'imic_get_child_values_status' ) )
{
    function imic_get_child_values_status( $arr )
    {
        foreach ( $arr as $tab )
        {

            $child_value = $tab[ 'imic_plugin_specification_values_child' ];

            if ( !empty( $child_value ) )
            {
                $result = 1;
                break;
            }
            else
            {
                $result = 0;
            }

        }
        return $result;
    }
}
