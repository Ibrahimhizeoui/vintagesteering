<?php

if ( !function_exists( 'imic_video_youtube' ) )
{
    function imic_video_youtube( $url, $width = 560, $height = 315 )
    {
        if ( $url != '' )
        {
            if ( stristr( $url, 'youtu.be/' ) )
            {
                preg_match( '/(https:|http:|)(\/\/www\.|\/\/|)(.*?)\/(.{11})/i', $url, $video_id );
                return '<iframe itemprop="video" src="http://www.youtube.com/embed/' . $video_id[ 4 ] . '?wmode=transparent&autoplay=0" width="' . $width . '" height="' . $height . '" ></iframe>';
            }
            else
            {
                preg_match( '/(https:|http:|):(\/\/www\.|\/\/|)(.*?)\/(embed\/|watch\?v=|(.*?)&v=|v\/|e\/|.+\/|watch.*v=|)([a-z_A-Z0-9]{11})/i', $url, $video_id );
                return '<iframe itemprop="video" src="http://www.youtube.com/embed/' . $video_id[ 6 ] . '?wmode=transparent&autoplay=0" width="' . $width . '" height="' . $height . '" ></iframe>';
            }
        }
    }
}
