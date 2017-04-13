<?php

function imic_enqueue_scripts() {
	global $imic_options;

	$theme_info = wp_get_theme();
	$sticky_menu = (isset($imic_options['enable-header-stick']))?$imic_options['enable-header-stick']:'';
	$basic = __('Basic Search','adaptable-child');
	$advanced = __('Advanced Search','adaptable-child');
	$mortgage_message = __('Please fill all fields', 'adaptable-child');
	$enquiry_email_msg = __('Please enter Email', 'adaptable-child');
	$enquiry_form_sending = __('Sending Information...', 'adaptable-child');
	$enquiry_form_success = __('Message has been sent to your friend', 'adaptable-child');
	$exceed_msg = __('You can not select more than 3 listings to compare', 'adaptable-child');
	$compares = __('Compare ', 'adaptable-child');
	$already_saved = __('You have already saved this search', 'adaptable-child');
	$success_saved = __('Successfully Saved', 'adaptable-child');
	$distance_measure = (isset($imic_options['distance_calculate']))?$imic_options['distance_calculate']:'miles';

	//**register script**//
	wp_register_script('imic_jquery_modernizr', IMIC_THEME_PATH . '/js/modernizr.js', array(), $theme_info->get( 'Version' ), true);
	wp_register_script('imic_jquery_prettyphoto', IMIC_THEME_PATH . '/vendor/prettyphoto/js/prettyphoto.js', array(), $theme_info->get( 'Version' ), true);
	wp_register_script('imic_jquery_magnific', IMIC_THEME_PATH . '/vendor/magnific/jquery.magnific-popup.min.js', array(), $theme_info->get( 'Version' ), true);
	wp_register_script('imic_jquery_ui_plugins', IMIC_THEME_PATH . '/js/ui-plugins.js', array(), $theme_info->get( 'Version' ), true);
	wp_register_script('imic_jquery_helper_plugins', IMIC_THEME_PATH . '/js/helper-plugins.js', array(), $theme_info->get( 'Version' ), true);
	wp_register_script('imic_owl_carousel_min', IMIC_THEME_PATH . '/vendor/owl-carousel/js/owl.carousel.min.js', array(), $theme_info->get( 'Version' ), true);
	wp_register_script('imic_password_checker', IMIC_THEME_PATH . '/vendor/password-checker.js', array(), $theme_info->get( 'Version' ), true);
	wp_register_script('imic_jquery_bootstrap', IMIC_THEME_PATH . '/js/bootstrap.js', array(), $theme_info->get( 'Version' ), true);
	wp_register_script('imic_jquery_init', IMIC_THEME_CHILD_PATH . '/js/init.js', array('imic_jquery_flexslider'), $theme_info->get( 'Version' ), true);
	wp_register_script('imic_google_map','//maps.google.com/maps/api/js?key=AIzaSyCXHrgJuWHL2CJG-iupEd-zHTN-KBZJRF4',array(),$theme_info->get( 'Version' ),true);
	wp_register_script('imic_gmap',IMIC_THEME_PATH . '/js/googleMap.js',array(),$theme_info->get( 'Version' ),true);
	wp_register_script('imic_jquery_flexslider', IMIC_THEME_PATH . '/vendor/flexslider/js/jquery.flexslider.js', array(), $theme_info->get( 'Version' ), true);
	wp_register_script('imic_nivo_slider', IMIC_THEME_PATH . '/vendor/nivoslider/jquery.nivo.slider.js', array(), $theme_info->get( 'Version' ), true);
	wp_register_script('imic_search_filter', IMIC_THEME_PATH . '/js/search-filter.js', array(), $theme_info->get( 'Version' ), true);
	wp_register_script('imic_add_listing', IMIC_THEME_CHILD_PATH . '/js/add-listing.js', array(), $theme_info->get( 'Version' ), true);
	wp_register_script('imic_vehicle_add', IMIC_THEME_PATH . '/js/vehicle-add.js', array(), $theme_info->get( 'Version' ), true);
	wp_register_script('imic_contact_map', IMIC_THEME_PATH . '/js/contact-map.js', array(), $theme_info->get( 'Version' ), true);
	wp_register_script('imic_agent_register', IMIC_THEME_PATH . '/js/agent-register.js', array(), $theme_info->get( 'Version' ), true);
	wp_register_script('imic_search_location', IMIC_THEME_PATH . '/js/search_location.js', array(), $theme_info->get( 'Version' ), true);
	wp_register_script('imic_enquiry_email', IMIC_THEME_PATH . '/js/enquiry_email.js', array(), $theme_info->get( 'Version' ), true);
	wp_register_script('imic_bootstrap_slider', IMIC_THEME_PATH . '/js/bootstrap-slider.js', array(), $theme_info->get( 'Version' ), true);
	wp_register_script('imic_common_scripts', IMIC_THEME_PATH . '/js/common_scripts.js', array(), $theme_info->get( 'Version' ), true);
	//**End register script**//
	//
	//**Enqueue script**//
	wp_enqueue_script('imic_jquery_modernizr');
	wp_enqueue_script('jquery');
	wp_enqueue_script('imic_bootstrap_slider');

	if(isset($imic_options['switch_lightbox']) && $imic_options['switch_lightbox'] == 0){
		wp_enqueue_script('imic_jquery_prettyphoto');
	}elseif(isset($imic_options['switch_lightbox']) && $imic_options['switch_lightbox'] == 1){
		wp_enqueue_script('imic_jquery_magnific');
	}

	wp_enqueue_script('imic_jquery_ui_plugins');
	wp_enqueue_script('imic_jquery_helper_plugins');
	wp_enqueue_script('imic_jquery_bootstrap');
	wp_enqueue_script('imic_password_checker');
	wp_enqueue_script('imic_jquery_init');
	wp_enqueue_script('imic_owl_carousel_min');
	wp_enqueue_script('imic_google_map');
	wp_enqueue_script('imic_search_location');
	wp_localize_script('imic_search_location','searches',array('ajaxurl'=>admin_url('admin-ajax.php'),'measure'=>$distance_measure));
	wp_localize_script('imic_search_filter','values',array('ajaxurl'=>admin_url('admin-ajax.php'),'tmpurl'=>get_template_directory_uri()));
	wp_enqueue_script('imic_common_scripts');
	wp_localize_script('imic_common_scripts','common',array('ajaxurl'=>admin_url('admin-ajax.php')));
	wp_enqueue_script('imic_vehicle_add');
	wp_localize_script('imic_vehicle_add','dashboard',array('ajaxurl'=>admin_url('admin-ajax.php'), 'exceed'=>$exceed_msg, 'compmsg'=>$compares, 'asaved'=>$already_saved, 'ssaved'=>$success_saved));
	wp_localize_script('imic_jquery_init','values',array('ajaxurl'=>admin_url('admin-ajax.php'),'tmpurl'=>get_template_directory_uri(),'basic'=>$basic,'advanced'=>$advanced));
	wp_localize_script('imic_jquery_init','overform',array('basic'=>$basic,'advanced'=>$advanced, 'mortgage'=>$mortgage_message));
	wp_enqueue_script('imic_enquiry_email');
	wp_localize_script('imic_enquiry_email','values_enquiry',array('ajaxurl'=>admin_url('admin-ajax.php'),'tmpurl'=>get_template_directory_uri(), 'msg'=>$enquiry_email_msg, 'sending'=>$enquiry_form_sending , 'success'=>$enquiry_form_success));

	if (is_singular() && comments_open() && get_option('thread_comments')) {
		wp_enqueue_script('comment-reply');
	}
	//**End Enqueue script**//
}
add_action('wp_enqueue_scripts', 'imic_enqueue_scripts');

?>
