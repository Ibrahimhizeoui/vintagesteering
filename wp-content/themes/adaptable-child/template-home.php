<?php
/*
Template Name: Home
*/
get_header();
global $imic_options;
//Get Page Banner Type
$id = is_home() ? get_option('page_for_posts') : get_the_ID();

// includes the controller file for billboards
include('includes/billboard/billboard.php');

$latest_vehicle_scroll = get_post_meta($id, 'imic_home_vehicle_auto_scroll', true);
$latest_vehicle_scroll_speed = get_post_meta($id, 'imic_browse_by_auto_scroll_speed', true);
$latest_vehicle_scroll_speed = ($latest_vehicle_scroll_speed == '') ? 5000 : $latest_vehicle_scroll_speed;
$vehicle_speed = ($latest_vehicle_scroll == 1) ? $latest_vehicle_scroll_speed : '';
$vehicle_switch = get_post_meta($id, 'imic_home_vehicle_switch', true);
$modal_search_switch = get_post_meta($id, '', true);
$news_switch = get_post_meta($id, 'imic_home_news_switch', true);
$testimonial_switch = get_post_meta($id, 'imic_home_testimonial_switch', true);
$make_search_switch = get_post_meta($id, 'imic_search_by_specification_switch', true);
$browse_listing = imic_get_template_url('template-listing.php');

if ($make_search_switch == 1):
    if (is_plugin_active('imithemes-listing/listing.php')):

        $specification_scroll = get_post_meta($id, 'imic_home_search_specification_auto_scroll', true);
        $specification_vehicle_scroll_speed = get_post_meta($id, 'imic_home_search_specification_auto_scroll_speed', true);
        $specification_vehicle_scroll_speed = ($specification_vehicle_scroll_speed == '') ? 5000 : $specification_vehicle_scroll_speed;
        $specification_speed = ($specification_scroll == 1) ? $specification_vehicle_scroll_speed : '';
        $search_by_spec_value = get_post_meta(get_the_ID(), 'imic_search_by_specification', true);
        $title = get_post_meta(get_the_ID(), 'imic_search_by_specification_title', true);
        $url = get_post_meta(get_the_ID(), 'imic_search_by_specification_url', true);

        $search_listing = get_bloginfo('url') . '/all-cars';

        $spec_int = get_post_meta($search_by_spec_value, 'imic_plugin_spec_char_type', true);
        $slug = $spec_int == 0 ? imic_the_slug($search_by_spec_value) : 'char_'.imic_the_slug($search_by_spec_value) ;

        if (!empty($search_by_spec_value)): ?>

            <div class="makeCarousel">
                <div class="container">
                    <!-- Search by make -->
                    <div class="row">
                        <div class="col-md-7 makeCarousel__owl">
                            <div class="row">
                                <ul class="owl-carousel" id="make-carousel"
                                    data-columns="6"
                                    data-autoplay="<?php echo esc_attr($specification_speed);?>"
                                    data-pagination="no"
                                    data-arrows="yes"
                                    data-single-item="no"
                                    data-items-desktop="10"
                                    data-items-desktop-small="4"
                                    data-items-tablet="3"
                                    data-items-mobile="3"
                                    <?php if (isset($imic_options['enable_rtl']) && $imic_options['enable_rtl'] == 1): ?>
                                        data-rtl="rtl"
                                    <?php else: ?>
                                        data-rtl="ltr"
                                    <?php endif; ?>>

                                    <?php
                                    $values = get_post_meta($search_by_spec_value, 'specifications_value', true);

                                    if (!empty($values)):
                                        foreach ($values as $value):

                                            $imgs = $value['imic_plugin_spec_image']; ?>

                                            <?php if (!empty($imgs)): ?>
                                                <li class="item">
                                                    <a href="<?php echo esc_url(add_query_arg($slug, $value['imic_plugin_specification_values'], $search_listing));?>"><img src="<?php echo esc_url($imgs); ?>" alt=""></a>
                                                </li>
                                            <?php endif; ?>

                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-3 col-md-offset-2 makeCarousel__viewAll">
                            <?php if ($url != ''): ?>
                                <a href="<?php echo esc_url($url); ?>" class="link link--bold link--spaced"><?php echo esc_attr_e('All Manufacturers', 'adaptable-child');?></a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    <?php endif; ?>
<?php endif; ?>

