<?php
/**
 * Controls a standard half/half text/text block on single pages.
 *
 * Available Objects
 * content_overview
 * content_info
 */

$overview   = get_sub_field('content_overview'); ?>

<?php if (!empty($overview)): ?>
    <section class="pageContent__row pageContent__standardBlock standardBlock">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h3><?php echo $overview; ?></h3>
                    <div class="spaced spaced--plus">
                        <?php if( have_rows('content_links') ): while ( have_rows('content_links') ) : the_row(); ?>

                            <?php
                            $buttonColour = get_sub_field('colour');

                            switch ($buttonColour) {
                                case 'black':
                                    $buttonColourString = ' button--black';
                                    break;
                                case 'green':
                                    $buttonColourString = ' button--alternate';
                                    break;
                                case 'gold':
                                    $buttonColourString = '';
                                default:
                                    $buttonColourString = '';
                            }; ?>

                            <a href="<?php the_sub_field('url'); ?>" class="button<?php echo $buttonColourString; ?>"><?php the_sub_field('text'); ?></a>
                        <?php endwhile; endif; ?>
                    </div>
                </div>
                <div class="col-md-6">
                    <?php
                    $mailchimp_classes = array('mailchimp--standalone');
                    include(locate_template('includes/template-parts/marketing/mailchimp.php')); ?>
                </div>
            </div>
        </div>
    </section>
<?php endif; ?>
