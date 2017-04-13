<?php

/**
 * adp_redirect_non_admin
 * Redirects users if they login to wp-admin directly
 * @param   string $redirect_to URL to redirect to.
 * @param   string $request URL the user is coming from.
 * @param   object $user Logged user's data.
 * @return  string
 */
function adp_redirect_non_admin_login($redirect_to, $request, $user)
{
    // if the user object contains errors
    if (is_wp_error($user)) {
        // log error and errored object
        _log("WP_errors inside \$user object \$user");

        return $redirect_to;
    }

    // if the user object is empty and the roles index is not an array
    if (!empty($user) && !is_array($user->roles)) {
        return $redirect_to;
    }

    // if not an admin or editor, redirect the user to wp-admin
    if (!in_array('administrator', $user->roles) || !in_array('editor', $user->roles)) {
        return $redirect_to;
    }

    // if all checks pass redirect user to the dashboard, woo
    return site_url() . '/dashboard';
}
add_filter('login_redirect', 'adp_redirect_non_admin_login', 10, 3);


/**
 * adp_redirect_non_admin_redirect description
 * redirects a user to the dashboard page if they try to access wp-admin
 * @return wp_action redirect user to page
 */
function adp_redirect_non_admin_redirect()
{
    if ( ! current_user_can('create_users') && ( ! defined('DOING_AJAX') || ! DOING_AJAX )) {
        wp_redirect(site_url() . '/dashboard');
        exit;
    }
}
add_action( 'admin_init', 'adp_redirect_non_admin_redirect', 1 );
