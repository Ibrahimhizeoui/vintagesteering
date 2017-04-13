<?php

if ( !function_exists( 'imic_cars_status_column_content' ) )
{
    add_action( 'manage_cars_posts_custom_column', 'imic_cars_status_column_content', 10, 2 );
    function imic_cars_status_column_content( $column_name, $post_id )
    {
        switch ( $column_name )
        {
            case 'Status':
                $status = get_post_meta( $post_id, 'imic_plugin_ad_payment_status', true );
                if ( $status == 0 )
                {
                    $val = __( "Pending", "framework" );
                }
                elseif ( $status == 1 )
                {
                    $val = __( "Completed", "framework" );
                }
                elseif ( $status == 2 )
                {
                    $val = __( "Sold", "framework" );
                }
                elseif ( $status == 3 )
                {
                    $val = __( "Inactive", "framework" );
                }
                elseif ( $status == 4 )
                {
                    $val = __( "Under Review", "framework" );
                }
                echo esc_attr( $val );
                break;
        }
    }
}
