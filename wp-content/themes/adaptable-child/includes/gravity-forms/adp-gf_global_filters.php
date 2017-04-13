<?php

/**
 * Alters how form submission buttons render
 * @param  [string] $button [input field submission]
 * @param  [form object] $form   [The current form in iteration]
 * @return [type]         [description]
 */
function adp_form_submisssion_button_output( $button, $form ) {
    return "<button class='button button--full button--alternate' id='gform_submit_button_{$form['id']}'><span>{$form['button']['text']}</span></button>";
}
add_filter( 'gform_submit_button', 'adp_form_submisssion_button_output', 10, 2 );
