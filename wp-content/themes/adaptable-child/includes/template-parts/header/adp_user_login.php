<?php

global $imic_options, $current_user;

if(!is_user_logged_in()): ?>

    <?php wp_enqueue_script('imic_agent_register'); ?>
    <?php wp_localize_script('imic_agent_register', 'agent_register', array('ajaxurl' => admin_url('admin-ajax.php'))); ?>

    <div class="userLogin">
        <a href="#" class="userLogin__icon fa fa-user" data-toggle="modal" data-target="#PaymentModal">
            <span><?php echo esc_attr_e('Login/Signup','adaptable-child'); ?></span>
        </a>
    </div>

<?php else:

    $default_image = (isset($imic_options['default_dealer_image'])) ? $imic_options['default_dealer_image'] : array('url'=>'');
    $user_id = get_current_user_id( );
    $user_info_id = get_user_meta($user_id,'imic_user_info_id',true);
    $userFirstName = $current_user->user_firstname;
    $userLastName = $current_user->user_lastname;
    $userName = get_the_author_meta( 'display_name', $user_id );

    if(!empty($userFirstName) || !empty($userLastName)):
        $userName = $userFirstName .' '. $userLastName;
    endif;

    $dashboard = '/dashboard'; ?>

    <div class="userLogin userLogin--loggedIn">
        <?php if (has_post_thumbnail($user_info_id)): ?>

            <a href="<?php echo esc_url(add_query_arg('profile',1,$dashboard)); ?>" class="userLogin__button userLogin__button--switch" id="userdropdown" data-toggle="dropdown">
                <?php echo get_the_post_thumbnail($user_info_id, '100x100'); ?>
                <i class="fa fa-tachometer" role="hidden"></i>
                <span><?php echo esc_attr_e('Login/Signup','adaptable-child'); ?></span>
            </a>

        <?php else: ?>

            <a href="<?php echo esc_url(add_query_arg('profile',1,$dashboard)); ?>" class="userLogin__icon user-login-icon fa fa-tachometer" data-toggle="dropdown">
                <span><?php echo esc_attr_e('Login/Signup','adaptable-child'); ?></span>
            </a>

        <?php endif; ?>

        <ul class="userLogin__dropdown dropdown-menu" role="menu" aria-labelledby="userdropdown">
            <li><a href="<?php echo esc_url($dashboard); ?>"><?php echo esc_attr_e('Dashboard','adaptable-child'); ?></a></li>
            <li><a href="<?php echo esc_url(add_query_arg('search',1,$dashboard)); ?>"><?php echo esc_attr_e('Saved Searches','adaptable-child'); ?></a></li>
            <li><a href="<?php echo esc_url(add_query_arg('saved',1,$dashboard)); ?>"><?php echo esc_attr_e('Saved Listings','adaptable-child'); ?></a></li>
            <li><a href="<?php echo esc_url(add_query_arg('manage',1,$dashboard)); ?>"><?php echo esc_attr_e('Manage Ads','adaptable-child'); ?></a></li>
            <li><a href="<?php echo esc_url(add_query_arg('profile',1,$dashboard)); ?>"><?php echo esc_attr_e('My Profile','adaptable-child'); ?></a></li>
            <li><a href="<?php echo wp_logout_url(home_url()); ?>"><?php echo esc_attr_e('Log Out','adaptable-child'); ?></a></li>
        </ul>

    </div>

<?php endif; ?>

<div class="button-wrap">
    <a class="fa button button--sell" href="/add-new-listing">Sell</a>
    <a class="fa button button--alternate button--search" href="/search" data-search-dd>Search</a>
</div>
