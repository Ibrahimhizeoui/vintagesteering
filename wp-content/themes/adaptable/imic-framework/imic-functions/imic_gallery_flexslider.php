<?php

/** -------------------------------------------------------------------------------------
 * Gallery Flexslider
 * @param ID of current Post.
 * @return Div with flexslider parameter.
 ----------------------------------------------------------------------------------- */
if ( !function_exists( 'imic_gallery_flexslider' ) )
{
    function imic_gallery_flexslider( $id )
    {
        $speed      = ( get_post_meta( get_the_ID(), 'imic_gallery_slider_speed', true ) != '' ) ? get_post_meta( get_the_ID(), 'imic_gallery_slider_speed', true ) : 5000;
        $pagination = get_post_meta( get_the_ID(), 'imic_gallery_slider_pagination', true );
        $auto_slide = get_post_meta( get_the_ID(), 'imic_gallery_slider_auto_slide', true );
        $direction  = get_post_meta( get_the_ID(), 'imic_gallery_slider_direction_arrows', true );
        $effect     = get_post_meta( get_the_ID(), 'imic_gallery_slider_effects', true );
        $pagination = !empty( $pagination ) ? $pagination : 'yes';
        $auto_slide = !empty( $auto_slide ) ? $auto_slide : 'yes';
        $direction  = !empty( $direction ) ? $direction : 'yes';
        $effect     = !empty( $effect ) ? $effect : 'slide';
        return '<div class="flexslider galleryflex" data-autoplay="' . $auto_slide . '" data-pagination="' . $pagination . '" data-arrows="' . $direction . '" data-style="' . $effect . '" data-pause="yes" data-speed=' . $speed . '>';
    }
}
