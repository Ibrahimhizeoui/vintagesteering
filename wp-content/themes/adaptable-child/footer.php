<?php
global $imic_options;
$menu_locations = get_nav_menu_locations(); ?>

    <footer class="site-footer">
        <?php if (is_active_sidebar('footer-sidebar')) : ?>
            <div class="site-footer-top">
            	<div class="container container--spacious">
                    <div class="row">
                        <?php dynamic_sidebar('footer-sidebar'); ?>
                        <div class="col-md-4 col-sm-4 widget footer_widget">
                            <?php
                            $mailchimp_classes = array('');
                            include(locate_template('includes/template-parts/marketing/mailchimp.php')); ?>
                        </div>
                    </div>
                 </div>
           	</div>
        <?php endif; ?>

        <div class="site-footer-bottom">
        	<div class="container">
                <div class="row">
                	<div class="col-md-6 col-sm-6 copyrights-left">
                        <!--<div class="googleTranslate" id="google_translate_element"></div>-->        
                    	<p class="footerCopyright"><?php echo $imic_options['footer_copyright_text']; ?></p>
                    </div>

                    <?php $socialSites = $imic_options['footer_social_links']; ?>
                    <div class="col-md-6 col-sm-6 copyrights-right clearfix">
                        <ul class="social-icons social-icons-colored">
                            <?php
                            foreach ($socialSites as $key => $value) {
                                if (filter_var($value, FILTER_VALIDATE_URL)) {
                                    $string = substr($key, 3);
                                    echo '<li class="'.$string.'"><a href="'.esc_url($value).'" target="_blank"><i class="fa '.$key.'"></i></a></li>';
                                }
                            } ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <a id="back-to-top"><i class="fa fa-angle-double-up"></i></a>

    <?php
    // Generic modals
    include(locate_template('includes/template-parts/modals/modal-payment.php'));
    include(locate_template('includes/template-parts/modals/modal-search.php'));
    include(locate_template('includes/template-parts/modals/modal-deletion-confirmation.php'));
    include(locate_template('includes/template-parts/modals/modal-approvalseal.php'));
    include(locate_template('includes/template-parts/modals/modal-premium.php'));
    include(locate_template('includes/template-parts/modals/modal-requestinfo.php'));

    // Modals specific to the single-cars template
    if (is_singular( 'cars' )) {
        include(locate_template('includes/template-parts/modals/modal-send_to_friend.php'));
        include(locate_template('includes/template-parts/modals/modal-request_testdrive.php'));
        include(locate_template('includes/template-parts/modals/modal-make_an_offer.php'));
    }

    wp_footer(); ?>
</body>
</html>
