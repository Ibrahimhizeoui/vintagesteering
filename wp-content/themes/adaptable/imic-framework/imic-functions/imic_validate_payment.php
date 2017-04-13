<?php

if ( !function_exists( 'imic_validate_payment' ) )
{
    function imic_validate_payment( $tx )
    {
        global $imic_options;

        // Init cURL
        $request = curl_init();

        $paypal_payment = $imic_options['paypal_site'];
        $paypal_payment = ($paypal_payment == "1") ? "https://www.paypal.com/cgi-bin/webscr" : "https://www.sandbox.paypal.com/cgi-bin/webscr";

        // Set request options
        curl_setopt_array($request, array(
            CURLOPT_URL => $paypal_payment,
            CURLOPT_POST => TRUE,
            CURLOPT_POSTFIELDS => http_build_query(array(
                'cmd' => '_notify-synch',
                'tx' => $tx,
                'at' => $imic_options[ 'paypal_token' ]
            )),
            CURLOPT_RETURNTRANSFER => TRUE,
            CURLOPT_HEADER => FALSE
            // CURLOPT_SSL_VERIFYPEER => TRUE,
            // CURLOPT_CAINFO => 'cacert.pem',
        ));

        // Execute request and get response and status code
        $response = curl_exec( $request );
        $status   = curl_getinfo( $request, CURLINFO_HTTP_CODE );

        // Close connection
        curl_close( $request );

        // Remove SUCCESS part (7 characters long)
        $response = substr( $response, 7 );

        // URL decode
        $response = urldecode( $response );

        // Turn into associative array
        preg_match_all( '/^([^=\s]++)=(.*+)/m', $response, $m, PREG_PATTERN_ORDER );
        $response = array_combine( $m[ 1 ], $m[ 2 ] );

        // Fix character encoding if different from UTF-8 (in my case)
        if ( isset( $response[ 'charset' ] ) AND strtoupper( $response[ 'charset' ] ) !== 'UTF-8' )
        {
            foreach ( $response as $key => &$value )
            {
                $value = mb_convert_encoding( $value, 'UTF-8', $response[ 'charset' ] );
            }
            $response[ 'charset_original' ] = $response[ 'charset' ];
            $response[ 'charset' ]          = 'UTF-8';
        }
        // Sort on keys for readability (handy when debugging)
        ksort( $response );
        return $response;
    }
}
