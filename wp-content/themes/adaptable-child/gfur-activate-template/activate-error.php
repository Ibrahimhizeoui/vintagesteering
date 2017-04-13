<?php

global $gw_activate_template;

$result = $gw_activate_template->result;

// if the blog is already active or if the blog is taken, display respective messages
if ( $gw_activate_template->is_blog_already_active( $result ) || $gw_activate_template->is_blog_taken( $result ) ):
    $signup = $result->get_error_data();
    ?>

    <h2><?php _e('Your account is now active!'); ?></h2>

    <p class="lead-in">
        <?php
        if ( $signup->domain . $signup->path == '' ) {
            header('location: index.php'); //redirect user to homepage after he/she has activated the account and loged in
            
            //printf( __( 'Your account has been activated. You may now <a href="%1$s" data-toggle="modal" data-target="#PaymentModal">log in</a> to the site using your chosen username of &#8220;%2$s&#8221;. <br/><br/> If you\'re haveing trouble logging in then please try resetting your password via the login button at the top of the site.'), 'http://' . $signup->domain, $signup->user_login );
        } else {
            printf( __( 'Your site at <a href="%1$s">%2$s</a> is active. You may now log in to your site using your chosen username of &#8220;%3$s&#8221;. Please check your email inbox at %4$s for your password and login instructions. If you do not receive an email, please check your junk or spam folder. If you still do not receive an email within an hour, you can <a href="%5$s">reset your password</a>.'), 'http://' . $signup->domain, $signup->domain, $signup->user_login, $signup->user_email, wp_lostpassword_url());
        }
        ?>
    </p>

<?php else: ?>

    <h2><?php _e('An error occurred during the activation'); ?></h2>
    <p><?php echo $result->get_error_message(); ?></p>

<?php endif; ?>
