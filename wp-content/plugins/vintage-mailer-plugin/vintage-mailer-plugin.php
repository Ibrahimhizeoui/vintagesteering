<?php
/**
 * Plugin Name: Vintage Steering Mailer Hooks
 * Description: Mail hooks
 * Version:     1.0
 * Author:      Provide IT
 */

require_once 'vintage-wp-mail.php';

add_action('init', 'vintage_custom_post_types');
function vintage_custom_post_types()
{
    register_post_type('vintage_mail_tpl',
        array(
            'labels' => array(
                'name' => __('Mail templates'),
                'singular_name' => __('Mail template')
            ),
            'public' => false,
            'show_ui' => true,
            'has_archive' => false,
            'supports' => array("title", "editor")
        )
    );

    add_filter('user_can_richedit', 'disable_wyswyg_for_custom_post_type');
    function disable_wyswyg_for_custom_post_type($default)
    {
        global $post;
        if ($post->post_type === 'vintage_mail_tpl') return false;
        return $default;
    }
}

function vintage_send_mail($user_email, $title, $mail_template, $message, $from_email = 'admin@vintagesteering.se', $from_name = 'Vintagesteering')
{
    $posts = get_posts(array(
        'numberposts' => -1,
        'post_type' => 'vintage_mail_tpl',
        'meta_key' => 'template_for',
        'meta_value' => $mail_template
    ));

    if (count($posts) === 0) {
        $posts = get_posts(array(
            'numberposts' => -1,
            'post_type' => 'vintage_mail_tpl',
            'meta_key' => 'template_for',
            'meta_value' => 'Default'
        ));
    }

    $tpl["text/html"] = $posts[0]->post_content;
    $tpl["text/plain"] = get_field("text_version", $posts[0]->ID) || " ";

    foreach ($message as $key => $value) {
        $tpl["text/html"] = str_replace($key, $value, $tpl["text/html"]);
        $tpl["text/plain"] = str_replace($key, $value, $tpl["text/plain"]);
    }

    global $from_email2;
    $from_email2 = $from_email;

    add_filter('wp_mail_from', $from_func = function ($from_email) {
        global $from_email2;
        return $from_email2;
    });

    global $from_name2;
        $from_name2 = $from_name;
    add_filter('wp_mail_from_name', $from_name_func = function ($from_name) {
        global $from_name2;
        return $from_name2;
    });

    //add_filter( 'wp_mail_content_type','vintage_set_html_mail_content_type' );
    wp_mail($user_email, $title, $tpl);
    //remove_filter( 'wp_mail_content_type','vintage_set_html_mail_content_type' );
    remove_filter('wp_mail_from', $from_func);
    remove_filter('wp_mail_from_name', $from_name_func);

}

add_action('transition_post_status', 'vintage_post_status_changed', 3, 3);

function vintage_post_status_changed($new, $old, $post)
{
    if ($post->post_type === 'cars') {
        if ($new === 'publish') {
            $user = get_userdata($post->post_author);
            $user_email = $user->data->user_email;

            $permalink = get_permalink($post);

            vintage_send_mail($user_email, 'New listing - ' . $post->post_title, 'Publish User', ["%link%" => $permalink]);
        }
    }
}

add_action('gform_entry_created', 'vintage_gravity_form_submitted', 10, 2);

function vintage_gravity_form_submitted($entry, $form)
{
    switch ($form['title']) {
        case "Enquiry Form":

            $postid = url_to_postid($entry['source_url']);
            $post = get_post($postid);
            $user = get_userdata($post->post_author);
            $user_email = $user->data->user_email;


            $body = 'Meddelande från ' . $entry[3] . ', ' . $entry[2] . '<br><br>' . $entry[1];

            vintage_send_mail($user_email, 'Message regarding ' . $post->post_title, 'Contact Seller', ["%content%" => $body], $entry[2], $entry[3]);

            exit(0);
            break;
        default:
            // Continue
    }
}

add_filter('retrieve_password_message', 'vintage_reset_message', 10, 3);
function vintage_reset_message($message, $reset_key, $user)
{

    $message = vintage_generate_mail("Reset Password", ["%content%" => "You have asked to reset your password. Please use the following verification code to create a new password: <a href='". network_site_url("wp-login.php?action=rp&key=$reset_key&login=" . rawurlencode($user), 'login') ."'>" . network_site_url("wp-login.php?action=rp&key=$reset_key&login=" . rawurlencode($user), 'login') . "</a><br /> Please don’t hesitate to contact us should you encounter any problems. <br /><br />The Vintage Steering Team"]);

   // wp_die();
    return $message;
}

add_filter('wp_mail_from', $from_func = function ($from_email) {
    return 'info@vintagesteering.com';
});
add_filter('wp_mail_from_name', $from_name_func = function ($from_name) {
    return 'Vintagesteering';
});