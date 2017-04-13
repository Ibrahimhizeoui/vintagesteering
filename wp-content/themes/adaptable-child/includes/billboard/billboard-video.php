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

$billboard_button_text_two = get_field('b_billboard_button_text_two');
$billboard_button_url_two = get_field('b_billboard_button_url_two');

// Billboard Video
$billboard_postimage_id = get_field('b_billboard_video_postimage') ? get_field('b_billboard_video_postimage') : get_field('b_billboard_option_postimage', 'option');
$billboard_postimage_attributes = wp_get_attachment_image_src( $billboard_postimage_id, 'medium' );
$billboard_postimage_url =  $billboard_postimage_attributes ? $billboard_postimage_attributes[0] : '';
$billboard_video_url = get_field('b_billboard_videourl');
// extact iframe URL
preg_match('/src="([^"]+)"/', $billboard_video_url, $match);
// URL
$video_url = isset($match[1]) ? $match[1] : '';

// output ?>
<header class="billboard billboard--overlay" style="background-image: url('<?php echo $billboard_image_url; ?>');">
    <div class="billboard__content billboard__content--left">
        <div class="col-sm-6 billboard__segment space">
            <h1 class="billboard__title"><?php echo $billboard_title; ?></h1>
            <div class="buttonGroup">
                <?php if ($billboard_button_text && $billboard_button_url): ?>
                    <a class="billboard__button button" href="<?php echo $billboard_button_url; ?>"><?php echo $billboard_button_text; ?></a>
                <?php endif; ?>
                <?php if ($billboard_button_text_two && $billboard_button_url_two): ?>
                    <a class="billboard__button button button--alternate" href="<?php echo $billboard_button_url_two; ?>"><?php echo $billboard_button_text_two; ?></a>
                <?php endif; ?>
            </div>
        </div>
        <div class="col-sm-6 billboard__segment">
            <div class="billboard__video" data-billboard-video>
                <a class="billboard__playButton mfp-iframe" href="<?php echo $video_url; ?>">
                    <i class="playButton" >
                        <span class="playButton__accessibility">Play Video</span>
                        <span class="playButton__icon"></span>
                    </i>
                </a>
                <img src="<?php echo $billboard_postimage_url; ?>" role="presentation" />
            </div>
        </div>
    </div>
</header>
