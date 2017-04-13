<?php // AD LISTING STEP FOUR
    $content = '';
    if ($update_id != '')
    {
        $post_id = get_post($update_id);
        $content = $post_id->post_content;
    }
?>

<div id="listing-add-form-four" class="stepContent tab-pane fade <?php echo ($active_tab4 != '') ? $active_tab4 . ' in' : ''; ?>">
    <div class="stepContent__section stepContent__header">
        <h3><?php echo esc_attr_e('Vehicle Description & Photos', 'adaptable-child'); ?></h3>
        <p><?php echo esc_attr_e('Max 12 photos, Max file size (2mb)'); ?></p>
    </div>

    <div class="stepContent__section stepContent__fileUploads">
        <h6 class="upper">Upload Photos</h6>
        <div class="customFileUpload button button--gold spaced">
            <span>Choose File(s)</span>
            <?php FRONT_MEDIA_ALLOW::wp_media_upload_button(); ?>
        </div>
        <p id="fileMessages"></p>
        <div class="image-placeholder row" id="photoList_new"></div>
        <?php
        $property_sights_value = get_post_meta($update_id, 'imic_plugin_vehicle_images', false);
        echo '<div class="image-placeholder row" id="photoList">';
            if (!empty($property_sights_value))
            {
                echo '<p>Click an image to make it the featured image for your listing</p>';
                foreach($property_sights_value as $property_sights)
                {
                    $default_featured_image = get_post_meta($update_id, '_thumbnail_id', true);
                    $def_class = ($default_featured_image == $property_sights) ? 'default-feat-image' : '' ;

                    echo '<div class="col-sm-3 col-xs-4">';
                        echo '<div class="property-img" data-adlisting-imagebox>';
                            echo '<div class="property-thumb ' . esc_attr($def_class) . '" data-adlisting-thumb>';
                                echo '<a data-featured-image id="feat-image" class="accent-color default-image" data-original-title="Set as default image" data-toggle="tooltip" style="text-decoration:none;" href="javascript:void(0);">';
                                    echo '<div class="property-details" style="display:none;">';
                                        echo '<span data-adlisting-propertyid class="property-id">' . $update_id . '</span>';
                                        echo '<span data-adlisting-imageid class="thumb-id">' . $property_sights . '</span>';
                                    echo '</div>';
                                    echo '<img src="' . wp_get_attachment_thumb_url($property_sights) . '" class="image-placeholder" alt="" data-adlisting-image/>';
                                echo '</a>';

                                if (true || get_query_var('edit'))
                                {
                                    echo '<input rel="' . $update_id . '" type="button" id="' . $property_sights . '" value="Remove" class="button remove-image">';
                                }
                            echo '</div>';
                        echo '</div>';
                    echo '</div>';
                }
            }
        echo '</div>'; ?>
    </div>

    <div class="stepContent__section">
        <h6 class="upper"><?php echo esc_attr_e('Vehicle Description', 'adaptable-child'); ?></h6>
        <textarea name="vehicle-detail" id="vehicle-detail" class="form-control spaced" rows="10" placeholder="Please add a description of your vehicle, adding any pieces of information that might be of use for potential customers"><?php if (!empty($content)): echo $content; endif; ?></textarea>
    </div>

    <div class="stepContent__section">
        <h6 class="upper"><?php echo esc_attr_e('Video Link (optional)', 'adaptable-child'); ?></h6>
        <input value="<?php echo get_post_meta($update_id, 'imic_plugin_video_url', true); ?>" name="vehicle-video" id="vehicle-video" type="text" class="form-control spaced" placeholder="Youtube/Video URL">
    </div>

    <div class="stepContent__section">
        <?php
        if (is_user_logged_in())
        {
        ?>
            <button type="submit" name="upload" id="ss" class="button button--alternate save-searched-value">
                <?php echo esc_attr_e('Save ', 'adaptable-child'); ?>
                &amp;
                <?php echo esc_attr_e(' continue', 'adaptable-child'); ?>
            </button>
        <?php
        }
        else
        {
            echo '<a class="btn btn-primary pull-right" data-toggle="modal" data-target="#PaymentModal">' . __('Login/Register', 'framework') . '</a>';
        }
        ?>
    </div>
</div>
