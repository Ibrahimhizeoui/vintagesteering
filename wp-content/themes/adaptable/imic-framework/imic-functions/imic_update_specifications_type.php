<?php

if ( !function_exists( 'imic_update_specifications_type' ) )
{
    function imic_update_specifications_type( )
    {
        global $imic_options;
        $specifications_upd_st = get_option( 'imic_specifications_upd_st' );
        $data_import_status    = get_option( 'imic_data_imported_status' );
        $listings_arg          = array(
             'post_type' => 'cars',
            'posts_per_page' => -1
        );
        if ( $specifications_upd_st == '' && $specifications_upd_st != 1 )
        {
            $listing_posts  = new WP_Query( $listings_arg );
            $total_listings = $listing_posts->found_posts;
            wp_reset_postdata();
        }
        if ( $specifications_upd_st == '' && $specifications_upd_st != 1 && $data_import_status == 1 )
        {
            $specificiations_arg  = array(
                 'post_type' => 'specification',
                'posts_per_page' => -1,
                'meta_query' => array(
                     array(
                         'key' => 'imic_plugin_spec_char_type',
                        'value' => 0,
                        'compare' => '='
                    )
                )
            );
            $specifications_posts = new WP_Query( $specificiations_arg );
            if ( $specifications_posts->have_posts() ):
                while ( $specifications_posts->have_posts() ):
                    $specifications_posts->the_post();
                    update_post_meta( get_the_ID(), 'imic_plugin_spec_char_type', 2 );
                endwhile;
            endif;
            wp_reset_postdata();
            $listings_arg  = array(
                 'post_type' => 'cars',
                'posts_per_page' => -1
            );
            $listing_posts = new WP_Query( $listings_arg );
            if ( $listing_posts->have_posts() ):
                while ( $listing_posts->have_posts() ):
                    $listing_posts->the_post();
                    $feat_data = get_post_meta( get_the_ID(), 'feat_data', true );

                    if ( isset( $feat_data[ 'start_time' ] ) )
                    {
                        foreach ( $feat_data[ 'sch_title' ] as $specs )
                        {
                            $this_slug = imic_the_slug( $specs );
                            if ( imic_value_search_multi_array( $specs, $feat_data ) )
                            {
                                $detailed_spec_key = array_search( $specs, $feat_data[ 'sch_title' ] );
                                $second_key        = array_search( $specs * 111, $feat_data[ 'sch_title' ] );
                                if ( is_int( $second_key ) )
                                {
                                    $val = $feat_data[ 'start_time' ][ $second_key ];
                                    update_post_meta( get_the_ID(), 'child_' . $this_slug, $val );
                                }
                                if ( is_int( $detailed_spec_key ) )
                                {
                                    $cur_spec = $feat_data[ 'start_time' ][ $detailed_spec_key ];
                                    if ( $cur_spec != '' )
                                    {
                                        update_post_meta( get_the_ID(), 'char_' . $this_slug, $cur_spec );
                                    }
                                }
                            }
                        }
                    }
                endwhile;
            endif;
            wp_reset_postdata();
            update_option( 'imic_specifications_upd_st', 1 );
        }
    }
    if ( !is_admin() )
    {
        imic_update_specifications_type();
    }
}
