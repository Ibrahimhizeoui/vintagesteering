<?php

if ( !function_exists( 'imic_get_template_url' ) )
{
    function imic_get_template_url( $TEMPLATE_NAME )
    {
        $url;
        $pages = get_pages( array(
             'meta_key' => '_wp_page_template',
            'meta_value' => $TEMPLATE_NAME,
            'sort_order' => 'desc'
        ) );
        if ( !empty( $pages ) )
        {
            $url = get_permalink( $pages[ 0 ]->ID );
            return $url;
        }
    }
}
