<?php get_header();
global $imic_options;

$id = get_the_ID();

/**
 * Grab user ID from custom post_type, then get user meta based on that id
 * This is done because we're on a "post" type page, not a "author" page.
 */
$userID = get_post_meta(get_the_ID(), 'imic_user_reg_id', true);

$userData = get_userdata($userID);
$userMeta = get_user_meta($userID);
$postMeta = get_post_meta($id);

// array of social profiles
$socialProfiles = [
    'facebook'       => get_post_meta($id, 'imic_user_facebook', true),
    'twitter'        => get_post_meta($id, 'imic_user_twitter', true),
    'snapchat-ghost' => get_post_meta($id, 'imic_user_snapchat', true),
    'instagram'      => get_post_meta($id, 'imic_user_instagram', true),
];

$name = $userData->user_login;

if (in_array("dealer", $userData->roles) || in_array("administrator", $userData->roles)):
    $name = isset($postMeta['imic_user_company'][0]) ? $postMeta['imic_user_company'][0] : $userData->user_login;
endif;

// Company tagline and website
$tagline = get_post_meta($id,'imic_user_company_tagline',true);
$website = get_post_meta($id,'imic_user_website',true);

// USers set media
$user_banner = wp_get_attachment_image_src(get_post_meta($id,'imic_user_logo',true), 'banner');

$user_avatar_default = (isset($imic_options['default_dealer_image'])) ? $imic_options['default_dealer_image'] : array('url' => '');
$user_avatar = wp_get_attachment_image_src(get_post_thumbnail_id($id), 'thumb');

// includes the controller file for billboards
include('includes/billboard/billboard.php'); ?>

