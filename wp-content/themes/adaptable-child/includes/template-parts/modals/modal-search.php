<div id="searchmodal" class="modal fade" aria-hidden="true" aria-labelledby="mymodalLabel" role="dialog" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" aria-hidden="true" data-dismiss="modal" type="button"><?php echo esc_attr_e('×', 'adaptable-child'); ?></button>
                <h4 id="mymodalLabel" class="modal-title"><?php echo esc_attr_e('Save Search', 'adaptable-child'); ?></h4>
            </div>
            <div class="modal-body">
                <form method="post" id="contactform" name="contactform" class="contact-form clearfix" action="mail/contact.php">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <input type="text" id="search-title" name="First Name"  class="form-control input-lg" placeholder="<?php _e('First name', 'adaptable-child'); ?>*">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <textarea cols="6" rows="2" id="search-desc" name="comments" class="form-control input-lg" placeholder="<?php _e('Description', 'adaptable-child'); ?>"></textarea>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <div id="messages"></div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <input id="" name="submit" type="button" class="button button--alternate inverted save-search" value="<?php _e('Save Search', 'adaptable-child'); ?>">
                <button class="btn btn-default inverted" data-dismiss="modal" type="button"><?php _e('Close', 'adaptable-child'); ?></button>
            </div>
        </div>
    </div>
</div>
