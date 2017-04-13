<?php

if ( !function_exists( 'imic_remove_session_saved' ) )
{
    function imic_remove_session_saved( )
    {
        $session = $_POST[ 'sessions' ];
        if ( $session == "one" )
        {
            unset( $_SESSION[ 'saved_vehicle_id1' ] );
        }
        elseif ( $session == "two" )
        {
            unset( $_SESSION[ 'saved_vehicle_id2' ] );
        }
        elseif ( $session == "three" )
        {
            unset( $_SESSION[ 'saved_vehicle_id3' ] );
        }
        elseif ( $session == "four" )
        {
            unset( $_SESSION[ 'search_page1' ] );
        }
        elseif ( $session == "five" )
        {
            unset( $_SESSION[ 'search_page2' ] );
        }
        elseif ( $session == "six" )
        {
            unset( $_SESSION[ 'search_page3' ] );
        }
        elseif ( $session == "seven" )
        {
            unset( $_SESSION[ 'viewed_vehicle_id1' ] );
        }
        elseif ( $session == "eight" )
        {
            unset( $_SESSION[ 'viewed_vehicle_id2' ] );
        }
        elseif ( $session == "nine" )
        {
            unset( $_SESSION[ 'viewed_vehicle_id3' ] );
        }
        die( );
    }
    add_action( 'wp_ajax_nopriv_imic_remove_session_saved', 'imic_remove_session_saved' );
    add_action( 'wp_ajax_imic_remove_session_saved', 'imic_remove_session_saved' );
}
