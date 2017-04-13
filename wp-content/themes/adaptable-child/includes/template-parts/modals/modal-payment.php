<div class="modal fade" id="PaymentModal" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="PaymentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h5 class="modal-title" id="myModalLabel"><?php echo esc_attr_e('Login or Register for website', 'adaptable-child'); ?></h5>
            </div>

            <div class="modal-body">
                <div class="tabs">
                    <ul class="nav nav-tabs">
                        <li class="active"> <a data-toggle="tab" href="#login-user-form"> <?php echo esc_attr_e('Login', 'adaptable-child'); ?> </a> </li>
                        <li> <a data-toggle="tab" href="#register-user-form"> <?php echo esc_attr_e('Register', 'adaptable-child'); ?> </a> </li>
                        <li> <a data-toggle="tab" href="#reset-user-form"> <?php echo esc_attr_e('Reset Password', 'adaptable-child'); ?> </a> </li>
                    </ul>

                    <div class="tab-content">
                        <div id="login-user-form" class="tab-pane active">
                            <form id="login-popup" action="login" method="post">
                                <?php
                                $redirect_login = get_post_meta(get_the_ID(), 'imic_login_redirect_options', true);
                                $redirect_login = !empty($redirect_login) ? $redirect_login :  home_url();
                                ?>

                                <input type ="hidden" class ="redirect_login" name ="redirect_login" value =""/>

                                <div class="form-group">
                                    <label for="loginname">Username</label>
                                    <input class="form-control input1" id="loginname" type="text" name="loginname" placeholder="<?php _e('Username', 'adaptable-child'); ?>">
                                </div>

                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input class="form-control input1" id="password" type="password" name="password" placeholder="<?php _e('Password', 'adaptable-child'); ?>">
                                </div>

                                <div class="form-group">
                                    <input type="checkbox" checked="checked" value="true" name="rememberme" id="rememberme" class="checkbox">
                                    <span><?php echo esc_attr_e('Remember Me!', 'adaptable-child'); ?></span>
                                </div>

                                <div class="form-group">
                                    <input class="submit_button button button--alternate button--full" type="submit" value="<?php echo esc_attr_e('Login Now', 'adaptable-child'); ?>" name="submit">
                                    <?php wp_nonce_field('ajax-login-nonce', 'security'); ?>
                                </div>

                                <p class="status"></p>
                            </form>
                        </div>

                        <div id="register-user-form" class="tab-pane userRegistration">
                            <?php
                            $registerUser = [
                                'id' => 6,
                                'title' => false,
                                'description' => false,
                                'display_inactive' => true,
                                'field_values' => null,
                                'ajax' => true,
                                'echo' => true
                            ];
                            gravity_form(
                                $registerUser['id'],
                                $registerUser['title'],
                                $registerUser['description'],
                                $registerUser['display_inactive'],
                                $registerUser['field_values'],
                                $registerUser['ajax'],
                                $registerUser['echo']
                            ); ?>
                       </div>

                       <div id="reset-user-form" class="tab-pane">
                           <form id="reset-pass" method="post">
                                <?php
                                $redirect_login = get_post_meta(get_the_ID(), 'imic_login_redirect_options', true);
                                $redirect_login = !empty($redirect_login) ? $redirect_login :  home_url();
                                ?>
                                <input type ="hidden" class ="redirect_login" name ="redirect_login" value =""/>

                                <div class="form-group">
                                    <label for="reset-email"><?php esc_attr_e('Email Address', 'adaptable-child'); ?></label>
                                    <input class="form-control input1" id="reset-email" type="text" name="reset-email" placeholder="<?php esc_attr_e('Email Address', 'adaptable-child'); ?>">
                                </div>

                                <div class="form-group" id="reset-key" style="display:none;">
                                    <label for="reset-verification"><?php esc_attr_e('Please insert verification code', 'adaptable-child'); ?></label>
                                    <input class="form-control input1" id="reset-verification" type="text" name="reset-verification" placeholder="<?php esc_attr_e('Please insert verification code', 'adaptable-child'); ?>">
                                </div>

                                <div id="show-pass-fields" style="display:none;">
                                    <div class="form-group">
                                        <label for="reset-pass1"><?php esc_attr_e('Enter Password', 'adaptable-child'); ?></label>
                                        <input class="form-control input1" id="reset-pass1" type="password" name="reset-pass1" placeholder="<?php esc_attr_e('Enter Password', 'adaptable-child'); ?>">
                                    </div>

                                    <div class="form-group">
                                        <label for="reset-pass2"><?php esc_attr_e('Enter Password Again', 'adaptable-child'); ?></label>
                                        <input class="form-control input1" id="reset-pass2" type="password" name="reset-pass2" placeholder="<?php esc_attr_e('Enter Password Again', 'adaptable-child'); ?>">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <input id="reset-code" class="submit_button button button--alternate button--full" type="submit" value="<?php echo esc_attr_e('Reset Password', 'adaptable-child'); ?>" name="submit">
                                </div>

                                <input style="display:none;" id="reset-new-pass" class="submit_button button button--alternate" type="submit" value="<?php echo esc_attr_e('Change Password', 'adaptable-child'); ?>" name="submit_pass">

                                <p class="status"></p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
