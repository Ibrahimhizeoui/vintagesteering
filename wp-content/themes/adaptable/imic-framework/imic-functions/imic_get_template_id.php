<?php

if ( !function_exists( 'imic_get_template_id' ) )
{
    function imic_get_template_id( $TEMPLATE_NAME )
    {
        $id    = '';
        $pages = get_pages( array(
             'meta_key' => '_wp_page_template',
            'meta_value' => $TEMPLATE_NAME,
            'sort_order' => 'desc'
        ) );
        if ( !empty( $pages ) )
        {
            $id = $pages[ 0 ]->ID;
            return $id;
        }
    }
}
