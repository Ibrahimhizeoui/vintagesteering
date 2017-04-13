<?php
	/*
Template Name: Add Listing
*/
    get_header();
    global $imic_options;

    // includes the controller file for billboards
    include('includes/billboard/billboard.php');

    $paypal_site = '';
    $opt_plans = $imic_options['opt_plans'];
    $listing_status_set = $imic_options['opt_listing_status'];
    $file_upload = (isset($imic_options['filetype_required'])) ? $imic_options['filetype_required']: '0';
    $select_plan = __('Please select payment plan', 'adaptable-child');
    $successfully_saved = __('Successfully Saved.', 'adaptable-child');
    $upload_images = __('Please upload images.', 'adaptable-child');
    $finish_tabs = __('Please complete previous tabs.', 'adaptable-child');

    $id = is_home() ? get_option('page_for_posts') : get_the_ID();

    if(is_plugin_active("imithemes-listing/listing.php"))
    {
        wp_enqueue_script('imic_add_listing');
        $pageSidebar2 = get_post_meta(get_the_ID(),'imic_select_sidebar_from_list2', true);

        if(!empty($pageSidebar2)&&is_active_sidebar($pageSidebar2))
        {
            $class2 = 9;
        }
        else
        {
            $class2 = 12;
        }

        $update_id = (get_query_var('edit')) ? get_query_var('edit') : '';
        $thanks = imic_get_template_url('template-dashboard.php');
        $paypal_site = $imic_options['paypal_site'];
        $paypal_currency = $imic_options['paypal_currency'];
        $paypal_email = $imic_options['paypal_email'];
        $plan = get_query_var('plans');
        $required_value = '';

        $vehicle_switch = get_post_meta($id,'imic_home_vehicle_switch',true);
        $parallax_switch = get_post_meta($id,'imic_home_third_parallax_section',true);
        $pricing_switch = get_post_meta($id,'imic_home_pricing_switch',true);
        $tab_class1 = $tab_class2 = $tab_class3 = $tab_class4 = $tab_class5 = $animation = $active_tab1 = $active_tab2 = $active_tab3 = $active_tab4 = $active_tab5 = $plan_price = '';
        $vehicle_author_id = get_post_field( 'post_author', $update_id);

        global $current_user;
        wp_get_current_user();
        $user_id = get_current_user_id( );
        $update_id = ($user_id==$vehicle_author_id) ? $update_id : '';

        if(is_user_logged_in())
        {
            echo ($user_id==$vehicle_author_id)?'':
            '<div id="not-valid"></div>';
        }

        $user_info_id = get_user_meta($user_id,'imic_user_info_id',true);
        $user_plan = get_post_meta($user_info_id, 'imic_user_all_plans', false);
        $user_plan = (!empty($user_plan)) ? $user_plan : array();

        if(!empty($user_plan)&&$plan=='')
        {
            foreach($user_plan as $user_plan_each)
            {
                $selected_plan_listings = get_post_meta($user_info_id, 'imic_allowed_listings_'.$user_plan_each, true);

                if($selected_plan_listings > 0)
                {
                    $plan = $user_plan_each;
                    break;
                }
            }
        }

        $plan_type = get_post_meta($plan, 'imic_plan_validity', true);
        $plan_recurring = ($plan_type!='0') ? $plan_type : '';
        $eligible_listing = '';
        $new_plan = $plan;
        $listings_plan = array();

        if($plan_recurring!=''||!empty($new_plan))
        {
            if(in_array($new_plan, $user_plan)||!empty($new_plan))
            {
                $selected_plan = get_post_meta($user_info_id, 'imic_user_plan_'.$new_plan, true);
                $selected_plan_listings = get_post_meta($user_info_id, 'imic_allowed_listings_'.$new_plan, true);

                if(!empty($selected_plan))
                {
                    foreach($selected_plan as $key=>$value)
                    {
                        $listing_ids = $value;
                        $listings_plan = explode(',', $listing_ids);
                    }
                }

                if($selected_plan_listings>0||in_array($update_id, $listings_plan))
                {
                    if(!empty($selected_plan))
                    {
                        foreach($selected_plan as $key=>$value)
                        {
                            switch($plan_type)
                            {
                                case 'day':
                                    $plan_validity_number = get_post_meta($new_plan, 'imic_plan_validity_days', true);
                                    break;
                                case 'week':
                                    $plan_validity_number = get_post_meta($new_plan, 'imic_plan_validity_weeks', true);
                                    break;
                                case 'month':
                                    $plan_validity_number = get_post_meta($new_plan, 'imic_plan_validity_months', true);
                                    break;
                                default:
                                    $plan_validity_number = '';
                            }

                            $valid_with_plan = get_post_meta($new_plan, 'imic_plan_validity_expire_listing', true);
                            $start_date = date('Y-m-d', $key);
                            $end_date = strtotime(date("Y-m-d", strtotime($start_date)) . " +". $plan_validity_number ." ".$plan_type);

                            if((date('Y-m-d', $end_date))>(date('Y-m-d')))
                            {
                                $eligible_listing = 1;
                            }
                        }
                    }
                }
            }
        }

    if($plan||$new_plan)
    {
        $plan = $plan;
        $plan_price = get_post_meta($plan,'imic_plan_price',true);

        if($plan_price != 0 && $plan_price != '' && $plan_price != 'free' && $eligible_listing != 1)
        {
            $paypal_site = ($paypal_site == "1") ? "https://www.paypal.com/cgi-bin/webscr" : "https://www.sandbox.paypal.com/cgi-bin/webscr";
        } else {
            if(($plan!='')&&($update_id!=''))
            {
                $paypal_site = add_query_arg(array('plans'=>$plan,'edit'=>$update_id),$thanks);
            }

            elseif($new_plan!='')
            {
                $paypal_site = add_query_arg(array('plans'=>$new_plan),$thanks);
            }
            else
            {
                $paypal_site = '';
            }
        }
    }

    $check_plan_price = get_post_meta($plan,'imic_plan_price',true);

    if($check_plan_price != '' && $check_plan_price != 'free')
    {
        $opt_plans = 0;
    }

    wp_localize_script('imic_add_listing','values',array(
        'ajaxurl'=>admin_url('admin-ajax.php'),
        'tmpurl'=>get_template_directory_uri(),
        'plans'=>$opt_plans,
        'isDefault'=>FRONT_MEDIA_ALLOW::check_file_input_method(),
        'fileupload' => $file_upload,
        'fileUploadUrl' => IMIC_THEME_CHILD_PATH . '/template-image-by-ajax-back.php'
    ));
    wp_localize_script('imic_add_listing','adds',array(
        'remain'=>$eligible_listing,
        'plans'=>$plan,
        'selectplan'=>$select_plan,
        'successaved'=>$successfully_saved,
        'noimage'=>$upload_images,
        'tabs'=>$finish_tabs
    ));

    $urole = '';
    $user_role = wp_get_post_terms($user_info_id, 'user-role');
    $list_ad = array('order'=>'');

    if(!empty($user_role))
    {
        $urole = $user_role[0]->term_id;
        $list_ad = get_option('taxonomy_'.$urole.'_metas');
    }

    if($list_ad['order']!="0")
    {
        $payment_status = get_post_meta($update_id,'imic_plugin_ad_payment_status',true);
        $payment_status = '';

        if($update_id!='')
        {
            $payment_status = get_post_meta($update_id,'imic_plugin_ad_payment_status',true);

            $steps_completed = get_post_meta($update_id,'imic_plugin_ads_steps',true);
            switch (true) {
                case $steps_completed >= 0:
                    $tab_class1 = ($steps_completed==0)?'pending':'completed';
                    $animation = ($steps_completed==0)?(0)."%":(20)."%";
                    $active_tab1 = "active";
                break;
                case $steps_completed >= 1:
                    $tab_class2 = ($steps_completed==1)?'pending':'completed';
                    $animation = ($steps_completed==1)?(20)."%":(40)."%";
                    $active_tab1 = '';
                    $active_tab2 = "active";
                break;
                case $steps_completed >= 2:
                    $tab_class3 = ($steps_completed==2)?'pending':'completed';
                    $animation = ($steps_completed==2)?(40)."%":(60)."%";
                    $active_tab1 = $active_tab2 = '';
                    $active_tab3 = "active";
                break;
                case $steps_completed >= 3:
                    $tab_class4 = ($steps_completed == 3) ? 'pending': 'completed';
                    $animation = ($steps_completed == 3) ? (60)."%" : (80)."%";
                    $active_tab1 = $active_tab2 = $active_tab3 = '';
                    $active_tab4 = "active";
                break;
                case $steps_completed >= 4:
                    $tab_class5 = ($steps_completed==4)?'pending':'completed';
                    $animation = ($steps_completed==4)?(80)."%":(100)."%";
                    $active_tab1 = $active_tab2 = $active_tab3 = $active_tab4 = '';
                    $active_tab5 = "active";
                break;
            }

            $specifications = get_post_meta($update_id,'feat_data',true);
        }
        else
        {
            $active_tab1 = "active";
        }

        $default_form = (is_plugin_active("imi-classifieds/imi-classified.php"))?'1':
        $imic_options['ad_listing_order'];

        $active_form_search = ($default_form=='0') ? 'active' : '';
        $active_custom_form = ($default_form=='1') ? 'active': '';
        $active_tab_search = ($default_form=='0') ? 'active in' : '';
        $active_tab_custom = ($default_form=='1') ? 'active in' : '';

        $paypal_site = (( $opt_plans == 1 && $eligible_listing == 1) || ($paypal_site != '')) ? $paypal_site : $thanks;

        $paypal_site = ( $opt_plans == 0 ) ? $thanks:

        $opt_plans;

        $browse_specification_switch = get_post_meta(get_the_ID(),'imic_browse_by_specification_switch',true);
        $browse_listing = imic_get_template_url("template-listing.php");

        switch($browse_specification_switch) {
            case 1:
                get_template_part('bar','one');
                break;
            case 2:
                get_template_part('bar','two');
                break;
            case 3:
                get_template_part('bar','saved');
                break;
            case 4:
                get_template_part('bar', 'category');
                break;
        }

        $specification_data_type = (get_option('imic_specifications_upd_st')!=1)?0:
        get_option('imic_specifications_upd_st'); ?>

    <!-- Start Body Content -->
<div class="main" role="main" id="main-form-content">
	<div id="content" class="content full">
        <div class="container">
        <?php
        // if(is_plugin_active("imi-classifieds/imi-classified.php"))
        // {
        //     echo '<div class="row">';
        //     $selected_cat = get_query_var('list-cat');
        //     $list_termss = array();
        //
        //     if($selected_cat)
        //     {
        //         $category_ids = get_term_by('slug', $selected_cat, 'listing-category');
        //         $term_ids = $category_ids->term_id;
        //         $parent = get_ancestors( $term_ids, 'listing-category' );
        //         foreach($parent as $parents)
        //         {
        //             $list_term = get_term_by('id', $parents, 'listing-category');
        //             $list_termss[] = $list_term->slug;
        //         }
        //
        //         $list_termss[] = $selected_cat;
        //     }
        //
        //     $listing_cats = get_terms('listing-category',array('parent' => 0,'number' => 10,'hide_empty' => false));
            // if(!empty($listing_cats))
            // {
            //     echo '<div class="col-md-3 col-sm-3 act-cat" id="list-1">';
            //     echo '<label>'.__('Select Category').'</label>';
            //     echo '<select data-page="ad" data-empty="true" name="list-cat" class="form-control selectpicker get-child-cat">';
            //     echo '<option value="" selected disabled>'.__('Select','framework').'</option>';
            //     $this_cat = $act = '';
            //     foreach($listing_cats as $cat)
            //     {
            //         $term_children = get_terms('listing-category',array('parent' => $cat->term_id));
            //         $disabled = (empty($term_children))?'blank':
            //         '';
            //
            //         if($this_cat!="selected"&&$act!=1)
            //         {
            //             $cat_id = (in_array($cat->slug,$list_termss))?$cat->term_id:
            //             '';
            //             $counter = (in_array($cat->slug,$list_termss))?1:
            //             0;
            //         }
            //
            //         $this_cat = (in_array($cat->slug,$list_termss))?'selected':
            //         '';
            //
            //         if($this_cat=="selected")
            //         {
            //             $act = 1;
            //         }
            //
            //         echo '<option '.$this_cat.' data-val="'.$disabled.'" value="'.$cat->slug.'">'.$cat->name.'</option>';
            //     }
            //     echo '</select>';
            //     echo '</div>';
            // }
            // if(get_query_var('list-cat'))
            // {
            //     while($counter<=count($list_termss)&&($cat_id!=''))
            //     {
            //         $meet = 0;
            //         $listing_cats = get_terms('listing-category',array('parent' => $cat_id));
            //
            //         if(!empty($listing_cats))
            //         {
            //             echo '<div class="col-md-3 col-sm-3 act-cat" id="list-'.($counter+1).'">';
            //             echo '<label>'.__('Select Category').'</label>';
            //             echo '<select data-empty="true" name="list-cat" class="form-control selectpicker get-child-cat">';
            //             echo '<option value="" selected disabled>'.__('Select','framework').'</option>';
            //             $this_cat = $act = '';
            //             foreach($listing_cats as $cat)
            //             {
            //                 $term_children = get_term_children($cat->term_id, 'listing-category');
            //                 $disabled = (empty($term_children))?'blank':
            //                 '';
            //
            //                 if($this_cat!="selected"&&$act!=1)
            //                 {
            //                     $cat_id = (in_array($cat->slug,$list_termss))?$cat->term_id:
            //                     '';
            //                 }
            //
            //                 $this_cat = (in_array($cat->slug,$list_termss))?'selected':
            //                 '';
            //
            //                 if($this_cat=="selected")
            //                 {
            //                     $act = 1;
            //                 }
            //
            //                 echo '<option '.$this_cat.' data-val="'.$disabled.'" value="'.$cat->slug.'">'.$cat->name.'</option>';
            //             }
            //
            //             echo '</select>';
            //             echo '</div>';
            //         }
            //
            //         $counter++;
            //     }
            //
            // }
            //echo '<div class="col-md-3 col-sm-3 loading-fields" id="loading-field" style="display:none;"><label>'.__('Select Category','framework').'</label><input class="form-control" type="text" value="'.__('Loading...','framework').'"></div></div>';
            // } ?>

        <div class="row">
        	<div class="col-md-4 listing-form-wrapper">
                <?php // Steps Sidebar ?>
                <?php include(locate_template('includes/add-listing/steps-sidebar.php')); ?>
            </div>

            <?php
            $search_fields = (isset($imic_options['search_vehicle'])) ? $imic_options['search_vehicle'] : array();
            $additional_details = (isset($imic_options['vehicle_more_details'])) ? $imic_options['vehicle_more_details'] : array();
        ?>
            <div class="col-md-7">
                <div class="waiting" style="display:none;">
                	<div class="spinner">
                      	<div class="rect1"></div>
                      	<div class="rect2"></div>
                      	<div class="rect3"></div>
                      	<div class="rect4"></div>
                      	<div class="rect5"></div>
                    </div>
                </div>
            	<!-- AD LISTING FORM -->
             	<form name="uploadfrm" id="uploadfrm" method="post" enctype="multipart/form-data" action="<?php echo esc_url($paypal_site); ?>">
                    <input type="hidden" name="_auto" value="1">
                    <input type="hidden" name="edit-vehicle" id="vehicle-id" value="<?php  echo esc_attr($update_id); ?>" class="<?php  echo esc_attr($update_id); ?>">
            		<section class="listing-form-content">
                        <?php // Step One ?>
                        <?php include(locate_template('includes/add-listing/step-one.php')); ?>

                        <?php // Step Two ?>
                        <?php include(locate_template('includes/add-listing/step-two.php')); ?>

                        <?php // Step Three ?>
                        <?php include(locate_template('includes/add-listing/step-three.php')); ?>

                        <?php // Step Four ?>
                        <?php include(locate_template('includes/add-listing/step-four.php')); ?>

                        <?php // Step Five ?>
                        <?php include(locate_template('includes/add-listing/step-five.php')); ?>
                	</section>
              	</form>
            </div>
        </div>
    </div>
</div>
</div>

<?php } else { ?>
    <div class="main" role="main">
        <div id="content" class="content full">
            <div class="container">
                <div class="text-align-center error-404">
                    <h1 class="huge"><?php  echo esc_attr_e('Sorry','adaptable-child'); ?></h1>
                    <hr class="sm">
                    <p><strong><?php  echo esc_attr_e('You do not have rights to ad listing.','adaptable-child'); ?></strong></p>
                    <p><?php  echo esc_attr_e('Please register with another role which have sufficient rights to ad listing.','adaptable-child'); ?></p>
                </div>
            </div>
        </div>
    </div>
<?php }
} else {
    ?>
<div class="main" role="main">
    	<div id="content" class="content full">
    		<div class="container">
            	<div class="text-align-center error-404">
            		<h1 class="huge"><?php  echo esc_attr_e('Sorry','adaptable-child'); ?></h1>
              		<hr class="sm">
              		<p><strong><?php  echo esc_attr_e('Sorry - Plugin not active','adaptable-child'); ?></strong></p>
					<p><?php  echo esc_attr_e('Please install and activate required plugins of theme.','adaptable-child'); ?></p>
             	</div>
            </div>
        </div>
   	</div>
<?php } ?>

<?php include(locate_template('includes/template-parts/globals/adp_overlay.php')); ?>

<?php get_footer(); ?>
