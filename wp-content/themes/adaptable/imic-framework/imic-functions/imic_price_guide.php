<?php

if ( !function_exists( 'imic_price_guide' ) )
{
    function imic_price_guide( )
    {
        //echo "sai";
        global $imic_options;
        $get_id        = $_POST[ 'id' ];
        $match_speci   = ( isset( $imic_options[ 'price_guide_specifications' ] ) ) ? $imic_options[ 'price_guide_specifications' ] : array( );
        $find_vals     = ( isset( $imic_options[ 'find_guide_specifications' ] ) ) ? $imic_options[ 'find_guide_specifications' ] : '';
        $specification = get_post_meta( $get_id, 'feat_data', true );
        $query         = array( );
        if ( !empty( $match_speci ) )
        {
            foreach ( $match_speci as $match )
            {
                $integer           = get_post_meta( $match, 'imic_plugin_spec_char_type', true );
                $value_label       = get_post_meta( $match, 'imic_plugin_value_label', true );
                $detailed_spec_key = array_search( $match, $specification[ 'sch_title' ] );
                $second_key        = array_search( $match * 111, $specification[ 'sch_title' ] );
                $slug              = imic_the_slug( $match );
                if ( $integer == 1 )
                {
                    $query[ ] = "int_" . $slug;
                }
                else
                {
                    $query[ ] = $slug;
                    if ( is_int( $second_key ) )
                    {
                        $query[ ] = $value_label;
                    }
                }
            }
            $query_vars = imic_search_match( $get_id, $match_speci, $specification );
            $query_val  = array_combine( $query, $query_vars );
            $count      = 1;
            $arrays     = array( );
            //print_r($query_val);
            if ( !empty( $query_val ) )
            {
                foreach ( $query_val as $key => $value )
                {
                    if ( !get_query_var( $key ) )
                    {
                        if ( strpos( $key, 'int' ) !== false )
                        {
                            $arrays[ $count ] = array(
                                 'key' => $key,
                                'value' => $value,
                                'compare' => '<=',
                                'type' => 'numeric'
                            );
                        }
                        else
                        {
                            $arrays[ $count ] = array(
                                 'key' => 'feat_data',
                                'value' => urldecode( $value ),
                                'compare' => 'LIKE'
                            );
                        }
                    }

                    $count++;
                }
            }
            $arr          = array( );
            $args_cars    = array(
                 'post_type' => 'cars',
                'meta_query' => $arrays,
                'posts_per_page' => 10,
                'post_status' => 'publish'
            );
            $cars_listing = new WP_Query( $args_cars );
            if ( $cars_listing->have_posts() ):
                while ( $cars_listing->have_posts() ):
                    $cars_listing->the_post();
                    $specifications = get_post_meta( get_the_ID(), 'feat_data', true );
                    $arr[ ]         = imic_vehicle_price( get_the_ID(), $find_vals, $specifications );
                endwhile;
            else:
                echo __( 'Sorry, No Idea for this listing', 'framework' );
            endif;
            wp_reset_postdata();
            if ( !empty( $arr ) )
            {
                if ( count( $arr ) > 1 )
                {
                    $min = min( $arr );
                    $max = max( $arr );
                    echo __( 'between ', 'framework' ) . $min . ' - ' . $max;
                }
                else
                {
                    echo __( 'Appx ', 'framework' ) . $arr[ 0 ];
                }
            }
        }
        else
        {
            echo __( 'Sorry, No Idea for this listing', 'framework' );
        }
        die( );
    }
    add_action( 'wp_ajax_nopriv_imic_price_guide', 'imic_price_guide' );
    add_action( 'wp_ajax_imic_price_guide', 'imic_price_guide' );
}
