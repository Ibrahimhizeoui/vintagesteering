<?php
//function mailtrap($phpmailer) {
//    $phpmailer->isSMTP();
//    $phpmailer->Host = 'mailtrap.io';
//    $phpmailer->SMTPAuth = true;
//    $phpmailer->Port = 2525;
//    $phpmailer->Username = '36212dfd60f7ae';
//    $phpmailer->Password = '24158c1a158547';
//}
//
//add_action('phpmailer_init', 'mailtrap');

/* ADD CHILD PATH */
define('IMIC_THEME_CHILD_PATH', get_stylesheet_directory_uri());

if (!function_exists('_log'))
{
    function _log($message)
    {
        if (WP_DEBUG === true)
        {
            if (is_array($message) || is_object($message))
            {
                error_log(print_r($message, true));
            }
            else
            {
                error_log($message);
            }
        }
    }
}

// Wordpress filters/actions/functions
include(locate_template('includes/wordpress/adp-wp_user_roles.php'));
include(locate_template('includes/wordpress/adp-wp_deregister_widgets.php'));
include(locate_template('includes/wordpress/adp-wp_disable_notifications.php'));
include(locate_template('includes/wordpress/adp-wp_disable_comments.php'));
include(locate_template('includes/wordpress/adp-wp_hide_admin_links.php'));
include(locate_template('includes/wordpress/adp-wp_asset_handler.php'));
include(locate_template('includes/wordpress/adp-wp_page_excerpts.php'));
include(locate_template('includes/wordpress/adp-wp_gravity_forms.php'));
include(locate_template('includes/wordpress/adp-wp_redirect_non_admins.php'));

// PolyLang
//include(locate_template('includes/polylang/adp-pll_hooks.php'));

// Redux
//include('includes/redux/adp-redux_include_library.php');
include(locate_template('includes/redux/adp-redux_overrides.php'));

// Advanced Custom Fields
include(locate_template('includes/acf/adp-acf_options_pages.php'));
include(locate_template('includes/acf/adp-acf_get_specific_image_data.php'));
include(locate_template('includes/acf/gravity-forms-acf/acf-gravity_forms.php'));

// Gravity Forms
include(locate_template('includes/gravity-forms/adp-gf_description_wrapper.php'));
include(locate_template('includes/gravity-forms/adp-gf_global_filters.php'));
include(locate_template('includes/gravity-forms/adp-gf_handle_user_signup.php'));

// Custom theme overrides/adjustments
include(locate_template('includes/overrides/adp-widgets_sidebars.php'));

// Currencies class
function myloader()
{
    ob_start();

    include(locate_template('includes/currency/classes/Currency.php'));
    include(locate_template('includes/currency/classes/Cookie.php'));
}
add_action('init', 'myloader');




// Remove post type support for the editor if a user is of role type editor.
function adp_remove_editor()
{
    remove_post_type_support( 'page', 'editor' );
}
add_action('init', 'adp_remove_editor');



// show or hide the admin bar
if (is_user_logged_in() && !is_admin())
{
    add_filter('show_admin_bar', '__return_false');
}



add_action('after_setup_theme', 'adp_i10n_text_domain_register');
function adp_i10n_text_domain_register()
{
    return load_theme_textdomain('adaptable-child', get_stylesheet_directory() . '/languages');
}



/**
 * {uSort} by alphanumeric (a-z/0-9) and also remove special characters while doing so
 * @param  int $a mixed
 * @param  int $b mixed
 * @return boolean
 */
function alphaNumericCmp($a, $b)
{
    $a = preg_replace('/[^a-zA-Z0-9\']/', '', $a);
    $b = preg_replace('/[^a-zA-Z0-9\']/', '', $b);

    if(is_numeric($a) && !is_numeric($b))
        return 1;
    else if(!is_numeric($a) && is_numeric($b))
        return -1;
    else
        return ($a < $b) ? -1 : 1;
}



/**
* Gravity Forms Custom Activation Template
* http://gravitywiz.com/customizing-gravity-forms-user-registration-activation-page
*/
function custom_maybe_activate_user()
{
    $template_path = STYLESHEETPATH . '/gfur-activate-template/activate.php';
    $is_activate_page = isset($_GET['page']) && $_GET['page'] == 'gf_activation';

    if(!file_exists($template_path) || !$is_activate_page)
        return;

    require_once($template_path);

    exit();
}
add_action('wp', 'custom_maybe_activate_user', 9);


/* Overrides */
include(locate_template('imic-framework/imic-framework.php'));
include(locate_template('imic-framework/imic-functions/imic_update_user_info.php'));
include(locate_template('imic-framework/imic-functions/imic_create_vehicle.php'));
include(locate_template('imic-framework/imic-functions/imic_search_result.php'));
include(locate_template('imic-framework/imic-functions/imic_sortable_specification.php'));



function getYoutubeIdFromUrl($url) {

    // Youtube
    $pattern = '#^(?:https?://)?';    # Optional URL scheme. Either http or https.
    $pattern .= '(?:www\.)?';         #  Optional www subdomain.
    $pattern .= '(?:';                #  Group host alternatives:
    $pattern .=   'youtu\.be/';       #    Either youtu.be,
    $pattern .=   '|youtube\.com';    #    or youtube.com
    $pattern .=   '(?:';              #    Group path alternatives:
    $pattern .=     '/embed/';        #      Either /embed/,
    $pattern .=     '|/v/';           #      or /v/,
    $pattern .=     '|/watch\?v=';    #      or /watch?v=,
    $pattern .=     '|/watch\?.+&v='; #      or /watch?other_param&v=
    $pattern .=   ')';                #    End path alternatives.
    $pattern .= ')';                  #  End host alternatives.
    $pattern .= '([\w-]{11})';        # 11 characters (Length of Youtube video ids).
    $pattern .= '(?:.+)?$#x';         # Optional other ending URL parameters.
    preg_match($pattern, $url, $matches);

    $videoId = (isset($matches[1])) ? $matches[1] : FALSE;

    return $videoId;
}

function isYoutubeLink($url) {
    if (strpos($url, 'youtube') > 0) {
        return true;
    }

    return false;
}


//add_action( 'user_register', 'vintagesteering_registration_save', 10, 1 );
function vintagesteering_registration_save( $user_id ) {

    if ( isset( $_POST['input_1'] ) )
	{
		if(role_exists($_POST['input_1']) && strpos(strtolower($_POST['input_1']),'admin') == false && strpos(strtolower($_POST['input_1']),'editor') == false) 
		{
			$user = new WP_User( $user_id );
			// Remove role
			$user->remove_role( 'subscriber' );
			// Add role
			$user->add_role( strtolower($_POST['input_1']) );
			
		}
	}
}
