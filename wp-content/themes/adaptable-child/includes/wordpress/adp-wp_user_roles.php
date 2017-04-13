<?php

/**
 * Remove user roles from wordpress that are not needed
 * @return [action] Remove user role when 'after_setup_theme' action has run
 */
function adp_remove_user_roles()
{
    // Check if roles exist before attempting to remove them;
    remove_role( 'subscriber' );
    remove_role( 'author' );
    remove_role( 'contributor' );    

    return;
}
add_action('init', 'adp_remove_user_roles');
