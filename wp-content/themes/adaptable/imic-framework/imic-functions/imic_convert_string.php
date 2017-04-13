<?php

if (!function_exists('imic_convert_string'))
{
    function imic_convert_string( $value )
    {
        switch ( $value )
        {
            case 'Zero':
                $print_int = 0;
                break;
            case 'One':
                $print_int = 1;
                break;
            case 'Two':
                $print_int = 2;
                break;
            case 'Three':
                $print_int = 3;
                break;
            case 'Four':
                $print_int = 4;
                break;
            case 'Five':
                $print_int = 5;
                break;
            case 'Six':
                $print_int = 6;
                break;
            case 'Seven':
                $print_int = 7;
                break;
            case 'Eight':
                $print_int = 8;
                break;
            case 'Nine':
                $print_int = 9;
                break;
        }
        return $print_int;
    }
}
