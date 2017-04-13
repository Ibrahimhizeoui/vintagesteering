<?php
/*
Template Name: How It Works
*/
get_header();

$id = (is_home()) ? $id = get_option('page_for_posts') : get_the_ID();

get_template_part('bar', 'two');

// includes the controller file for billboards
include('includes/billboard/billboard.php'); ?>

<main class="main" role="main">
    <div class="container container--padded">
        <?php
        $overview = get_field('hiw_overview_text');
        $info = get_field('hiw_content_info');
        ?>

        <?php if (!empty($overview) && !empty($info)): ?>
            <section class="pageContent__row pageContent__standardBlock standardBlock row row--spaced--plus intro">
                <div class="container">
                    <div class="row">
                        <div class="col-md-6">
                            <h1 class="standardBlock__title"><?php echo $overview; ?></h1>
                        </div>
                        <div class="col-md-6">
                            <?php echo $info; ?>
                        </div>
                    </div>
                </div>
            </section>
        <?php endif; ?>

        <section class="row row--spaced--plus promoSet">
            <?php if ( have_rows('hiw_features') ): ?>
                <?php while ( have_rows('hiw_features') ): the_row(); ?>
                    <div class="col-sm-4 promoSet__promo promo">
                        <i class="promo__icon">
                            <img class="promo__image" src="<?php echo get_stylesheet_directory_uri().'/images/icons/star-icon.png'; ?>" alt="Gold Circular icon with central white star" title="Circle Star Icon"/>
                        </i>
                        <article class="promo__article">
                            <h6><?php the_sub_field('feature'); ?></h6>
                            <p><?php the_sub_field('description'); ?></p>
                        </article>
                    </div>
                <?php endwhile; ?>
            <?php endif; ?>
        </section>

        <?php if ( have_rows('hiw_descriptions') ): ?>
            <?php while ( have_rows('hiw_descriptions') ): the_row(); ?>
                <article class="row row--spaced standardTextBlock">
                    <div class="col-xs-12">
                        <h5 class="standardTextBlock__title"><?php the_sub_field('title'); ?></h5>
                        <p class="standardTextBlock__text"><?php the_sub_field('text'); ?></p>
                    </div>
                </article>
            <?php endwhile; ?>
        <?php endif; ?>

        <section class="row row--spaced--plus--plus standardImageBlock">
            <?php
            // This is for when we're grabbing content via the image id
            $image = acf_image_data(get_field('hiw_image'), 'large'); ?>
            <img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" width="<?php echo $image['width']; ?>" height="<?php echo $image['height']; ?>" />
        </section>
    </div>
</main>

<?php get_footer(); ?>
