var AUTOSTARS = window.AUTOSTARS || {};

jQuery(function($) {
    "use strict";

    $("form.searchoneform").submit(function() {
        $(this).find(':input[value=""]').attr("disabled", "disabled");
        return true; // ensure form still submits
    });
    $("form.search1, form.search2").submit(function() {
        $(this).find(':input[value=""]').attr("disabled", "disabled");
        return true; // ensure form still submits
    });

    AUTOSTARS.megaMenu = function() {
        jQuery('.megamenu-sub-title').closest('ul.sub-menu').wrapInner('<div class="row" />').wrapInner('<div class ="megamenu-container container" />').wrapInner('<li />');
        jQuery('.megamenu-container').closest('li.menu-item-has-children').addClass('megamenu');
        var $class = '';
        jQuery(".megamenu-container").each(function(index, elem) {
            var numImages = $(this).find('.row').children().length;
            switch (numImages) {
                case 1:
                    $class = 12;
                    break;
                case 2:
                    $class = 6;
                    break;
                case 3:
                    $class = 4;
                    break;
                case 4:
                    $class = 3;
                    break;
                default:
                    $class = 2;
            }

            $(this).find('.row').find('.col-md-3').each(function() {
                jQuery(this).removeClass('col-md-3').addClass('col-md-' + $class);
            })
        });
    }

    /* ==================================================
    	Contact Form Validations
    ================================================== */
    AUTOSTARS.ContactForm = function() {
        $('.contact-form').each(function() {
            var formInstance = $(this);
            formInstance.submit(function() {

                var action = $(this).attr('action');

                $("#message").slideUp(750, function() {
                    $('#message').hide();

                    $('#submit')
                        .after('<img src="images/assets/ajax-loader.gif" class="loader" />')
                        .attr('disabled', 'disabled');

                    $.post(action, {
                            fname: $('#fname').val(),
                            lname: $('#lname').val(),
                            email: $('#email').val(),
                            phone: $('#phone').val(),
                            comments: $('#comments').val(),
                            recipients: $('#recipients').val(),
                            captcha_q: jQuery('#captcha').text(),
                            captcha_a: jQuery('#captcha_val').val()
                        },
                        function(data) {
                            document.getElementById('message').innerHTML = data;
                            $('#message').slideDown('slow');
                            $('.contact-form img.loader').fadeOut('slow', function() {
                                $(this).remove()
                            });
                            $('#submit').removeAttr('disabled');
                            if (data.match('success') != null) $('.contact-form').slideUp('slow');

                        }
                    );
                });
                return false;
            });
        });
    }

    /* ==================================================
    	Scroll to Top
    ================================================== */
    AUTOSTARS.scrollToTop = function() {
        var windowWidth = $(window).width(),
            didScroll = false;

        var $arrow = $('#back-to-top');

        $arrow.on("click", function(e) {
            $('body,html').animate({
                scrollTop: "0"
            }, 750, 'easeOutExpo');
            e.preventDefault();
        })

        $(window).scroll(function() {
            didScroll = true;
        });

        setInterval(function() {
            if (didScroll) {
                didScroll = false;

                if ($(window).scrollTop() > 200) {
                    $arrow.fadeIn();
                } else {
                    $arrow.fadeOut();
                }
            }
        }, 250);
    }

    /* ==================================================
       Accordion
    ================================================== */
    AUTOSTARS.accordion = function() {
        var accordion_trigger = $('.accordion-heading.accordionize');

        accordion_trigger.delegate('.accordion-toggle', 'click', function(event) {
            if ($(this).hasClass('active')) {
                $(this).removeClass('active');
                $(this).addClass('inactive');
            } else {
                accordion_trigger.find('.active').addClass('inactive');
                accordion_trigger.find('.active').removeClass('active');
                $(this).removeClass('inactive');
                $(this).addClass('active');
            }
            event.preventDefault();
        });
    }

    /* ==================================================
       Toggle
    ================================================== */
    AUTOSTARS.toggle = function() {
        var accordion_trigger_toggle = $('.accordion-heading.togglize');

        accordion_trigger_toggle.delegate('.accordion-toggle', 'click', function(event) {
            if ($(this).hasClass('active')) {
                $(this).removeClass('active');
                $(this).addClass('inactive');
            } else {
                $(this).removeClass('inactive');
                $(this).addClass('active');
            }
            event.preventDefault();
        });
    }
        /* ==================================================
           Tooltip
        ================================================== */
    AUTOSTARS.toolTip = function() {
        $('a[data-toggle=tooltip]').tooltip();
        $('a[data-toggle=tooltip]').tooltip();
        $('a[data-toggle=popover]').popover({
            html: true
        }).on("click", function(e) {
            e.preventDefault();
            $(this).focus();
        });
    }

    /* ==================================================
       Owl Carousel
    ================================================== */
    AUTOSTARS.OwlCarousel = function() {
        $('.owl-carousel').each(function() {
            var carouselInstance = $(this);
            var carouselColumns = carouselInstance.attr("data-columns") ? carouselInstance.attr("data-columns") : "1"
            var carouselitemsDesktop = carouselInstance.attr("data-items-desktop") ? carouselInstance.attr("data-items-desktop") : "4"
            var carouselitemsDesktopSmall = carouselInstance.attr("data-items-desktop-small") ? carouselInstance.attr("data-items-desktop-small") : "3"
            var carouselitemsTablet = carouselInstance.attr("data-items-tablet") ? carouselInstance.attr("data-items-tablet") : "2"
            var carouselitemsMobile = carouselInstance.attr("data-items-mobile") ? carouselInstance.attr("data-items-mobile") : "1"
            var carouselAutoplay = carouselInstance.attr("data-autoplay") ? carouselInstance.attr("data-autoplay") : false
            var carouselPagination = carouselInstance.attr("data-pagination") == 'yes' ? true : false
            var carouselArrows = carouselInstance.attr("data-arrows") == 'yes' ? true : false
            var carouselSingle = carouselInstance.attr("data-single-item") == 'yes' ? true : false
            var carouselStyle = carouselInstance.attr("data-style") ? carouselInstance.attr("data-style") : "fade"
            var carouselRTL = carouselInstance.attr("data-rtl") ? carouselInstance.attr("data-rtl") : "rtl"

            carouselInstance.owlCarousel({
                items: carouselColumns,
                autoPlay: carouselAutoplay,
                navigation: carouselArrows,
                pagination: carouselPagination,
                itemsDesktop: [1199, carouselitemsDesktop],
                itemsDesktopSmall: [979, carouselitemsDesktopSmall],
                itemsTablet: [768, carouselitemsTablet],
                itemsMobile: [479, carouselitemsMobile],
                singleItem: carouselSingle,
                navigationText: ["<i class='fa fa-chevron-left'></i>", "<i class='fa fa-chevron-right'></i>"],
                stopOnHover: true,
                lazyLoad: true,
                direction: carouselRTL,
                transitionStyle: 'carouselStyle'
            });
        });
    }

    /* ==================================================
       Animated Counters
    ================================================== */
    AUTOSTARS.Counters = function() {
        $('.counters').each(function() {
            $(".timer .count").appear(function() {
                var counter = $(this).html();
                $(this).countTo({
                    from: 0,
                    to: counter,
                    speed: 2000,
                    refreshInterval: 60
                });
            });
        });
    }

    /* ==================================================
       SuperFish menu
    ================================================== */
    AUTOSTARS.SuperFish = function() {
        $('.sf-menu').superfish({
            delay: 200,
            animation: {
                opacity: 'show',
                height: 'show'
            },
            speed: 'fast',
            cssArrows: false,
            disableHI: true
        });
        $(".dd-menu > ul > li:has(ul)").find("a:first").append(" <i class='fa fa-angle-down'></i>");
        $(".dd-menu > ul > li > ul > li:has(ul)").find("a:first").append(" <i class='fa fa-angle-right'></i>");
        $(".dd-menu > ul > li > ul > li > ul > li:has(ul)").find("a:first").append(" <i class='fa fa-angle-right'></i>");
    }

    /* ==================================================
       Header Functions
    ================================================== */
    AUTOSTARS.StickyHeader = function() {
        //Updates scroll position
        var $header = $('.site-header');
        var $headerW = $('.site-header-wrapper');
        var $logo = $('.site-logo img');
        var $topnav = $('.top-navigation');
        var $tagline = $('.site-tagline');
        var $userbtn = $('.user-login-btn');
        var $navbar = $('.navbar');
        var $searchform = $('.navbar .search-form');
        var $bselect = $('.bootstrap-select .dropdown-menu');

        function menuScroll() {
            var lastScroll = 0;
            $(window).scroll(function(event) {
                //Sets the current scroll position
                var st = $(this).scrollTop();
                //Determines up-or-down scrolling
                if (st > lastScroll && $(window).width() > 992) {
                    //Replace this with your function call for downward-scrolling
                    $searchform.slideUp();
                    $bselect.css('visibility', 'hidden');
                } else {}

                //Updates scroll position
                lastScroll = st;
            });
        }
        if ($(window).width() > 992) {
            menuScroll();
        }


        setInterval(function() {
            if ($(window).scrollTop() > 30) {
                $header.addClass('sticky-header');
            } else {
                $header.removeClass('sticky-header');
            }
        }, 250);

    }

    /* ==================================================
    	Responsive Nav Menu
    ================================================== */
    AUTOSTARS.MobileMenu = function() {
        // Responsive Menu Events
        $('#menu-toggle').on("click", function() {
            $(this).toggleClass("opened");
            $(".toggle-menu").slideToggle();
            $(".site-header-wrapper").toggleClass("sticktr");
            $(".body").toggleClass("sticktr");
            var SHHH = $(".site-header").innerHeight();
            var NBHH = $(".navbar").innerHeight();
            var THHH = $(".top-header").innerHeight();
            $(".toggle-menu").css("top", NBHH);
            $(".header-v2 .toggle-menu").css("top", SHHH);
            $(".header-v3 .toggle-menu").css("top", SHHH + THHH);
            return false;
        });
        $(window).resize(function() {
            if ($("#menu-toggle").hasClass("opened")) {
                $(".toggle-menu").css("display", "block");
            }
        });
    }

    /* ==================================================
       IsoTope Portfolio
    ================================================== */
    AUTOSTARS.IsoTope = function() {
        $("ul.sort-source").each(function() {
            var source = $(this);
            var destination = $("ul.sort-destination[data-sort-id=" + $(this).attr("data-sort-id") + "]");
            if (destination.get(0)) {
                $(window).load(function() {
                    destination.isotope({
                        itemSelector: ".grid-item",
                        layoutMode: 'sloppyMasonry'
                    });
                    source.find("a").on("click", function(e) {
                        e.preventDefault();
                        var $this = $(this),
                            filter = $this.parent().attr("data-option-value");
                        source.find("li.active").removeClass("active");
                        $this.parent().addClass("active");
                        destination.isotope({
                            filter: filter
                        });
                        if (window.location.hash != "" || filter.replace(".", "") != "*") {
                            self.location = "#" + filter.replace(".", "");
                        }
                        return false;
                    });
                    $(window).on("hashchange", function(e) {
                        var hashFilter = "." + location.hash.replace("#", ""),
                            hash = (hashFilter == "." || hashFilter == ".*" ? "*" : hashFilter);
                        source.find("li.active").removeClass("active");
                        source.find("li[data-option-value='" + hash + "']").addClass("active");
                        destination.isotope({
                            filter: hash
                        });
                    });
                    var hashFilter = "." + (location.hash.replace("#", "") || "*");
                    var initFilterEl = source.find("li[data-option-value='" + hashFilter + "'] a");
                    if (initFilterEl.get(0)) {
                        source.find("li[data-option-value='" + hashFilter + "'] a").click();
                    } else {
                        source.find("li:first-child a").click();
                    }
                });
            }
        });
        $(window).load(function() {
            var $blogContainer = $('.grid-holder');
            var IsoTopeCont = $(".isotope-grid");

            IsoTopeCont.isotope({
                itemSelector: ".grid-item",
                layoutMode: 'sloppyMasonry'
            });

            if ($blogContainer.length > 0) {

                $blogContainer.isotope({
                    itemSelector: '.grid-item',
                    layoutMode: 'sloppyMasonry'
                });

                $(window).resize(function() {
                    $blogContainer.isotope({
                        itemSelector: '.grid-item',
                        layoutMode: 'sloppyMasonry'
                    });
                });
            }
        });
    }

    /* ==================================================
       IsoTope Portfolio
    ================================================== */
    AUTOSTARS.Password = function() {
        var $input = $('.password-input');
        var $output = $('.password-output');
        var $input2 = $('.password-input2');
        var $output2 = $('.password-output2');
        $.passy.requirements.length.min = 4;

        var feedback = [{
            width: '20%',
            color: '#d9534f'
        }, {
            width: '50%',
            color: '#f0ad4e'
        }, {
            width: '80%',
            color: '#5bc0de'
        }, {
            width: '100%',
            color: '#5cb85c'
        }];

        $input.passy(function(strength, valid) {
            $output.css('background-color', feedback[strength].color);
            $output.css('width', feedback[strength].width);

        });

        $('.password-generate').on("click", function() {
            var sn = $input.passy('generate', 8);
            $($input2).val($input.val());
        });
    }

    AUTOSTARS.Password1 = function() {
        var $input = $('.password-input-popup');
        var $output = $('.password-output-popup');
        var $input2 = $('.password-input2-popup');
        var $output2 = $('.password-output2-popup');
        $.passy.requirements.length.min = 4;

        var feedback = [{
            width: '20%',
            color: '#d9534f'
        }, {
            width: '50%',
            color: '#f0ad4e'
        }, {
            width: '80%',
            color: '#5bc0de'
        }, {
            width: '100%',
            color: '#5cb85c'
        }];

        $input.passy(function(strength, valid) {
            $output.css('background-color', feedback[strength].color);
            $output.css('width', feedback[strength].width);

        });

        $('.password-generate-popup').on("click", function() {
            var sn = $input.passy('generate', 8);
            $($input2).val($input.val());
        });
        //$('.password-input').hidePassword(true);
        //$('.password-input2').hidePassword(true);
    }

    /* ==================================================
       Search Results Listing
    ================================================== */
    AUTOSTARS.RESULTS = function() {
        $('#results-holder').each(function() {
            $(this).find('.result-item').matchHeight();
        });
    }

    /* ==================================================
       Pricing Tables
    ================================================== */
    var $tallestCol;
    AUTOSTARS.pricingTable = function() {
        $('.pricing-table').each(function() {
            $tallestCol = 0;
            $(this).find('> div .features').each(function() {
                ($(this).height() > $tallestCol) ? $tallestCol = $(this).height(): $tallestCol = $tallestCol;
            });
            if ($tallestCol == 0) $tallestCol = 'auto';
            $(this).find('> div .features').css('height', $tallestCol);
        });
    }

    /* ==================================================
       Init Functions
    ================================================== */
    $(document).ready(function() {
        $(".span2").slider({});
        $('.span2').slider().on('slideStop', function(ev) {
            var adjustValue1 = 15;
            var adjustValue2 = 0;
            if (ev.value[0] == ev.value[1]) {
                if ($(this).data('slider-min') + adjustValue1 > ev.value[0]) {
                    adjustValue1 = 0;
                    adjustValue2 = 15;
                }
                $(this).slider('setValue', [ev.value[0] - adjustValue1, ev.value[1] + adjustValue2]); // if equal change value
            }
        });

        $('.span2').slider().on('slide', function(ev) {
            //$(this).attr("data-imic-start", ev.value[0]);
            //$(this).attr("data-imic-end", ev.value[1]);
            $(this).parent().parent().find('input.search-range').val(ev.value[0] + "-" + ev.value[1]);
            $(this).parent().parent().find('.left').text(ev.value[0]);
            $(this).parent().parent().find('.right').text(ev.value[1]);
            $(this).parent().parent().find('.range-val').attr("data-range", ev.value[0] + "-" + ev.value[1]);
            //$('#right').text(ev.value[1]);
        });

        $('.password-show').click(function() {
            var $rel = $(this).attr("rel");
            if ($rel == "0") {
                $(this).attr("rel", "1");
                $("#pwd1").attr("type", "text");
                $("#pwd2").attr("type", "text");
            } else {
                $(this).attr("rel", "0");
                $("#pwd1").attr("type", "password");
                $("#pwd2").attr("type", "password");
            }
        });

        $('.password-show-popup').click(function() {
            var $rel = $(this).attr("rel");
            if ($rel == "0") {
                $(this).attr("rel", "1");
                $("#pwd1-popup").attr("type", "text");
                $("#pwd2-popup").attr("type", "text");
            } else {
                $(this).attr("rel", "0");
                $("#pwd1-popup").attr("type", "password");
                $("#pwd2-popup").attr("type", "password");
            }
        });

        AUTOSTARS.ContactForm();
        AUTOSTARS.scrollToTop();
        AUTOSTARS.accordion();
        AUTOSTARS.toggle();
        AUTOSTARS.toolTip();
        AUTOSTARS.OwlCarousel();
        AUTOSTARS.SuperFish();
        AUTOSTARS.Counters();
        AUTOSTARS.IsoTope();
        AUTOSTARS.StickyHeader();
        AUTOSTARS.Password();
        AUTOSTARS.Password1();
        AUTOSTARS.pricingTable();
        AUTOSTARS.MobileMenu();
        AUTOSTARS.megaMenu();

        $('.selectpicker select').addClass('form-control');

        $('.selectpicker').selectpicker({
            container: 'body'
        });
    });

    // Any Button Scroll to section
    $('.scrollto').on("click", function() {
        $.scrollTo(this.hash, 800, {
            easing: 'easeOutQuint'
        });
        return false;
    });

    $('.categorty-browse-cols').each(function() {
        $(this).find('.categorty-browse-col').matchHeight();
    });

    $(document).ready(function() {

        $('#listing-images').flexslider({
            animation: "slide",
            controlNav: false,
            animationLoop: true,
            smoothHeight: true,
            slideshow: false,
            sync: "#listing-thumbs",
            prevText: "",
            nextText: ""
        });

        /* Listing details slider */
        $('#listing-thumbs').flexslider({
            animation: "slide",
            controlNav: false,
            animationLoop: true,
            slideshow: false,
            directionNav: true,
            itemWidth: 150,
            itemMargin: 10,
            asNavFor: '#listing-images',
            prevText: "",
            nextText: ""
        });

        // Sticky Blocks
        var toffset = $(".site-header-wrapper").height() - 23;
        var soffset = $(".site-header-wrapper").height() + 89;
        var goffset = $(".site-header-wrapper").height() + 19;
        var boffset = $(".site-footer").height() + 90;

        if ($('body').hasClass('admin-bar')) {
            var toffset = $(".site-header-wrapper").height() + 5;
            var soffset = $(".site-header-wrapper").height() + 117;
            var goffset = $(".site-header-wrapper").height() + 47;
            var boffset = $(".site-footer").height() + 118;
        }

        if ($(window).width() > 767) {
            $(".tsticky").sticky({
                topSpacing: toffset
            });
            $(".tbsticky").sticky({
                topSpacing: soffset,
                bottomSpacing: boffset
            });
            $(".tbssticky").sticky({
                topSpacing: goffset,
                bottomSpacing: boffset
            });
        }

        $('.dropdown-toggle.selectpicker').on("click", function(e) {
            $('.bootstrap-select .dropdown-menu').css("visibility", "visible");
            e.preventDefault;
        });

        // Add Listing Form Page

        $('.listing-add-form .registeredv').on("click", function() {
            $(".registration-details").slideDown();
        });
        $('.listing-add-form .noregisteredv').on("click", function() {
            $(".registration-details").slideUp();
        });

        // Listing Page
        $(".toggle-make a").on("click", function() {
            $(".by-type-options").slideToggle();
            return false;
        });
        $(".search-trigger").on("click", function() {
            $(".search-form").slideToggle();
            return false;
        });

        var GridView;
        function GridViewFunction() {
            var GridView = setTimeout(function() {
                $("#results-holder").removeClass("results-list-view");
                $("#results-holder").addClass("results-grid-view");
                $("#results-list-view").removeClass("active");
                $("#results-grid-view").addClass("active");
                AUTOSTARS.RESULTS();
                $(".waiting").hide();
                $('body,html').animate({
                    scrollTop: "212"
                }, 750, 'easeOutExpo');
            }, 800);
        }

        function GridViewStopFunction() {
            clearTimeout(GridView);
        }
        var ListView;

        function ListViewFunction() {
            var ListView = setTimeout(function() {
                $("#results-holder").removeClass("results-grid-view");
                $("#results-holder").addClass("results-list-view");
                $("#results-grid-view").removeClass("active");
                $("#results-list-view").addClass("active");
                $("#results-holder").find(".result-item").css("height", "auto");
                $(".waiting").hide();
                $('body,html').animate({
                    scrollTop: "212"
                }, 750, 'easeOutExpo');
            }, 800);
        }

        function ListViewStopFunction() {
            clearTimeout(ListView);
        }
        $("#results-grid-view").on("click", function() {
            $(".waiting").fadeIn();
            GridViewFunction();
            GridViewStopFunction();
            return false;
        });

        $("#results-list-view").on("click", function() {
            $(".waiting").fadeIn();
            ListViewFunction();
            ListViewStopFunction();
            return false;
        });

        if ($("#results-holder").hasClass("results-grid-view")) {
            AUTOSTARS.RESULTS();
        }
        //* Advanced Search Trigger
        $('.search-advanced-trigger').on("click", function() {
            if ($(this).hasClass('advanced')) {
                $(this).removeClass('advanced');
                $(".advanced-search-row").slideDown();
                $(this).html(overform.basic + ' <i class="fa fa-arrow-up"></i>');
            } else {

                $(this).addClass('advanced');
                $(".advanced-search-row").slideUp();
                $(this).html(overform.advanced + ' <i class="fa fa-arrow-down"></i>');
            }
            return false;
        });

        $("#Show-Filters").on("click", function() {
            $("#Search-Filters").slideToggle();
        });

        // Tabs deep linking
        $('a[data-toggle="tab"]').on("click", function(e) {
            e.preventDefault();
            $('a[href="' + $(this).attr('href') + '"]').tab('show');
        });

        // Vehicle Details Clone
        $(".badge-premium-listing").clone().appendTo(".single-listing-actions");
    });
    // FITVIDS
    $(".fw-video, .format-video .post-media").fitVids();

    $(window).load(function() {
        $(".listing-slider .flexslider .format-video a").each(function() {
            $(this).append("<span class='icon'><i class='fa fa-play'></i></span>");
        });
        AUTOSTARS.StickyHeader();
    });
    $(".cust-counter").wrapAll("<section class=\"counters padding-tb45 accent-color text-align-center\"><div class=\"container\"><div class=\"row\">");
    // Icon Append
    $('.basic-link, .categorty-browse-col ul ul li').append(' <i class="fa fa-angle-right"></i>');
    $('.basic-link.backward').prepend(' <i class="fa fa-angle-left"></i> ');
    $('ul.checks li, .add-features-list li').prepend('<i class="fa fa-check"></i> ');
    $('ul.chevrons li').prepend('<i class="fa fa-chevron-right"></i> ');
    $('ul.carets li, ul.inline li, .filter-options-list li').prepend('<i class="fa fa-caret-right"></i> ');
    $('a.external').prepend('<i class="fa fa-external-link"></i> ');

    // Animation Appear
    var AppDel;

    function AppDelFunction($appd) {
        $appd.addClass("appear-animation");
        if (!$("html").hasClass("no-csstransitions") && $(window).width() > 767) {
            $appd.appear(function() {
                var delay = ($appd.attr("data-appear-animation-delay") ? $appd.attr("data-appear-animation-delay") : 1);
                if (delay > 1) $appd.css("animation-delay", delay + "ms");
                $appd.addClass($appd.attr("data-appear-animation"));
                setTimeout(function() {
                    $appd.addClass("appear-animation-visible");
                }, delay);
                clearTimeout();
            }, {
                accX: 0,
                accY: -150
            });
        } else {
            $appd.addClass("appear-animation-visible");
        }
    }

    function AppDelStopFunction() {
        clearTimeout(AppDel);
    }

    $("[data-appear-animation]").each(function() {
        var $this = $(this);
        AppDelFunction($this);
        AppDelStopFunction();
    });


    // Animation Progress Bars
    var AppAni;

    function AppAniFunction($anim) {
        $anim.addClass($anim.attr("data-appear-animation"));
        $anim.animate({
            width: $anim.attr("data-appear-progress-animation")
        }, 1000, "linear");
    }

    (function() {
        var $progressBar = $('[data-appear-progress-animation]');
        AppAniFunction($progressBar);
    }());

    // Parallax Jquery Callings
    if (!Modernizr.touch) {
        $(window).on('load', function() {
            parallaxInit();
        });
    }

    function parallaxInit() {
        $('.parallax1').parallax("50%", 0.1);
        $('.parallax2').parallax("50%", 0.1);
        $('.parallax3').parallax("50%", 0.1);
        $('.parallax4').parallax("50%", 0.1);
        $('.parallax5').parallax("50%", 0.1);
        $('.parallax6').parallax("50%", 0.1);
        $('.parallax7').parallax("50%", 0.1);
        $('.parallax8').parallax("50%", 0.1);
        /*add as necessary*/
    }
    // Window height/Width Getter Classes
    var wheighter = $(window).height();
    var wwidth = $(window).width();
    $(".wheighter").css("height", wheighter);
    $(".wwidth").css("width", wwidth);
    $(window).resize(function() {
        var wheighter = $(window).height();
        var wwidth = $(window).width();
        $(".wheighter").css("height", wheighter);
        $(".wwidth").css("width", wwidth);
    });
});
jQuery(".property-img").on('click', function(e) {
    e.preventDefault();

    var that = jQuery(this);
    $property_id = jQuery(this).find('[data-adlisting-propertyid]').text();
    $thumb_id = jQuery(this).find('[data-adlisting-imageid]').text();

    jQuery.ajax({
        type: 'POST',
        url: values.ajaxurl,
        data: {
            action: 'update_property_featured_image',
            property_id: $property_id,
            thumb_id: $thumb_id,
        },
        success: function(data) {
            jQuery('[data-adlisting-imagebox]').each(function() {
                if (that.parent().find('[data-adlisting-imageid]').text() != jQuery(this).find('[data-adlisting-imageid]').text()) {
                    jQuery(this).find('[data-adlisting-thumb]').contents().unwrap();
                    jQuery(this).find('a').contents().unwrap();
                    jQuery(this).find('[data-adlisting-image]').wrap('<a class="accent-color default-image" data-original-title="Set as default image" data-toggle="tooltip" style="text-decoration:none;" href="#"></a>');
                } else {
                    jQuery(this).find('[data-adlisting-thumb]').contents().unwrap();
                    jQuery(this).find('a').contents().unwrap();
                }
            })
        },
        error: function(errorThrown) {}
    });
});
//Remove property image
jQuery(".remove-image").live('click', function() {

    var ID = jQuery(this).attr('id');
    var PRID = jQuery(this).attr('rel');
    var globalOverlay = jQuery('[data-overlay]');

    jQuery(globalOverlay).show();

    jQuery.ajax({
        type: 'POST',
        url: values.ajaxurl,
        data: {
            action: 'imic_remove_property_image',
            thumb_id: ID,
            property_id: PRID,
        },
        success: function(data) {
            jQuery("#" + ID).parent().parent().remove();
            jQuery(globalOverlay).hide();
        },
        error: function(errorThrown) {}
    });
});

