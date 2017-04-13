<?php

// Billboard Title Text
$billboard_title = get_field('b_billboard_title') ? get_field('b_billboard_title') : get_the_title();

// Billboard Image Data
$billboard_image_id = get_field('b_billboard_image') ? get_field('b_billboard_image') : get_field('b_billboard_option_image', 'option');
$billboard_image_attributes = wp_get_attachment_image_src( $billboard_image_id, 'large' );
$billboard_image_url =  $billboard_image_attributes ? $billboard_image_attributes[0] : '';

// Billboard Button
$billboard_button_text = get_field('b_billboard_button_text');
$billboard_button_url = get_field('b_billboard_button_url');

// output ?>
<header class="billboard billboard--overlay" style="background-image: url('<?php echo $billboard_image_url; ?>');">
    <div class="billboard__content billboard__content--left">
        <div class="col-sm-6 billboard__segment space">
            <h1 class="billboard__title"><?php echo $billboard_title; ?></h1>
            <?php if ($billboard_button_text && $billboard_button_url): ?>
                <a class="billboard__button button button--alternate" href="<?php echo $billboard_button_url; ?>"><?php echo $billboard_button_text; ?></a>
            <?php endif; ?>
        </div>
        <div class="col-sm-6 billboard__segment">
            <?php get_template_part('search-one'); ?>
        </div>
    </div>
</header>
