<?php
/**
 * Contact Form
 * Uses a custom GravityForms ACF addon which allows users to specify a form they
 * want to include rather than us hard coding one.
 *
 * Available Field Objects
 * gravity_form
 *
 * See Gravity forms docs for how to embed forms
 * https://www.gravityhelp.com/documentation/article/embedding-a-form/
 */

// Get form object
$form_object = get_sub_field('gravity_form');

// enque scripts on page
gravity_form_enqueue_scripts($form_object['id'], true);

// Show the form frontend
echo '<section class="pageContent__row pageContent__gform">';
    echo '<div class="container container--small">';
        gravity_form($form_object['id'], false, false, false, '', true, 1);
    echo '</div>';
echo '</section>';
