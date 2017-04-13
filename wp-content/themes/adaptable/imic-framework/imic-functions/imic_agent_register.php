<?php

if ( !function_exists( 'imic_agent_register' ) )
{
    function imic_agent_register( )
    {
        if ( !$_POST )
            exit;
        // Email address verification, do not edit.
        function isEmail( $email )
        {
            return ( preg_match( "/^[-_.[:alnum:]]+@((([[:alnum:]]|[[:alnum:]][[:alnum:]-]*[[:alnum:]])\.)+(ad|ae|aero|af|ag|ai|al|am|an|ao|aq|ar|arpa|as|at|au|aw|az|ba|bb|bd|be|bf|bg|bh|bi|biz|bj|bm|bn|bo|br|bs|bt|bv|bw|by|bz|ca|cc|cd|cf|cg|ch|ci|ck|cl|cm|cn|co|com|coop|cr|cs|cu|cv|cx|cy|cz|de|dj|dk|dm|do|dz|ec|edu|ee|eg|eh|er|es|et|eu|fi|fj|fk|fm|fo|fr|ga|gb|gd|ge|gf|gh|gi|gl|gm|gn|gov|gp|gq|gr|gs|gt|gu|gw|gy|hk|hm|hn|hr|ht|hu|id|ie|il|in|info|int|io|iq|ir|is|it|jm|jo|jp|ke|kg|kh|ki|km|kn|kp|kr|kw|ky|kz|la|lb|lc|li|lk|lr|ls|lt|lu|lv|ly|ma|mc|md|me|mg|mh|mil|mk|ml|mm|mn|mo|mp|mq|mr|ms|mt|mu|museum|mv|mw|mx|my|mz|na|name|nc|ne|net|nf|ng|ni|nl|no|np|nr|nt|nu|nz|om|org|pa|pe|pf|pg|ph|pk|pl|pm|pn|pr|pro|ps|pt|pw|py|qa|re|ro|ru|rw|sa|sb|sc|sd|se|sg|sh|si|sj|sk|sl|sm|sn|so|sr|st|su|sv|sy|sz|tc|td|tf|tg|th|tj|tk|tm|tn|to|tp|tr|tt|tv|tw|tz|ua|ug|uk|um|us|uy|uz|va|vc|ve|vg|vi|vn|vu|wf|ws|ye|yt|yu|za|zm|zw)$|(([0-9][0-9]?|[0-1][0-9][0-9]|[2][0-4][0-9]|[2][5][0-5])\.){3}([0-9][0-9]?|[0-1][0-9][0-9]|[2][0-4][0-9]|[2][5][0-5]))$/i", $email ) );
        }


        if ( !defined( "PHP_EOL" ) )
            define( "PHP_EOL", "\r\n" );

        $username         = $_POST[ 'username' ];
        $email            = $_POST[ 'email' ];
        $pwd1             = $_POST[ 'pwd1' ];
        $pwd2             = $_POST[ 'pwd2' ];
        $captcha_question = $_POST[ 'captcha_q' ];
        $captcha_answer   = $_POST[ 'captcha_a' ];
        $captcha_split    = explode( ' ', $captcha_question );
        if ( $captcha_split[ 1 ] == '+' )
        {
            $second_val = imic_convert_string( $captcha_split[ 2 ] );
            $exact_val  = $captcha_split[ 0 ] + $second_val;
        }
        elseif ( $captcha_split[ 1 ] == '-' )
        {
            $second_val = imic_convert_string( $captcha_split[ 2 ] );
            $exact_val  = $captcha_split[ 0 ] - $second_val;
        }
        else
        {
            $second_val = imic_convert_string( $captcha_split[ 2 ] );
            $exact_val  = $captcha_split[ 0 ] * $second_val;
        }

        if ( trim( $username ) == '' )
        {
            echo '<div class="alert alert-error">' . __( 'You must enter your username.', 'framework' ) . '</div>';
            exit( );
        }
        else if ( trim( $email ) == '' )
        {
            echo '<div class="alert alert-error">' . __( 'You must enter email address.', 'framework' ) . '</div>';
            exit( );
        }
        else if ( !isEmail( $email ) )
        {
            echo '<div class="alert alert-error">' . __( 'You must enter a valid email address.', 'framework' ) . '</div>';
            exit( );
        }
        else if ( trim( $pwd1 ) == '' )
        {
            echo '<div class="alert alert-error">' . __( 'You must enter password.', 'framework' ) . '</div>';
            exit( );
        }
        else if ( trim( $pwd2 ) == '' )
        {
            echo '<div class="alert alert-error">' . __( 'You must enter repeat password.', 'framework' ) . '</div>';
            exit( );
        }
        else if ( trim( $pwd1 ) != trim( $pwd2 ) )
        {
            echo '<div class="alert alert-error">' . __( 'You must enter a same password.', 'framework' ) . '</div>';
            exit( );
        }
        elseif ( $exact_val != $captcha_answer )
        {
            echo '<div class="alert alert-error">' . __( 'Captcha do not match.', 'framework' ) . '</div>';
            exit( );
        }


        $err     = '';
        $success = '';

        global $wpdb, $PasswordHash, $current_user, $user_ID, $imic_options;

        if ( isset( $_POST[ 'task' ] ) && $_POST[ 'task' ] == 'register' )
        {
            $username = esc_sql( trim( $_POST[ 'username' ] ) );
            $pwd1     = esc_sql( trim( $_POST[ 'pwd1' ] ) );
            $pwd2     = esc_sql( trim( $_POST[ 'pwd2' ] ) );
            $email    = esc_sql( trim( $_POST[ 'email' ] ) );
            $role     = ( isset( $_POST[ 'roles' ] ) ) ? esc_sql( trim( $_POST[ 'roles' ] ) ) : '';

            //Email properties
            $dealer_msg         = $imic_options[ 'agent_register' ];
            $admin_mail_to      = get_option( 'admin_email' );
            $mail_subject       = $username . " registered successfully.";
            $admin_mail_content = "<p>" . __( "New user registered with following details.", "framework" ) . "</p>";
            $admin_mail_content .= "<p>" . __( "Name: ", "framework" ) . $username . "</p>";
            $admin_mail_content .= "<p>" . __( "Email: ", "framework" ) . $email . "</p>";
            $admin_msg     = wordwrap( $admin_mail_content, 70 );
            $admin_headers = "From: $email" . PHP_EOL;
            $admin_headers .= "Reply-To: $email" . PHP_EOL;
            $admin_headers .= "MIME-Version: 1.0" . PHP_EOL;
            $admin_headers .= "Content-Type: text/html; charset=\"iso-8859-1\"\n";
            $dealer_headers = "From: $admin_mail_to" . PHP_EOL;
            $dealer_headers .= "Reply-To: $admin_mail_to" . PHP_EOL;
            $dealer_headers .= "MIME-Version: 1.0" . PHP_EOL;
            $dealer_headers .= "Content-Type: text/html; charset=\"iso-8859-1\"\n";
            if ( $email == "" || $pwd1 == "" || $pwd2 == "" || $username == "" )
            {
                $err = 'Please don\'t leave the required fields.';
            }
            else if ( $pwd1 <> $pwd2 )
            {
                $err = 'Password do not match.';
            }
            else if ( !filter_var( $email, FILTER_VALIDATE_EMAIL ) )
            {
                $err = 'Invalid email address.';
            }
            else if ( email_exists( $email ) )
            {
                $err = 'Email already exist.';
            }
            else
            {

                $user_id = wp_insert_user( array(
                     'user_pass' => apply_filters( 'pre_user_user_pass', $pwd1 ),
                    'user_login' => apply_filters( 'pre_user_user_login', $username ),
                    'user_email' => apply_filters( 'pre_user_user_email', $email ),
                    'role' => 'dealer'
                ) );
                $my_post = array(
                     'post_title' => $username,
                    'post_type' => 'user',
                    'post_status' => 'publish'
                    //'tax_input'	=> array('user-category'=>array('subsscriber'))
                    //'post_category' => array(8,39)
                );
                // Insert the post into the database
                $post_id = wp_insert_post( $my_post );
                update_user_meta( $user_id, 'imic_user_info_id', $post_id );
                wp_set_object_terms( $post_id, $role, 'user-role' );
                update_post_meta( $post_id, 'imic_user_reg_id', $user_id );

                if ( is_wp_error( $user_id ) )
                {
                    $err = 'Error on user creation.';
                }
                else
                {
                    do_action( 'user_register', $user_id );
                    $success                          = 'You\'re successfully register';
                    $info_register                    = array( );
                    $info_register[ 'user_login' ]    = $username;
                    $info_register[ 'user_password' ] = $pwd1;
                    wp_signon( $info_register, false );
                }
            }
        }

        if ( !empty( $err ) ):
            echo '<div class="alert alert-error">' . $err . '</div>';
        endif;

        if ( !empty( $success ) ):
            mail( $admin_mail_to, $mail_subject, $admin_msg, $admin_headers );
            mail( $email, $mail_subject, $dealer_msg, $dealer_headers );
            echo '<div class="alert alert-success">' . $success . '</div>';
        endif;
        die( );
    }
    add_action( 'wp_ajax_nopriv_imic_agent_register', 'imic_agent_register' );
    add_action( 'wp_ajax_imic_agent_register', 'imic_agent_register' );
}
