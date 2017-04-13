<?php

if ( !function_exists( 'imic_video_embed' ) )
{
    function imic_video_embed( $url, $width = 500, $height = 300 )
    {
        if ( strpos( $url, 'youtube' ) || strpos( $url, 'youtu.be' ) )
        {
            return imic_video_youtube( $url, $width, $height );
        }
        else
        {
            return imic_video_vimeo( $url, $width, $height );
        }
    }
}
