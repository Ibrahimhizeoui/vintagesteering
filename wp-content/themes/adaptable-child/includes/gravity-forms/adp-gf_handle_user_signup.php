<?php
function create_new_user_posts($user_id, $feed, $entry, $password)
{
    // Get the user data
    $user = get_userdata($user_id);

    // Set taxterm/username from entry so its understandable
	//var_dump($entry);
	
    $taxTerm = strtolower($entry[1]);
    $username = $user->user_login;

    // Create a user post for the site to tie listings to etc
    $postArray = [
        'post_status' => 'publish',
        'post_type'  => 'user',
        'post_title' => $username
    ];

    // Insert the newly created post into the database
    $postID = wp_insert_post($postArray);

    // Update the post meta for the user
    update_post_meta($postID, 'imic_user_reg_id', $user_id);
    update_post_meta($postID, 'imic_user_company', $username);

    // Sets the user role type for the post
    wp_set_object_terms($postID, $taxTerm, 'user-role', false);
	
	$user2 = new WP_User( $user_id );
	// Remove role
	$user2->remove_role( 'subscriber' );
	// Add role
	$user2->add_role( $taxTerm );

    _log($user_id);
    _log($taxTerm);

    // Set user role to selected in form
    $user_id = wp_update_user([
        'ID' => $user_id,
        'role' => $taxTerm
    ]);

    // Create link to the post created above
    update_user_meta($user_id, 'imic_user_info_id', $postID);

    // Get the user login details
    // $user_login = $user->user_login;
    // $user_password = $password;
    //
    // // Sign the user in
     wp_signon([
         'user_login' => $user_login,
         'user_password' =>  $user_password,
         'remember' => false
     ]);
	 wp_redirect(home_url('/dashboard/?profile=1'));
}
add_action( 'gform_user_registered', 'create_new_user_posts', 10, 4 );


// remove_action("gform_post_submission", array("GFUser", "gf_create_user"));
// add_action("gform_after_submission", array("GFUser", "gf_create_user"), 10, 2);
// add_action("gform_user_registered", "gforms_autologin", 10, 4);
// function gforms_autologin($user_id, $config, $entry, $password) {
//
//     $form = RGFormsModel::get_form_meta($entry['form_id']);
//
//     $user_login = apply_filters("gform_username_{$form['id']}",
//             apply_filters('gform_username', GFUser::get_meta_value('username', $config, $form, $entry), $config, $form, $entry),
//             $config, $form, $entry);
//
//     $redirect_url = rgars($form, 'confirmation/url') ? rgars($form, 'confirmation/url') : home_url() . '/dashboard';
//
//     //pass the above to the wp_signon function
//     $result = wp_signon(array('user_login' => $user_login, 'user_password' =>  $password, 'remember' => false));
//
//     if(!is_wp_error($result))
//         wp_redirect($redirect_url);
// }
