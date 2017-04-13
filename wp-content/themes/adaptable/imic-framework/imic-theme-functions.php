<?php
if ( !defined( 'ABSPATH' ) )
    exit; // Exit if accessed directly

/* imic Framework Theme Functions
 * ------------------------------------------------
 * imic_theme_activation()
 * imic_maintenance_mode()
 * imic_custom_login_logo()
 * imic_add_nofollow_cat()
 * imic_admin_bar_menu()
 * imic_analytics()
 * imic_custom_styles()
 * imic_custom_script()
 * imic_content_filter()
 * imic_register_sidebars()
 * imic_custom_taxonomies_terms_links()
 * imic_afterSavePost()
 * IMIC_Custom_Nav()
 * imic_get_all_types()
 * imic_get_cat_list()
 * imic_widget_titles()
 * imic_RevSliderShortCode()
 * imic_cat_count_flag()
 * imic_get_all_sidebars()
 * imic_register_meta_box()
 * imic_wp_get_attachment()
 * imic_gallery_flexslider()
 * imic_social_staff_icon()
 * imic_share_buttons()
 * imic_custom_excerpt_length()
 * imic_count_user_posts_by_type()
 * imic_search_result()
 * imic_matched_results()
 * imic_get_all_integer_specifications()
 * imic_create_vehicle()
 * imic_add_query_vars_filter()
 * imic_session_init()
 * imic_search_array()
 * imic_vehicle_add()
 * imic_save_search()
 * imic_sight()
 * imi_remove_cars()
 * imi_remove_search()
 * imi_remove_ads()
 * imic_sortable_specification()
 * imic_queryToArray()
 * ajax_login_init()
 * ajax_login()
 * imic_get_template_url()
 * imic_get_template_id()
 * imic_remove_property_image()
 * update_property_featured_image()
 * imic_agent_register()
 * imic_search_dealers()
 * imic_count_cars_by_specification()
 * imic_remove_session_saved()
 * imic_calcPay()
 * imic_mortgage_calculator()
 * imic_is_decimal()
 * imic_price_guide()
 * imic_update_user_info()
 * imi_update_status_ads()
 * find_car_with_position()
 * find_car_with_image()
 * imic_validate_payment()
 * imic_add_dealer_role()
 * imic_value_search_multi_array()
 * imic_array_empty()
 * imic_cars_status_columns()
 * imic_cars_status_column_content()
 * imic_agent_fields()
 * imic_get_currency_symbol()
 */


/**
 * The includes are done like this because there was no proper way to
 * and the theme just dumped everything in this one file
 */
foreach(glob(ImicFrameworkPath.'/imic-functions/*.php') as $filename)
{
    include_once($filename);
}

add_filter('widget_text', 'do_shortcode'); ?>
