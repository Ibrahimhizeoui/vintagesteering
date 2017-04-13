<!--Modal Plans-->
<div id="plan-select" class="modal fade" aria-hidden="true" aria-labelledby="mymodalLabel" role="dialog" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" aria-hidden="true" data-dismiss="modal" type="button"><?php  echo esc_attr_e('Ã�','adaptable-child'); ?></button>
                <h4 id="mymodalLabel" class="modal-title"><?php  echo esc_attr_e('Plans','adaptable-child'); ?></h4>
            </div>

            <div class="modal-body">
                <div class="pricing-table three-cols margin-0">
                <?php

                $add_listing = imic_get_template_url('template-add-listing.php');

                log_me($add_listing);

                $args_plan = array('post_type'=>'plan','post_status'=>'publish','posts_per_page'=>-1);
                $plan_listing = new WP_Query( $args_plan );

                if ( $plan_listing->have_posts() ) :
                    while ( $plan_listing->have_posts() ) :
                        $plan_listing->the_post();
                        $paypal_site = $imic_options['paypal_site'];
                        $highlight = get_post_meta(get_the_ID(),'imic_pricing_highlight',true);
                        $highlight_class = ($highlight==1) ? "highlight accent-color" : "";
                        $price = get_post_meta(get_the_ID(),'imic_plan_price',true);
                        $currency = (isset($imic_options['paypal_currency'])) ? $imic_options['paypal_currency'] : 'USD';
                        $currency = imic_get_currency_symbol($currency);
                        $plan_currency = get_post_meta(get_the_ID(), 'imic_plan_currency', true);
                        $plan_currency_position = get_post_meta(get_the_ID(), 'imic_plan_currency_position', true);

                        if($price!=0&&$price!='free')
                        {
                            $paypal_site = ($paypal_site=="1")?"https://www.paypal.com/cgi-bin/webscr":
                            "https://www.sandbox.paypal.com/cgi-bin/webscr";
                        }
                        else
                        {
                            $paypal_site = '';
                        }

                        $advantage = get_post_meta(get_the_ID(),'imic_plan_advantage',true);
                        ?>

                        <div class="pricing-column <?php  echo esc_attr($highlight_class); ?>">
                            <h3><?php  echo get_the_title(); ?><span class="highlight-reason"><?php  echo esc_attr($advantage); ?></span></h3>
                            <div class="pricing-column-content">
                                <?php
                                if($plan_currency_position==1)
                                {
                                    echo '<h4><span class="dollar-sign">'.$plan_currency.'</span>'.$price.'</h4>';
                                }
                                else
                                {
                                    echo '<h4>'.$price.'<span class="dollar-sign">'.$plan_currency.'</span></h4>';
                                } ?>
                                <span class="interval"><?php  echo esc_attr_e('Until Sold','adaptable-child'); ?></span>
                                <?php  the_content(); ?>
                                <a data-dismiss="modal" class="btn btn-primary select-plan"><div style="display:none;"><span class="plan-id"><?php  echo esc_attr(get_the_ID()); ?></span><span class="plan-title"><?php  echo get_the_title(); ?></span><span class="plan-price-sh"><?php  echo esc_attr($price); ?></span><span class="plan-thanks"><?php  echo esc_url($thanks); ?></span><span class="plan-url"><?php  echo esc_url($paypal_site); ?></span></div><?php  echo esc_attr_e('Select','adaptable-child'); ?></a>
                            </div>
                        </div>
                    <?php endwhile;
                    endif; wp_reset_postdata(); ?>
                </div>
            </div>

            <div class="modal-footer">
                <button class="btn btn-default inverted" data-dismiss="modal" type="button"><?php  echo esc_attr_e('Close','adaptable-child'); ?></button>
            </div>
        </div>
    </div>
</div>
