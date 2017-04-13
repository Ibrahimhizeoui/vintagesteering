<?php
/*
*  Register ACF options page
*/
if( function_exists('acf_add_options_page') ) {
	acf_add_options_page(array(
		'page_title' 	=> 'Global Options',
		'menu_title'	=> 'Global Options',
		'menu_slug' 	=> 'global-options',
		'capability'	=> 'edit_posts',
		'redirect'		=> true
	));
	acf_add_options_sub_page(array(
		'page_title' 	=> 'Marketing Details',
		'menu_title'	=> 'Marketing Details',
		'parent_slug'	=> 'global-options',
	));
    acf_add_options_sub_page(array(
        'page_title' 	=> 'Default Options',
        'menu_title'	=> 'Default Options',
        'parent_slug'	=> 'global-options',
    ));
    acf_add_options_sub_page(array(
        'page_title' 	=> 'Header Options',
        'menu_title'	=> 'Header Options',
        'parent_slug'	=> 'global-options',
    ));
}
