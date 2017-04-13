<?php

if ( !function_exists( 'imic_contact_site_plans' ) )
{
    function imic_contact_site_plans( )
    {
        $tx      = ( isset( $_POST[ 'transaction' ] ) ) ? $_POST[ 'transaction' ] : '';
        $message = ( isset( $_POST[ 'message' ] ) ) ? $_POST[ 'message' ] : '';
        $plan_id = ( isset( $_POST[ 'plan' ] ) ) ? $_POST[ 'plan' ] : '';
        if ( $tx != '' )
        {
            $paypal_details = imic_validate_payment( $tx );
            if ( !empty( $paypal_details ) )
            {
                $st            = $paypal_details[ 'payment_status' ];
                $payment_gross = $paypal_details[ 'payment_gross' ];
                global $current_user;
                get_currentuserinfo();
                $user_id            = get_current_user_id();
                $current_user       = wp_get_current_user();
                $user_info_id       = get_user_meta( $user_id, 'imic_user_info_id', true );
                $site_manager_email = get_option( 'admin_email' );
                $manager_email      = esc_attr( $site_manager_email );
                $dealer_name        = get_the_title( $user_info_id );
                $e_subject          = __( 'Payment Related Query', 'framework' );
                $e_body             = __( "You have been contacted by $dealer_name ", "framework" ) . PHP_EOL . PHP_EOL;
                $e_content          = '';
                $e_content .= __( "Name: ", "framework" ) . $dealer_name . PHP_EOL . PHP_EOL;
                $e_content .= __( "Email: ", "framework" ) . $current_user->user_email . PHP_EOL . PHP_EOL;
                $e_content .= __( "Plan: ", "framework" ) . get_the_title( $plan_id ) . PHP_EOL . PHP_EOL;
                $e_content .= __( "Transaction ID: ", "framework" ) . $paypal_details[ 'txn_id' ] . PHP_EOL . PHP_EOL;
                $e_content .= __( "Payment Status: ", "framework" ) . $paypal_details[ 'payment_status' ] . PHP_EOL . PHP_EOL;
                $e_content .= __( "Message: ", "framework" ) . $message . PHP_EOL . PHP_EOL;
                $e_reply = __( "You can contact ", "framework" ) . $dealer_name . __( " via email, ", "framework" ) . $current_user->user_email;
                $msg     = wordwrap( $e_body . $e_content . $e_reply, 70 );
                $headers = __( "From: ", "framework" ) . $current_user->user_email . PHP_EOL;
                $headers .= __( "Reply-To: ", "framework" ) . $current_user->user_email . PHP_EOL;
                $headers .= "MIME-Version: 1.0" . PHP_EOL;
                $headers .= "Content-type: text/plain; charset=utf-8" . PHP_EOL;
                $headers .= "Content-Transfer-Encoding: quoted-printable" . PHP_EOL;
                if ( mail( $manager_email, $e_subject, $msg, $headers ) )
                {
                    echo "<div class=\"alert alert-success\">" . __( 'Thank you', 'framework' ) . " <strong>$dealer_name</strong>, " . __( 'your message has been submitted to us.', 'framework' ) . "</div>";
                }
                else
                {
                    echo '<div class="alert alert-error">ERROR!</div>';
                }
            }
        }
        die( );
    }
    add_action( 'wp_ajax_nopriv_imic_contact_site_plans', 'imic_contact_site_plans' );
    add_action( 'wp_ajax_imic_contact_site_plans', 'imic_contact_site_plans' );
}
