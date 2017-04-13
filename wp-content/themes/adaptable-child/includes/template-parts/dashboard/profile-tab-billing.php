<?php
    // woocommerce county list
    $wcc = new WC_Countries();
    /**
     * Simple Associative array of country codes/country names
     */
    $countryList = $wcc->get_countries();
    // get the users current set country if they have set one
    $usersSetCountry = get_post_meta($user_info_id, 'imic_user_country', true);
?>

<div id="billinginfo" class="tab-pane fade">
    <div class="row">
        <div class="col-md-12">

            <?php
            $user_id = get_current_user_id();
            $adpUserData = get_userdata($user_id);
            ?>
            <?php if($adpUserData->roles[0] == 'dealer') : ?>
                <div class="row">
                    <div class="col-md-6">
                        <label for="profilecity"><?php echo esc_attr_e('Name', 'adaptable-child'); ?>*</label>
                        <input id="profilecity" type="text" name="user-billing-name" class="form-control" value="<?php echo get_post_meta($user_info_id, 'imic_user_billing_name', true); ?>" placeholder="<?php echo esc_attr_e('Name', 'adaptable-child'); ?>">
                    </div>
                    <div class="col-md-6">
                        <label for="profilecity"><?php echo esc_attr_e('Postal address', 'adaptable-child'); ?>*</label>
                        <input id="profilecity" type="text" name="user-billing-address" class="form-control" value="<?php echo get_post_meta($user_info_id, 'imic_user_billing_address', true); ?>" placeholder="<?php echo esc_attr_e('Postal address', 'adaptable-child'); ?>">
                    </div>
                </div>
            <?php endif; ?>
            <div class="row">
                <div class="col-md-6">
                    <label for="profilecity"><?php echo esc_attr_e('City', 'adaptable-child'); ?>*</label>
                    <input id="profilecity" type="text" name="user-city" class="form-control" value="<?php echo get_post_meta($user_info_id, 'imic_user_city', true); ?>" placeholder="<?php echo esc_attr_e('City', 'adaptable-child'); ?>">
                </div>
                <div class="col-md-6">
                    <label for="profilezip"><?php echo esc_attr_e('Zip/Post code', 'adaptable-child'); ?>*</label>
                    <input id="profilezip" name="user-zip" value="<?php echo get_post_meta($user_info_id, 'imic_user_zip_code', true); ?>" type="text" class="form-control" placeholder="<?php echo esc_attr_e('Zip/Post code', 'adaptable-child'); ?>">
                </div>
            </div>

            <label for="user-country"><?php echo esc_attr_e('Select A Country', 'adaptable-child'); ?>*</label>
            <select id="user-country" name="user-country" class="form-control selectpicker">
                <option><?php echo esc_attr_e('Select', 'adaptable-child'); ?></option>
                <?php foreach ($countryList as $countrycode => $countryname): ?>
                    <option <?php echo ($usersSetCountry == $countryname) ? 'selected' : ''; ?> value="<?php echo $countryname; ?>"><?php echo $countryname; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
</div>