jQuery(".get-child-field").on('change', function() {
    //alert("sainath");
    var $spec_id = jQuery(this).attr("id");
    var $spec_val_sort = jQuery(this).val();
    jQuery.ajax({
        type: 'POST',
        url: values.ajaxurl,
        data: {
            action: 'imic_sortable_specification',
            sorting: $spec_val_sort,
            spec_id: $spec_id
        },
        success: function(data) {
            //alert(data);
            var $dyna_div = $spec_id;
            $dyna_div = $dyna_div.split("-");
            var $dyna_id = $dyna_div[1] - 2648;
            $dyna_id = ($dyna_id * 111) + 2648;
            jQuery("#" + $spec_id + ":hidden").html();
            jQuery("div#" + $dyna_div[0] + "-" + $dyna_id).html(data);
            if ($spec_val_sort == "0") {
                jQuery(".sorting-dynamic").hide();
            }
            jQuery('.selectpicker').selectpicker({
                container: 'body'
            });
        },
        error: function(errorThrown) {}
    });
});


jQuery(".get-child-filter").on('click', function() {
    var $spec_id = jQuery(this).parent().parent().attr("data-ids");
    var $spec_val_sort = jQuery(this).text();
    var $dyna_div;
    var $dyna_id_wp;
    var $dyna_id;

    jQuery(this).parent().parent().parent().parent().collapse("hide");

    jQuery.ajax({
        type: 'POST',
        url: values.ajaxurl,
        data: {
            action: 'imic_sortable_specification_filter',
            sorting: $spec_val_sort,
            spec_id: $spec_id
        },
        success: function(data) {
            //alert(data);
            $dyna_div = $spec_id;
            $dyna_div = $dyna_div.split("-");
            $dyna_id_wp = $dyna_div[1] - 2648;
            $dyna_id = $dyna_div[1] - 2648;
            $dyna_id = ($dyna_id * 111) + 2648;

            jQuery("#" + $spec_id + ":hidden").html();
            jQuery("div#" + $dyna_div[0] + "-" + $dyna_id).html(data);

            if ($spec_val_sort == "0") {
                jQuery(".sorting-dynamic").hide();
            }

            jQuery('.selectpicker').selectpicker({
                container: 'body'
            });

            jQuery('.new-filter-list li').prepend('<i class="fa fa-caret-right"></i> ');

            jQuery('#collapseTwo-sub' + $dyna_id_wp).collapse("show");
        },
        error: function(errorThrown) {
            console.log('error' + errorThrown);
        }
    });
});
