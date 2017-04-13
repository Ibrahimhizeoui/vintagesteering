<?php namespace LukeRoberts;
/*
Template Name: Dashboard
*/

use \WP_Query as WP_Query;

// Instantiate our Currency Class
$currencies = new Currency();

// Get the current in use currency.
$currentCurrency = $currencies->getCurrentCurrency();

get_header();

global $imic_options;

//Get Page Banner Type
$id = (is_home()) ? $id = get_option('page_for_posts') : get_the_ID();

get_template_part('bar', 'two');

// includes the controller file for billboards
include('includes/billboard/billboard.php');

if (is_plugin_active('imithemes-listing/listing.php')) {
    global $current_user;

    $compare_url = imic_get_template_url('template-compare.php');
    $pageSidebar2 = get_post_meta(get_the_ID(), 'imic_select_sidebar_from_list2', true);

    if (!empty($pageSidebar2) && is_active_sidebar($pageSidebar2)) {
        $class2 = 9;
    } else {
        $class2 = 12;
    }

    $required_value = $total_ads = $st = '';
    $user_id = get_current_user_id();
    $user_info_id = get_user_meta($user_id, 'imic_user_info_id', true);
    $user_name = get_the_title($user_info_id);
    $saved_cars = get_post_meta($user_info_id, 'imic_user_saved_cars', true);
    $saved_search = get_post_meta($user_info_id, 'imic_user_saved_search', true);
    $listing_url = get_bloginfo('url') . '/add-new-listing';
    $args_cars = array('post_type' => 'cars', 'author' => $current_user->ID, 'posts_per_page' => -1, 'post_status' => array('publish', 'draft'));
    $cars_listing = new WP_Query($args_cars);

    if ($cars_listing->have_posts()) :
        while ($cars_listing->have_posts()) :
            $cars_listing->the_post();
            $total_ads = $cars_listing->post_count;
        endwhile;
    endif;
    wp_reset_postdata();

    $browse_listing = imic_get_template_url('template-listing.php');

    $vehicle = esc_attr(get_query_var('edit'));
    $listing_status = (isset($imic_options['opt_listing_status'])) ? $imic_options['opt_listing_status'] : '';
    $payment_status = ($listing_status == 'draft') ? '4' : '1';
    update_post_meta($vehicle, 'imic_plugin_ads_steps', 5);
    update_post_meta($vehicle, 'imic_plugin_ad_payment_status', $payment_status);
    $opt_plans = $imic_options['opt_plans'];
    $payment_gross = 'free';
    $eligible_listing = '';
    $plans = esc_attr(get_query_var('plans'));
    $listing_end_status = get_post_meta($plans, 'imic_days_periodic_listing', true);
    $listing_end_status = ($listing_end_status != '') ? $listing_end_status : 500;
    $listing_date = date('Y-m-d', strtotime('+'.$listing_end_status.' days'));
    $plan_type = get_post_meta($plans, 'imic_plan_validity', true);
    $user_plan = get_post_meta($user_info_id, 'imic_user_all_plans', false);
    $user_plan = ($user_plan != '') ? $user_plan : array();
    $plan_listings_count = get_post_meta($plans, 'imic_plan_validity_listings', true);
    $all_plans_user = get_post_meta($user_info_id, 'imic_user_plan_'.$plans, true);
    $plan_new_price = get_post_meta($plans, 'imic_plan_price', true);

    $adpUserData = get_userdata($user_id);
    $adpProfileTabText = ($adpUserData->roles[0] == 'dealer') ? 'Dealership Profile' : 'Seller Profile';

    if ($plan_new_price == '' || $plan_new_price == 'free') {
        if (!empty($all_plans_user)) {
            foreach ($all_plans_user as $key => $value) {
                $data[date('U')] = $value;
            }
        } else {
            $data[date('U')] = '';
        }
        $allowed_listings = get_post_meta($user_info_id, 'imic_allowed_listings_'.$plans, true);
        $updated_allowed_listings = $allowed_listings + $plan_listings_count;
        $user_all_plans = get_post_meta($user_info_id, 'imic_user_all_plans', false);
        if ($updated_allowed_listings <= 0) {
            update_post_meta($user_info_id, 'imic_user_plan_'.$plans, $data);
            update_post_meta($user_info_id, 'imic_allowed_listings_'.$plans, $updated_allowed_listings - 1);

            if (!in_array($plans, $user_all_plans)) {
                add_post_meta($user_info_id, 'imic_user_all_plans', $plans, false);
            }
        }
    }

    if (in_array($plans, $user_plan)) {
        $selected_plan = get_post_meta($user_info_id, 'imic_user_plan_'.$plans, true);
        $selected_plan_listings = get_post_meta($user_info_id, 'imic_allowed_listings_'.$plans, true);
        if (!empty($selected_plan)) {
            foreach ($selected_plan as $key => $value) {
                $listing_ids = $value;
                $listings_plan = explode(',', $listing_ids);
            }
        }
        if ($selected_plan_listings > 0 || in_array($vehicle, $listings_plan)) {
            if (!empty($selected_plan)) {
                foreach ($selected_plan as $key => $value) {
                    switch ($plan_type) {
                        case 'day':
                            $plan_validity_number = get_post_meta($plans, 'imic_plan_validity_days', true);
                            break;
                        case 'week':
                            $plan_validity_number = get_post_meta($plans, 'imic_plan_validity_weeks', true);
                            break;
                        case 'month':
                            $plan_validity_number = get_post_meta($plans, 'imic_plan_validity_months', true);
                            break;
                    }

                    $valid_with_plan = get_post_meta($plans, 'imic_plan_validity_expire_listing', true);
                    if ($valid_with_plan == 1) {
                        $start_date = date('Y-m-d', $key);
                        $listing_date = strtotime(date('Y-m-d', strtotime($start_date)).' +'.$plan_validity_number.' '.$plan_type);
                        $listing_date = date('Y-m-d', $listing_date);
                    }
                    if ($listing_date > date('Y-m-d')) {
                        $eligible_listing = 1;
                    }
                }
            }
        }
    }

    $payment = '';
    if ($opt_plans == 1)
    {
        $transaction_id = isset($_REQUEST['tx']) ? esc_attr($_REQUEST['tx']) : date('U');
        if ($transaction_id != '' && $vehicle != '' && $transaction_id != $vehicle * 4)
        {
            $paypal_details = imic_validate_payment($transaction_id);
            if ($plan_type != '0')
            {
                $plan_id = isset($_REQUEST['item_number']) ? esc_attr($_REQUEST['item_number']) : '';
                $plan_id = ($plan_id != '') ? $plan_id : get_query_var('plans');
                $post_type = get_post_type($plan_id);
                $plan_price = '';
                if ($post_type == 'plan')
                {
                    $plan_price = get_post_meta($plan_id, 'imic_plan_price', true);
                    $payment = $plan_price;
                    $plan_price = floor($plan_price);
                    $plan_listings_count = get_post_meta($plan_id, 'imic_plan_validity_listings', true);
                    $plan_listings_count = esc_attr($plan_listings_count);
                }

                if (!empty($paypal_details))
                {
                    $st = $paypal_details['payment_status'];
                    $payment_gross = $paypal_details['payment_gross'];
                    $payment = floor($payment_gross);
                }

                $confirm = ($plan_price == $payment) ? 1 : '';
                $st = ($confirm == 1) ? $st : __('Not Verified', 'adaptable-child');
                $data = array();

                if ($confirm == 1)
                {
                    $all_plans_user = get_post_meta($user_info_id, 'imic_user_plan_'.$plan_id, true);
                    if (!empty($all_plans_user))
                    {
                        foreach ($all_plans_user as $key => $value)
                        {
                            $data[date('U')] = $value.','.$vehicle;
                        }
                    } else
                    {
                        $data[date('U')] = $vehicle.',';
                    }

                    $last_transaction_id = get_post_meta($user_info_id, 'imic_user_tr_id', false);
                    $allowed_listings = get_post_meta($user_info_id, 'imic_allowed_listings_'.$plan_id, true);
                    $allowed_listings = ($allowed_listings >= 0) ? $allowed_listings : 0;
                    $updated_allowed_listings = $allowed_listings + $plan_listings_count;
                    $user_all_plans = get_post_meta($user_info_id, 'imic_user_all_plans', false);
                    if (!in_array($transaction_id, $last_transaction_id))
                    {
                        update_post_meta($user_info_id, 'imic_user_plan_'.$plan_id, $data);
                        update_post_meta($user_info_id, 'imic_allowed_listings_'.$plan_id, $updated_allowed_listings - 1);
                        add_post_meta($user_info_id, 'imic_user_tr_id', $transaction_id, false);
                        if (!in_array($plan_id, $user_all_plans))
                        {
                            add_post_meta($user_info_id, 'imic_user_all_plans', $plan_id, false);
                        }
                    }
                }
            }

            if (!empty($paypal_details))
            {
                $st = $paypal_details['payment_status'];
                $payment_gross = $paypal_details['payment_gross'];
                if ($st == 'Completed')
                {
                    if ($payment_status == '1')
                    {
                        update_post_meta($vehicle, 'imic_plugin_ads_steps', 5);
                    }
                    update_post_meta($vehicle, 'imic_plugin_ad_payment_status', $payment_status);
                    update_post_meta($vehicle, 'imic_plugin_paid_price', $payment_gross);
                }
            }
            update_post_meta($vehicle, 'imic_plugin_car_plan', $plans);
            update_post_meta($vehicle, 'imic_plugin_listing_end_dt', $listing_date);
        }

        $plan_price = get_post_meta($plans, 'imic_plan_price', true);
        if ($plan_price == 'free' || $plan_price == '')
        {
            $st = 'free';
            if ($payment_status == '1')
            {
                update_post_meta($vehicle, 'imic_plugin_ads_steps', 5);
            }

            update_post_meta($vehicle, 'imic_plugin_ad_payment_status', $payment_status);
            update_post_meta($vehicle, 'imic_plugin_paid_price', $payment_gross);
            update_post_meta($vehicle, 'imic_plugin_car_plan', $plans);
            update_post_meta($vehicle, 'imic_plugin_listing_end_dt', $listing_date);
        }

        if ($eligible_listing == 1)
        {
            update_post_meta($vehicle, 'imic_plugin_listing_end_dt', $listing_date);
        }
    } else
    {
        $st = 'free';
        if ($payment_status == '1')
        {
            update_post_meta($vehicle, 'imic_plugin_ads_steps', 5);
        }
        update_post_meta($vehicle, 'imic_plugin_ad_payment_status', $payment_status);
        update_post_meta($vehicle, 'imic_plugin_paid_price', '');
        update_post_meta($vehicle, 'imic_plugin_car_plan', 'N/A');
        update_post_meta($vehicle, 'imic_plugin_listing_end_dt', $listing_date);
    }

    $specification_type = (isset($imic_options['short_specifications'])) ? $imic_options['short_specifications'] : '0';
    ?>

    <!-- Start Body Content -->
    <div class="main" role="main">
        <div id="content" class="content full dashboard-pages">
            <div class="container">
                <div class="dashboard-wrapper">
                    <div class="row">

                        <?php if (!is_user_logged_in())
                        {
                            echo '<div class="col-md-12 col-sm-12">';
                            echo '<p>'.__('Login or Register to access this page', 'framework').'</p>';
                            echo '<a class="button" data-toggle="modal" data-target="#PaymentModal">'.__('Login/Register', 'framework').'</a>';
                            echo '</div>';
                        } else {
                        ?>
                            <div class="col-md-3 users-sidebar-wrapper">

                                <div class="users-sidebar ">
                                    <a href="<?php echo esc_url($listing_url); ?>" class="button button--alternate button--full button--central add-listing-btn"><?php echo esc_attr_e('New Ad listing', 'adaptable-child'); ?></a>
                                        <ul class="list-group">
                                            <li class="list-group-item <?php if ($_SERVER['QUERY_STRING'] == '') { echo 'active'; } ?>">
                                                <a href="<?php echo get_permalink(); ?>">
                                                    <?php echo esc_attr_e('Dashboard', 'adaptable-child'); ?>
                                                </a>
                                            </li>

                                            <?php if (!empty($saved_search))
                                            { ?>
                                                <li class="list-group-item <?php if (get_query_var('search') == 1) { echo 'active'; }?>">
                                                    <span class="badge"><?php echo count($saved_search);?></span>
                                                    <a href="<?php echo esc_url(add_query_arg('search', 1, get_permalink())); ?>">
                                                        <?php echo esc_attr_e('Saved Searches', 'adaptable-child'); ?>
                                                    </a>
                                                </li>
                                            <?php }

                                            if (!empty($saved_cars))
                                            { ?>
                                                <li class="list-group-item <?php if (get_query_var('saved') == 1) { echo 'active'; } ?>">
                                                    <span class="badge"><?php echo count($saved_cars); ?></span>
                                                    <a href="<?php echo esc_url(add_query_arg('saved', 1, get_permalink())); ?>">
                                                        <?php echo esc_attr_e('Saved Cars', 'adaptable-child'); ?>
                                                    </a>
                                                </li>
                                            <?php } ?>

                                            <?php if ($total_ads != '') { ?>
                                                <li class="list-group-item <?php if (get_query_var('manage') == 1) { echo 'active'; } ?>">
                                                    <span class="badge"><?php echo esc_attr($total_ads); ?></span>
                                                    <a href="<?php echo esc_url(add_query_arg('manage', 1, get_permalink())); ?>">
                                                        <?php echo esc_attr_e('Manage Ads', 'adaptable-child'); ?>
                                                    </a>
                                                </li>
                                            <?php } ?>

                                            <li class="list-group-item <?php if (get_query_var('plans') == 1) { echo 'active'; } ?>">
                                                <a href="<?php echo esc_url(add_query_arg('plans', 1, get_permalink())); ?>">
                                                    <?php echo esc_attr_e('Plans Subscribed', 'adaptable-child'); ?>
                                                </a>
                                            </li>

                                            <li class="list-group-item <?php if (get_query_var('profile') == 1) { echo 'active'; } ?>">
                                                <a href="<?php echo esc_url(add_query_arg('profile', 1, get_permalink())); ?>">
                                                    <?php echo esc_attr_e($adpProfileTabText, 'adaptable-child'); ?>
                                                </a>
                                            </li>

                                            <li class="list-group-item">
                                                <a href="<?php echo wp_logout_url(home_url()); ?>">
                                                    <?php echo esc_attr_e('Log Out', 'adaptable-child'); ?>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="col-md-9">
                                    <?php if (($st == 'Completed' || $st == 'free') && ($vehicle != ''))
                                    {
                                        echo '<div class="alert alert-success fade in">
                                            <a class="close" href="#" data-dismiss="alert">×</a>
                                            <strong>Well done!</strong>
                                            '.__('Thanks for submiting your listing. You can visit dashboard for further reference', 'framework').'
                                        </div> ';

                                        //Email properties
                                        $success_msg = $imic_options['payment_success_mail'];
                                        $listing_contact_email = '';
                                        $admin_mail_to = ($listing_contact_email == '') ? get_option('admin_email') : $listing_contact_email;
                                        $mail_subject = $user_name.__('successfully added listing.', 'adaptable-child');
                                        $admin_mail_content = '<p>'.$user_name.__(' has added Ad listing.', 'framework').'</p>';
                                        $admin_mail_content .= '<p>'.__('Name: ', 'framework').$user_name.'</p>';
                                        $admin_mail_content .= '<p>'.__('Email: ', 'framework').$current_user->user_email.'</p>';
                                        $admin_mail_content .= '<p>'.__('Ad: ', 'framework').get_permalink($vehicle).'</p>';
                                        $admin_msg = wordwrap($admin_mail_content, 70);
                                        $admin_headers = "From: $current_user->user_email".PHP_EOL;
                                        $admin_headers .= "Reply-To: $current_user->user_email".PHP_EOL;
                                        $admin_headers .= 'MIME-Version: 1.0'.PHP_EOL;
                                        $admin_headers .= "Content-Type: text/html; charset=\"iso-8859-1\"\n";
                                        $dealer_headers = "From: $admin_mail_to".PHP_EOL;
                                        $dealer_headers .= "Reply-To: $admin_mail_to".PHP_EOL;
                                        $dealer_headers .= 'MIME-Version: 1.0'.PHP_EOL;
                                        $dealer_headers .= "Content-Type: text/html; charset=\"iso-8859-1\"\n";
                                        @mail($admin_mail_to, $mail_subject, $admin_msg, $admin_headers);
                                        @mail($current_user->user_email, $mail_subject, $success_msg, $dealer_headers);
                                    }

                                    if ((esc_attr(get_query_var('search')) != 1) && (esc_attr(get_query_var('saved')) != 1) && (esc_attr(get_query_var('profile')) != 1) && (esc_attr(get_query_var('account')) != 1) && (esc_attr(get_query_var('plans')) != 1))
                                    {
                                        // echo '<p>Get started and upload your car to our global network of classic car enthusiasts! The process is quick, easy and designed to give potential buyers the best view and assessment of the car you are interested in selling. We recommend making use of our high-resolution picture quality and the possibility to upload videos to truly market your car. We will gladly make recommendations to make your listing as informative and visible as possible. All your car listings, whether they in progress or already published, can be found under Manage Ads.</p>';

                                        $additional_specs = $imic_options['unique_specs'];
                                        $detailed_title = $imic_options['highlighted_specs'];
                                        $ads_count = (get_query_var('manage') != 1) ? 1 : -1;
                                        $args_cars = array('post_type' => 'cars', 'author' => $user_id, 'posts_per_page' => $ads_count, 'post_status' => array('publish', 'draft'));
                                        $cars_listing = new WP_Query($args_cars);

                                        if ($cars_listing->have_posts()) : ?>
                                            <div id="ads-section" class="dashboard-block">
                                                <div class="dashboard-block-head">

                                                    <?php if (($total_ads > 1) && (esc_attr(get_query_var('manage')) != 1) && (esc_attr(get_query_var('plans')) != 1))
                                                    { ?>
                                                        <a href="<?php echo esc_url(add_query_arg('manage', '1', get_permalink())); ?>" class="button pull-right">
                                                            <?php echo esc_attr_e('See all Ads ', 'framework') . '('.$total_ads.')'; ?>
                                                        </a>
                                                    <?php } ?>

                                                    <h3><?php echo esc_attr_e('All My Listings', 'adaptable-child'); ?></h3>
                                                </div>
                                                <div class="table-responsive">
                                                    <table class="table table-bordered dashboard-tables saved-cars-table">
                                                        <thead>
                                                            <tr>
                                                                <td>&nbsp;</td>
                                                                <td><?php echo esc_attr_e('Description', 'adaptable-child'); ?></td>
                                                                <td><?php echo esc_attr_e('Price/Status', 'adaptable-child'); ?></td>
                                                                <td><?php echo esc_attr_e('Created On', 'adaptable-child'); ?></td>
                                                                <td><?php echo esc_attr_e('Payment', 'adaptable-child'); ?></td>
                                                            </tr>
                                                        </thead>
                                                    <tbody>
                                                        <?php while ($cars_listing->have_posts()) :
                                                            $cars_listing->the_post();
                                                            $last_term = get_last_child_term_id(get_the_ID(), 'listing-category', true);
                                                            $plan_id = get_post_meta(get_the_ID(), 'imic_plugin_car_plan', true);

                                                            $statuses = get_post_meta(get_the_ID(), 'imic_plugin_ad_payment_status', true);
                                                            switch($statuses)
                                                            {
                                                                case 1:
                                                                    $status = __('Active', 'adaptable-child');
                                                                    $label = 'success';
                                                                    break;
                                                                case 2:
                                                                    $status = __('Sold', 'adaptable-child');
                                                                    $label = 'primary';
                                                                    break;
                                                                case 3:
                                                                    $status = __('Inactive', 'adaptable-child');
                                                                    $label = 'primary';
                                                                    break;
                                                                case 4 || 0:
                                                                    $status = __('Under Review', 'adaptable-child');
                                                                    $label = 'info';
                                                                    break;
                                                                default:
                                                                    $status = '';
                                                            }

                                                            $specifications = get_post_meta(get_the_ID(), 'feat_data', true);
                                                            $default_image_vehicle = (isset($imic_options['default_car_image'])) ? $imic_options['default_car_image'] : array('url' => '');

                                                            if ($specification_type == 0) {
                                                                $detailed_specs = (isset($imic_options['vehicle_specs'])) ? $imic_options['vehicle_specs'] : array();
                                                            } else {
                                                                $detailed_specs = array();
                                                            }

                                                            $detailed_specs = imic_filter_lang_specs($detailed_specs);

                                                            if (is_plugin_active('imi-classifieds/imi-classified.php')) {
                                                                $detailed_specs = imic_classified_short_specs(get_the_ID(), $detailed_specs);
                                                            }

                                                            $details_value         = imic_vehicle_all_specs(get_the_ID(), $detailed_specs, $specifications);

                                                            // Get the vehicle price as JUST a numerical value
                                                            $vehicle_numeric_price = preg_replace("/[^0-9]/", "", imic_vehicle_price(get_the_ID(), $additional_specs, $specifications));

                                                            // Convert price dependent on what the user has selected or default which is GBP
                                                            $vehicle_converted_price = convert_currency($vehicle_numeric_price, $from = 'GBP', $in = $currentCurrency);

                                                            // Format the currency price
                                                            $vehicle_formatted_price = format_currency($vehicle_converted_price, $currentCurrency, true) ;

                                                            // The complete price which checks if the format price is empty
                                                            $vehicle_complete_price = !empty($vehicle_formatted_price) ? $vehicle_formatted_price : 'TBC';

                                                            $new_highlighted_specs = imic_filter_lang_specs_admin($detailed_title, get_the_ID());
                                                            $detailed_title        = $new_highlighted_specs;
                                                            $title                 = imic_vehicle_title(get_the_ID(), $detailed_title, $specifications);

                                                            $title = ($title == '') ? get_the_title() : $title;
                                                            if ($plan_id != '' && $last_term != '') {
                                                                $edit_url = array('edit' => get_the_ID(), 'plans' => $plan_id, 'list-cat' => $last_term);
                                                            } elseif ($plan_id == '' && $last_term != '') {
                                                                $edit_url = array('edit' => get_the_ID(), 'list-cat' => $last_term);
                                                            } elseif ($plan_id != '' && $last_term == '') {
                                                                $edit_url = array('edit' => get_the_ID(), 'plans' => $plan_id);
                                                            } else {
                                                                $edit_url = array('edit' => get_the_ID());
                                                            }
                                                            ?>

                                                            <tr>
                                                                <td align="center" valign="middle">
                                                                    <input id="<?php echo esc_attr(get_the_ID()); ?>" value="1" class="remove-ads" type="checkbox">
                                                                </td>

                                                                <td>
                                                                    <?php if (has_post_thumbnail()) { ?>
                                                                        <a href="<?php echo esc_url(add_query_arg($edit_url, $listing_url)); ?>" class="car-image">
                                                                            <?php the_post_thumbnail();?>
                                                                        </a>
                                                                    <?php } else { ?>
                                                                        <a href="<?php echo esc_url(add_query_arg($edit_url, $listing_url)); ?>" class="car-image">
                                                                            <img src="<?php echo esc_url($default_image_vehicle['url']); ?>">
                                                                        </a>
                                                                    <?php } ?>

                                                                    <div class="search-find-results">
                                                                        <?php if ($statuses == 1) { ?>
                                                                            <h5><a href="<?php echo esc_url(get_permalink(get_the_ID())); ?>"><?php echo esc_attr($title);?></a></h5>
                                                                        <?php } else { ?>
                                                                            <h5><?php echo esc_attr($title); ?></h5>
                                                                        <?php } ?>

                                                                        <ul class="inline">
                                                                            <?php foreach ($details_value as $detail) {
                                                                                if ((!empty($detail)) && ($detail != 'select')) {
                                                                                    echo '<li>'.$detail.'</li>';
                                                                                }
                                                                            } ?>
                                                                        </ul>
                                                                    </div>
                                                                </td>

                                                                <td align="center">
                                                                    <span class="price" data-price-conversion data-vehicle-price="<?php echo $vehicle_numeric_price; ?>"><?php echo esc_attr($vehicle_complete_price);?></span>
                                                                </td>

                                                                <td>
                                                                    <a href="<?php echo esc_url(add_query_arg($edit_url, $listing_url)); ?>" class="edit center blockDisplay">Edit Listing</a>
                                                                    <br/>
                                                                    <?php
                                                                    echo esc_attr(get_the_date(get_option('date_format')));
                                                                    echo esc_attr_e(' @ ', 'adaptable-child');
                                                                    echo esc_attr(get_the_date(get_option('time_format')));
                                                                    ?>
                                                                </td>

                                                                <td align="center">
                                                                    <span id="ad-<?php echo esc_attr(get_the_ID()); ?>" class="label label-<?php echo esc_attr($label); ?>">
                                                                    <?php echo esc_attr($status); ?></span>
                                                                </td>
                                                            </tr>
                                                        <?php endwhile; ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <button id="selected-ads" class="button delete-ads"><?php echo esc_attr_e('Delete Selected', 'adaptable-child'); ?></button>
                                            </div>
                                        <?php else: ?>
                                            <div class="dashboard-block">
                                                <div class="dashboard-block-head">
                                                    <h3><?php echo esc_attr_e('My Ad Listings', 'adaptable-child'); ?></h3>
                                                </div>
                                                <div class="table-responsive">
                                                    <p><?php echo esc_attr_e('You have not created any Ads yet.', 'adaptable-child'); ?></p>
                                                </div>
                                            </div>
                                        <?php endif; wp_reset_postdata();
                                    } ?>

                                    <?php if ((esc_attr(get_query_var('search')) != 1) && (esc_attr(get_query_var('manage')) != 1) && (esc_attr(get_query_var('profile')) != 1) && (esc_attr(get_query_var('account')) != 1) && (esc_attr(get_query_var('plans')) != 1))
                                    { ?>
                                        <div id="saved-cars-section" class="dashboard-block">
                                            <div class="dashboard-block-head">
                                                <?php if ((count($saved_cars) > 3) && (esc_attr(get_query_var('saved')) != 1))
                                                { ?>
                                                    <a href="<?php echo esc_url(add_query_arg('saved', 1, get_permalink())); ?>" class="button pull-right"><?php echo esc_attr_e('See all cars ', 'adaptable-child');
                                                        echo '('.count($saved_cars).')'; ?>
                                                    </a><?php
                                                } ?>
                                                <h3><?php echo esc_attr_e('Saved Cars', 'adaptable-child'); ?></h3>
                                            </div>
                                            <div class="table-responsive">
                                                <?php if (!empty($saved_cars))
                                                { ?>
                                                    <table id="saved-cars-table" class="table table-bordered dashboard-tables saved-cars-table saved-cars-box">
                                                        <thead>
                                                            <tr>
                                                                <td>&nbsp;</td>
                                                                <td><?php echo esc_attr_e('Description', 'adaptable-child');?></td>
                                                                <td><?php echo esc_attr_e('Price/Status', 'adaptable-child');?></td>
                                                                <td><?php echo esc_attr_e('Saved On', 'adaptable-child'); ?></td>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        <?php $additional_specs = $imic_options['unique_specs'];
                                                            if ($specification_type == 0)
                                                            {
                                                                $detailed_specs = (isset($imic_options['vehicle_specs'])) ? $imic_options['vehicle_specs'] : array();
                                                            } else
                                                            {
                                                                $detailed_specs = array();
                                                            }

                                                            $detailed_title = $imic_options['highlighted_specs'];
                                                            $saved_four = 1;

                                                            foreach ($saved_cars as $save)
                                                            {
                                                                $specifications = get_post_meta($save[0], 'feat_data', true);
                                                                $details_value = imic_vehicle_all_specs($save[0], $detailed_specs, $specifications);
                                                                if (is_plugin_active('imi-classifieds/imi-classified.php'))
                                                                {
                                                                    $details_value = imic_classified_short_specs($save, $details_value);
                                                                }

                                                                // Get the vehicle price as JUST a numerical value
                                                                $vehicle_numeric_price = preg_replace("/[^0-9]/", "", imic_vehicle_price($save[0], $additional_specs, $specifications));

                                                                // Convert price dependent on what the user has selected or default which is GBP
                                                                $vehicle_converted_price = convert_currency($vehicle_numeric_price, $from = 'GBP', $in = $currentCurrency);

                                                                // Format the currency price
                                                                $vehicle_formatted_price = format_currency($vehicle_converted_price, $currentCurrency, true) ;

                                                                // The complete price which checks if the format price is empty
                                                                $vehicle_complete_price = !empty($vehicle_formatted_price) ? $vehicle_formatted_price : 'TBC';

                                                                $new_highlighted_specs = imic_filter_lang_specs_admin($detailed_title, $save[0]);
                                                                $detailed_title = $new_highlighted_specs;
                                                                $title = imic_vehicle_title($save[0], $detailed_title, $specifications);
                                                                ?>

                                                                <tr>
                                                                    <td align="center" valign="middle" class="checkb">
                                                                        <input id="saved-<?php echo esc_attr($save[0]); ?>" value="1" class="remove-saved compare-check" type="checkbox">
                                                                    </td>
                                                                    <td>
                                                                        <a href="<?php echo esc_url(get_permalink($save[0])); ?>" class="car-image"><?php echo get_the_post_thumbnail($save[0]);?></a>
                                                                        <div class="search-find-results">
                                                                            <h5><a href="<?php echo esc_url(get_permalink($save[0])); ?>"><?php echo esc_attr($title); ?></a></h5>
                                                                            <ul class="inline">
                                                                                <?php foreach ($details_value as $detail)
                                                                                {
                                                                                    if (!empty($detail))
                                                                                    {
                                                                                        echo '<li>'.$detail.'</li>';
                                                                                    }
                                                                                } ?>
                                                                            </ul>
                                                                        </div>
                                                                    </td>
                                                                    <td align="center" valign="middle">
                                                                        <span class="price" data-price-conversion data-vehicle-price="<?php echo $vehicle_numeric_price; ?>"><?php echo esc_attr($vehicle_complete_price);?></span>
                                                                    </td>
                                                                    <td>
                                                                        <?php
                                                                        echo esc_attr(date(get_option('date_format'), $save[1]));
                                                                        echo esc_attr_e(' @ ', 'adaptable-child');
                                                                        echo esc_attr(date(get_option('time_format'), $save[1]));
                                                                        ?>
                                                                    </td>
                                                                </tr>

                                                                <?php if (esc_attr(get_query_var('saved') != 1))
                                                                {
                                                                    if ($saved_four++ > 3)
                                                                    {
                                                                        break;
                                                                    }
                                                                }
                                                            } ?>
                                                        </tbody>
                                                    </table>
                                                </div>

                                                <button rel="selected-saved-ad" class="button delete-saved"><?php echo esc_attr_e('Delete Selected', 'adaptable-child'); ?></button>
                                                <a href="<?php echo esc_url($compare_url); ?>" id="compare-selected" class="button compare-in-box">
                                                    <?php echo esc_attr_e('Compare', 'adaptable-child'); ?>
                                                </a><?php
                                            } else
                                            { ?>
                                                <p><?php echo esc_attr_e('You don\'t have any saved listing in your dashboard', 'adaptable-child'); ?></p>
                                                </div>
                                            <?php
                                        }
                                        ?>
                                    </div>
                                    <?php
                                }
                                if ((esc_attr(get_query_var('manage')) != 1) && (esc_attr(get_query_var('saved')) != 1) && (esc_attr(get_query_var('profile')) != 1) && (esc_attr(get_query_var('account')) != 1) && (esc_attr(get_query_var('plans')) != 1))
                                { ?>
                                    <div id="search-cars-section" class="dashboard-block">
                                        <div class="dashboard-block-head">
                                            <?php if ((count($saved_search) > 3) && (esc_attr(get_query_var('search') != 1)))
                                            { ?>
                                                <a href="<?php echo esc_url(add_query_arg('search', 1, get_permalink())); ?>" class="button pull-right">
                                                    <?php echo esc_attr_e('See all searches ', 'framework') . '('.count($saved_search).')'; ?>
                                                </a><?php
                                            } ?>
                                            <h3><?php echo esc_attr_e('Saved Searches', 'adaptable-child'); ?></h3>
                                        </div>
                                        <div class="table-responsive">
                                            <?php if (!empty($saved_search))
                                            { ?>
                                                <table id="search-cars-table" class="table table-bordered dashboard-tables saved-searches-table">
                                                    <thead>
                                                        <tr>
                                                            <td>&nbsp;</td>
                                                            <td><?php echo esc_attr_e('Custom search name', 'adaptable-child'); ?></td>
                                                            <td><?php echo esc_attr_e('Details', 'adaptable-child'); ?></td>
                                                            <!--<td><?php echo esc_attr_e('Receive alerts', 'adaptable-child'); ?></td>-->
                                                            <td><?php echo esc_attr_e('Created On', 'adaptable-child'); ?></td>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $count = $search_four = 1;
                                                        foreach ($saved_search as $search)
                                                        {
                                                            $res = preg_replace('/[^a-zA-Z]/', '', $search[0]); ?>
                                                            <tr>
                                                                <td align="center" valign="middle"><input value="1" id="<?php echo esc_attr($res); ?>" class="remove-search" type="checkbox"></td>
                                                                <td>
                                                                    <a href="<?php echo esc_url($search[2]); ?>" class="search-name"><?php echo esc_attr($search[0]);?></a>
                                                                </td>
                                                                <td><?php echo esc_attr($search[1]); ?></td>
                                                                <td>
                                                                    <span class="text-success"><?php echo esc_attr_e('Saved on', 'adaptable-child');?></span>
                                                                    <?php
                                                                    echo esc_attr(date(get_option('date_format'), $search[3]));
                                                                    echo esc_attr_e(' @ ', 'adaptable-child');
                                                                    echo esc_attr(date(get_option('time_format'), $search[3]));
                                                                    ?>
                                                                </td>
                                                            </tr>
                                                            <?php ++$count;
                                                            if (esc_attr(get_query_var('search') != 1))
                                                            {
                                                                if ($search_four++ > 3)
                                                                {
                                                                    break;
                                                                }
                                                            }
                                                        } ?>
                                                    </tbody>
                                                </table><?php
                                                echo '</div>';
                                                echo '<button id="selected-search-ad" class="button delete-search">'.__('Delete Selected', 'framework').'</button>';
                                            } else
                                            { ?>
                                                <p><?php echo esc_attr_e('You don\'t have any saved searches in your dashboard', 'adaptable-child'); ?></p>
                                            </div>
                                            <?php } ?>
                                        </div>
                                        <?php
                                    }

                                    if (get_query_var('plans') == 1)
                                    {
                                        $plans = get_post_meta($user_info_id, 'imic_user_all_plans', false);
                                        $plans = array_unique($plans); ?>
                                        <div id="plans-section" class="dashboard-block">
                                            <div class="dashboard-block-head">
                                                <h3><?php echo esc_attr_e('My Payment Plans', 'adaptable-child'); ?></h3>
                                                <?php
                                                    // <p>echo __('Plans you have subscribed to are listed below, If you want to add more listings you can click the <strong>refresh</strong> symbol below and proceed to payment', 'adaptable-child');</p>
                                                    // <p>echo __('Alternatively you can select the "+" button and proceed to adding a new listing!', 'adaptable-child');</p>
                                                ?>
                                            </div>

                                            <div class="table-responsive">
                                                <?php if (!empty($plans))
                                                { ?>
                                                    <table id="search-cars-table" class="table table-bordered dashboard-tables saved-searches-table">
                                                        <thead>
                                                            <tr>
                                                                <td><?php echo esc_attr_e('Plan name', 'adaptable-child'); ?></td>
                                                                <td><?php echo esc_attr_e('Balance Listings', 'adaptable-child'); ?></td>
                                                                <td><?php echo esc_attr_e('Plan Expires', 'adaptable-child'); ?></td>
                                                                <td><?php echo esc_attr_e('Actions', 'adaptable-child'); ?></td>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php $count = $search_four = 1;
                                                            if (!empty($plans))
                                                            {
                                                                foreach ($plans as $plan)
                                                                {
                                                                    if (get_post_type($plan) == 'plan')
                                                                    {
                                                                        $plan_data = get_post_meta($user_info_id, 'imic_user_plan_'.$plan, true);
                                                                        $allowed_listings = get_post_meta($user_info_id, 'imic_allowed_listings_'.$plan, true);
                                                                        $label_allow_listings = ($allowed_listings > 1) ? __(' Listings', 'framework') : __(' Listing', 'adaptable-child');
                                                                        $plan_validity = get_post_meta($plan, 'imic_plan_validity', true);

                                                                        switch ($plan_validity) {
                                                                            case 'day':
                                                                                $plan_validity_number = get_post_meta($plan, 'imic_plan_validity_days', true);
                                                                                break;
                                                                            case 'week':
                                                                                $plan_validity_number = get_post_meta($plan, 'imic_plan_validity_weeks', true);
                                                                                break;
                                                                            case 'month':
                                                                                $plan_validity_number = get_post_meta($plan, 'imic_plan_validity_months', true);
                                                                                break;
                                                                        }

                                                                        $valid_with_plan = get_post_meta($plan, 'imic_plan_validity_expire_listing', true);

                                                                        if (!empty($plan_data))
                                                                        {
                                                                            foreach ($plan_data as $key => $value)
                                                                            {
                                                                                $start_date = date('Y-m-d', $key);
                                                                                $end_date = strtotime(date('Y-m-d', strtotime($start_date)).' +'.$plan_validity_number.' '.$plan_validity);
                                                                                echo '<tr>
                                                                                    <td><strong>'.esc_attr(get_the_title($plan)).'</strong></td>
                                                                                    <td>'.esc_attr($allowed_listings).$label_allow_listings.'</td>
                                                                                    <td>'.esc_attr(date_i18n(get_option('date_format'), $end_date)).'</td>
                                                                                    <td align="center">
                                                                                        <a href="'.esc_url(add_query_arg('plans', $plan, $listing_url)).'" class="text-success" title="'.__('Add Listing', 'framework').'">
                                                                                            <i class="fa fa-plus"></i>
                                                                                        </a>
                                                                                        &nbsp;
                                                                                        <a data-toggle="modal" data-target="#'.$plan.'-PaypalModal" href="" class="text-success" title="'.__('Renew Plan', 'framework').'">
                                                                                        <i class="fa fa-refresh"></i>
                                                                                        </a>
                                                                                    </td>
                                                                                </tr>';

                                                                                $plan_price = get_post_meta($plan, 'imic_plan_price', true);
                                                                                $paypal_currency = $imic_options['paypal_currency'];
                                                                                $paypal_email = $imic_options['paypal_email'];
                                                                                $paypal_site = $imic_options['paypal_site'];
                                                                                global $current_user;
                                                                                get_currentuserinfo();
                                                                                $user_id = get_current_user_id();
                                                                                $current_user = wp_get_current_user();
                                                                                $user_info_id = get_user_meta($user_id, 'imic_user_info_id', true);
                                                                                $thanks_url = imic_get_template_url('template-thanks.php');
                                                                                $paypal_site = ($paypal_site == '1') ? 'https://www.paypal.com/cgi-bin/webscr' : 'https://www.sandbox.paypal.com/cgi-bin/webscr';

                                                                                echo '<div id="'.$plan.'-PaypalModal" class="modal fade" aria-hidden="true" aria-labelledby="mymodalLabel" role="dialog" tabindex="-1">
                                                                                    <div class="modal-dialog">
                                                                                        <div class="modal-content">
                                                                                            <div class="modal-header">
                                                                                                <button class="close" aria-hidden="true" data-dismiss="modal" type="button">'.esc_attr__('×', 'framework').'</button>
                                                                                                <h4 id="mymodalLabel" class="modal-title">'.esc_attr__('Payment Information', 'framework').'</h4>
                                                                                            </div>

                                                                                            <div class="modal-body">
                                                                                                <form method="post" id="planpaypalform" name="planpaypalform" class="clearfix" action="'.esc_url($paypal_site).'">
                                                                                                    <div class="row">
                                                                                                        <div class="col-md-6">
                                                                                                            <div class="form-group">
                                                                                                                <input type="text" value="'.get_the_title($user_info_id).'" id="paypal-title" disabled name="First Name"  class="form-control input-lg" placeholder="'.__('Name', 'framework').'*">
                                                                                                            </div>
                                                                                                        </div>
                                                                                                        <div class="col-md-6">
                                                                                                            <div class="form-group">
                                                                                                                <input type="text" value="'.$current_user->user_email.'" id="paypal-email" disabled name="email"  class="form-control input-lg" placeholder="'.__('Email', 'framework').'*">
                                                                                                            </div>
                                                                                                        </div>

                                                                                                        <div class="col-md-12">
                                                                                                            <div class="form-group">
                                                                                                                <div id="messages"></div>
                                                                                                            </div>
                                                                                                        </div>

                                                                                                        <input type="hidden" name="rm" value="2">
                                                                                                        <input type="hidden" name="amount" value="'.esc_attr($plan_price).'">
                                                                                                        <input type="hidden" name="cmd" value="_xclick">
                                                                                                        <input type="hidden" name="business" value="'.esc_attr($paypal_email).'">
                                                                                                        <input type="hidden" name="currency_code" value="'.esc_attr($paypal_currency).'">
                                                                                                        <input type="hidden" name="item_name" value="'.get_the_title($plan).'">
                                                                                                        <input type="hidden" name="item_number" value="'.esc_attr($plan).'">
                                                                                                        <input type="hidden" name="return" value="'.esc_url($thanks_url).'" />
                                                                                                        <div class="col-md-12">
                                                                                                            <div class="form-group">
                                                                                                                <input id="paypal-plan" name="submit" type="submit" class="button" value="'.__('Proceed to Payment', 'framework').'">
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </form>
                                                                                            </div>
                                                                                            <div class="modal-footer"></div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>';
                                                                            }
                                                                        }
                                                                    }
                                                                }
                                                            } ?>
                                                        </tbody>
                                                    </table><?php
                                                echo '</div>';
                                            } else
                                            { ?>
                                                <p><?php echo esc_attr_e('You don\'t have any subscribed plans.', 'adaptable-child');?></p>
                                            </div>
                                        <?php } ?>
                                    </div>
                                <?php }


if (get_query_var('profile') == 1) {
    $msg = $msg_update = '';
    $othertextonomies = $city_type_value = '';
    if ('POST' == $_SERVER['REQUEST_METHOD']) {
        require_once ABSPATH.'wp-admin/includes/user.php';
        //check_admin_referer('update-profile_' . $user_id);

        $errors          = edit_user($user_id);
        $first_name      = ($_POST['first-name']);
        $last_name       = esc_sql(trim($_POST['last-name']));
        $user_phone      = esc_sql(trim($_POST['user-phone']));
        $user_zip        = esc_sql(trim($_POST['user-zip']));
        $user_city       = esc_sql(trim($_POST['user-city']));
        $user_old_pass   = esc_sql(trim($_POST['user-pass']));
        $new_pass1       = esc_sql(trim($_POST['user-new-pass1']));
        $new_pass2       = esc_sql(trim($_POST['user-new-pass2']));
        $facebook        = esc_sql(trim($_POST['user-facebook']));
        $twitter         = esc_sql(trim($_POST['user-twitter']));
        $snapchat        = esc_sql(trim($_POST['user-snapchat']));
        $instagram       = esc_sql(trim($_POST['user-instagram']));
        $user_country    = esc_sql(trim($_POST['user-country']));
        $company_name    = esc_sql(trim($_POST['company-name']));
        $company_tagline = esc_sql(trim($_POST['company-tagline']));
        $company_url     = esc_sql(trim($_POST['website-url']));
        $dealer_content  = esc_sql(trim($_POST['dealer_content']));
        $billing_name = $_POST['user-billing-name'];
        $billing_address = $_POST['user-billing-address'];

        if ($first_name != '') {
            $ss = wp_update_user(array('ID' => $user_id, 'first_name' => $first_name, 'last_name' => $last_name));
        }

        if (file_exists($_FILES['bannerimage']['tmp_name']) || is_uploaded_file($_FILES['bannerimage']['tmp_name'])) {
            $newupload = imic_sight('bannerimage', $user_info_id);
            update_post_meta($user_info_id, 'imic_user_logo', $newupload);
        }
        if (file_exists($_FILES['userimage']['tmp_name']) || is_uploaded_file($_FILES['userimage']['tmp_name'])) {
            $newupload1 = imic_sight('userimage', $user_info_id);
            update_post_meta($user_info_id, '_thumbnail_id', $newupload1);
        }

        if (empty($first_name)) {
            $msg .= __('Please fill first name', 'framework')."\r\n";
        }

        if (empty($user_zip) || empty($user_city)) {
            $msg .= __('Please fill in your billing information', 'framework')."\r\n";
        }

        if ($msg == '') {
            wp_set_object_terms($user_info_id, $user_country, 'user-country');
            update_post_meta($user_info_id, 'imic_user_zip_code', $user_zip);
            update_post_meta($user_info_id, 'imic_user_city', $user_city);
            update_post_meta($user_info_id, 'imic_user_billing_name', $billing_name);
            update_post_meta($user_info_id, 'imic_user_billing_address', $billing_address);
            update_post_meta($user_info_id, 'imic_user_country', $user_country);
            update_post_meta($user_info_id, 'imic_user_telephone', $user_phone);
            update_post_meta($user_info_id, 'imic_user_company', $company_name);
            update_post_meta($user_info_id, 'imic_user_company_tagline', $company_tagline);
            update_post_meta($user_info_id, 'imic_user_website', $company_url);
            update_post_meta($user_info_id, 'imic_user_facebook', $facebook);
            update_post_meta($user_info_id, 'imic_user_twitter', $twitter);
            update_post_meta($user_info_id, 'imic_user_instagram', $instagram);
            update_post_meta($user_info_id, 'imic_user_snapchat', $snapchat);
            $dealer_post_content = array(
                'ID' => $user_info_id,
                'post_content' => $dealer_content,
            );



            wp_update_post($dealer_post_content);
            $user = get_user_by('login', $current_user->user_login);
            if ($user && wp_check_password($user_old_pass, $user->data->user_pass, $user->ID)) {
                if ($new_pass1 == $new_pass2) {
                    $msg_update .= __('Profile Updated Successfully', 'adaptable-child');
                    wp_set_password($new_pass1, $user->ID);
                } else {
                    $msg .= __('Please confirm password again', 'adaptable-child');
                }
            }
        }
        if ($msg == '') {
            $msg_update .=  __('Profile Updated Successfully', 'adaptable-child');
        }
    } ?>
    <h2><?php echo esc_attr_e($adpProfileTabText, 'adaptable-child'); ?></h2>
    <div class="dashboard-block">
        <?php if ($msg != '') { ?>
            <div id="message">
                <div class="alert alert-error"><?php echo esc_attr($msg); ?></div>
            </div>
        <?php } elseif ($msg_update != '') { ?>
            <div id="message">
                <div class="alert alert-success"><?php echo esc_attr($msg_update); ?></div>
            </div>
        <?php } ?>


        <?php
        // Profile Tabs
        include(locate_template('includes/template-parts/dashboard/profile-tabs.php')); ?>

    </div>
<?php }

if (get_query_var('account') == 1) { ?>

<?php get_header();
        global $imic_options;

        $id = (is_home()) ? $id = get_option('page_for_posts') : get_the_ID();
        include('includes/billboard/billboard.php');

        if (is_plugin_active('imithemes-listing/listing.php')) {
            $compare_url = imic_get_template_url('template-compare.php');
            $pageSidebar2 = get_post_meta(get_the_ID(), 'imic_select_sidebar_from_list2', true);
            if (!empty($pageSidebar2) && is_active_sidebar($pageSidebar2)) {
                $class2 = 9;
            } else {
                $class2 = 12;
            }
            $required_value = $total_ads = $st = '';
            global $current_user;

            $user_id = get_current_user_id();
            $user_info_id = get_user_meta($user_id, 'imic_user_info_id', true);
            $user_name = get_the_title($user_info_id);
            $saved_cars = get_post_meta($user_info_id, 'imic_user_saved_cars', true);
            $saved_search = get_post_meta($user_info_id, 'imic_user_saved_search', true);
            $listing_url = imic_get_template_url('template-add-listing.php');
            $args_cars = array('post_type' => 'cars', 'author' => $current_user->ID, 'posts_per_page' => -1, 'post_status' => array('publish', 'draft'));
            $cars_listing = new WP_Query($args_cars);
            if ($cars_listing->have_posts()) :
                while ($cars_listing->have_posts()) :
                    $cars_listing->the_post();
                    $total_ads = $cars_listing->post_count;
                endwhile;
            endif;
            wp_reset_postdata();
            //$ads_count = ($_SERVER['QUERY_STRING']=='')?1:-1;
            $browse_specification_switch = get_post_meta(get_the_ID(), 'imic_browse_by_specification_switch', true);
            $browse_listing = imic_get_template_url('template-listing.php');
            if ($browse_specification_switch == 1) {
                get_template_part('bar', 'one');
            } elseif ($browse_specification_switch == 2) {
                get_template_part('bar', 'two');
            } elseif ($browse_specification_switch == 3) {
                get_template_part('bar', 'saved');
            }
            if ($browse_specification_switch == 4) {
                get_template_part('bar', 'category');
            }
            ?>
<?php
$vehicle = esc_attr(get_query_var('edit'));
            $listing_status = (isset($imic_options['opt_listing_status'])) ? $imic_options['opt_listing_status'] : '';
            $payment_status = ($listing_status == 'draft') ? '4' : '1';
            update_post_meta($vehicle, 'imic_plugin_ads_steps', 5);
            update_post_meta($vehicle, 'imic_plugin_ad_payment_status', $payment_status);
            $opt_plans = $imic_options['opt_plans'];
            $payment_gross = 'free';
            $eligible_listing = '';
            $plans = esc_attr(get_query_var('plans'));
            $listing_end_status = get_post_meta($plans, 'imic_days_periodic_listing', true);
            $listing_end_status = ($listing_end_status != '') ? $listing_end_status : 500;
            $listing_date = date('Y-m-d', strtotime('+'.$listing_end_status.' days'));
            $plan_type = get_post_meta($plans, 'imic_plan_validity', true);
            $user_plan = get_post_meta($user_info_id, 'imic_user_all_plans', false);
            $user_plan = ($user_plan != '') ? $user_plan : array();
            $plan_listings_count = get_post_meta($plans, 'imic_plan_validity_listings', true);
            $all_plans_user = get_post_meta($user_info_id, 'imic_user_plan_'.$plans, true);
            $plan_new_price = get_post_meta($plans, 'imic_plan_price', true);
            if ($plan_new_price == '' || $plan_new_price == 'free') {
                if (!empty($all_plans_user)) {
                    foreach ($all_plans_user as $key => $value) {
                        $data[date('U')] = $value;
                    }
                } else {
                    $data[date('U')] = '';
                }
                $allowed_listings = get_post_meta($user_info_id, 'imic_allowed_listings_'.$plans, true);
                $updated_allowed_listings = $allowed_listings + $plan_listings_count;
                $user_all_plans = get_post_meta($user_info_id, 'imic_user_all_plans', false);
                if ($updated_allowed_listings <= 0) {
                    update_post_meta($user_info_id, 'imic_user_plan_'.$plans, $data);
                    update_post_meta($user_info_id, 'imic_allowed_listings_'.$plans, $updated_allowed_listings - 1);
                    if (!in_array($plans, $user_all_plans)) {
                        add_post_meta($user_info_id, 'imic_user_all_plans', $plans, false);
                    }
                }
            }
            if (in_array($plans, $user_plan)) {
                $selected_plan = get_post_meta($user_info_id, 'imic_user_plan_'.$plans, true);
                $selected_plan_listings = get_post_meta($user_info_id, 'imic_allowed_listings_'.$plans, true);
                if (!empty($selected_plan)) {
                    foreach ($selected_plan as $key => $value) {
                        $listing_ids = $value;
                        $listings_plan = explode(',', $listing_ids);
                    }
                }
                if ($selected_plan_listings > 0 || in_array($vehicle, $listings_plan)) {
                    if (!empty($selected_plan)) {
                        foreach ($selected_plan as $key => $value) {
                            switch ($plan_type) {
case 'day':
$plan_validity_number = get_post_meta($plans, 'imic_plan_validity_days', true);
break;
case 'week':
$plan_validity_number = get_post_meta($plans, 'imic_plan_validity_weeks', true);
break;
case 'month':
$plan_validity_number = get_post_meta($plans, 'imic_plan_validity_months', true);
break;
}
                            $valid_with_plan = get_post_meta($plans, 'imic_plan_validity_expire_listing', true);
                            if ($valid_with_plan == 1) {
                                $start_date = date('Y-m-d', $key);
                                $listing_date = strtotime(date('Y-m-d', strtotime($start_date)).' +'.$plan_validity_number.' '.$plan_type);
                                $listing_date = date('Y-m-d', $listing_date);
                            }
                            if ($listing_date > date('Y-m-d')) {
                                $eligible_listing = 1;
                            }
                        }
                    }
                }
            }
            $payment = '';
            if ($opt_plans == 1) {
                $transaction_id = isset($_REQUEST['tx']) ? esc_attr($_REQUEST['tx']) : date('U');
                if ($transaction_id != '' && $vehicle != '' && $transaction_id != $vehicle * 4) {
                    $paypal_details = imic_validate_payment($transaction_id);
//Code to update plan information for user
//Added next to v1.6
//Start
if ($plan_type != '0') {
    $plan_id = isset($_REQUEST['item_number']) ? esc_attr($_REQUEST['item_number']) : '';
    $plan_id = ($plan_id != '') ? $plan_id : get_query_var('plans');
    $post_type = get_post_type($plan_id);
    $plan_price = '';
    if ($post_type == 'plan') {
        $plan_price = get_post_meta($plan_id, 'imic_plan_price', true);
        $payment = $plan_price;
        $plan_price = floor($plan_price);
        $plan_listings_count = get_post_meta($plan_id, 'imic_plan_validity_listings', true);
        $plan_listings_count = esc_attr($plan_listings_count);
    }
    if (!empty($paypal_details)) {
        $st = $paypal_details['payment_status'];
        $payment_gross = $paypal_details['payment_gross'];
        $payment = floor($payment_gross);
    }
    $confirm = ($plan_price == $payment) ? 1 : '';
    $st = ($confirm == 1) ? $st : __('Not Verified', 'adaptable-child');
    $data = array();
    if ($confirm == 1) {
        $all_plans_user = get_post_meta($user_info_id, 'imic_user_plan_'.$plan_id, true);
        if (!empty($all_plans_user)) {
            foreach ($all_plans_user as $key => $value) {
                $data[date('U')] = $value.','.$vehicle;
            }
        } else {
            $data[date('U')] = $vehicle.',';
        }
        $last_transaction_id = get_post_meta($user_info_id, 'imic_user_tr_id', false);
        $allowed_listings = get_post_meta($user_info_id, 'imic_allowed_listings_'.$plan_id, true);
        $allowed_listings = ($allowed_listings >= 0) ? $allowed_listings : 0;
        $updated_allowed_listings = $allowed_listings + $plan_listings_count;
        $user_all_plans = get_post_meta($user_info_id, 'imic_user_all_plans', false);
        if (!in_array($transaction_id, $last_transaction_id)) {
            update_post_meta($user_info_id, 'imic_user_plan_'.$plan_id, $data);
            update_post_meta($user_info_id, 'imic_allowed_listings_'.$plan_id, $updated_allowed_listings - 1);
            add_post_meta($user_info_id, 'imic_user_tr_id', $transaction_id, false);
            if (!in_array($plan_id, $user_all_plans)) {
                add_post_meta($user_info_id, 'imic_user_all_plans', $plan_id, false);
            }
        }
    }
}
//End
if (!empty($paypal_details)) {
    $st = $paypal_details['payment_status'];
    $payment_gross = $paypal_details['payment_gross'];
    if ($st == 'Completed') {
        if ($payment_status == '1') {
            update_post_meta($vehicle, 'imic_plugin_ads_steps', 5);
        }
        update_post_meta($vehicle, 'imic_plugin_ad_payment_status', $payment_status);
        update_post_meta($vehicle, 'imic_plugin_paid_price', $payment_gross);
    }
}
                    update_post_meta($vehicle, 'imic_plugin_car_plan', $plans);
                    update_post_meta($vehicle, 'imic_plugin_listing_end_dt', $listing_date);
                }
                $plan_price = get_post_meta($plans, 'imic_plan_price', true);
                if ($plan_price == 'free' || $plan_price == '') {
                    $st = 'free';
                    if ($payment_status == '1') {
                        update_post_meta($vehicle, 'imic_plugin_ads_steps', 5);
                    }
                    update_post_meta($vehicle, 'imic_plugin_ad_payment_status', $payment_status);
                    update_post_meta($vehicle, 'imic_plugin_paid_price', $payment_gross);
                    update_post_meta($vehicle, 'imic_plugin_car_plan', $plans);
                    update_post_meta($vehicle, 'imic_plugin_listing_end_dt', $listing_date);
                }
                if ($eligible_listing == 1) {
                    update_post_meta($vehicle, 'imic_plugin_listing_end_dt', $listing_date);
                }
            } else {
                $st = 'free';
                if ($payment_status == '1') {
                    update_post_meta($vehicle, 'imic_plugin_ads_steps', 5);
                }
                update_post_meta($vehicle, 'imic_plugin_ad_payment_status', $payment_status);
                update_post_meta($vehicle, 'imic_plugin_paid_price', '');
                update_post_meta($vehicle, 'imic_plugin_car_plan', 'N/A');
                update_post_meta($vehicle, 'imic_plugin_listing_end_dt', $listing_date);
            }
            $specification_type = (isset($imic_options['short_specifications'])) ? $imic_options['short_specifications'] : '0'; ?>

<!-- Start Body Content -->
<div class="main" role="main">
<div id="content" class="content full dashboard-pages">
<div class="container">
<div class="dashboard-wrapper">
<div class="row">

<?php if (!is_user_logged_in()) {
    echo '<div class="col-md-12 col-sm-12">';
    echo '<p>'.__('Login or Register to access this page', 'framework').'</p>';
    echo '<a class="button" data-toggle="modal" data-target="#PaymentModal">'.__('Login/Register', 'framework').'</a>';
    echo '</div>';
} else {
    ?>
<div class="col-md-3 users-sidebar-wrapper">
<!-- SIDEBAR tbssticky -->
<div class="users-sidebar">
    <a href="<?php echo esc_url($listing_url);?>" class="button add-listing-btn"><?php echo esc_attr_e('New Ad listing', 'adaptable-child'); ?></a>
    <ul class="list-group">
        <li class="list-group-item <?php if ($_SERVER['QUERY_STRING'] == '') { echo 'active'; } ?>">
            <a href="<?php echo get_permalink(); ?>">
                <?php echo esc_attr_e('Dashboard', 'adaptable-child'); ?>
            </a>
        </li>

        <?php if (!empty($saved_search)) { ?>
            <li class="list-group-item <?php if (get_query_var('search') == 1) { echo 'active'; } ?>">
                <span class="badge"><?php echo count($saved_search); ?></span>
                <a href="<?php echo esc_url(add_query_arg('search', 1, get_permalink())); ?>">
                    <?php echo esc_attr_e('Saved Searches', 'adaptable-child'); ?>
                </a>
            </li>
        <?php }

        if (!empty($saved_cars)) { ?>
            <li class="list-group-item <?php if (get_query_var('saved') == 1) { echo 'active'; } ?>">
                <span class="badge"><?php echo count($saved_cars); ?></span>
                <a href="<?php echo esc_url(add_query_arg('saved', 1, get_permalink())); ?>">
                    <?php echo esc_attr_e('Saved Cars', 'adaptable-child'); ?>
                </a>
            </li><?php
        } ?>

        <li class="list-group-item">
            <a href="<?php echo esc_url($listing_url); ?>">
                <?php echo esc_attr_e('Create new Ad', 'adaptable-child'); ?>
            </a>
        </li>

        <?php if ($total_ads != '') { ?>
            <li class="list-group-item <?php if (get_query_var('manage') == 1) { echo 'active'; } ?>">
                <span class="badge"><?php echo esc_attr($total_ads); ?></span>
                <a href="<?php echo esc_url(add_query_arg('manage', 1, get_permalink())); ?>">
                    <?php echo esc_attr_e('Manage Ads', 'adaptable-child'); ?>
                </a>
            </li>
        <?php } ?>

        <li class="list-group-item <?php if (get_query_var('plans') == 1) { echo 'active'; } ?>">
            <a href="<?php echo esc_url(add_query_arg('plans', 1, get_permalink())); ?>">
                <?php echo esc_attr_e('My Payment Plans', 'adaptable-child'); ?>
            </a>
        </li>

        <li class="list-group-item <?php if (get_query_var('profile') == 1) { echo 'active'; } ?>">
            <a href="<?php echo esc_url(add_query_arg('profile', 1, get_permalink())); ?>">
                <?php echo esc_attr_e($adpProfileTabText, 'adaptable-child'); ?>
            </a>
        </li>

        <!--<li class="list-group-item <?php if (get_query_var('account') == 1) { echo 'active'; } ?>">
            <a href="<?php echo esc_url(add_query_arg('account', 1, get_permalink())); ?>">
                <?php echo esc_attr_e('Account Settings', 'adaptable-child');?>
            </a>
        </li>-->

        <li class="list-group-item">
            <a href="<?php echo wp_logout_url(home_url()); ?>">
                <?php echo esc_attr_e('Log Out', 'adaptable-child'); ?>
            </a>
        </li>
    </ul>
</div>
</div>
<div class="col-md-9">
<?php if (($st == 'Completed' || $st == 'free') && ($vehicle != '')) {
    echo '<div class="alert alert-success fade in">
<a class="close" href="#" data-dismiss="alert">×</a>
<strong>Well done!</strong>
'.__('Thanks for submiting your listing. You can visit dashboard for further reference', 'framework').'
</div> ';
//Email properties
$success_msg = $imic_options['payment_success_mail'];
    $listing_contact_email = '';
    $admin_mail_to = ($listing_contact_email == '') ? get_option('admin_email') : $listing_contact_email;
    $mail_subject = $user_name.__('successfully added listing.', 'adaptable-child');
    $admin_mail_content = '<p>'.$user_name.__(' has added Ad listing.', 'framework').'</p>';
    $admin_mail_content .= '<p>'.__('Name: ', 'framework').$user_name.'</p>';
    $admin_mail_content .= '<p>'.__('Email: ', 'framework').$current_user->user_email.'</p>';
    $admin_mail_content .= '<p>'.__('Ad: ', 'framework').get_permalink($vehicle).'</p>';
    $admin_msg = wordwrap($admin_mail_content, 70);
    $admin_headers = "From: $current_user->user_email".PHP_EOL;
    $admin_headers .= "Reply-To: $current_user->user_email".PHP_EOL;
    $admin_headers .= 'MIME-Version: 1.0'.PHP_EOL;
    $admin_headers .= "Content-Type: text/html; charset=\"iso-8859-1\"\n";
    $dealer_headers = "From: $admin_mail_to".PHP_EOL;
    $dealer_headers .= "Reply-To: $admin_mail_to".PHP_EOL;
    $dealer_headers .= 'MIME-Version: 1.0'.PHP_EOL;
    $dealer_headers .= "Content-Type: text/html; charset=\"iso-8859-1\"\n";
    @mail($admin_mail_to, $mail_subject, $admin_msg, $admin_headers);
    @mail($current_user->user_email, $mail_subject, $success_msg, $dealer_headers);
}
    if ((esc_attr(get_query_var('search')) != 1) && (esc_attr(get_query_var('saved')) != 1) && (esc_attr(get_query_var('profile')) != 1) && (esc_attr(get_query_var('account')) != 1) && (esc_attr(get_query_var('plans')) != 1)) {
        echo '<h2>'.__('Dashboard', 'framework').'</h2>';
        if (have_posts()): while (have_posts()):the_post();
        the_content();
        endwhile;
        endif;
        $additional_specs = $imic_options['unique_specs'];
        $detailed_title = $imic_options['highlighted_specs'];
        $ads_count = (get_query_var('manage') != 1) ? 1 : -1;
        $args_cars = array('post_type' => 'cars', 'author' => $user_id, 'posts_per_page' => $ads_count, 'post_status' => array('publish', 'draft'));
        $cars_listing = new WP_Query($args_cars);
        if ($cars_listing->have_posts()) : ?>
<div id="ads-section" class="dashboard-block">
<div class="dashboard-block-head"><?php if (($total_ads > 1) && (esc_attr(get_query_var('manage')) != 1) && (esc_attr(get_query_var('plans')) != 1)) {
    ?>
<a href="<?php echo esc_url(add_query_arg('manage', '1', get_permalink()));
    ?>" class="button pull-right"><?php echo esc_attr_e('See all Ads ', 'adaptable-child');
    echo '('.$total_ads.')';
    ?></a><?php
}
        ?>
<h3><?php echo esc_attr_e('My Ad Listings', 'adaptable-child');
        ?></h3>
</div>
<div class="table-responsive">
    <table class="table table-bordered dashboard-tables saved-cars-table">
        <thead>
            <tr>
                <td>&nbsp;</td>
                <td><?php echo esc_attr_e('Description', 'adaptable-child'); ?></td>
                <td><?php echo esc_attr_e('Price/Status', 'adaptable-child'); ?></td>
                <td><?php echo esc_attr_e('Created On', 'adaptable-child'); ?></td>
                <td><?php echo esc_attr_e('Payment', 'adaptable-child'); ?></td>
                <!--<td><?php echo esc_attr_e('Actions', 'adaptable-child'); ?></td>-->
            </tr>
        </thead>
        <tbody>
            <?php while ($cars_listing->have_posts()) :
            $cars_listing->the_post();
                    $last_term = get_last_child_term_id(get_the_ID(), 'listing-category', true);
                    $plan_id = get_post_meta(get_the_ID(), 'imic_plugin_car_plan', true);
                    $statuses = get_post_meta(get_the_ID(), 'imic_plugin_ad_payment_status', true);
                    $status = '';

                    if ($statuses == 1) {
                        $status = __('Active', 'adaptable-child');
                        $label = 'success';
                    } elseif ($statuses == 2) {
                        $status = __('Sold', 'adaptable-child');
                        $label = 'primary';
                    } elseif ($statuses == 3) {
                        $status = __('Inactive', 'adaptable-child');
                        $label = 'primary';
                    } elseif ($statuses == 4 || $statuses == 0) {
                        $status = __('Under Review', 'adaptable-child');
                        $label = 'info';
                    }
                    $specifications = get_post_meta(get_the_ID(), 'feat_data', true);
                    $default_image_vehicle = (isset($imic_options['default_car_image'])) ? $imic_options['default_car_image'] : array('url' => '');
                    if ($specification_type == 0) {
                        $detailed_specs = (isset($imic_options['vehicle_specs'])) ? $imic_options['vehicle_specs'] : array();
                    } else {
                        $detailed_specs = array();
                    }
                    $detailed_specs = imic_filter_lang_specs($detailed_specs);
                    if (is_plugin_active('imi-classifieds/imi-classified.php')) {
                        $detailed_specs = imic_classified_short_specs(get_the_ID(), $detailed_specs);
                    }

                    $details_value = imic_vehicle_all_specs(get_the_ID(), $detailed_specs, $specifications);

                    // Get the vehicle price as JUST a numerical value
                    $vehicle_numeric_price = preg_replace("/[^0-9]/", "", imic_vehicle_price(get_the_ID(), $additional_specs, $specifications));

                    // Convert price dependent on what the user has selected or default which is GBP
                    $vehicle_converted_price = convert_currency($vehicle_numeric_price, $from = 'GBP', $in = $currentCurrency);

                    // Format the currency price
                    $vehicle_formatted_price = format_currency($vehicle_converted_price, $currentCurrency, true) ;

                    // The complete price which checks if the format price is empty
                    $vehicle_complete_price = !empty($vehicle_formatted_price) ? $vehicle_formatted_price : 'TBC';

                    $new_highlighted_specs = imic_filter_lang_specs_admin($detailed_title, get_the_ID());
                    $detailed_title = $new_highlighted_specs;
                    $title = imic_vehicle_title(get_the_ID(), $detailed_title, $specifications);
                    $title = ($title == '') ? get_the_title() : $title;
                    if ($plan_id != '' && $last_term != '') {
                        $edit_url = array('edit' => get_the_ID(), 'plans' => $plan_id, 'list-cat' => $last_term);
                    } elseif ($plan_id == '' && $last_term != '') {
                        $edit_url = array('edit' => get_the_ID(), 'list-cat' => $last_term);
                    } elseif ($plan_id != '' && $last_term == '') {
                        $edit_url = array('edit' => get_the_ID(), 'plans' => $plan_id);
                    } else {
                        $edit_url = array('edit' => get_the_ID());
                    }
                    ?>
            <tr>
            <td align="center" valign="middle">
                <input id="<?php echo esc_attr(get_the_ID()); ?>" value="1" class="remove-ads" type="checkbox">
            </td>
            <td>
            <!-- Result -->
            <?php if (has_post_thumbnail()) {
                ?>
            <a href="<?php echo esc_url(add_query_arg($edit_url, $listing_url));
                ?>" class="car-image"><?php the_post_thumbnail();
                ?></a><?php
            } else {
                ?>
            <a href="<?php echo esc_url(add_query_arg($edit_url, $listing_url));
                ?>" class="car-image"><img src="<?php echo esc_url($default_image_vehicle['url']);
                ?>"></a><?php
            }
                    ?>
            <div class="search-find-results">
            <?php if ($statuses == 1) {
                ?>
            <h5><a href="<?php echo esc_url(get_permalink(get_the_ID()));
                ?>"><?php echo esc_attr($title);
                ?></a></h5>
            <?php
            } else {
                ?>
            <h5><?php echo esc_attr($title);
                ?></h5>
            <?php
            }
                    ?>
            <ul class="inline">
            <?php foreach ($details_value as $detail) {
                if ((!empty($detail)) && ($detail != 'select')) {
                    echo '<li>'.$detail.'</li>';
                }
            }
                    ?>
            </ul>
            </div>
            </td>
            <td align="center"><span class="price" data-price-conversion data-vehicle-price="<?php echo $vehicle_numeric_price; ?>"><?php echo esc_attr($vehicle_complete_price);?></span></td>
            <td>
                <?php
                    echo esc_attr(get_the_date(get_option('date_format')));
                    echo esc_attr_e(' @ ', 'adaptable-child');
                    echo esc_attr(get_the_date(get_option('time_format')));
                    ?>
            </td>
            <td align="center"><span id="ad-<?php echo esc_attr(get_the_ID());
                    ?>" class="label label-<?php echo esc_attr($label);
                    ?>"><?php echo esc_attr($status);
                    ?></span></td>
            </tr>
            <?php endwhile;
                    ?>
        </tbody>
    </table>
</div>
<button id="selected-ads" class="button delete-ads"><?php echo esc_attr_e('Delete Selected', 'adaptable-child');?></button>
</div>
<?php else: ?>
<div class="dashboard-block">
<div class="dashboard-block-head">
<h3><?php echo esc_attr_e('My Ad Listings', 'adaptable-child');
        ?></h3>
</div>
<div class="table-responsive">
<p><?php echo esc_attr_e('You have not created any Ads yet.', 'adaptable-child');
        ?></p>
</div>
</div>
<?php endif;
        wp_reset_postdata();
    }
    ?>
<?php if ((esc_attr(get_query_var('search')) != 1) && (esc_attr(get_query_var('manage')) != 1) && (esc_attr(get_query_var('profile')) != 1) && (esc_attr(get_query_var('account')) != 1) && (esc_attr(get_query_var('plans')) != 1)) {
    ?>
<div id="saved-cars-section" class="dashboard-block">
<div class="dashboard-block-head">
<?php if ((count($saved_cars) > 3) && (esc_attr(get_query_var('saved')) != 1)) {
    ?>
<a href="<?php echo esc_url(add_query_arg('saved', 1, get_permalink()));
    ?>" class="button pull-right"><?php echo esc_attr_e('See all cars ', 'adaptable-child');
    echo '('.count($saved_cars).')';
    ?></a><?php
}
    ?>
<h3><?php echo esc_attr_e('Saved Cars', 'adaptable-child');
    ?></h3>
</div>
<div class="table-responsive">
<?php if (!empty($saved_cars)) {
    ?>
<table id="saved-cars-table" class="table table-bordered dashboard-tables saved-cars-table saved-cars-box">
    <thead>
    <tr>
        <td>&nbsp;</td>
        <td><?php echo esc_attr_e('Description', 'adaptable-child'); ?></td>
        <td><?php echo esc_attr_e('Price/Status', 'adaptable-child'); ?></td>
        <td><?php echo esc_attr_e('Created On', 'adaptable-child'); ?></td>
        <!--<td><?php echo esc_attr_e('Actions', 'adaptable-child'); ?></td>-->
    </tr>
    </thead>
    <tbody>
    <?php $additional_specs = $imic_options['unique_specs'];
        if ($specification_type == 0) {
            $detailed_specs = (isset($imic_options['vehicle_specs'])) ? $imic_options['vehicle_specs'] : array();
        } else {
            $detailed_specs = array();
        }
        $detailed_title = $imic_options['highlighted_specs'];
        $saved_four = 1;
        foreach ($saved_cars as $save) {
            $specifications = get_post_meta($save[0], 'feat_data', true);
            $details_value = imic_vehicle_all_specs($save[0], $detailed_specs, $specifications);
            if (is_plugin_active('imi-classifieds/imi-classified.php')) {
                $details_value = imic_classified_short_specs($save, $details_value);
            }

            // Get the vehicle price as JUST a numerical value
            $vehicle_numeric_price = preg_replace("/[^0-9]/", "", imic_vehicle_price($save[0], $additional_specs, $specifications));

            // Convert price dependent on what the user has selected or default which is GBP
            $vehicle_converted_price = convert_currency($vehicle_numeric_price, $from = 'GBP', $in = $currentCurrency);

            // Format the currency price
            $vehicle_formatted_price = format_currency($vehicle_converted_price, $currentCurrency, true) ;

            // The complete price which checks if the format price is empty
            $vehicle_complete_price = !empty($vehicle_formatted_price) ? $vehicle_formatted_price : 'TBC';

            $new_highlighted_specs = imic_filter_lang_specs_admin($detailed_title, $save[0]);
            $detailed_title = $new_highlighted_specs;
            $title = imic_vehicle_title($save[0], $detailed_title, $specifications);
            ?>

            <tr>
                <td align="center" valign="middle" class="checkb">
                    <input id="saved-<?php echo esc_attr($save[0]); ?>" value="1" class="remove-saved compare-check" type="checkbox">
                </td>
                <td>
                    <a href="<?php echo esc_url(get_permalink($save[0]));?>" class="car-image">
                        <?php echo get_the_post_thumbnail($save[0]); ?>
                    </a>
                    <div class="search-find-results">
                        <h5>
                            <a href="<?php echo esc_url(get_permalink($save[0])); ?>"><?php echo esc_attr($title); ?></a>
                        </h5>
                        <ul class="inline">
                            <?php
                            foreach ($details_value as $detail) {
                                if (!empty($detail)) {
                                    echo '<li>'.$detail.'</li>';
                                }
                            }
                            ?>
                        </ul>
                    </div>
                </td>
                <td align="center">
                    <span class="price" data-price-conversion data-vehicle-price="<?php echo $vehicle_numeric_price; ?>"><?php echo esc_attr($vehicle_complete_price);?></span>
                </td>
                <td>
                    <span class="text-success"><?php echo esc_attr_e('Saved on', 'adaptable-child');?></span>
                        <?php
                        echo esc_attr(date(get_option('date_format'), $save[1]));
                        echo esc_attr_e(' @ ', 'adaptable-child');
                        echo esc_attr(date(get_option('time_format'), $save[1]));
                        ?>
                </td>
            </tr>
            <?php
            if (esc_attr(get_query_var('saved') != 1)) {
                if ($saved_four++ > 3) {
                    break;
                }
            }
        } ?>
    </tbody>
</table>
</div>
<button rel="selected-saved-ad" class="button delete-saved"><?php echo esc_attr_e('Delete Selected', 'adaptable-child');
    ?></button>
<a href="<?php echo esc_url($compare_url);
    ?>" id="compare-selected" class="button compare-in-box"><?php echo esc_attr_e('Compare', 'adaptable-child');
    ?></a><?php
} else {
    ?>
<p><?php echo esc_attr_e('You don\'t have any saved listing in your dashboard', 'adaptable-child');
    ?></p></div>
<?php
}
    ?>
</div>
<?php
}
    if ((esc_attr(get_query_var('manage')) != 1) && (esc_attr(get_query_var('saved')) != 1) && (esc_attr(get_query_var('profile')) != 1) && (esc_attr(get_query_var('account')) != 1) && (esc_attr(get_query_var('plans')) != 1)) {
        ?>
<div id="search-cars-section" class="dashboard-block">
<div class="dashboard-block-head"><?php if ((count($saved_search) > 3) && (esc_attr(get_query_var('search') != 1))) {
    ?>
<a href="<?php echo esc_url(add_query_arg('search', 1, get_permalink()));
    ?>" class="button pull-right"><?php echo esc_attr_e('See all searches ', 'adaptable-child');
    echo '('.count($saved_search).')';
    ?></a><?php
}
        ?>
<h3><?php echo esc_attr_e('Saved Searches', 'adaptable-child');
        ?></h3>
</div>
<div class="table-responsive">
    <?php if (!empty($saved_search)) { ?>
        <table id="search-cars-table" class="table table-bordered dashboard-tables saved-searches-table">
            <thead>
                <tr>
                    <td>&nbsp;</td>
                    <td><?php echo esc_attr_e('Custom search name', 'adaptable-child'); ?></td>
                    <td><?php echo esc_attr_e('Details', 'adaptable-child'); ?></td>
                    <!--<td><?php echo esc_attr_e('Receive alerts', 'adaptable-child'); ?></td>-->
                    <td><?php echo esc_attr_e('Created On', 'adaptable-child'); ?></td>
                </tr>
            </thead>
            <tbody>
                <?php $count = $search_four = 1;
                    foreach ($saved_search as $search) {
                        $res = preg_replace('/[^a-zA-Z]/', '', $search[0]);
                        ?>
                <tr>
                <td valign="middle"><input value="1" id="<?php echo esc_attr($res);
                        ?>" class="remove-search" type="checkbox"></td>
                <td><a href="<?php echo esc_url($search[2]);
                        ?>" class="search-name"><?php echo esc_attr($search[0]);
                        ?></a></td>
                <td><?php echo esc_attr($search[1]);
                        ?></td>
                <!--<td><a href="#"><select class="form-control selectpicker input-sm"><option>Enable</option><option>Disable</option></select></a></td>-->
                <td><span class="text-success"><?php echo esc_attr_e('Saved on', 'adaptable-child');
                        ?></span> <?php echo esc_attr(date(get_option('date_format'), $search[3]));
                        echo esc_attr_e(' @ ', 'adaptable-child');
                        echo esc_attr(date(get_option('time_format'), $search[3]));
                        ?></td>
                <?php ++$count;
                        if (esc_attr(get_query_var('search') != 1)) {
                            if ($search_four++ > 3) {
                                break;
                            }
                        }
                    }
                    ?>
            </tbody>
        </table><?php
    echo '</div>
    <button id="selected-search-ad" class="button delete-search">'.__('Delete Selected', 'framework').'</button>';
} else { ?>
    <p><?php echo esc_attr_e('You don\'t have any saved searches in your dashboard', 'adaptable-child');?></p>
    </div>
<?php } ?>
</div>
<?php
    }
    if (get_query_var('plans') == 1) {
        $plans = get_post_meta($user_info_id, 'imic_user_all_plans', false);
        $plans = array_unique($plans);
        ?>
<div id="plans-section" class="dashboard-block">
<div class="dashboard-block-head">
<h3><?php echo esc_attr_e('Plan Subscribed', 'adaptable-child');
        ?></h3>
</div>
<div class="table-responsive"><?php if (!empty($plans)) {
    ?>
<table id="search-cars-table" class="table table-bordered dashboard-tables saved-searches-table">
<thead>
<tr>
    <td><?php echo esc_attr_e('Plan name', 'adaptable-child'); ?></td>
    <td><?php echo esc_attr_e('Balace Listings', 'adaptable-child'); ?></td>
    <!--<td><?php echo esc_attr_e('Receive alerts', 'adaptable-child'); ?></td>-->
    <td><?php echo esc_attr_e('Created On', 'adaptable-child'); ?></td>
</tr>
</thead>
<tbody>
<?php $count = $search_four = 1;
    if (!empty($plans)) {
        foreach ($plans as $plan) {
            if (get_post_type($plan) == 'plan') {
                $plan_data = get_post_meta($user_info_id, 'imic_user_plan_'.$plan, true);
                $allowed_listings = get_post_meta($user_info_id, 'imic_allowed_listings_'.$plan, true);
                $label_allow_listings = ($allowed_listings > 1) ? __(' Listings', 'framework') : __(' Listing', 'adaptable-child');
                $plan_validity = get_post_meta($plan, 'imic_plan_validity', true);
                switch ($plan_validity) {
case 'day':
$plan_validity_number = get_post_meta($plan, 'imic_plan_validity_days', true);
break;
case 'week':
$plan_validity_number = get_post_meta($plan, 'imic_plan_validity_weeks', true);
break;
case 'month':
$plan_validity_number = get_post_meta($plan, 'imic_plan_validity_months', true);
break;
}
                $valid_with_plan = get_post_meta($plan, 'imic_plan_validity_expire_listing', true);
                if (!empty($plan_data)) {
                    foreach ($plan_data as $key => $value) {
                        $start_date = date('Y-m-d', $key);
                        $end_date = strtotime(date('Y-m-d', strtotime($start_date)).' +'.$plan_validity_number.' '.$plan_validity);
                        echo '<tr>
<td><a>'.esc_attr(get_the_title($plan)).'</a></td>
<td>'.esc_attr($allowed_listings).$label_allow_listings.'</td>
<td><span class="text-success">'.__('Expires on ', 'framework').'</span>'.esc_attr(date_i18n(get_option('date_format'), $end_date)).'</td>
<td align="center">
<a href="'.esc_url(add_query_arg('plans', $plan, $listing_url)).'" class="text-success" title="'.__('Add Listing', 'framework').'">
<i class="fa fa-plus"></i>
</a>
&nbsp;
<a data-toggle="modal" data-target="#'.$plan.'-PaypalModal" href="" class="text-success" title="'.__('Renew Plan', 'framework').'">
<i class="fa fa-refresh"></i>
</a>
</td>
</tr>';
                        $plan_price = get_post_meta($plan, 'imic_plan_price', true);
                        $paypal_currency = $imic_options['paypal_currency'];
                        $paypal_email = $imic_options['paypal_email'];
                        $paypal_site = $imic_options['paypal_site'];
                        global $current_user;
                        get_currentuserinfo();
                        $user_id = get_current_user_id();
                        $current_user = wp_get_current_user();
                        $user_info_id = get_user_meta($user_id, 'imic_user_info_id', true);
                        $thanks_url = imic_get_template_url('template-thanks.php');
                        $paypal_site = ($paypal_site == '1') ? 'https://www.paypal.com/cgi-bin/webscr' : 'https://www.sandbox.paypal.com/cgi-bin/webscr';
                        echo '<div id="'.$plan.'-PaypalModal" class="modal fade" aria-hidden="true" aria-labelledby="mymodalLabel" role="dialog" tabindex="-1">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<button class="close" aria-hidden="true" data-dismiss="modal" type="button">'.esc_attr__('×', 'framework').'</button>
<h4 id="mymodalLabel" class="modal-title">'.esc_attr__('Payment Information', 'framework').'</h4>
</div>
<div class="modal-body">
<form method="post" id="planpaypalform" name="planpaypalform" class="clearfix" action="'.esc_url($paypal_site).'">
<div class="row">
<div class="col-md-6">
<div class="form-group">
<input type="text" value="'.get_the_title($user_info_id).'" id="paypal-title" disabled name="First Name"  class="form-control input-lg" placeholder="'.__('Name', 'framework').'*">
</div>
</div>
<div class="col-md-6">
<div class="form-group">
<input type="text" value="'.$current_user->user_email.'" id="paypal-email" disabled name="email"  class="form-control input-lg" placeholder="'.__('Email', 'framework').'*">
</div>

</div>
<div class="col-md-12">
<div class="form-group">
<div id="messages"></div>
</div>

</div>
<input type="hidden" name="rm" value="2">
<input type="hidden" name="amount" value="'.esc_attr($plan_price).'">
<input type="hidden" name="cmd" value="_xclick">
<input type="hidden" name="business" value="'.esc_attr($paypal_email).'">
<input type="hidden" name="currency_code" value="'.esc_attr($paypal_currency).'">
<input type="hidden" name="item_name" value="'.get_the_title($plan).'">
<input type="hidden" name="item_number" value="'.esc_attr($plan).'">
<input type="hidden" name="return" value="'.esc_url($thanks_url).'" />
<div class="col-md-12">
<div class="form-group">
<input id="paypal-plan" name="submit" type="submit" class="button" value="'.__('Proceed to Payment', 'framework').'">
</div>
</div>
</div>
</form>
</div>
<div class="modal-footer">

</div>
</div>
</div>
</div>';
                    }
                }
            }
        }
    }
    ?>
</tbody>
</table><?php
echo '</div>';
} else {
    ?>
<p><?php echo esc_attr_e('You don\'t have any subscribed plans.', 'adaptable-child');
    ?></p></div><?php
}
        ?>

</div>
<?php
    }
    if (get_query_var('profile') == 1) {
        $msg = $msg_update = '';
        $othertextonomies = $city_type_value = '';
        if ('POST' == $_SERVER['REQUEST_METHOD']) {
            require_once ABSPATH.'wp-admin/includes/user.php';
            //check_admin_referer('update-profile_' . $user_id);

            $errors = edit_user($user_id);
            $first_name = ($_POST['first-name']);
            $last_name = esc_sql(trim($_POST['last-name']));
            $user_phone = esc_sql(trim($_POST['user-phone']));
            $user_zip = esc_sql(trim($_POST['user-zip']));
            $user_city = esc_sql(trim($_POST['user-city']));
            $user_old_pass = esc_sql(trim($_POST['user-pass']));
            $new_pass1 = esc_sql(trim($_POST['user-new-pass1']));
            $new_pass2 = esc_sql(trim($_POST['user-new-pass2']));
            $facebook = esc_sql(trim($_POST['user-facebook']));
            $twitter = esc_sql(trim($_POST['user-twitter']));
            $gplus = esc_sql(trim($_POST['user-gplus']));
            $ustate = esc_sql(trim($_POST['user-state']));
            $pinterest = esc_sql(trim($_POST['user-pinterest']));
            $company_name = esc_sql(trim($_POST['company-name']));
            $company_tagline = esc_sql(trim($_POST['company-tagline']));
            $company_url = esc_sql(trim($_POST['website-url']));
            $dealer_content = esc_sql(trim($_POST['dealer_content']));
            if ($first_name != '') {
                $ss = wp_update_user(array('ID' => $user_id, 'first_name' => $first_name, 'last_name' => $last_name));
            }
            if (empty($first_name)) {
                $msg .= __('Please fill first name', 'framework')."\r\n";
            }
            if (empty($user_zip)) {
                $msg .= __('Please fill in your billing information', 'framework')."\r\n";
            }
            if ($msg == '') {
                wp_set_object_terms($user_info_id, $ustate, 'user-city');
                if (file_exists($_FILES['bannerimage']['tmp_name']) || is_uploaded_file($_FILES['bannerimage']['tmp_name'])) {
                    $newupload = imic_sight('bannerimage', $user_info_id);
                    update_post_meta($user_info_id, 'imic_user_logo', $newupload);
                }
                if (file_exists($_FILES['userimage']['tmp_name']) || is_uploaded_file($_FILES['userimage']['tmp_name'])) {
                    $newupload1 = imic_sight('userimage', $user_info_id);
                    update_post_meta($user_info_id, '_thumbnail_id', $newupload1);
                }
                update_post_meta($user_info_id, 'imic_user_zip_code', $user_zip);
                update_post_meta($user_info_id, 'imic_user_city', $user_city);
                update_post_meta($user_info_id, 'imic_user_telephone', $user_phone);
                update_post_meta($user_info_id, 'imic_user_company', $company_name);
                update_post_meta($user_info_id, 'imic_user_company_tagline', $company_tagline);
                update_post_meta($user_info_id, 'imic_user_website', $company_url);
                update_post_meta($user_info_id, 'imic_user_facebook', $facebook);
                update_post_meta($user_info_id, 'imic_user_twitter', $twitter);
                update_post_meta($user_info_id, 'imic_user_gplus', $gplus);
                update_post_meta($user_info_id, 'imic_user_pinterest', $pinterest);
                $dealer_post_content = array(
                    'ID' => $user_info_id,
                    'post_content' => $dealer_content,
                );
                wp_update_post($dealer_post_content);
                $user = get_user_by('login', $current_user->user_login);
                if ($user && wp_check_password($user_old_pass, $user->data->user_pass, $user->ID)) {
                    if ($new_pass1 == $new_pass2) {
                        $msg_update .= __('Profile Updated Successfully', 'adaptable-child');
                        wp_set_password($new_pass1, $user->ID);
                    } else {
                        $msg .= __('Please confirm password again', 'adaptable-child');
                    }
                }
            }
            if ($msg == '') {
                $msg_update .=  __('Profile Updated Successfully', 'adaptable-child');
            }
        }
        ?>

<h2><?php echo esc_attr_e($adpProfileTabText, 'adaptable-child');
        ?></h2>
<div class="dashboard-block">
<?php if ($msg != '') {
    ?>
<div id="message"><div class="alert alert-error"><?php echo esc_attr($msg); ?></div></div><?php
} elseif ($msg_update != '') {
    ?>
<div id="message"><div class="alert alert-success"><?php echo esc_attr($msg_update);
    ?></div></div><?php
}
        ?>
<div class="tabs profile-tabs">
<ul class="nav nav-tabs">
<li class="active"> <a data-toggle="tab" href="#personalinfo" aria-controls="personalinfo" role="tab"><?php echo esc_attr_e('Personal Info', 'adaptable-child');
        ?></a></li>
<li> <a data-toggle="tab" href="#socialinfo" aria-controls="socialinfo" role="tab"><?php echo esc_attr_e('Social Info', 'adaptable-child');
        ?></a></li>
<li> <a data-toggle="tab" href="#billinginfo" aria-controls="billinginfo" role="tab"><?php echo esc_attr_e('Billing Info', 'adaptable-child');
        ?></a></li>
<li> <a data-toggle="tab" href="#changepassword" aria-controls="changepassword" role="tab"><?php echo esc_attr_e('Change Password', 'adaptable-child');
        ?></a></li>
</ul>
<form action="" method="post" enctype="multipart/form-data">
<div class="tab-content">
<!-- SOCIAL INFO -->
<div id="personalinfo" class="tab-pane fade active in">
<div class="row">
<div class="col-md-8">
<div class="row">
<div class="col-md-6">
<label><?php echo esc_attr_e('First name*', 'adaptable-child');
        ?></label>
<input name="first-name" value="<?php echo esc_attr($current_user->user_firstname);
        ?>" type="text" class="form-control" placeholder="" >
</div>
<div class="col-md-6">
<label><?php echo esc_attr_e('Last name', 'adaptable-child');
        ?></label>
<input name="last-name" value="<?php echo esc_attr($current_user->user_lastname);
        ?>" type="text" class="form-control" placeholder="">
</div>
</div>
<div class="row">
<div class="col-md-6">
<label><?php echo esc_attr_e('Email', 'adaptable-child');
        ?>*</label>
<input name="user-email" value="<?php echo esc_attr($current_user->user_email);
        ?>" type="text" class="form-control" placeholder="mail@example.com" disabled>
</div>
<div class="col-md-6">
<label><?php echo esc_attr_e('Phone', 'adaptable-child');
        ?></label>
<input name="user-phone" value="<?php echo get_post_meta($user_info_id, 'imic_user_telephone', true);
        ?>" type="text" class="form-control" placeholder="000-00-0000">
</div>
</div>
<div class="row">
<div class="col-md-6">
<label><?php echo esc_attr_e('Company Name', 'adaptable-child'); ?></label>
<input name="company-name" value="<?php echo get_post_meta($user_info_id, 'imic_user_company', true); ?>" type="text" class="form-control" placeholder="">
</div>
<div class="col-md-6">
<label><?php echo esc_attr_e('Company Tagline', 'adaptable-child'); ?></label>
<input name="company-tagline" value="<?php echo get_post_meta($user_info_id, 'imic_user_company_tagline', true); ?>" type="text" class="form-control" placeholder="">
</div>
</div>
<label><?php echo esc_attr_e('Website', 'adaptable-child');
        ?></label>
<input name="website-url" value="<?php echo get_post_meta($user_info_id, 'imic_user_website', true);
        ?>" type="text" class="form-control" placeholder="">
<?php
$post_id = get_post($user_info_id);
        $content = $post_id->post_content;
        $content = apply_filters('the_content', $content);
        $content = str_replace(']]>', ']]>', $content);
        ?>
<label><?php echo esc_attr_e('Description', 'adaptable-child');
        ?></label>
<textarea class="form-control" rows="5" name="dealer_content"><?php echo do_shortcode($content);
        ?></textarea>
<div class="row">
<div class="col-md-6">
<?php $user_avatar = get_post_meta($user_info_id, 'imic_user_logo', true);
        $image_avatar = wp_get_attachment_image_src($user_avatar, '', '');
        if (!empty($image_avatar)) {
            ?>
<img src="<?php echo esc_url($image_avatar[0]);
            ?>" width="150" height="150">
<?php
        }
        ?>
<label><?php echo esc_attr_e('Banner Image', 'adaptable-child');
        ?></label>
<input name="bannerimage" type="file">
</div>
<div class="col-md-6">
<?php if (has_post_thumbnail($user_info_id)) {
    echo get_the_post_thumbnail($user_info_id, '200x200');
}
        ?>
<label><?php echo esc_attr_e('Company/User Image', 'adaptable-child');
        ?></label>
<input name="userimage" type="file">
</div>
</div>
</div>
</div>
</div>
<!-- SOCIAL INFO -->
<div id="socialinfo" class="tab-pane fade">
<div class="row">
<div class="col-md-8">
<div class="row">
<div class="col-md-6">
<label><?php echo esc_attr_e('Facebook', 'adaptable-child');
        ?></label>
<input name="user-facebook" value="<?php echo get_post_meta($user_info_id, 'imic_user_facebook', true);
        ?>" type="text" class="form-control" placeholder="" >
</div>
<div class="col-md-6">
<label><?php echo esc_attr_e('Twitter', 'adaptable-child');
        ?></label>
<input name="user-twitter" value="<?php echo get_post_meta($user_info_id, 'imic_user_twitter', true);
        ?>" type="text" class="form-control" placeholder="">
</div>
</div>
<div class="row">
<div class="col-md-6">
<label><?php echo esc_attr_e('Google Plus', 'adaptable-child');
        ?></label>
<input name="user-gplus" value="<?php echo get_post_meta($user_info_id, 'imic_user_gplus', true);
        ?>" type="text" class="form-control" placeholder="">
</div>
<div class="col-md-6">
<label><?php echo esc_attr_e('Pinterest', 'adaptable-child');
        ?></label>
<input name="user-pinterest" value="<?php echo get_post_meta($user_info_id, 'imic_user_pinterest', true);
        ?>" type="text" class="form-control" placeholder="">
</div>
</div>
</div>
</div>
</div>
<!-- PROFIE BILLING INFO -->
<div id="billinginfo" class="tab-pane fade">
<div class="row">
<div class="col-md-8">
<div class="row">
<div class="col-md-6">
<label><?php echo esc_attr_e('City', 'adaptable-child');
        ?>*</label>
<input type="text" name="user-city" class="form-control" value="<?php echo get_post_meta($user_info_id, 'imic_user_city', true);
        ?>" placeholder="">
</div>
<div class="col-md-6">
<label><?php echo esc_attr_e('Zip', 'adaptable-child');
        ?>*</label>
<input name="user-zip" value="<?php echo get_post_meta($user_info_id, 'imic_user_zip_code', true);
        ?>" type="text" class="form-control" placeholder="" >
</div>
</div>

<?php $ustate = '';
        $user_state = wp_get_post_terms($user_info_id, 'user-city');
        if (!empty($user_state)) {
            $ustate = $user_state[0]->slug;
        }
        $user_city = get_terms('user-city', array('hide_empty' => false, 'orderby' => 'name'));
        ?>
<label><?php echo esc_attr_e('Select State', 'adaptable-child');
        ?>*</label>
<select id="ustate" name="user-state" class="form-control selectpicker">
<option><?php echo esc_attr_e('Select', 'adaptable-child');
        ?></option>
<?php foreach ($user_city as $city) {
    ?>
<option <?php echo ($ustate == $city->slug) ? 'selected' : '';
    ?> value="<?php echo esc_attr($city->slug);
    ?>"><?php echo esc_attr($city->name);
    ?></option>
<?php
}
        ?>
</select>
</div>
</div>
</div>
<!-- PROFIE CHANGE PASSWORD -->
<div id="changepassword" class="tab-pane fade">
<div class="row">
<div class="col-md-8">
<div class="row">
<div class="col-md-6">
<label><?php echo esc_attr_e('Old Password', 'adaptable-child');
        ?></label>
<input name="user-pass" type="password" class="form-control" placeholder="">
</div>
</div>
<div class="row">
<div class="col-md-6">
<label><?php echo esc_attr_e('New password', 'adaptable-child');
        ?></label>
<input name="user-new-pass1" type="password" class="form-control" placeholder="">
</div>
<div class="col-md-6">
<label><?php echo esc_attr_e('Confirm new password', 'adaptable-child');
        ?></label>
<input name="user-new-pass2" type="password" class="form-control" placeholder="">
</div>
</div>
</div>
</div>
</div>
</div>
<button type="submit" class="button"><?php echo esc_attr_e('Update details', 'adaptable-child'); ?></button>
</form>
</div>
</div>
<?php } ?>
</div><?php
}
            ?>
</div>
</div>
</div>
</div>
</div>
<!-- End Body Content -->
<?php
    } else {
        ?>
        <div class="main" role="main">
            <div id="content" class="content full">
                <div class="container">
                    <div class="text-align-center error-404">
                        <h1 class="huge"><?php echo esc_attr_e('Sorry', 'adaptable-child'); ?></h1>
                        <hr class="sm">
                        <p><strong><?php echo esc_attr_e('Sorry - Plugin not active', 'adaptable-child'); ?></strong></p>
                        <p><?php echo esc_attr_e('Please install and activate required plugins of theme.', 'adaptable-child'); ?></p>
                    </div>
                </div>
            </div>
        </div>
    <?php }
    get_footer(); ?>
    Your latest offers and news every week to our verified users. </p>
</div>
</div>
</div>
</div>
</div>
<?php } ?>
</div>
<?php } ?>
</div>
</div>
</div>
</div>
</div>
<!-- End Body Content -->
<?php

} else {
    ?>
<div class="main" role="main">
<div id="content" class="content full">
<div class="container">
<div class="text-align-center error-404">
<h1 class="huge"><?php echo esc_attr_e('Sorry', 'adaptable-child'); ?></h1>
<hr class="sm">
<p><strong><?php echo esc_attr_e('Sorry - Plugin not active', 'adaptable-child'); ?></strong></p>
<p><?php echo esc_attr_e('Please install and activate required plugins of theme.', 'adaptable-child'); ?></p>
</div>
</div>
</div>
</div>
<?php } get_footer(); ?>
