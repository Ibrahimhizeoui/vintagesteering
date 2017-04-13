<?php
/**
 * Overrides parent theme widget titles
 * @param  Widget parameters
 * @return imic_widget_titles
 */
function imic_widget_titles(array $params) {
    // $params will ordinarily be an array of 2 elements, we're only interested in the first element
    $widget = & $params[0];

    $widget['before_title'] = '<h6 class="widgettitle">';
    $widget['after_title'] = '</h6>';

    return $params;
}
add_filter('dynamic_sidebar_params', 'imic_widget_titles', 20);
