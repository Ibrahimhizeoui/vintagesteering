<?php

// Billboard Title Text
$billboard_title = get_field('hpbl_billboard_title') ? get_field('hpbl_billboard_title') : get_the_title();

// Billboard Image Data
$billboard_image_id = get_field('hpbl_billboard_image') ? get_field('hpbl_billboard_image') : get_field('b_billboard_option_image', 'option');
$billboard_image_attributes = wp_get_attachment_image_src( $billboard_image_id, 'large' );
$billboard_image_url =  $billboard_image_attributes ? $billboard_image_attributes[0] : '';

// Billboard Button
$billboard_button_text = get_field('hpbl_billboard_button_text');
$billboard_button_url = get_field('hpbl_billboard_button_url');

$billboard_button_text_two = get_field('hpbl_billboard_button_text_two');
$billboard_button_url_two = get_field('hpbl_billboard_button_url_two');

// output ?>
<header class="billboard billboard--central billboard--overlay billboard--max-height billboard--matching-buttons" style="background-image: url('<?php echo $billboard_image_url; ?>');">
    <div class="billboard__content">
        <h1 class="billboard__title billboard__title--uppercase billboard__title--nomax"><?php echo $billboard_title; ?></h1>
        <?php if ($billboard_button_text && $billboard_button_url): ?>
            <a class="button" href="<?php echo $billboard_button_url; ?>"><?php echo $billboard_button_text; ?></a>
        <?php endif; ?>
        <?php if ($billboard_button_text_two && $billboard_button_url_two): ?>
            <a class="button button--alternate" href="<?php echo $billboard_button_url_two; ?>"><?php echo $billboard_button_text_two; ?></a>
        <?php endif; ?>
    </div>
</header>
