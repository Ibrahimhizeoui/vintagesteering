<?php

if ( !function_exists( 'imic_get_currency_symbol' ) )
{
    function imic_get_currency_symbol( $currency = '' )
    {
        if ( !$currency )
        {
            $currency = 'USD';
        }
        switch ( $currency )
        {
            case 'AED':
                $currency_symbol = 'AED';
                break;
            case 'BDT':
                $currency_symbol = '&#2547;&nbsp;';
                break;
            case 'BRL':
                $currency_symbol = '&#82;&#36;';
                break;
            case 'BGN':
                $currency_symbol = '&#1083;&#1074;.';
                break;
            case 'AUD':
            case 'CAD':
            case 'CLP':
            case 'MXN':
            case 'NZD':
            case 'HKD':
            case 'SGD':
            case 'COP':
            case 'USD':
                $currency_symbol = '&#36;';
                break;
            case 'EUR':
                $currency_symbol = '&euro;';
                break;
            case 'CNY':
            case 'RMB':
            case 'JPY':
                $currency_symbol = '&yen;';
                break;
            case 'RUB':
                $currency_symbol = '&#8381;';
                break;
            case 'KRW':
                $currency_symbol = '&#8361;';
                break;
            case 'TRY':
                $currency_symbol = '&#84;&#76;';
                break;
            case 'NOK':
                $currency_symbol = '&#107;&#114;';
                break;
            case 'ZAR':
                $currency_symbol = '&#82;';
                break;
            case 'CZK':
                $currency_symbol = '&#75;&#269;';
                break;
            case 'MYR':
                $currency_symbol = '&#82;&#77;';
                break;
            case 'DKK':
                $currency_symbol = 'kr.';
                break;
            case 'HUF':
                $currency_symbol = '&#70;&#116;';
                break;
            case 'IDR':
                $currency_symbol = 'Rp';
                break;
            case 'INR':
                $currency_symbol = '&#x20B9;';
                break;
            case 'ISK':
                $currency_symbol = 'Kr.';
                break;
            case 'ILS':
                $currency_symbol = '&#8362;';
                break;
            case 'JMD':
                $currency_symbol = '&#74;&#36;';
                break;
            case 'PHP':
                $currency_symbol = '&#8369;';
                break;
            case 'PLN':
                $currency_symbol = '&#122;&#322;';
                break;
            case 'PKR':
                $currency_symbol = '&#8360;';
                break;
            case 'SEK':
                $currency_symbol = '&#107;&#114;';
                break;
            case 'CHF':
                $currency_symbol = '&#67;&#72;&#70;';
                break;
            case 'TWD':
                $currency_symbol = '&#78;&#84;&#36;';
                break;
            case 'THB':
                $currency_symbol = '&#3647;';
                break;
            case 'GBP':
                $currency_symbol = '&pound;';
                break;
            case 'RON':
                $currency_symbol = 'lei';
                break;
            case 'VND':
                $currency_symbol = '&#8363;';
                break;
            case 'NGN':
                $currency_symbol = '&#8358;';
                break;
            case 'HRK':
                $currency_symbol = 'Kn';
                break;
            default:
                $currency_symbol = '';
                break;
        }
        return $currency_symbol;
    }
}
