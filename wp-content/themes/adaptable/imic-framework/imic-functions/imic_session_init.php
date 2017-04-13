<?php

if ( !function_exists( 'imic_session_init' ) )
{
    function imic_session_init( )
    {
        if ( !session_id() )
        {
            session_start();
        }
    }
    $import = ( isset( $_GET[ 'import' ] ) ) ? $_GET[ 'import' ] : '';
    if ( ( basename( $_SERVER[ 'SCRIPT_NAME' ] ) != "import.php" ) && ( $import != 'wordpress' ) )
    {
        //if(!is_admin()) {
        add_action( 'init', 'imic_session_init' );
    }
}
