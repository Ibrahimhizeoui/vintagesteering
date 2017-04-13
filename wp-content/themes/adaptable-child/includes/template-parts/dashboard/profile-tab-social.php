<div id="socialinfo" class="tab-pane fade">
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-6">
                    <label for="profilefacebook"><?php echo esc_attr_e('Facebook', 'adaptable-child'); ?></label>
                    <input id="profilefacebook" name="user-facebook" value="<?php echo get_post_meta($user_info_id, 'imic_user_facebook', true); ?>" type="text" class="form-control" placeholder="" >
                </div>
                <div class="col-md-6">
                    <label for="profiletwitter" ><?php echo esc_attr_e('Twitter', 'adaptable-child'); ?></label>
                    <input id="profiletwitter" name="user-twitter" value="<?php echo get_post_meta($user_info_id, 'imic_user_twitter', true); ?>" type="text" class="form-control" placeholder="">
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <label for="profilesnapchat"><?php echo esc_attr_e('Snapchat', 'adaptable-child'); ?></label>
                    <input id="profilesnapchat" name="user-snapchat" value="<?php echo get_post_meta($user_info_id, 'imic_user_snapchat', true); ?>" type="text" class="form-control" placeholder="">
                </div>
                <div class="col-md-6">
                    <label for="profileinstagram"><?php echo esc_attr_e('Instagram', 'adaptable-child'); ?></label>
                    <input id="profileinstagram" name="user-instagram" value="<?php echo get_post_meta($user_info_id, 'imic_user_instagram', true); ?>" type="text" class="form-control" placeholder="">
                </div>
            </div>
        </div>
    </div>
</div>
