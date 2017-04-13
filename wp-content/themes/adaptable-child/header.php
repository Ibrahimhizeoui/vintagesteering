<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<style type="text/css">
    .mmenu{
        height: 100px;
    }
</style>
    <?php include(locate_template('includes/wordpress/adp-wp_head.php')); ?>
   
    <body <?php body_class('body'); ?>>
        <div class="site-header-wrapper">
            <header class="top-header mmenu">
                <div class="container sp-cont">
                    <div class="pull-right top-header__dropdown top-header__mobileMenu mobileMenu">
                        <a href="#" class="visible-sm visible-xs" id="menu-toggle"><i class="fa fa-bars"></i></a>
                    </div>

                    <div class="pull-right top-header__dropdown top-header__currency currencySwitcher">
                        <?php // Currency Switcher Dropdown
                        include(locate_template('includes/template-parts/header/adp_currency_switcher.php')); ?>
                    </div>

                    <div class="pull-right top-header__dropdown top-header__language languageSwitcher">
                        <?php // Language Switcher Dropdown
                        include(locate_template('includes/template-parts/header/adp_language_switcher.php')); ?>
                    </div>

                    <ul class="pull-right social-icons social-icons-colored">
                        <?php // List of inputted Social Profiles
                        include(locate_template('includes/template-parts/header/adp_social_profiles.php')); ?>
                    </ul>

                    <?php // Primary menu
                    include(locate_template('includes/template-parts/header/adp_primary_menu.php')); ?>
               	</div>
            </header>

            <header class="site-header">
                <div class="container sp-cont">
                    <div class="site-logo">
                        <?php // Site branding control
                        include(locate_template('includes/template-parts/header/adp_site_branding.php')); ?>
                    </div>

                    <div class="header-right">
                        <?php // User login options
                        include(locate_template('includes/template-parts/header/adp_user_login.php')); ?>
                    </div>
                </div>
            </header>
        </div>
