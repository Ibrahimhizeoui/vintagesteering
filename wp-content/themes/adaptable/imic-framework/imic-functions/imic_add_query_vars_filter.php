<?php

if ( !function_exists( 'imic_add_query_vars_filter' ) )
{
    function imic_add_query_vars_filter( $vars )
    {
        $vars[ ] = "edit";
        $vars[ ] = "search";
        $vars[ ] = "saved";
        $vars[ ] = "profile";
        $vars[ ] = "account";
        $vars[ ] = "manage";
        $vars[ ] = "compare";
        $vars[ ] = "plans";
        $vars[ ] = "list-cat";
        return $vars;
    }
    add_filter( 'query_vars', 'imic_add_query_vars_filter' );
}
