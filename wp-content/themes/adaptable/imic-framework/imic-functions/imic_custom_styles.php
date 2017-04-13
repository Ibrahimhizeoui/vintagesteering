<?php

if ( !function_exists( 'imic_custom_styles' ) )
{
    function imic_custom_styles( )
    {
        $options = get_option( 'imic_options' );
        // OPEN STYLE TAG
        echo '<style type="text/css">' . "\n";
            // Custom CSS
            $custom_css = $options[ 'custom_css' ];
            if ( $options[ 'enable-header-stick' ] == 0 )
            {
                echo '.site-header-wrapper{position:relative;}body.admin-bar .site-header-wrapper{top:0;}.body{padding-top:0!important;}.actions-bar.tsticky{top:0!important;}';
            }
            if ( $options[ 'theme_color_type' ][ 0 ] == 1 )
            {
                $primaryColor = $options[ 'primary_theme_color' ];
                echo '
                    .text-primary, .btn-primary .badge, .btn-link,a.list-group-item.active > .badge,.nav-pills > .active > a > .badge, p.drop-caps:first-child:first-letter, .accent-color, .nav-np .next:hover, .nav-np .prev:hover, .basic-link, .pagination > li > a:hover,.pagination > li > span:hover,.pagination > li > a:focus,.pagination > li > span:focus, .accordion-heading:hover .accordion-toggle, .accordion-heading:hover .accordion-toggle.inactive, .accordion-heading:hover .accordion-toggle i, .accordion-heading .accordion-toggle.active, .accordion-heading .accordion-toggle.active, .accordion-heading .accordion-toggle.active i, .main-navigation > ul > li > ul > li a:hover, .main-navigation > ul > li:hover > a, .main-navigation > ul > li:hover > a > i, .top-navigation li a:hover, .search-form h3, .featured-block h4, .vehicle-cost, .icon-box-inline span, .post-title a, .post-review-block h3.post-title a:hover, .review-status strong, .testimonial-block blockquote:before, .testimonial-info span, .additional-images .owl-carousel .item-video i, .vehicle-enquiry-foot i, .vehicle-enquiry-head h4, .add-features-list li i, .comparision-table .price, .search-filters .accordion-heading.accordionize .accordion-toggle.active, .search-filters .accordion-heading.togglize .accordion-toggle.active, .search-filters .accordion-heading .accordion-toggle.active, .search-filters .accordion-heading:hover .accordion-toggle.active, .search-filters .accordion-heading:hover .accordion-toggle.active:hover, .search-filters .accordion-heading.accordionize .accordion-toggle.active i, .search-filters .accordion-heading.togglize .accordion-toggle.active i, .filter-options-list li a:hover, .calculator-widget .loan-amount, .map-agent h4 a, .pricing-column h3, .listing-form-steps li.active a .step-state, .listing-form-steps li:hover a .step-state, .result-item-pricing .price, .result-item-features li i, .users-sidebar .list-group li a:hover > i, .saved-cars-table .price, .post .post-title a:hover, a, .post-actions .comment-count a:hover, .pricing-column .features a:hover, a:hover, .service-block h4 a:hover, .saved-cars-table .search-find-results a:hover, .widget a:hover, .nav-tabs > li > a:hover, .list-group-item a:hover, .icon-box.ibox-plain .ibox-icon i,.icon-box.ibox-plain .ibox-icon img, .icon-box.ibox-border .ibox-icon i,.icon-box.ibox-border .ibox-icon img, .top-header .sf-menu > li:hover > a, .header-v2 .topnav > ul > li:hover > a, .header-v4 .search-function .search-trigger, .additional-triggers > li > a:hover, .woocommerce div.product span.price, .woocommerce div.product p.price, .woocommerce #content div.product span.price, .woocommerce #content div.product p.price, .woocommerce-page div.product span.price, .woocommerce-page div.product p.price, .woocommerce-page #content div.product span.price, .woocommerce-page #content div.product p.price, .woocommerce ul.products li.product .price, .woocommerce-page ul.products li.product .price{
    	               color:' . esc_attr( $primaryColor ) . ';
                    }
                   .basic-link:hover, .continue-reading:hover{
    	                  opacity:.8
                    }

                    p.drop-caps.secondary:first-child:first-letter, .accent-bg, .btn-primary,
                    .btn-primary.disabled,
                    .btn-primary[disabled],
                    fieldset[disabled] .btn-primary,
                    .btn-primary.disabled:hover,
                    .btn-primary[disabled]:hover,
                    fieldset[disabled] .btn-primary:hover,
                    .btn-primary.disabled:focus,
                    .btn-primary[disabled]:focus,
                    fieldset[disabled] .btn-primary:focus,
                    .btn-primary.disabled:active,
                    .btn-primary[disabled]:active,
                    fieldset[disabled] .btn-primary:active,
                    .btn-primary.disabled.active,
                    .btn-primary[disabled].active,
                    fieldset[disabled] .btn-primary.active,
                    .dropdown-menu > .active > a,
                    .dropdown-menu > .active > a:hover,
                    .dropdown-menu > .active > a:focus,
                    .nav-pills > li.active > a,
                    .nav-pills > li.active > a:hover,
                    .nav-pills > li.active > a:focus,
                    .pagination > .active > a,
                    .pagination > .active > span,
                    .pagination > .active > a:hover,
                    .pagination > .active > span:hover,
                    .pagination > .active > a:focus,
                    .pagination > .active > span:focus,
                    .label-primary,
                    .progress-bar-primary,
                    a.list-group-item.active,
                    a.list-group-item.active:hover,
                    a.list-group-item.active:focus,
                    .panel-primary > .panel-heading, .carousel-indicators .active, .flex-control-nav a:hover, .flex-control-nav a.flex-active, .media-box .media-box-wrapper, .media-box .zoom .icon, .media-box .expand .icon, .icon-box.icon-box-style1:hover .ico, .cart-bubble, .toggle-make a:hover, .search-trigger, .toggle-make a, .featured-block-image strong, .pass-actions:hover, .utility-icons > li > a:hover, .utility-icons > li:hover > a, .owl-theme .owl-page.active span, .owl-theme .owl-controls.clickable .owl-page:hover span, .seller-info, .search-icon-boxed, .logged-in-user:hover .user-dd-dropper, .testimonials-wbg .testimonial-block blockquote:after, .selling-choice > .btn-default.active, .fact-ico, .ibox-effect.ibox-dark .ibox-icon i:hover,.ibox-effect.ibox-dark:hover .ibox-icon i,.ibox-border.ibox-effect.ibox-dark .ibox-icon i:after, .icon-box .ibox-icon i,.icon-box .ibox-icon img, .icon-box .ibox-icon i,.icon-box .ibox-icon img, .icon-box.ibox-dark.ibox-outline:hover .ibox-icon i, .share-buttons-tc > li > a{
                        background-color: ' . esc_attr( $primaryColor ) . ';
                    }
                    .btn-primary:hover,
                    .btn-primary:focus,
                    .btn-primary:active,
                    .btn-primary.active,
                    .open .dropdown-toggle.btn-primary, .toggle-make a:hover, .toggle-make a:hover, .search-trigger:hover, .woocommerce a.button.alt:hover, .woocommerce button.button.alt:hover, .woocommerce input.button.alt:hover, .woocommerce #respond input#submit.alt:hover, .woocommerce #content input.button.alt:hover, .woocommerce-page a.button.alt:hover, .woocommerce-page button.button.alt:hover, .woocommerce-page input.button.alt:hover, .woocommerce-page #respond input#submit.alt:hover, .woocommerce-page #content input.button.alt:hover, .woocommerce a.button.alt:active, .woocommerce button.button.alt:active, .woocommerce input.button.alt:active, .woocommerce #respond input#submit.alt:active, .woocommerce #content input.button.alt:active, .woocommerce-page a.button.alt:active, .woocommerce-page button.button.alt:active, .woocommerce-page input.button.alt:active, .woocommerce-page #respond input#submit.alt:active, .woocommerce-page #content input.button.alt:active, .wpcf7-form .wpcf7-submit{
                      background: ' . esc_attr( $primaryColor ) . ';
                      opacity:.9
                    }
                    p.demo_store, .woocommerce a.button.alt, .woocommerce button.button.alt, .woocommerce input.button.alt, .woocommerce #respond input#submit.alt, .woocommerce #content input.button.alt, .woocommerce-page a.button.alt, .woocommerce-page button.button.alt, .woocommerce-page input.button.alt, .woocommerce-page #respond input#submit.alt, .woocommerce-page #content input.button.alt, .woocommerce span.onsale, .woocommerce-page span.onsale, .wpcf7-form .wpcf7-submit, .woocommerce .widget_price_filter .ui-slider .ui-slider-handle, .woocommerce-page .widget_price_filter .ui-slider .ui-slider-handle, .woocommerce .widget_layered_nav ul li.chosen a, .woocommerce-page .widget_layered_nav ul li.chosen a, .ticket-cost{
                    	background: ' . esc_attr( $primaryColor ) . ';
                    }
                    .nav .open > a,
                    .nav .open > a:hover,
                    .nav .open > a:focus,
                    .pagination > .active > a,
                    .pagination > .active > span,
                    .pagination > .active > a:hover,
                    .pagination > .active > span:hover,
                    .pagination > .active > a:focus,
                    .pagination > .active > span:focus,
                    a.thumbnail:hover,
                    a.thumbnail:focus,
                    a.thumbnail.active,
                    a.list-group-item.active,
                    a.list-group-item.active:hover,
                    a.list-group-item.active:focus,
                    .panel-primary,
                    .panel-primary > .panel-heading, .btn-primary.btn-transparent, .icon-box.icon-box-style1 .ico, .user-login-btn:hover, .icon-box-inline span, .vehicle-enquiry-head, .selling-choice > .btn-default.active, .icon-box.ibox-border .ibox-icon, .icon-box.ibox-outline .ibox-icon, .icon-box.ibox-dark.ibox-outline:hover .ibox-icon, .header-v2 .site-header-wrapper, .dd-menu.topnav > ul > li > ul, .dd-menu.topnav > ul > li.megamenu > ul{
                    	border-color:' . esc_attr( $primaryColor ) . ';
                    }
                    .panel-primary > .panel-heading + .panel-collapse .panel-body, .nav-tabs > li.active > a, .nav-tabs > li.active > a:hover, .nav-tabs > li.active > a:focus, .main-navigation > ul > li ul, .navbar .search-form-inner, .woocommerce .woocommerce-info, .woocommerce-page .woocommerce-info, .woocommerce .woocommerce-message, .woocommerce-page .woocommerce-message{
                    	border-top-color:' . esc_attr( $primaryColor ) . ';
                    }
                    .panel-primary > .panel-footer + .panel-collapse .panel-body{
                    	border-bottom-color:' . esc_attr( $primaryColor ) . ';
                    }
                    .search-find-results, .dd-menu > ul > li > ul li ul{
                    	border-left-color:' . esc_attr( $primaryColor ) . ';
                    }
                    .ibox-border.ibox-effect.ibox-dark .ibox-icon i:hover,.ibox-border.ibox-effect.ibox-dark:hover .ibox-icon i {
                    	box-shadow:0 0 0 1px ' . esc_attr( $primaryColor ) . ';
                    }
                    .ibox-effect.ibox-dark .ibox-icon i:after {
                    	box-shadow:0 0 0 2px ' . esc_attr( $primaryColor ) . ';
                    }
                    @media only screen and (max-width: 767px) {
                    	.utility-icons.social-icons > li > a:hover{
                    		color:' . esc_attr( $primaryColor ) . ';
                    	}
                    }
                    /* Color Scheme Specific Classes */';
                }

                if ( $custom_css )
                {
                    echo "\n" . '/*========== User Custom CSS Styles ==========*/' . "\n";
                    echo esc_attr( $custom_css );
                }
                // CLOSE STYLE TAG
            echo "</style>" . "\n";
    }
    add_action( 'wp_head', 'imic_custom_styles' );
}