<!-- Start Body Content -->
<main class="main" role="main">
    <?php if ($vehicle_switch == 1): ?>
        <?php if (is_plugin_active('imithemes-listing/listing.php')): ?>

            <?php
            $RTLString = ( isset($imic_options['enable_rtl']) && $imic_options['enable_rtl'] == 1) ? 'data-rtl="rtl"' : 'data-rtl="ltr"';

            $vehicle_count = get_post_meta($id, 'imic_home_vehicle_count', true);
            $vehicle_title = get_post_meta($id, 'imic_home_vehicle_title', true);
            $vehicle_column = get_post_meta($id, 'imic_home_vehicle_column', true);

            $badges_type          = (isset($imic_options['badges_type'])) ? $imic_options['badges_type']                                      : '0';
            $badge_ids            = ($badges_type == '0') ? $badge_ids = (isset($imic_options['badge_specs'])) ? $imic_options['badge_specs'] : [] : $badge_ids = [] ;
            $specification_type   = (isset($imic_options['short_specifications'])) ? $imic_options['short_specifications']                    : '0';
            $detailed_specs       = ($specification_type == 0) ? (isset($imic_options['vehicle_specs'])) ? $imic_options['vehicle_specs']     : [] : [] ;
            $img_src              = '';
            $category_rail        = (isset($imic_options['category_rail'])) ? $imic_options['category_rail']                                  : '0';
            $additional_specs     = (isset($imic_options['additional_specs'])) ? $imic_options['additional_specs']                            : [];
            $additional_spec_type = get_post_meta($additional_specs, 'imic_plugin_spec_char_type', true);
            $additional_spec_slug = imic_the_slug($additional_specs);
            $additional_spec_slug = ($additional_spec_type == 2) ? 'char_'.$additional_spec_slug                                              : $additional_spec_slug;
            $additional_specs_all = get_post_meta($additional_specs, 'specifications_value', true);
            $highlighted_specs    = (isset($imic_options['highlighted_specs'])) ? $imic_options['highlighted_specs']                          : [];
            $unique_specs         = (isset($imic_options['unique_specs'])) ? $imic_options['unique_specs']                                    : '';
            $gridClass = 'col-sm-6 col-md-4';

            $args_cars = array(
                'post_type' => 'cars',
                'posts_per_page' => $vehicle_count,
                'post_status' => 'publish',
                'meta_query' => array(
                    'relation' => 'AND',
                    array(
                        'key' => 'imic_plugin_ad_payment_status',
                        'value' => '1',
                        'compare' => '='
                    ),
                    array(
                        'key' => 'imic_plugin_listing_end_dt',
                        'value' => date('Y-m-d'),
                        'compare' => '>='
                    )
                )
            );

            $cars_listing = new WP_Query($args_cars); ?>

            <section class="listing-block recent-vehicles container container--spacious">

                <div class="listing-header row">
                    <div class="col-xs-6 col-sm-8 listing-header-title">
                        <h6><?php echo esc_attr($vehicle_title); ?></h6>
                    </div>
                    <div class="col-xs-6 col-sm-4 listing-header-link">
                        <a class="link link--black" href="<?php echo home_url().'/all-cars'; ?>">View All</a>
                    </div>
                </div>

                <div class="listing-container row" data-mfp-delegation>
                    <ul <?php echo $RTLString; ?>>
                        <?php if ($cars_listing->have_posts()):
                            while ($cars_listing->have_posts()): $cars_listing->the_post();
                                include(locate_template('includes/template-parts/listings/vehicle-standard_content.php'));
                            endwhile;
                        endif; wp_reset_postdata(); ?>
                    </ul>
                </div>
            </section>
        <?php endif; ?>
    <?php endif; ?>

    <?php if (have_rows('p_c_page_content')): ?>
        <?php while (have_rows('p_c_page_content')) : the_row(); ?>
            <?php get_template_part('includes/template-parts/generic/fc', get_row_layout()); ?>
        <?php endwhile; ?>
    <?php endif; ?>

    <?php if ($news_switch == 1 || $testimonial_switch == 1): ?>

        <?php
        $latest_news_scroll = get_post_meta($id, 'imic_home_news_auto_scroll', true);
        $news_vehicle_scroll_speed = get_post_meta($id, 'imic_home_news_auto_scroll_speed', true);
        $news_vehicle_scroll_speed = ($news_vehicle_scroll_speed == '') ? 5000 : $news_vehicle_scroll_speed;
        $news_speed = ($latest_news_scroll == 1) ? $news_vehicle_scroll_speed : '';
        $news_title = get_post_meta(get_the_ID(), 'imic_home_news_title', true);
        $allnews_title = get_post_meta(get_the_ID(), 'imic_home_allnews_title', true);
        $allnews_url = get_post_meta(get_the_ID(), 'imic_home_allnews_url', true);

        // Blog query
        $args_post = array('post_type' => 'post', 'posts_per_page' => 3);
        $post_listing = new WP_Query($args_post);
        ?>

        <section class="latest-news container container--spacious--plus">
            <div class="listing-header latest-news__header row">
                <div class="col-xs-6 col-sm-8 listing-header-title">
                    <h6><?php echo esc_attr($news_title);?></h6>
                </div>
                <div class="col-xs-6 col-sm-4 listing-header-link">
                    <?php if ($allnews_url != '' && $allnews_url != ''): ?>
                        <a class="link link--black" href="<?php echo esc_url($allnews_url);?>"><?php echo esc_attr($allnews_title);?></a>
                    <?php endif; ?>
                </div>
            </div>

            <div class="listing-container latest-news__container row">
                <?php if ($post_listing->have_posts()) :

                    $post_listing = new WP_Query($args_post);
                    $post_thumbid = get_post_thumbnail_id();
                    $post_thumb = wp_get_attachment_image_src($post_thumbid, 'medium')[0]; ?>

                    <ul class="grid-holder col-3 posts-grid">
                        <?php while ($post_listing->have_posts()) : $post_listing->the_post(); ?>
                            <?php get_template_part('content', 'single'); ?>
                        <?php endwhile; ?>
                        </ul>
                <?php endif; wp_reset_postdata(); ?>
            </div>
        </section>
    <?php endif; ?>
</main>

<?php
// Lower billboard for homepage
include('includes/billboard/billboard-home-lower.php');

get_footer(); ?>
