<?php
/**
 *  Displays choice to user frontend
 */

$plansArguments = array(
    'post_type'      => 'plan',
    'post_status'    => 'publish',
    'posts_per_page' => -1,
    'orderby'        => 'date'
);
$paymentPlans = get_posts($plansArguments);

if (!empty($paymentPlans)): ?>
    <div class="btn-group planSelection row" data-toggle="buttons" data-mfp-delegation>
        <?php foreach ($paymentPlans as $paymentPlan) : setup_postdata($paymentPlan);
            $index = 0;
            // ID of plan in loop
            $id = $paymentPlan->ID;
            // advantages of this plan
            $advantage = get_post_meta($id,'imic_plan_advantage',true);
            // price
            $highlight = get_post_meta($id,'imic_pricing_highlight',true);

            // currency
            $price = get_post_meta($id, 'imic_plan_price', true);
            $currency = imic_get_currency_symbol( (isset($imic_options['paypal_currency'])) ? $imic_options['paypal_currency'] : 'USD' );
            $plan_currency = get_post_meta($id, 'imic_plan_currency', true);
            $plan_currency_position = get_post_meta($id, 'imic_plan_currency_position', true);

            $premiumEnabled = get_post_meta($id, 'imic_pricing_premium_badge', true);

            // currency output control
            $plan_currency_str = $price.'<span class="dollar-sign">'.$plan_currency.'</span>';
            if($plan_currency_position == 1) {
                $plan_currency_str = '<span class="dollar-sign">'.$plan_currency.'</span>'.$price;
            }

            // paypal
            $paypal_site = '';
            if($price != '' && $price != 0 && $price != 'free') {
                $paypal_site = ($imic_options['paypal_site'] == "1") ? "https://www.paypal.com/cgi-bin/webscr" : "https://www.sandbox.paypal.com/cgi-bin/webscr";
            }

            // output ?>
            <div class="planSelection__option col-sm-6">
                <label for="option_<?php echo $index; ?>" class="btn button--plan listingPromoChoice <?php if ($highlight == 1): ?>listingPromoChoice--highlight<?php endif; ?>" data-plan-selection>
                    <input type="radio" name="Loan-Tenure" id="option_<?php echo $index; ?>" autocomplete="off">
                    <h3 class="listingPromoChoice__title"><?php echo get_the_title($id); ?></h3>
                    <h4 class="listingPromoChoice__price"><?php echo $plan_currency_str; ?></h4>
                    <?php if (have_rows('p_plan_features', $id)): ?>
                        <ul class="listingPromoChoice__features">
                            <?php while (have_rows('p_plan_features', $id)) : the_row(); ?>
                                <li class="listingPromoChoice__feature"><?php the_sub_field('feature'); ?></li>
                            <?php endwhile; ?>
                        </ul>
                    <?php endif; ?>

                    <span style="display:none;"
                        data-plan-details=""
                        data-plan-id="<?php echo esc_attr($id); ?>"
                        data-plan-title="<?php echo get_the_title($id); ?>"
                        data-plan-price-sh="<?php echo esc_attr($price); ?>"
                        data-plan-thanks="<?php echo esc_url($thanks); ?>"
                        data-plan-url="<?php echo esc_url($paypal_site); ?>">
                    </span>
                </label>

                <?php if ($premiumEnabled): ?>
                    <span class="planSelection__modal" data-premium-modal data-mfp-src="#premiumModal">What is a Premium Listing?</span>
                <?php endif; ?>
            </div>
        <?php $count++; endforeach; wp_reset_postdata(); ?>
    </div>
<?php endif; ?>
