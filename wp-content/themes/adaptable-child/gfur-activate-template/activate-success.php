<?php

global $gw_activate_template;

extract( $gw_activate_template->result );

$url = is_multisite() ? get_blogaddress_by_id( (int) $blog_id ) : home_url('', 'http');
$user = new WP_User( (int) $user_id );

// <div id="signup-welcome">
//     <p><span class="h3">_e('Username:'); </span> echo $user->user_login;</p>
//     <p><span class="h3">_e('Password:'); </span> echo $password;</p>
// </div> ?>

<h2><?php _e('Your account is now active!'); ?></h2>

<?php if ( $url != network_home_url('', 'http') ) : ?>
    <p class="view"><?php printf( __('Your account is now activated. Go to the <a href="%1$s">homepage</a> or <a href="#" data-toggle="modal" data-target="#PaymentModal">Log in</a>'), $url ); ?></p>
<?php else: ?>
    <p class="view"><?php printf( __('Your account is now activated. <a href="#" data-toggle="modal" data-target="#PaymentModal">Log in</a> or go back to the <a href="%1$s">homepage</a>.' ), network_home_url() ); ?></p>
<?php endif; ?>
