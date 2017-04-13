<?php
// enqueue gravity forms
function adp_gravity_forms_scripts() {
    if (!function_exists('gravity_form_enqueue_scripts')) {
        return;    
    }

    gravity_form_enqueue_scripts(1, true);
}
add_action('init', 'adp_gravity_forms_scripts');
