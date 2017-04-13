<div class="modal fade" id="sendModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4><?php echo esc_attr_e('Send To A Friend', 'adaptable-child'); ?></h4>
            </div>

            <div class="modal-body">
                <p><?php echo esc_attr_e('Want to send this to a friend? We\'ve got you covered, just fill the form out below and we\'ll handle the rest!', 'adaptable-child'); ?></p>
                <form class="enquiry-vehicle">
                    <input type="hidden" name="email_content" value="enquiry_form">
                    <input type="hidden" name="Subject" id="subject" value="Send To A Friend">
                    <input type="hidden" name="Vehicle_ID" value="<?php echo esc_attr(get_the_ID()); ?>">

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <input type="text" name="Friendemail" class="form-control" placeholder="<?php echo esc_attr_e('Friends Email', 'adaptable-child'); ?>">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="email" name="Email" class="form-control" placeholder="<?php echo esc_attr_e('Your Email', 'adaptable-child'); ?>">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <input type="text" name="Name" class="form-control" placeholder="<?php echo esc_attr_e('Your Name', 'adaptable-child'); ?>">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 spaced">
                            <input type="submit" class="button button--alternate button--full" value="<?php echo esc_attr_e('Submit', 'adaptable-child'); ?>">
                        </div>
                        <div class="message"></div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
