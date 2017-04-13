<?php
$id = get_the_ID();

// Defaults
$default_listing_image = ( isset($imic_options['default_car_image']) ) ? $imic_options['default_car_image']['url'] : '';

// Vehicle Images
$cars_images = [];
$vehicle_gallery = get_post_meta($id, 'imic_plugin_vehicle_images', false);
if (!empty($vehicle_gallery)) {
    foreach ($vehicle_gallery as $attachmentID) {
        $cars_images[] = [
            'thumb' => wp_get_attachment_image_src($attachmentID, 'thumb', false),
            'medium' => wp_get_attachment_image_src($attachmentID, '1000x800', false),
            'full' => wp_get_attachment_image_src($attachmentID, 'full', false)
        ];
    }
}

// Check if the user has uploaded a video for their lisitng
$video = get_post_meta($id, 'imic_plugin_video_url', true);
$video_thumb = ($video) ? wp_get_attachment_image_src(get_field('id_video_iframe_default', 'option'), 'large') : '';

if (!empty($cars_images) || $video) {
    $modalEnable = 'data-listings-modal';
}

?>

<div class="col-md-12">
    <div class="listing-slider">
        <div id="listing-images" class="format-gallery listing-images flexslider">

            <?php if ($plan_premium == 1): ?>
                <div class="listing-badges">
                    <span class="label label-bulk label-success premium-listing" data-premium-modal data-mfp-src="#premiumModal">
                        <?php echo esc_attr_e('Premium listing', 'adaptable-child'); ?>
                    </span>
                </div>
            <?php endif; ?>

            <ul class="slides" <?php print_r($modalEnable); ?>>
                <?php // If we have a video for the vehicle
                if ($video): ?>
                    <li class="format-video">
                        <a href="<?php echo $video; ?>" class="media-box mfp-iframe">
                            <?php if(isYoutubeLink($video)): ?>
                                <?php $youtubeID = getYoutubeIdFromUrl($video); ?>
                                <img src="http://img.youtube.com/vi/<?php echo $youtubeID; ?>/mqdefault.jpg" alt="" title="" />
                            <?php else : ?>
                                <canvas id="canvas_<?php echo md5($video); ?>"></canvas>
                            <?php endif; ?>
                        </a>
                        <?php if(!isYoutubeLink($video)): ?>
                        <video id="video_<?php echo md5($video); ?>" src="<?php echo $video; ?>" style="display:none;"></video>
                        <script>
                            (function(){
                                setTimeout(function(){
                                    var canvas = document.getElementById('canvas_<?php echo md5($video); ?>');
                                    var video = document.getElementById('video_<?php echo md5($video); ?>');
                                    canvas.getContext('2d').drawImage(video, 0, 0, video.videoWidth, video.videoHeight);
                                }, 1500)
                            })();
                        </script>
                        <?php endif; ?>
                    </li>
                <?php endif; ?>

                <?php // If we have uploaded images
                if (!empty($cars_images)): ?>
                    <?php foreach ($cars_images as $image): ?>
                        <li class="media-box">
                            <a href="<?php echo esc_url($image['full'][0]); ?>" class="magnific-gallery-image">
                                <img src="<?php echo esc_url($image['medium'][0]); ?>">
                            </a>
                        </li>
                    <?php endforeach; ?>
                <?php endif; ?>

                <?php // Default placeholder image
                if (!$video || empty($cars_images)): ?>
                    <li class="media-box">
                        <img src="<?php echo esc_url($default_listing_image); ?>" alt="Images Coming Soon">
                    </li>
                <?php endif; ?>
            </ul>
        </div>

        <?php if (count($cars_images) > 1 || ( count($cars_images) == 1 && $video) ): ?>
            <div class="additional-images">
                <div id="listing-thumbs" class="flexslider">
                    <ul class="slides">

                        <?php if ($video): ?>
                            <li class="format-video">
                                <a href="<?php echo $video; ?>" class="media-box mfp-iframe">
                                    <?php if(isYoutubeLink($video)): ?>
                                        <?php $youtubeID = getYoutubeIdFromUrl($video); ?>
                                        <img src="http://img.youtube.com/vi/<?php echo $youtubeID; ?>/mqdefault.jpg" alt="" title="" />
                                    <?php else : ?>
                                        <canvas id="canvas_<?php echo md5($video); ?>_small" style="width:100%;height:100%;"></canvas>
                                    <?php endif; ?>
                                </a>
                                <?php if(!isYoutubeLink($video)): ?>
                                    <script>
                                        (function(){
                                            setTimeout(function(){
                                                var canvas = document.getElementById('canvas_<?php echo md5($video); ?>_small');
                                                var video = document.getElementById('video_<?php echo md5($video); ?>');
                                                canvas.getContext('2d').drawImage(video, 0, 0, video.videoWidth, video.videoHeight);
                                            }, 1500)
                                        })();
                                    </script>
                                <?php endif; ?>
                            </li>
                        <?php endif; ?>

                        <?php if (!empty($cars_images)): ?>
                            <?php foreach ($cars_images as $images): ?>
                                <li>
                                    <a href="#" class="media-box"><img src="<?php echo esc_url($images['thumb'][0]); ?>" alt=""></a>
                                </li>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>
