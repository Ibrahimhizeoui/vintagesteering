<?php
/**
 * Grabs image data from imageID, instead of grabbing an entire array of key/values
 * @param  int      $id     Image ID
 * @param  string   $size   Image Size
 * @return array            Array of cherry picked values
 */
function acf_image_data($id, $size){
    $arr = [];

    $arr['url'] = wp_get_attachment_image_src($id, $size, false)[0];
    $arr['width'] = wp_get_attachment_image_src($id, $size, false)[1];
    $arr['height'] = wp_get_attachment_image_src($id, $size, false)[2];
    $arr['alt'] = get_post_meta($id, '_wp_attachment_image_alt', true);

    return $arr;
}
