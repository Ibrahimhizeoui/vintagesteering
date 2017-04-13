<?php namespace LukeRoberts;

get_header();
global $imic_options;

//$id = get_option('page_for_posts') ? get_option('page_for_posts') : get_the_ID();
$id = get_the_ID();

get_template_part('bar', 'two');

if (is_plugin_active('imithemes-listing/listing.php')) {
    /**
     * Explanation for some of the varibles declared below
     * it needs explaining (it's not very clear from the theme devs)
     * ======================
     * - $post_author_id    - This is the wordpress USER ID attached to this post via whoever created this custom_post type (cars)
     * - $this_user         - this is ID of the custom 'user' post type which is linked to the user_id grabbed from the above
     * ======================
     */
    $pageSidebar2                = get_post_meta(get_the_ID(),'imic_select_sidebar_from_list', true);
    $list_slugs                  = array();
    $post_author_id              = get_post_field('post_author', $id);
    $this_user                   = get_user_meta($post_author_id, 'imic_user_info_id', true);
    $add                         = get_post_meta($this_user, 'imic_user_zip_code', true);
    $company_name                = get_post_meta($this_user, 'imic_user_company', true);
    $user_thumbid                = get_post_meta($this_user, '_thumbnail_id', true);
    $user_image                  = wp_get_attachment_image_src($user_thumbid, 'thumb', false, array());
    $highlighted_specs           = (isset($imic_options[ 'highlighted_specs' ])) ? $imic_options[ 'highlighted_specs' ] : '';
    $new_highlighted_specs       = imic_filter_lang_specs_admin($highlighted_specs, $id);
    $highlighted_specs           = $new_highlighted_specs;
    $unique_specs                = $imic_options[ 'unique_specs' ];
    $specifications              = get_post_meta($id, 'feat_data', true);

    // Instantiate our Currency Class
    $currencies = new Currency();

    // Get the current in use currency.
    $currentCurrency = $currencies->getCurrentCurrency();

    // Get the vehicle price as JUST a numerical value
    $vehicle_numeric_price = preg_replace("/[^0-9]/", "", imic_vehicle_price($id, $unique_specs, $specifications));

    // Convert price dependent on what the user has selected or default which is GBP
    $vehicle_converted_price = convert_currency($vehicle_numeric_price, $from = 'GBP', $in = $currentCurrency);

    // Format the currency price
    $vehicle_formatted_price = format_currency($vehicle_converted_price, $currentCurrency, true) ;

    // The complete price which checks if the format price is empty
    $vehicle_complete_price = !empty($vehicle_formatted_price) ? $vehicle_formatted_price : 'TBC';

    $highlight_value             = imic_vehicle_title($id, $highlighted_specs, $specifications);
    $featured_specifications     = (isset($imic_options[ 'side_specifications' ])) ? $imic_options[ 'side_specifications' ] : array();
    $normal_specifications       = (isset($imic_options[ 'normal_specifications' ])) ? $imic_options[ 'normal_specifications' ] : array();
    $normal_specification        = array();
    $browse_specification_switch = get_post_meta($id, 'imic_browse_by_specification_switch', true);
    $browse_listing              = imic_get_template_url('template-listing.php');
    $plan                        = get_post_meta($id, 'imic_plugin_car_plan', true);
    $plan_premium                = get_post_meta('10'.$plan, 'imic_pricing_premium_badge', true);
    $userFirstName               = get_the_author_meta('first_name', $post_author_id);
    $userLastName                = get_the_author_meta('last_name', $post_author_id);
    $user_data                   = get_userdata(intval($post_author_id));
    $userName                    = $user_data->display_name;

    if (!empty($userFirstName) || !empty($userLastName)) {
        $userName = $userFirstName . ' ' . $userLastName;
    }

    $vehicle_status = get_post_meta(get_the_ID(), 'imic_plugin_ad_payment_status', true);

    if ($vehicle_status != 1) {
        echo '<div class="main" role="main">';
            echo '<div id="content" class="content full">';
                echo '<div class="container">';
                    echo '<div class="row">';
                        echo '<p>' . __('Vehicle might be sold or not active', 'framework') . '</p>';
                    echo '</div>';
                echo '</div>';
            echo '</div>';
        echo '</div>';
    } else {
        $save1                = (isset($_SESSION[ 'saved_vehicle_id1' ])) ? $_SESSION[ 'saved_vehicle_id1' ] : '';
        $save2                = (isset($_SESSION[ 'saved_vehicle_id2' ])) ? $_SESSION[ 'saved_vehicle_id2' ] : '';
        $save3                = (isset($_SESSION[ 'saved_vehicle_id3' ])) ? $_SESSION[ 'saved_vehicle_id3' ] : '';
        $user_id              = get_current_user_id();
        $current_user_info_id = get_user_meta($user_id, 'imic_user_info_id', true);

        if ($current_user_info_id != '') {
            $saved_car_user = get_post_meta($current_user_info_id, 'imic_user_saved_cars', true);
        }

        if ((empty($saved_car_user)) || ($current_user_info_id == '') || ($saved_car_user == '')) {
            $saved_car_user = array(
                $save1,
                $save2,
                $save3
            );
        }

        $save_icon               = (imic_value_search_multi_array(get_the_ID(), $saved_car_user)) ? 'fa-star' : 'fa-star-o';
        $save_icon_disable       = (imic_value_search_multi_array(get_the_ID(), $saved_car_user)) ? 'disabled' : '';
        $enquiry_form1           = (isset($imic_options[ 'enquiry_form1' ])) ? $imic_options[ 'enquiry_form1' ] : '0';
        $classified_data         = get_option('imic_classifieds');
        $classified_data         = (!empty($classified_data)) ? $classified_data : array();
        $listing_details         = (isset($imic_options[ 'listing_details' ])) ? $imic_options[ 'listing_details' ] : 0;
        $specification_data_type = (get_option('imic_specifications_upd_st') != 1) ? 0 : get_option('imic_specifications_upd_st');
        $tabs                    = (isset($imic_options[ 'details_tab' ])) ? $imic_options[ 'details_tab' ] : array();
        ?>

        <main class="main single-listing" role="main" data-mfp-delegation>
            <div class="container">
                <header class="vehicle-header">
                    <?php include 'includes/template-parts/single-listing/single-listing-vehicle-header.php'; ?>
                </header>

                <article class="single-vehicle-details">
                    <div class="single-listing-images row">
                        <?php include 'includes/template-parts/single-listing/single-listing-vehicle-images.php'; ?>
                    </div>

                    <div class="vehicle-single-information row">
                        <div class="col-md-8">
                            <?php
                            /**
                             *  For the tabs we don't have to worry about order as that's controlled via the
                             *  wp-admin interface by the admin
                             */
                            if ($tabs):

                                // include file with functions for handling tabs
                                include('includes/template-parts/single-listing/single-listing-tabs.php'); ?>

                                <div class="tabs vehicle-single-tabs">
                                    <ul class="nav nav-tabs">
                                        <?php
                                        $count = 1;
                                        /**
                                         * Maps and ooutputs tab headers
                                         * @return HTML
                                         */
                                        mapItem($tabs, function($tab) use (&$count){
                                            $active = ($count == 1) ? 'active' : '';
                                            echo tabHtml($tab, $active, $count);
                                            $count++;
                                        }); ?>
                                    </ul>

                                    <div class="tab-content">
                                        <?php
                                        $count = 1;
                                        /**
                                         * Maps and outputs the content areas
                                         * @return HTML
                                         */
                                        mapItem($tabs, function($tab) use (&$count){
                                            $active = ($count == 1) ? 'active in' : '';
                                            echo tabContentHtml($tab, $active, $count);
                                            $count++;
                                        }); ?>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <div class="listingShare">
                                <a <?php echo esc_attr($save_icon_disable); ?> href="#" rel="popup-save" class="button button--small button--passive save-car" title="<?php echo esc_attr_e('Save this listing', 'adaptable-child'); ?>">
                                    <span><?php echo esc_attr_e('Save this listing', 'adaptable-child'); ?></span>
                                    <div class="vehicle-details-access" style="display:none;">
                                        <span class="vehicle-id"><?php echo esc_attr(get_the_ID()); ?></span>
                                    </div>
                                </a>
                                <a href="#" data-toggle="modal" data-target="#sendModal" class="button button--small button--passive" title="<?php echo esc_attr_e('Send To A Friend','adaptable-child'); ?>">
                                    <span><?php echo esc_attr_e('Send To A Friend','adaptable-child'); ?></span>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-4 sidebar-widget widget">
                            <?php include 'includes/template-parts/single-listing/single-listing-specsidebar.php'; ?>

                            <div class="custom-sidebar">
                                <?php dynamic_sidebar($pageSidebar2); ?>
                            </div>
                        </div>
                    </div>
                </article>
            </div>

            <!-- RELATED LISTINGS -->
            <?php include(locate_template('includes/theme/adp-single_listing-related_listings.php')); ?>

        </main>

        <?php //Session for recently viewed cars
            if (!isset($_SESSION[ 'viewed_vehicle_id1' ])) {
                $_SESSION[ 'viewed_vehicle_id1' ] = get_the_ID  ();
            } elseif (!isset($_SESSION[ 'viewed_vehicle_id2' ])) {
                if ($_SESSION[ 'viewed_vehicle_id1' ] != get_the_ID()) {
                    $_SESSION[ 'viewed_vehicle_id2' ] = get_the_ID();
                }
            } elseif (!isset($_SESSION[ 'viewed_vehicle_id3' ])) {
                if ($_SESSION[ 'viewed_vehicle_id1' ] != get_the_ID() && $_SESSION[ 'viewed_vehicle_id2' ] != get_the_ID()) {
                    $_SESSION[ 'viewed_vehicle_id3' ] = get_the_ID();
                }
            } else {
                unset($_SESSION[ 'viewed_vehicle_id1' ]);
                if ($_SESSION[ 'viewed_vehicle_id2' ] != get_the_ID() && $_SESSION[ 'viewed_vehicle_id3' ] != get_the_ID()) {
                    $_SESSION[ 'viewed_vehicle_id1' ] = get_the_ID();
                }
            }
    } //End of status view

} else { ?>
    <main class="main" role="main">
        <div id="content" class="content full">
            <div class="container">
                <div class="text-align-center error-404">
                    <h1 class="huge"><?php echo esc_attr_e('Sorry This page doesn\'t exist', 'adaptable-child'); ?></h1>
                    <hr class="sm">
                </div>
            </div>
        </div>
    </main>

<?php }

if (is_plugin_active('imi-classifieds/imi-classified.php')) {
    imic_viewed_listing(get_the_ID());
}

get_footer(); ?>
