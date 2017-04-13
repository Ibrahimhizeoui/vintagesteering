<?php

//Manage Custom Columns for Cars Post Type
if ( !function_exists( 'imic_cars_status_columns' ) )
{
    add_filter( 'manage_edit-cars_columns', 'imic_cars_status_columns' );
    function imic_cars_status_columns( $columns )
    {
        $columns[ 'Status' ] = __( 'Status', 'framework' );
        //$columns['Recurring'] = __('Recurring', 'framework');
        return $columns;
    }
}
