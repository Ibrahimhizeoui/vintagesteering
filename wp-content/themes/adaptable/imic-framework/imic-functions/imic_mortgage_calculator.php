<?php

if ( !function_exists( 'imic_mortgage_calculator' ) )
{
    function imic_mortgage_calculator( )
    {
        //echo "sai";
        $currency      = $_POST[ 'currency' ];
        $principal     = $_POST[ 'loan_amount' ]; //Mortgage Amount
        $interest_rate = $_POST[ 'interest' ]; //Interest Rate %
        $down          = $_POST[ 'down_payment' ]; //10% down payment
        $years         = 0;
        $months        = $_POST[ 'months' ];
        $compound      = 2; //compound is always set to 2
        $frequency     = 12; //Number of months (Monthly (12), Semi-Monthly (24), Bi-Weekly(26) and Weekly(52)
        echo '<span class="meta-data">' . __( 'This is the payment you need to make per month', 'framework' ) . '</span>';
        echo '<span class="loan-amount">' . $currency . floor( imic_calcPay( $principal, $years, $months, $interest_rate, $compound, $frequency, $down ) ) . '<small>/' . __( 'month', 'framework' ) . '</small><span>';
        die( );
    }
    add_action( 'wp_ajax_nopriv_imic_mortgage_calculator', 'imic_mortgage_calculator' );
    add_action( 'wp_ajax_imic_mortgage_calculator', 'imic_mortgage_calculator' );
}
