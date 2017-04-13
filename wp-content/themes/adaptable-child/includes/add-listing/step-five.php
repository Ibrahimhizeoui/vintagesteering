<?php
// woocommerce county list
$wcc = new WC_Countries();

// Simple Associative array of country codes/country names
$countryList = $wcc->get_countries();

// get the users set country if they have set one
$usersSetCountry = get_post_meta($user_info_id, 'imic_user_country', true); 
?>

<!-- AD LISTING FORM STEP FIVE -->
<div id="listing-add-form-five" class="stepContent tab-pane fade <?php echo ($active_tab5 != '') ? $active_tab5 . ' in' : ''; ?>">
    <div class="stepSellingChoice">
        <?php $listing_view = get_post_meta($update_id, 'imic_plugin_listing_view', true); ?>
        <label class="all active"><input type="radio" name="Loan-Tenure" id="option1" autocomplete="off" value="all" checked></label>
    </div>

    <?php if (($payment_status <= 0 && $opt_plans == 1) && ($eligible_listing != 1)): ?>
        <div class="stepContent__section stepContent__header">
            <h3><?php echo esc_attr_e('Publish Your Listing', 'adaptable-child'); ?></h3>
            <p>Select a plan from below and fill out your billing details.</p>
        </div>
        <div class="stepContent__section">
            <?php // Allow users to select a plan ?>
            <?php include('plan-selection.php'); ?>
        </div>
    <?php else: ?>
        <div class="stepContent__section stepContent__header">
            
            <h3><?php echo esc_attr_e('Your listing has been edited', 'adaptable-child'); ?></h3>
        </div>
    <?php endif; ?>

    <div class="stepContent__section">
        <?php
        if ($opt_plans != 0 && $eligible_listing != 1)
        { ?>
            <h3><?php echo esc_attr_e('Billing Info', 'adaptable-child'); ?></h3>
            <div class="stepContent__billing">
                <div class="row">
                    <?php 
                    $adpUserData = get_userdata($user_id);
                    $dealer = ($adpUserData->roles[0] == 'dealer');
                    if($dealer): ?>
                    <div class="col-md-12">
                        <input type="hidden" id="uid" value="<?php echo esc_attr($user_id); ?>">
                        <input type="hidden" id="uinfo" value="<?php echo esc_attr($user_info_id); ?>">
                        <label for="fname"><?php echo esc_attr_e('Name of dealership', 'adaptable-child'); ?>*</label>
                        <input id="fname" value="<?php echo esc_attr($current_user->user_firstname); ?>" type="text" class="form-control" placeholder="<?php echo esc_attr_e('Name of dealership', 'adaptable-child'); ?>*" style="text-indent: 2.1%;">
                        <input id="lname" value="<?php echo esc_attr($current_user->user_lastname); ?>" type="hidden">
                    </div>
                    <?php else: ?>
                    <div class="col-md-6">
                        <input type="hidden" id="uid" value="<?php echo esc_attr($user_id); ?>">
                        <input type="hidden" id="uinfo" value="<?php echo esc_attr($user_info_id); ?>">
                        <label for="fname"><?php echo esc_attr_e('First name', 'adaptable-child'); ?>*</label>
                        <input id="fname" value="<?php echo esc_attr($current_user->user_firstname); ?>" type="text" class="form-control" placeholder="<?php echo esc_attr_e('First name', 'adaptable-child'); ?>*">
                    </div>
                    <div class="col-md-6">
                        <label for="lname"><?php echo esc_attr_e('Last name', 'adaptable-child'); ?></label>
                        <input id="lname" value="<?php echo esc_attr($current_user->user_lastname); ?>" type="text" class="form-control" placeholder="<?php echo esc_attr_e('Last name', 'adaptable-child'); ?>">
                    </div>
                    <?php endif; ?>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <label for="billingemail"><?php echo esc_attr_e('Email', 'adaptable-child'); ?>*</label>
                        <input id="billingemail" value="<?php echo esc_attr($current_user->user_email); ?>" type="text" class="form-control" placeholder="mail@example.com" disabled >
                    </div>
                    <div class="col-md-6">
                        <label for="uphone"><?php echo esc_attr_e('Phone', 'adaptable-child'); ?></label>
                        <input id="uphone" value="<?php echo esc_attr(get_post_meta($user_info_id, 'imic_user_telephone', true)); ?>" type="text" class="form-control" placeholder="Phone No.">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <label for="ucity"><?php echo esc_attr_e('City', 'adaptable-child'); ?>*</label>
                        <input id="ucity" value="<?php echo get_post_meta($user_info_id, 'imic_user_city', true); ?>" type="text" class="form-control" placeholder="<?php echo esc_attr_e('City', 'adaptable-child'); ?>*">
                    </div>
                    <div class="col-md-6">
                        <label for="uzip"><?php echo esc_attr_e('Zip', 'adaptable-child'); ?>*</label>
                        <input id="uzip" value="<?php echo get_post_meta($user_info_id, 'imic_user_zip_code', true); ?>" type="text" class="form-control" placeholder="<?php echo esc_attr_e('Zip', 'adaptable-child'); ?>*">
                    </div>
                </div>
            </div>

            <label for="usercountry"><?php echo esc_attr_e('Select A Country', 'adaptable-child'); ?>*</label>
            <select id="usercountry" name="usercountry" class="form-control selectpicker">
                <option><?php echo esc_attr_e('Select', 'adaptable-child'); ?></option>
                <?php foreach ($countryList as $countrycode => $countryname): ?>
                    <option <?php echo ($usersSetCountry == $countryname) ? 'selected' : ''; ?> value="<?php echo $countryname; ?>"><?php echo $countryname; ?></option>
                <?php endforeach; ?>
            </select>

            <?php if (($payment_status <= 0 && $opt_plans == 1) && ($eligible_listing != 1)): ?>
                <div class="termsAndConditions">
                    <label for="tandcs">
                        <input type="checkbox" name="tandcs" id="tandcs" autocomplete="off"> I Agree to the <a href="terms-of-condition" target="_blank" rel="noopener noreferrer">Terms &amp; Conditions</a>
                    </label>
                </div>
            <?php endif; ?>
            <input type="hidden" name="rm" value="2">
            <input type="hidden" name="amount" value="<?php echo esc_attr($plan_price); ?>">
            <input type="hidden" name="cmd" value="_xclick">
            <input type="hidden" name="business" value="<?php echo esc_attr($paypal_email); ?>">
            <input type="hidden" name="currency_code" value="<?php echo esc_attr($paypal_currency); ?>">
            <input type="hidden" name="item_name" value="<?php echo get_the_title($plan); ?>">
            <input type="hidden" name="item_number" value="<?php echo esc_attr($plan); ?>">
            <input type="hidden" name="return" value="<?php echo esc_url(add_query_arg(array(
                'plans' => $plan,
                'edit' => get_query_var('edit')
                ) , $thanks)); ?>"
            />
            <?php
        }?>

        <div class="stepContent__section center">
            <?php
            $status_vehicle = get_post_meta($update_id, 'imic_plugin_ad_payment_status', true);
            if ($status_vehicle == "3" || $status_vehicle == "0" || $status_vehicle == "")
            {
                if (is_user_logged_in())
                { ?>
                    <input type="submit" id="final-pay" class="button button--alternate button--full" value="<?php if ($opt_plans != 0 && $eligible_listing != 1) { echo __('Pay', 'adaptable-child'); ?> &amp; <?php } echo __('Publish', 'adaptable-child'); ?>">
                    <?php
                }
                else
                {
                    echo '<a class="button button--alternate button" data-toggle="modal" data-target="#PaymentModal">' . __('Login/Register', 'framework') . '</a>';
                }

                if ($opt_plans != 0 && $eligible_listing != 1)
                { ?>
                    <p class="small adlisting__paypalConf">
                        <span class="adlisting__paypal">
                            <a href="https://www.paypal.com/uk/webapps/mpp/paypal-popup" title="How PayPal Works" onclick="javascript:window.open('https://www.paypal.com/uk/webapps/mpp/paypal-popup','WIPaypal','toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes, width=1060, height=700'); return false;">
                                <img src="https://www.paypalobjects.com/webstatic/mktg/Logo/pp-logo-100px.png" border="0" alt="PayPal Logo">
                            </a>
                        </span>
                        <?php echo esc_attr_e('You will be redirected to Paypal secure payment page for the payment which can be done using your Paypal account or via Credit Card', 'adaptable-child'); ?>
                    </p><?php
                }

            } ?>
        </div>
    </div>
</div>
