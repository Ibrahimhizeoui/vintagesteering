<?php

if ( !function_exists( 'imic_theme_activation' ) )
{
    function imic_theme_activation( )
    {
        global $pagenow;
        if ( is_admin() && 'themes.php' == $pagenow && isset( $_GET[ 'activated' ] ) )
        {
            #provide hook so themes can execute theme specific functions on activation
            do_action( 'imic_theme_activation' );
        }
    }
    add_action( 'admin_init', 'imic_theme_activation' );
}
