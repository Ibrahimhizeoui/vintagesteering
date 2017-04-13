<?php

$id = (is_home()) ? $id = get_option('page_for_posts') : get_the_ID();
$browse_listing = imic_get_template_url("template-listing.php");

$page_header = get_post_meta($id, 'imic_pages_Choose_slider_display', true);
switch ($page_header){
    case 3:
        get_template_part('pages', 'flex');
        break;
    case 4:
        get_template_part('pages', 'nivo');
        break;
    case 5:
        get_template_part('pages', 'revolution');
        break;
    case 1 || 2:
        get_template_part('pages', 'banner');
        break;
}

$pageSidebar = get_post_meta(get_the_ID(),'imic_select_sidebar_from_list', true);
$sidebar_column = get_post_meta(get_the_ID(),'imic_sidebar_columns_layout',true);
if(!empty($pageSidebar)&&is_active_sidebar($pageSidebar)) {
    $left_col = 12-$sidebar_column;
    $class = $left_col;
}else{
    $class = 12;
}

$browse_specification_switch = get_post_meta(get_the_ID(),'imic_browse_by_specification_switch',true);
switch ($browse_specification_switch){
    case 1:
        get_template_part('bar', 'one');
        break;
    case 2:
        get_template_part('bar', 'two');
        break;
    case 3:
        get_template_part('bar', 'saved');
        break;
    case 4:
        get_template_part('bar', 'category');
        break;
}
