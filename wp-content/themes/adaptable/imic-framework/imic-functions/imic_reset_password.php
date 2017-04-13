<?php

if ( !function_exists( 'imic_reset_password' ) )
{
    function imic_reset_password( )
    {
        $user_email             = ( isset( $_POST[ 'reset_email' ] ) ) ? $_POST[ 'reset_email' ] : '';
        $user_verification_code = ( isset( $_POST[ 'verification_code' ] ) ) ? $_POST[ 'verification_code' ] : '';
        $reset_pass1            = ( isset( $_POST[ 'reset_pass1' ] ) ) ? $_POST[ 'reset_pass1' ] : '';
        $reset_pass2            = ( isset( $_POST[ 'reset_pass2' ] ) ) ? $_POST[ 'reset_pass2' ] : '';
        if ( $user_verification_code == '' )
        {
            if ( $user_email != '' )
            {
                if ( email_exists( $user_email ) )
                {
                    $user    = get_user_by( 'email', $user_email );
                    $user_id = $user->ID;
                    update_user_meta( $user_id, 'imic_reset_password_key', $user_id + date( 'U' ) );
                    $user_verification_get = get_user_meta( $user_id, 'imic_reset_password_key', true );
                    $to                    = $user_email;
                    $subject               = esc_attr__( 'Verification Code to reset password', 'framework' );
                    $body                  = esc_attr__( 'Please use this verification code to reset password', 'framework' );
                    $body .= esc_attr__( 'Verification Code', 'framework' ) . ' ' . $user_verification_get;
                    wp_mail( $to, $subject, $body );
                    echo json_encode( array(
                         'valid' => true,
                        'message' => __( 'Please insert verification code, which you recieved in above email.', 'framework' )
                    ) );
                }
                else
                {
                    echo json_encode( array(
                         'valid' => false,
                        'message' => __( 'Email is not registered with us.', 'framework' )
                    ) );
                }
            }
            else
            {
                //echo json_encode(array('valid'=>false, 'message'=>__('Please enter registered email address.','framework')));
            }
        }
        elseif ( $user_verification_code != '' && $reset_pass1 == '' )
        {
            if ( $user_email != '' )
            {
                if ( email_exists( $user_email ) )
                {
                    $user                  = get_user_by( 'email', $user_email );
                    $user_id               = $user->ID;
                    $user_verification_get = get_user_meta( $user_id, 'imic_reset_password_key', true );
                    if ( $user_verification_code == $user_verification_get )
                    {
                        echo json_encode( array(
                             'authenticate' => true,
                            'message' => __( 'Generate New Password.', 'framework' )
                        ) );
                    }
                    else
                    {
                        echo json_encode( array(
                             'authenticate' => false,
                            'message' => __( 'Verification code does not match.', 'framework' )
                        ) );
                    }
                }
                else
                {
                    echo json_encode( array(
                         'valid' => false,
                        'message' => __( 'Email is not registered with us.', 'framework' )
                    ) );
                }
            }
        }
        else
        {
            $user_id_pass = '';
            if ( email_exists( $user_email ) )
            {
                $user         = get_user_by( 'email', $user_email );
                $user_id_pass = $user->ID;
            }
            if ( ( $reset_pass1 != '' && $reset_pass2 != '' ) && ( $reset_pass1 == $reset_pass2 ) && ( $user_id_pass != '' ) )
            {
                wp_set_password( $reset_pass2, $user_id_pass );
                echo json_encode( array(
                     'passauth' => true,
                    'message' => __( 'New Password Created, please login.', 'framework' )
                ) );
            }
            else
            {
                echo json_encode( array(
                     'passauth' => false,
                    'message' => __( 'Password doesn not match.', 'framework' )
                ) );
            }
        }
        die( );
    }
}
