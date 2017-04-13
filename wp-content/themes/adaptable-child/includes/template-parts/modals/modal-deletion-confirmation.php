<div id="confirm-delete" class="modal fade" aria-hidden="true" aria-labelledby="mymodalLabel" role="dialog" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" aria-hidden="true" data-dismiss="modal" type="button"><?php echo esc_attr_e('×', 'adaptable-child'); ?></button>
                <h4 id="mymodalLabel" class="modal-title"><?php echo esc_attr_e('Delete Selected Listings', 'adaptable-child'); ?></h4>
            </div>
            <div class="modal-body">
                <?php echo esc_attr_e('Are you sure you want to delete the selected listing(s)?', 'adaptable-child'); ?>
            </div>
            <div class="modal-footer">
                <input id="delete" name="submit" data-dismiss="modal" type="button" class="button" value="<?php _e('Delete', 'adaptable-child'); ?>">
                <button class="button button--black" data-dismiss="modal" type="button"><?php _e('Close', 'adaptable-child'); ?></button>
            </div>
        </div>
    </div>
</div>
