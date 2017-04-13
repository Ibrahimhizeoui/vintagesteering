<?php
    $enquiry_form3           = (isset($imic_options[ 'enquiry_form3' ])) ? $imic_options[ 'enquiry_form3' ] : '0';
    $editor_form3            = (isset($imic_options[ 'enquiry_form3_editor' ])) ? $imic_options[ 'enquiry_form3_editor' ] : '';
?>

<div class="modal fade" id="offerModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4><?php echo esc_attr_e('Make an offer', 'adaptable-child'); ?></h4>
            </div>
            <div class="modal-body">
                <?php if ($enquiry_form3 == 0) { ?>
                    <p><?php echo esc_attr_e('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla convallis egestas rhoncus. Donec facilisis fermentum sem, ac viverra ante luctus vel. Donec vel mauris quam.', 'adaptable-child'); ?></p>

                    <form class="enquiry-vehicle">
                        <input type="hidden" name="email_content" value="enquiry_form">
                        <input type="hidden" name="Subject" id="subject" value="<?php echo esc_attr_e('Make an offer', 'adaptable-child'); ?>">
                        <input type="hidden" name="Vehicle_ID" value="<?php echo esc_attr(get_the_ID()); ?>">

                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-user"></i></span>
                            <input type="text" name="Name" class="form-control" placeholder="<?php echo esc_attr_e('Full Name', 'adaptable-child'); ?>">
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                                    <input type="email" name="Email" class="form-control" placeholder="<?php echo esc_attr_e('Email', 'adaptable-child'); ?>">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                                    <input type="text" name="Phone" class="form-control" placeholder="<?php echo esc_attr_e('Phone', 'adaptable-child'); ?>">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-dollar"></i></span>
                                    <input type="text" name="Offered Price" class="form-control" placeholder="<?php echo esc_attr_e('Offered Price', 'adaptable-child');  ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-credit-card"></i></span>
                                    <select name="Financing Required" type="text" class="form-control selectpicker">
                                        <option value="no" selected><?php echo esc_attr_e('Financing required?', 'adaptable-child'); ?></option>
                                        <option value="yes"><?php echo esc_attr_e('Yes', 'adaptable-child'); ?></option>
                                        <option value="no"><?php echo esc_attr_e('No', 'adaptable-child'); ?></option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <textarea class="form-control" name="Additional Comments" placeholder="<?php echo esc_attr_e('Additional comments', 'adaptable-child'); ?>"></textarea>
                        <input type="submit" class="btn btn-primary pull-right" value="<?php echo esc_attr_e('Submit', 'adaptable-child'); ?>">
                        <div class="clearfix"></div>
                        <div class="message"></div>
                    </form><?php
                } elseif ($enquiry_form3 == 1) {
                    echo do_shortcode($editor_form3);
                }   ?>
            </div>
        </div>
    </div>
</div>
