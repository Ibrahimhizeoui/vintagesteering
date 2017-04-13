<?php

if ( !function_exists( 'imic_count_cars_by_specification' ) )
{
    function imic_count_cars_by_specification( $specification, $value, $slug = '' )
    {
        $count = '';
        if ( strpos( $specification, 'int' ) !== false )
        {
            $args_cars = array(
                 'post_type' => 'cars',
                'listing-category' => $slug,
                'posts_per_page' => -1,
                'meta_query' => array(
                     array(
                         'key' => $specification,
                        'value' => $value,
                        'compare' => '<=',
                        'type' => 'numeric'
                    ),
                    array(
                         'key' => 'imic_plugin_ad_payment_status',
                        'value' => 1,
                        'compare' => '='
                    )
                )
            );
        }
        elseif ( ( strpos( $specification, 'char' ) !== false ) || ( strpos( $specification, 'child' ) !== false ) )
        {
            $args_cars = array(
                 'post_type' => 'cars',
                'listing-category' => $slug,
                'posts_per_page' => -1,
                'meta_query' => array(
                     array(
                         'key' => $specification,
                        'value' => $value,
                        'compare' => '='
                    ),
                    array(
                         'key' => 'imic_plugin_ad_payment_status',
                        'value' => 1,
                        'compare' => '='
                    )
                )
            );
        }
        else
        {
            $args_cars = array(
                 'post_type' => 'cars',
                'listing-category' => $slug,
                'posts_per_page' => -1,
                'meta_query' => array(
                     array(
                         'key' => $specification,
                        'value' => serialize( strval( $value ) ),
                        'compare' => 'LIKE'
                    ),
                    array(
                         'key' => 'imic_plugin_ad_payment_status',
                        'value' => 1,
                        'compare' => '='
                    )
                )
            );
        }
        $cars_listing = new WP_Query( $args_cars );
        if ( $cars_listing->have_posts() ):
            $count = $cars_listing->found_posts;
        endif;
        wp_reset_postdata();
        return $count;
    }
}
