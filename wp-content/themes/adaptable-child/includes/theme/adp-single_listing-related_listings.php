<?php
$current_car            = get_the_ID();
$related_args           = [];
$arrays                 = [];
$taxonomy_array         = [];
$value                  = $pagin = $offset = $off = '';
$count                  = 1;
$related_specifications = (isset($imic_options[ 'related_specifications' ])) ? $imic_options[ 'related_specifications' ] : [];

if (!empty($related_specifications)) {
    $this_specification = get_post_meta(get_the_ID(), 'feat_data', true);
    $related_args       = imic_vehicle_all_specs(get_the_ID(), $related_specifications, $this_specification);
}

if (!empty($related_args)) {
    foreach ($related_args as $key => $value) {
        if (strpos($key, 'int_') !== false || strpos($key, 'range_') !== false) {
            if (strpos($key, 'range_') !== false) {
                $new_val            = explode('-', $value);
                $value              = $new_val[ 1 ];
                $pm_value           = $new_val[ 0 ];
                $key                = explode('_', $key);
                $key                = 'int_' . $key[ 1 ];
                $arrays[ $count++ ] = array(
                    'key' => $key,
                    'value' => $pm_value,
                    'compare' => '>=',
                    'type' => 'numeric'
                );
            }
            $arrays[ $count ] = array(
                'key' => $key,
                'value' => $value,
                'compare' => '<=',
                'type' => 'numeric'
            );
        } else {
            $arrays[ $count ] = array(
                'key' => 'feat_data',
                'value' => $value,
                'compare' => 'LIKE'
            );
            ++$count;
        }
    }
} else {
    $taxonomy_array[ 0 ] = array(
        'taxonomy' => 'listing-category',
        'field' => 'slug',
        'terms' => [],
        'operator' => 'IN'
    );
}

$arrays[ $count + 1 ] = array(
    'key' => 'imic_plugin_ad_payment_status',
    'value' => '1',
    'compare' => '='
);

$badges_type          = (isset($imic_options[ 'badges_type' ])) ? $imic_options[ 'badges_type' ] : '0';
$specification_type   = (isset($imic_options[ 'short_specifications' ])) ? $imic_options[ 'short_specifications' ] : '0';
$badge_ids            = (isset($imic_options[ 'badge_specs' ]) && $badges_type == 0) ? $imic_options[ 'badge_specs' ] : [];
$detailed_specs       = (isset($imic_options[ 'vehicle_specs' ]) && $specification_type == 0) ? $imic_options[ 'vehicle_specs' ] : [];
$additional_specs     = (isset($imic_options[ 'additional_specs'])) ? $imic_options['additional_specs'] : [];
$category_rail        = (isset($imic_options[ 'category_rail' ])) ? $imic_options[ 'category_rail' ] : '0';
$additional_specs     = (isset($imic_options[ 'additional_specs' ])) ? $imic_options[ 'additional_specs' ] : '';
$highlighted_specs    = (isset($imic_options[ 'highlighted_specs' ])) ? $imic_options[ 'highlighted_specs' ] : [];

$img_src = '';
$logged_user_pin      = '';
$user_id              = get_current_user_id();
$logged_user          = get_user_meta($user_id, 'imic_user_info_id', true);
$logged_user_pin      = get_post_meta($logged_user, 'imic_user_zip_code', true);
$additional_spec_slug = imic_the_slug($additional_specs);
$additional_specs_all = get_post_meta($additional_specs, 'specifications_value', true);
$unique_specs         = $imic_options[ 'unique_specs' ];

$gridClass = 'col-sm-6 col-md-4';

$args_cars = array(
    'post_type' => 'cars',
    'tax_query' => $taxonomy_array,
    'meta_query' => $arrays,
    'posts_per_page' => 3,
    'post_status' => 'publish',
    'post__not_in' => array( $current_car )
);

$cars_listing = new WP_Query($args_cars); ?>

<aside class="relatedListings">
    <div class="container">
        <?php if ($cars_listing->have_posts()): ?>
            <section class="listing-block recent-vehicles">
                <header class="listing-header row">
                    <div class="col-sm-8 listing-header-title">
                        <h6><?php echo __('Related Listings', 'adaptable-child'); ?></h6>
                    </div>
                </header>

                <div class="listing-container row">
                    <ul>
                        <?php if ($cars_listing->have_posts()):

                            while ($cars_listing->have_posts()): $cars_listing->the_post();

                                include(locate_template('includes/template-parts/listings/vehicle-standard_content.php'));

                            endwhile;

                        endif; wp_reset_postdata(); ?>
                    </ul>
                </div>
            </section>
        <?php endif; wp_reset_postdata(); ?>
    </div>
</aside>
