<div id="changepassword" class="tab-pane fade">
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-6">
                    <label for="profileuserpass"><?php echo esc_attr_e('Old Password', 'adaptable-child'); ?></label>
                    <input id="profileuserpass" name="user-pass" type="password" class="form-control" placeholder="">
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label for="profileusernewpass"><?php echo esc_attr_e('New password', 'adaptable-child'); ?></label>
                    <input id="profileusernewpass" name="user-new-pass1" type="password" class="form-control" placeholder="">
                </div>
                <div class="col-md-6">
                    <label for="profileusernewpassconf" ><?php echo esc_attr_e('Confirm new password', 'adaptable-child'); ?></label>
                    <input id="profileusernewpassconf" name="user-new-pass2" type="password" class="form-control" placeholder="">
                </div>
            </div>
        </div>
    </div>
</div>
