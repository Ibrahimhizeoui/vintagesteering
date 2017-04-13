<?php

$page_header = get_field('b_billboard_type');

switch ($page_header)
{
    case 'standard':
        require('billboard-standard.php');
        break;
    case 'video':
        require('billboard-video.php');
        break;
    default:
        require('billboard-none.php');
}
