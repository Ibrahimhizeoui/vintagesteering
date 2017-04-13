<?php

/**
 * Disables all wordpress update notifications unless you can update wordpress core
 */
function adp_wp_remove_update_notifications(){
    global $wp_version;

    if(!current_user_can('update_core')) return;

    return(object) array(
        'last_checked'=> time(),
        'version_checked'=> $wp_version
    );
}
add_filter('pre_site_transient_update_core','adp_wp_remove_update_notifications');
add_filter('pre_site_transient_update_plugins','adp_wp_remove_update_notifications');
add_filter('pre_site_transient_update_themes','adp_wp_remove_update_notifications');
