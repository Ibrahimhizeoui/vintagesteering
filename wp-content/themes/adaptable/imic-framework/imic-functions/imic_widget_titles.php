<?php

if ( !function_exists( 'imic_widget_titles' ) )
{
    add_filter( 'dynamic_sidebar_params', 'imic_widget_titles', 20 );
    function imic_widget_titles( array $params )
    {
        // $params will ordinarily be an array of 2 elements, we're only interested in the first element
        $widget =& $params[ 0 ];
        $id = $params[ 0 ][ 'id' ];
        if ( $id == 'footer-sidebar' )
        {
            $widget[ 'before_title' ] = '<h4 class="widgettitle">';
            $widget[ 'after_title' ]  = '</h4>';
        }
        else
        {
            $widget[ 'before_title' ] = '<h3 class="widgettitle">';
            $widget[ 'after_title' ]  = '</h3>';
        }
        return $params;
    }
}
