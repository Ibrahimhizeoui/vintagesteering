<?php
/**
 * Applies an inner wrapper to gravity forms description fields
 * This is so we can vertically align text to the bottom of the container
 * wothout affecting the other floated container.
 */

function adp_gf_description_wrapper($form){
    // fields
    $fields = $form['fields'];

    // loop fields
    foreach ($fields as $field) {

        if (empty($field['description'])) continue;

        // wrap the description inside a <p> tag
        $description = '<span class="gfield_description__text-bottom"></span>';
        $description .= '<span class="gfield_description__text">' . $field['description'] . '</span>';

        // re-assign a description
        $field['description'] = $description;
    }

    // return the form
    return $form;
}
add_filter('gform_pre_render', 'adp_gf_description_wrapper');

?>
