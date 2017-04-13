<?php

if ( !function_exists( 'imic_calcPay' ) )
{
    function imic_calcPay( $MORTGAGE, $AMORTYEARS, $AMORTMONTHS, $INRATE, $COMPOUND, $FREQ, $DOWN )
    {
        $MORTGAGE = $MORTGAGE - $DOWN;
        $compound = $COMPOUND / 12;
        $monTime  = ( $AMORTYEARS * 12 ) + ( 1 * $AMORTMONTHS );
        $RATE     = ( $INRATE * 1.0 ) / 100;
        $yrRate   = $RATE / $COMPOUND;
        $rdefine  = pow( ( 1.0 + $yrRate ), $compound ) - 1.0;
        $PAYMENT  = ( $MORTGAGE * $rdefine * ( pow( ( 1.0 + $rdefine ), $monTime ) ) ) / ( ( pow( ( 1.0 + $rdefine ), $monTime ) ) - 1.0 );
        if ( $FREQ == 12 )
        {
            return $PAYMENT;
        }
        if ( $FREQ == 26 )
        {
            return $PAYMENT / 2.0;
        }
        if ( $FREQ == 52 )
        {
            return $PAYMENT / 4.0;
        }
        if ( $FREQ == 24 )
        {
            $compound2 = $COMPOUND / $FREQ;
            $monTime2  = ( $AMORTYEARS * $FREQ ) + ( $AMORTMONTHS * 2 );
            $rdefine2  = pow( ( 1.0 + $yrRate ), $compound2 ) - 1.0;
            $PAYMENT2  = ( $MORTGAGE * $rdefine2 * ( pow( ( 1.0 + $rdefine2 ), $monTime2 ) ) ) / ( ( pow( ( 1.0 + $rdefine2 ), $monTime2 ) ) - 1.0 );
            return $PAYMENT2;
        }
    }
}
