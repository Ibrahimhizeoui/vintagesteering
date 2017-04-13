<?php

if ( !function_exists( 'imic_update_listing_date' ) )
{
    function imic_update_listing_date( )
    {
        if ( !is_admin() )
        {
            $status_listing_update_date = get_option( 'imic_listing_date' );
            if ( $status_listing_update_date != "snsd" )
            {
                $query = new WP_Query( array(
                     'post_type' => 'cars',
                    'posts_per_page' => -1
                ) );
                if ( $query->have_posts() )
                {
                    while ( $query->have_posts() )
                    {
                        $query->the_post();
                        $listing_end_date = get_post_meta( get_the_ID(), 'imic_plugin_listing_end_dt', true );
                        if ( $listing_end_date == '' )
                        {
                            update_post_meta( get_the_ID(), 'imic_plugin_listing_end_dt', '2020-01-01' );
                        }
                    }
                    update_option( 'imic_listing_date', 'snsd' );
                }
                else
                {
                    update_option( 'imic_listing_date', '' );
                }
                wp_reset_postdata();
            }
        }
    }
    imic_update_listing_date();
}
