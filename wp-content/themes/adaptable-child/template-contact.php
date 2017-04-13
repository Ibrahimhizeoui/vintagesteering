<?php
/*
Template Name: Contact
*/
get_header();

global $imic_options;

$id = (is_home()) ? $id = get_option('page_for_posts') : get_the_ID();

get_template_part('bar', 'two');

// includes the controller file for billboards
include('includes/billboard/billboard.php');

// Email / Address
$email = get_field('g_bcd_email', 'option') ? get_field('g_bcd_email', 'option') : '';
$address = get_field('g_bcd_address', 'option') ? get_field('g_bcd_address', 'option') : '';

?>


<div class="main" role="main">
	<div class="container container--spacious">
        <div class="row">
            <div class="col-md-3" style="min-height:10px;">
                <?php echo "<a class=\"link link--gold link--spaced-down\" href=\"mailto: $email\">$email</a>"; ?>
                <address>
                    <?php echo $address; ?>
                </address>
            </div>
            <div class="col-md-9">
                <section class="contactForm">
                    <div data-formid="f1" class="contactForm__form contactForm__form--visible">
                        <?php gravity_form(1, false, false, false, null, true, null, true); ?>
                    </div>
                </section>
            </div>
       	</div>
   	</div>
</div>
<?php get_footer(); ?>
