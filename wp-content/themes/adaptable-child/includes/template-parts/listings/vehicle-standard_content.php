<?php namespace LukeRoberts;

// Controller
$postID = get_the_ID();

if (is_plugin_active('imi-classifieds/imi-classified.php')) {
    $badge_ids = imic_classified_badge_specs($postID, $badge_ids);
    $detailed_specs = imic_classified_short_specs($postID, $detailed_specs);
}

$post_author_id = get_post_field('post_author', $postID);
$user_info_id   = get_user_meta($post_author_id, 'imic_user_info_id', true);
$author_role    = get_option('blogname');

$plan           = get_post_meta($id, 'imic_plugin_car_plan', true);
$plan_premium   = get_post_meta('10'.$plan, 'imic_pricing_premium_badge', true);


if (!empty($user_info_id)) {
    $term_list = wp_get_post_terms($user_info_id, 'user-role', array('fields' => 'names'));
    if (!empty($term_list)) {
        $author_role = $term_list[0];
    } else {
        $author_role = get_option('blogname');
    }
}

$specifications = get_post_meta($postID, 'feat_data', true);

// Instantiate our Currency Class
$currencies = new Currency();

// Get the current in use currency.
$currentCurrency = $currencies->getCurrentCurrency();

// Get the vehicle price as JUST a numerical value
$vehicle_numeric_price = preg_replace("/[^0-9]/", "", imic_vehicle_price($postID, $unique_specs, $specifications));

// Convert price dependent on what the user has selected or default which is GBP
$vehicle_converted_price = convert_currency($vehicle_numeric_price, $from = 'GBP', $in = $currentCurrency);

// Format the currency price
$vehicle_formatted_price = format_currency($vehicle_converted_price, $currentCurrency, true);

$vehicle_complete_price = !empty($vehicle_formatted_price) ? $vehicle_formatted_price : 'TBC';

$highlight_value = rtrim(mb_strimwidth(get_the_title(), 0, 30, "..."));

$details_value = imic_vehicle_all_specs($postID, $detailed_specs, $specifications);
$data_ser_type = (get_option('imic_specifications_upd_st') != 1) ? 0 : get_option('imic_specifications_upd_st');

$metaString = !empty($details_value) ? mb_strimwidth(implode($details_value, ', '), 0, 50, "...") : '';

if (!empty($additional_specs)) {

    if ($data_ser_type == '0') {
        $image_key = array_search($additional_specs, $specifications['sch_title']);
        $additional_specs_value = $specifications['start_time'][$image_key];
    } else {
        $img_char = imic_the_slug($additional_specs);
        $additional_specs_value = get_post_meta($postID, 'char_'.$img_char, true);
    }

    $this_key = find_car_with_position($additional_specs_all, $additional_specs_value);
    $img_src = $additional_specs_all[$this_key]['imic_plugin_spec_image'];
}

if (has_post_thumbnail()) {
    $thumbid = get_post_thumbnail_id();
    $postImage = wp_get_attachment_image_src($thumbid, '400x400', true)[0];
} else {
    $postImage = ( isset( $imic_options['default_car_image']) ) ? $imic_options['default_car_image']['url'] :  $thumb_url[0];
}

$badges = imic_vehicle_all_specs($id, $badge_ids, $specifications);
$badgeString = [];
if (!empty($badges)) {
    // create array of badges
    foreach ($badges as $badge) {
        $badgeString[] = '<span class="label label-default">'.esc_attr($badge).'</span>';
    }
    // Add premium badge if it exists
    if ($plan_premium) {
        $badgeString[] = '<span class="label label-success" data-premium-modal data-mfp-src="#premiumModal">'.esc_attr('Premium listing', 'framework').'</span>';
    }
}
$badgeString = implode($badgeString, '');

// View ?>

<li class="item <?php print_r($gridClass); ?>">
    <div class="vehicle-block format-standard">

        <a href="<?php echo esc_url(get_permalink());?>" class="vehicle-listing-image media-box">
            <img src="<?php echo $postImage; ?>" alt="Image of <?php echo esc_attr($highlight_value); ?>" title="Car Image">
        </a>

        <div class="vehicle-block-content">
            <div class="vehicleBadges">
                <?php echo $badgeString; ?>
            </div>

            <?php if (!empty($highlight_value)): ?>
                <h6 class="vehicle-title">
                    <a href="<?php echo esc_url(get_permalink());?>"><?php echo $highlight_value; ?></a>
                </h6>
            <?php endif; ?>

            <span class="vehicle-meta"><?php echo $metaString; ?></span>

            <?php if ($img_src != ''): ?>
                <?php
                $speci_value = $additional_specs_all[$this_key]['imic_plugin_specification_values'];
                $speci_value = str_replace(' ', '%20', $speci_value);
                ?>
                <a href="<?php echo esc_url(add_query_arg($additional_spec_slug, $speci_value, $browse_listing)); ?>"
                    title="<?php _e('View all', 'adaptable-child'); echo esc_attr($additional_specs_all[$this_key]['imic_plugin_specification_values']); ?>"
                    class="vehicle-body-type">
                    <img src="<?php echo esc_url($additional_specs_all[$this_key]['imic_plugin_spec_image']);?>">
                </a>
           <?php endif; ?>


           <span class="vehicle-cost" data-price-conversion data-vehicle-price="<?php echo $vehicle_numeric_price; ?>"><?php echo esc_attr($vehicle_complete_price);?></span>
           <?php if ($category_rail == '1' && is_plugin_active('imi-classifieds/imi-classified.php')) {
               echo imic_get_cats_list(get_the_ID(), 'list');
           } ?>
        </div>
    </div>
</li>
