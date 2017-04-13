<?php

if ( !function_exists( 'imic_add_dealer_role' ) )
{
    function imic_add_dealer_role( )
    {
        remove_role( 'dealer' );
        add_role( 'dealer', 'Dealer', array(
             'read' => true,
            'edit_posts' => false,
            'delete_posts' => false,
            'upload_files' => true
        ) );
    }
    add_action( "after_switch_theme", "imic_add_dealer_role", 10, 2 );
}
