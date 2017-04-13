<?php

if ( !function_exists( 'imic_video_vimeo' ) )
{
    function imic_video_vimeo( $url, $width = 500, $height = 281 )
    {
        if ( $url != '' )
        {
            preg_match( '/https?:\/\/vimeo.com\/(\d+)$/', $url, $video_id );
            return '<iframe src="//player.vimeo.com/video/' . $video_id[ 1 ] . '?title=0&amp;byline=0&amp;autoplay=0&amp;portrait=0" width="' . $width . '" height="' . $height . '" allowfullscreen></iframe>';
        }
    }
}
