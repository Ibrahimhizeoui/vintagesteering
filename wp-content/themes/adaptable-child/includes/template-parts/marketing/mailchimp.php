<?php
$action_url = get_field('em_form_action_url', 'option');

if ($action_url):
    // get classes from array
    $mc_classes = '';

    $mailchimp_classes = $mailchimp_classes;

    if (is_array($mailchimp_classes)) {
        $mc_classes = implode(' ', $mailchimp_classes);
    }

    $form_title = get_field('em_form_title', 'option'); ?>

    <div class="mailchimp <?php echo $mc_classes; ?>">
        <form action="<?php echo $action_url; ?>" name="mc-embedded-subscribe-form" method="post" class="validate" target="_blank" novalidate>
            <div class="mailchimp__container" id="mc_embed_signup_scroll">
                <div class="mailchimp__fields">
                    <?php if ($form_title): ?>
                        <h6 class="mailchimp__title"><?php echo $form_title; ?></h6>
                    <?php endif; ?>
                </div>
                <div class="mailchimp__fields mc-field-group">
                	<input class="mailchimp__field" type="email" value="" name="EMAIL" class="required email" placeholder="Email Address" id="mce-EMAIL">
                </div>
            	<div id="mce-responses" class="clear">
            		<div class="response" id="mce-error-response" style="display:none"></div>
            		<div class="response" id="mce-success-response" style="display:none"></div>
            	</div>    <!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
                <div class="mailchimp__hidden" style="position: absolute; left: -5000px;" aria-hidden="true"><input type="text" name="b_4c689ebbaa685082aa5141f7a_5eed3240aa" tabindex="-1" value=""></div>
                <input type="submit" value="Subscribe" name="subscribe" id="mc-embedded-subscribe" class="mailchimp__submit">
            </div>
        </form>
    </div>
<?php endif; ?>
<!--End mc_embed_signup-->