<?php if(is_plugin_active("imithemes-listing/listing.php")) { ?>
  	<main class="main" role="main">
    	<div id="content" class="content full dealer-prosite">
            <header class="dealerInfoBar">
        		<div class="container">
                	<div class="row">
                    	<div class="col-xs-12 col-sm-4 col-md-3">
                            <ul class="social-icons social-icons-colored dealerInfoBar__social">
                                <?php foreach ($socialProfiles as $network => $url): ?>
                                    <li class="<?php echo $network; ?>">
                                        <a href="<?php echo esc_url($url); ?>">
                                            <i class="fa fa-<?php echo $network; ?>"></i>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                        <div class="col-sm-4 col-md-4 col-md-offset-1">
                        	<div class="dealerInfoBar__avatar">
                                <?php if (is_array($user_avatar) && !empty($user_avatar)): ?>
                                    <img src="<?php echo esc_url($user_avatar[0]); ?>" width="<?php $user_avatar[1]; ?>" height="<?php $user_avatar[2]; ?>" alt="<?php echo $name.'\'s Profile picture'; ?>">
                                <?php else: ?>
                                    <img src="<?php echo esc_url($user_avatar_default['url']); ?>" alt="">
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-4 col-md-4">
                            <div class="dealerInfoBar__listinginfo">
                                <span><?php echo esc_attr_e('Member since','adaptable-child'); ?>: <strong><?php echo esc_attr(date("Y", strtotime($userData->user_registered)));?></strong></span>
                                <span><?php echo esc_attr_e('Listings','adaptable-child'); ?>: <strong><?php echo esc_attr(imic_count_user_posts_by_type($userID,'cars')); ?></strong></span>
                            </div>
                        </div>
                    </div>
           		</div>
         	</header>

            <div class="container">
                <div class="dealer">

                    <h2 class="dealer__name"><?php echo esc_attr($name); ?></h2>

                    <?php if (in_array("dealer", $userData->roles) || in_array("administrator", $userData->roles)): ?>
                        <?php if($tagline != ''): ?>
                            <p class="dealer__meta"><?php echo esc_attr($tagline); ?></p>
                        <?php endif; ?>
                    <?php endif; ?>

                    <div class="dealer__contact">
                        <?php if($website != ''): ?>
                            <a href="<?php echo esc_url($website); ?>" class="dealer__website button button--black" target="_blank"><?php echo esc_attr_e('Website','adaptable-child'); ?></a>
                        <?php endif; ?>

                        <a href="#" data-toggle="modal" data-target="#infoModal" class="dealer__website button button--alternate" title="<?php echo esc_attr_e('Request more info', 'adaptable-child'); ?>">
                            <span><?php echo esc_attr_e('Contact Seller', 'adaptable-child'); ?></span>
                        </a>
                    </div>


                    <div class="dealer__description">
                        <?php
                        $post_id = get_post($id);
    					$content = $post_id->post_content;
    					echo $content = apply_filters('the_content', $content);
                        ?>
                    </div>
                </div>

                <?php
                $browse_listing = imic_get_template_url('template-listing.php');
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
                $gridClass = 'col-sm-6 col-md-4 col-lg-3';

                $args_cars = array(
                    'post_type' =>'cars',
                    'posts_per_page' => -1,
                    'post_status' => 'publish',
                    'author' => $userID,
                    'meta_query' => array(
                        'key' =>'imic_plugin_ad_payment_status',
                        'value' =>'1',
                        'compare' =>'='
                    )
                );

                $cars_listing = new WP_Query( $args_cars );

                if ( $cars_listing->have_posts() ) : ?>

                    <!-- Recently Listed Vehicles -->
                    <section class="listing-block recent-vehicles dealer-listings">
                        <div class="listing-header">
                            <div class="listing-header-title listing-header-title--central">
                                <h6><?php echo esc_attr_e('Our Recently Listed Vehicles','adaptable-child'); ?></h6>
                            </div>
                        </div>

                        <div class="listing-container row">
                            <ul>
    						    <?php while ( $cars_listing->have_posts() ) : $cars_listing->the_post();

                                    include(locate_template('includes/template-parts/listings/vehicle-standard_content.php'));

                                endwhile; ?>
                            </ul>
                        </div>
                    </section>
                <?php endif; wp_reset_postdata(); ?>
           	</div>
        </div>
    </main>

<?php } else { ?>
    <!-- Start Body Content -->
  	<div class="main" role="main">
    	<div id="content" class="content full">
            <div class="container">
              	<div class="row">
                	<div class="col-md-9 posts-archive">
                    <?php if(have_posts()):while(have_posts()):the_post(); ?>
                  		<article <?php post_class('post format-standard'); ?>>
                    		<div class="row">
                            <?php $content_class = 12; if(has_post_thumbnail(get_the_ID())) { $content_class = 8; ?>
                      			<div class="col-md-4 col-sm-4"> <a href="<?php echo esc_url(get_permalink()); ?>"><?php the_post_thumbnail('600x400',array('class'=>'img-thumbnail')); ?></a> </div><?php } ?>
                      			<div class="col-md-<?php echo esc_attr($content_class); ?> col-sm-<?php echo esc_attr($content_class); ?>">
                                    <div class="post-actions">
                                        <div class="post-date"><?php echo esc_attr(get_the_date(get_option('date_format'))); ?></div>
                                        <div class="comment-count"><?php if (comments_open()) { echo comments_popup_link('<i class="fa fa-comment"></i>'.__('No comments yet','framework'), '<i class="fa fa-comment"></i>1', '<i class="fa fa-comment"></i>%','pull-right meta-data', 'comments-link',__('Comments are off for this post','framework')); } ?></div>
                                    </div>
                        			<h3 class="post-title"><a href="<?php echo esc_url(get_permalink()); ?>"><?php the_title(); ?></a></h3>
                        			<?php echo imic_excerpt(35); ?>
                                     <a href="<?php echo esc_url(get_permalink()); ?>" class="continue-reading"><?php echo esc_attr_e('Continue reading','adaptable-child'); ?> <i class="fa fa-long-arrow-right"></i></a></p>
                                   	<div class="post-meta"><?php echo esc_attr_e('Posted in:','adaptable-child'); ?> <?php the_category(' '); ?></div>
                      			</div>
                    		</div>
                  		</article>
                        <?php endwhile; endif; if(function_exists('imic_pagination')) { imic_pagination(); } else { next_posts_link( 'Older Entries'); previous_posts_link( 'Newer Entries' ); } ?>
                    </div>
                    <!-- Start Sidebar -->
                    <?php if(is_active_sidebar('post-sidebar')) { ?>
                    <!-- Sidebar -->
                    <div class="col-md-3">
                    	<?php dynamic_sidebar('post-sidebar'); ?>
                    </div>
                    <?php } ?>
                    </div>
              	</div>
            </div>
        </div>
   	</div>
    <!-- End Body Content -->
<?php } ?>

<?php get_footer(); ?>
