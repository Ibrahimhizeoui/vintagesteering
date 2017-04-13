<?php // troll

get_header();

global $imic_options;

$id = is_home() ? get_option('page_for_posts') : get_the_ID();

//Get Page Banner Type
$page_header = get_post_meta($id,'imic_pages_Choose_slider_display',true);
switch($page_header) {
    case 3:
        get_template_part( 'pages', 'flex' );
        break;
    case 4:
        get_template_part( 'pages', 'nivo' );
        break;
    case 5:
        get_template_part( 'pages', 'revolution' );
        break;
    case 1 || 2:
        get_template_part( 'pages', 'banner' );
        break;
} ?>

<main class="main" role="main" id="main-form-content">
	<div id="content" class="content full">
        <div class="container">
            <?php if ( have_posts() ): ?>

                <div class="spacer-30"></div>

                <div class="pricing-table three-cols margin-0">

                    <?php while ( have_posts() ) : the_post(); ?>
                        <?php
                        $plan_price = get_post_meta(get_the_ID(),'imic_plan_price',true);
                        $plan_period = get_post_meta(get_the_ID(), 'imic_plan_validity', true);
                        $plan_period_time = get_post_meta(get_the_ID(), 'imic_plan_validity_weeks', true);
                        $plan_period_listing = get_post_meta(get_the_ID(), 'imic_plan_validity_listings', true);
                        $plan_listing_draft = get_post_meta(get_the_ID(), 'imic_plan_validity_expire_listing', true);

                        if($plan_period != '0' && is_user_logged_in() && $plan_period != '' && $plan_price != '' && $plan_price != 'free')
                        {
                            $plan_btn_val = __('Pay Now', 'adaptable-child');
                            $plan_url = '';
                            $modal = 'data-toggle="modal" data-target="#'.get_the_ID().'-PaypalModal"';
                        }
                        elseif($plan_period != '0' && !is_user_logged_in() && $plan_period != '' && $plan_price != '' && $plan_price != 'free')
                        {
                            $plan_btn_val = __('Log In/Register', 'adaptable-child');
                            $plan_url = '';
                            $modal = 'data-toggle="modal" data-target="#PaymentModal"';
                        }
                        else
                        {
                            $plan_btn_val = __('Create Ad Now', 'adaptable-child');
                            $plan_url = add_query_arg('plans',get_the_ID(),$add_listing);
                            $modal = '';
                        }

                        $highlight = get_post_meta(get_the_ID(),'imic_pricing_highlight',true);
                        $highlight_class = ($highlight==1)?"highlight accent-color":"";
                        $advantage = get_post_meta(get_the_ID(),'imic_plan_advantage',true);
                        $plan_currency = get_post_meta(get_the_ID(), 'imic_plan_currency', true);
                        $plan_currency_position = get_post_meta(get_the_ID(), 'imic_plan_currency_position', true); ?>

                        <div class="pricing-column <?php echo $highlight_class; ?>">
                            <h3><?php the_title() ?><span class="highlight-reason"><?php echo $advantage; ?></span></h3>

                            <div class="pricing-column-content">
                                <?php if($plan_currency_position==1): ?>
                                    <h4><span class="dollar-sign"><?php echo $plan_currency; ?></span><?php echo get_post_meta(get_the_ID(),'imic_plan_price',true); ?></h4>
                                <?php else: ?>
                                    <h4><?php echo get_post_meta(get_the_ID(),'imic_plan_price',true); ?><span class="dollar-sign"><?php echo $plan_currency; ?></span></h4>
                                <?php endif; ?>

                                <span class="interval"><?php echo __('Until Sold','adaptable-child'); ?></span>
                                <?php
                                    $post_id = get_post(get_the_ID());
                                    $content = $post_id->post_content;
                                    $content = apply_filters('the_content', $content);
                                    echo str_replace(']]>', ']]>', $content);
                                ?>
                                <a <?php echo $modal ?> class="btn btn-primary" href="<?php echo esc_url($plan_url); ?>"><?php echo $plan_btn_val; ?></a>
                            </div>

                            <?php
                            if($plan_period != '0' && is_user_logged_in() && $plan_period != '')
                            {
                                $paypal_currency = $imic_options['paypal_currency'];
                                $paypal_email = $imic_options['paypal_email'];
                                $paypal_site = $imic_options['paypal_site'];
                                global $current_user;
                                get_currentuserinfo();
                                $user_id = get_current_user_id( );
                                $current_user = wp_get_current_user();
                                $user_info_id = get_user_meta($user_id,'imic_user_info_id',true);
                                $thanks_url = imic_get_template_url('template-thanks.php');
                                $paypal_site = ($paypal_site=="1")?"https://www.paypal.com/cgi-bin/webscr":"https://www.sandbox.paypal.com/cgi-bin/webscr";
                                ?>

                                <div id="<?php echo get_the_ID(); ?>-PaypalModal" class="modal fade" aria-hidden="true" aria-labelledby="mymodalLabel" role="dialog" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button class="close" aria-hidden="true" data-dismiss="modal" type="button"><?php echo esc_attr__('×','adaptable-child'); ?></button>
                                                <h4 id="mymodalLabel" class="modal-title"><?php echo esc_attr__('Payment Information','adaptable-child'); ?></h4>
                                            </div>

                                            <div class="modal-body">
                                                <form method="post" id="planpaypalform" name="planpaypalform" class="clearfix" action="<?php echo esc_url($paypal_site); ?>">
                                                    <div class="row">

                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <input type="text" value="<?php echo get_the_title($user_info_id); ?>" id="paypal-title" disabled name="First Name"  class="form-control input-lg" placeholder="<?php echo __('Name', 'adaptable-child'); ?>*">
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <input type="text" value="<?php echo $current_user->user_email; ?>" id="paypal-email" disabled name="email"  class="form-control input-lg" placeholder="<?php echo __('Email', 'adaptable-child'); ?>*">
                                                            </div>
                                                        </div>

                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <div id="messages"></div>
                                                            </div>
                                                        </div>

                                                        <input type="hidden" name="rm" value="2">
                                                        <input type="hidden" name="amount" value="<?php echo esc_attr($plan_price); ?>">
                                                        <input type="hidden" name="cmd" value="_xclick">
                                                        <input type="hidden" name="business" value="<?php echo esc_attr($paypal_email); ?>">
                                                        <input type="hidden" name="currency_code" value="<?php echo esc_attr($paypal_currency); ?>">
                                                        <input type="hidden" name="item_name" value="<?php echo get_the_title(get_the_ID()); ?>">
                                                        <input type="hidden" name="item_number" value="<?php echo esc_attr(get_the_ID()); ?>">
                                                        <input type="hidden" name="return" value="<?php echo esc_url($thanks_url); ?>" />

                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <input id="paypal-plan" name="submit" type="submit" class="btn btn-default" value="<?php echo __('Proceed to Payment', 'adaptable-child'); ?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="modal-footer"></div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    <?php endwhile; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</main>

<?php get_footer(); ?>
