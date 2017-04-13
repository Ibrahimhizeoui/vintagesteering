<div id="personalinfo" class="tab-pane fade active in">
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <?php if(in_array("dealer", $current_user->roles)) : ?>
                <div class="col-md-12">
                    <label><?php echo esc_attr_e('Name of dealership*', 'adaptable-child'); ?></label>
                    <input name="first-name" value="<?php echo esc_attr($current_user->user_firstname); ?>" type="text" class="form-control" placeholder="" >
                </div>
                <?php else: ?>
                <div class="col-md-6">
                    <label><?php echo esc_attr_e('First name*', 'adaptable-child'); ?></label>
                    <input name="first-name" value="<?php echo esc_attr($current_user->user_firstname); ?>" type="text" class="form-control" placeholder="" >
                </div>
                <div class="col-md-6">
                    <label><?php echo esc_attr_e('Last name', 'adaptable-child'); ?></label>
                    <input name="last-name" value="<?php echo esc_attr($current_user->user_lastname); ?>" type="text" class="form-control" placeholder="">
                </div>
                <?php endif; ?>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label><?php echo esc_attr_e('Email', 'adaptable-child'); ?>*</label>
                    <input name="user-email" value="<?php echo esc_attr($current_user->user_email); ?>" type="text" class="form-control" placeholder="mail@example.com" disabled>
                </div>
                <div class="col-md-6">
                    <label><?php echo esc_attr_e('Phone', 'adaptable-child'); ?></label>
                    <input name="user-phone" value="<?php echo get_post_meta($user_info_id, 'imic_user_telephone', true); ?>" type="text" class="form-control" placeholder="000-00-0000">
                </div>
            </div>

            <?php if (in_array("dealer", $current_user->roles) || in_array("administrator", $current_user->roles)): ?>
                <div class="row">
                    <div class="col-md-6">
                        <label><?php echo esc_attr_e('Company Name', 'adaptable-child'); ?></label>
                        <input name="company-name" value="<?php echo get_post_meta($user_info_id, 'imic_user_company', true); ?>" type="text" class="form-control" placeholder="">
                    </div>
                    <div class="col-md-6">
                        <label><?php echo esc_attr_e('Company Tagline', 'adaptable-child'); ?></label>
                        <input name="company-tagline" value="<?php echo get_post_meta($user_info_id, 'imic_user_company_tagline', true); ?>" type="text" class="form-control" placeholder="">
                    </div>
                </div>
            <?php endif; ?>

            <label><?php echo esc_attr_e('Website', 'adaptable-child'); ?></label>
            <input name="website-url" value="<?php echo get_post_meta($user_info_id, 'imic_user_website', true); ?>" type="text" class="form-control" placeholder="">

            <?php
            $post_id = get_post($user_info_id);
            $content = $post_id->post_content;
            $content = str_replace(']]>', ']]>', $content);
            ?>

            <?php if (in_array("dealer", $current_user->roles) || in_array("administrator", $current_user->roles)): ?>
                <label><?php echo esc_attr_e('Description', 'adaptable-child'); ?></label>
                <textarea class="form-control" rows="5" name="dealer_content"><?php echo do_shortcode($content); ?></textarea>
            <?php endif; ?>

            <div class="row">
                <div class="col-md-6">
                    <?php
                    $user_avatar = get_post_meta($user_info_id, 'imic_user_logo', true);
                    $image_avatar = wp_get_attachment_image_src($user_avatar, '', '');

                    echo '<div class="profileImageWrap">';
                        echo '<div class="profileImageWrap__inner">';
                            if (!empty($image_avatar)) {
                                echo '<img src="'. esc_url($image_avatar[0]) .'" width="150" >';
                            }
                        echo '</div>';
                    echo '</div>';

                    echo '<div class="customFileUpload button button--gold spaced">';
                        echo '<span class="customFileUpload__text">Choose Banner Image</span>';
                        echo '<input class="customFileUpload__input" name="bannerimage" type="file">';
                    echo '</div>';
                    ?>
                </div>

                <div class="col-md-6">
                    <?php
                    echo '<div class="profileImageWrap">';
                        echo '<div class="profileImageWrap__inner">';

                            $user_avatar = get_post_meta($user_info_id, '_thumbnail_id', true);
                            $image_avatar = wp_get_attachment_image_src($user_avatar, '', '');

                            if (!empty($image_avatar)) {
                                echo '<img src="'. esc_url($image_avatar[0]) .'" width="150">';
                            }
                        echo '</div>';
                    echo '</div>';

                    echo '<div class="customFileUpload button button--gold spaced">';
                        echo '<span class="customFileUpload__text">Choose Company/User Image</span>';
                        echo '<input class="customFileUpload__input" name="userimage" type="file">';
                    echo '</div>'; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    /**
     *  Image preview on upload
     * */
    (function($) {
        $('.customFileUpload__input').each(function(){

            $(this).on('change', function(){
                var imageContainer = $(this).parent('.customFileUpload').siblings('.profileImageWrap').find('.profileImageWrap__inner');
                console.log('change');
                if (this.files && this.files[0]) {
                    console.log('in if');
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        if(imageContainer.find('img').length > 0) {
                            console.log('if');
                            // Image exists, change the src
                            imageContainer.find('img').attr('src', e.target.result);
                        } else {
                            console.log('else');
                            // Create image
                            imageContainer.html('<img src="'+e.target.result+'" class="attachment-200x200 size-200x200 wp-post-image">');
                        }
                    };
                    reader.readAsDataURL(this.files[0]);
                }
            });
        });
    })(jQuery);
</script>