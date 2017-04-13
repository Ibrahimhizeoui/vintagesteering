<?php
/**
 * This file is for overitting any redux framework functionality
 * as well as functionality that has been coupled with the theme
 * but we don't need.
 *
 * When calling redux options you need to use the option name declared
 * by the theme to change theme values.
 * ---------------------------
 * option name - imic_options
 * ---------------------------
 */

/*-------------------------------------------------------------------*/
/*  REDUX OVERRIDES                                                  */
/*-------------------------------------------------------------------*/
/**
 * [Remove <style></style> from Head which overrides typography across the site]
 * @param  [object] $redux_object [the redux object passed from the redux/construct action]
 * @return [object change]        [update output to false]
 */
function vts0561_remove_headStyle($redux_object)
{
    if (is_admin()) return;

    return $redux_object->args['output_tag'] = false;
}
add_action('redux/construct', 'vts0561_remove_headStyle', 100);
