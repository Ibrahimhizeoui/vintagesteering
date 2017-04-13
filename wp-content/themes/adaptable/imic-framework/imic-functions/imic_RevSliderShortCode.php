<?php

if ( !function_exists( 'imic_RevSliderShortCode' ) )
{
    function imic_RevSliderShortCode( )
    {
        $slidernames = array( );
        if ( class_exists( 'RevSlider' ) )
        {
            $sld     = new RevSlider();
            $sliders = $sld->getArrSliders();
            if ( !empty( $sliders ) )
            {

                foreach ( $sliders as $slider )
                {
                    $title                                 = $slider->getParam( 'title', 'false' );
                    $shortcode                             = $slider->getParam( 'shortcode', 'false' );
                    $slidernames[ esc_attr( $shortcode ) ] = $title;
                }
            }

        }
        return $slidernames;
    }
}
