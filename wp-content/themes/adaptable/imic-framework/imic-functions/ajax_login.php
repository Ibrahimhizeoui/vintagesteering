<?php

if ( !function_exists( 'ajax_login' ) )
{
    function ajax_login( )
    {
        check_ajax_referer( 'ajax-login-nonce', 'security' );
        $info = array( );
        if ( filter_var( $_POST[ 'username' ], FILTER_VALIDATE_EMAIL ) )
        {
            $user_withemail = get_user_by( 'email', $_POST[ 'username' ] );
            if ( !is_wp_error( $user_withemail ) )
            {
                $info[ 'user_login' ] = $user_withemail->user_login;
            }
            else
            {
                $info[ 'user_login' ] = 'abcd1234!@#$abcd';
            }
        }
        else
        {
            $info[ 'user_login' ] = $_POST[ 'username' ];
        }
        $info[ 'user_password' ] = $_POST[ 'password' ];
        if ( $_POST[ 'rememberme' ] == 'true' )
        {
            $info[ 'remember' ] = true;
        }
        else
        {
            $info[ 'remember' ] = false;
        }
        $user_signon = wp_signon( $info, false );
        if ( is_wp_error( $user_signon ) )
        {
            echo json_encode( array(
                 'loggedin' => false,
                'message' => __( 'Wrong username or password.', 'framework' )
            ) );
        }
        else
        {
            echo json_encode( array(
                 'loggedin' => true,
                'message' => __( 'Login successful, redirecting...', 'framework' )
            ) );
        }
        die( );
    }
}
