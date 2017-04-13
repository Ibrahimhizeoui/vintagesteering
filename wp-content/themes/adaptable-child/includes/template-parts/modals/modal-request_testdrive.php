<?php
$enquiry_form2           = (isset($imic_options[ 'enquiry_form2' ])) ? $imic_options[ 'enquiry_form2' ] : '0';
$editor_form2            = (isset($imic_options[ 'enquiry_form2_editor' ])) ? $imic_options[ 'enquiry_form2_editor' ] : '';
?>

<div class="modal fade" id="testdriveModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4><?php echo esc_attr_e('Book a test drive', 'adaptable-child'); ?></h4>
            </div>

            <div class="modal-body">
                <?php if ($enquiry_form2 == 0) { ?>
                    <p><?php echo esc_attr_e('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla convallis egestas rhoncus. Donec facilisis fermentum sem, ac viverra ante luctus vel. Donec vel mauris quam.', 'adaptable-child'); ?></p>
                    <form class="enquiry-vehicle">
                        <input type="hidden" name="email_content" value="enquiry_form">
                        <input type="hidden" name="Subject" id="subject" value="Book a test drive">
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
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    <input type="text" name="Preferred Date" id="datepicker" class="form-control" placeholder="<?php echo esc_attr_e('Preferred Date', 'adaptable-child'); ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="input-group input-append bootstrap-timepicker">
                                    <span class="input-group-addon add-on"><i class="fa fa-clock-o"></i></span>
                                    <input type="text" name="Preferred Time" id="timepicker" class="form-control" placeholder="<?php echo esc_attr_e('Preferred time', 'adaptable-child'); ?>">
                                </div>
                            </div>
                        </div>

                        <input type="submit" class="btn btn-primary pull-right" value="<?php echo esc_attr_e('Schedule Now', 'adaptable-child'); ?>">
                        <label class="btn-block"><?php echo esc_attr_e('Preferred Contact', 'adaptable-child'); ?></label>
                        <label class="checkbox-inline"><input name="Preferred Contact Email" value="yes" type="checkbox"> <?php echo esc_attr_e('Email', 'adaptable-child');  ?></label>
                        <label class="checkbox-inline"><input name="Preferred Contact Phone" value="yes" type="checkbox"> <?php echo esc_attr_e('Phone', 'adaptable-child'); ?></label>

                        <div class="message"></div>
                    </form><?php
                } elseif ($enquiry_form2 == 1) {
                    echo do_shortcode($editor_form2);
                } ?>
            </div>
        </div>
    </div>
</div>
