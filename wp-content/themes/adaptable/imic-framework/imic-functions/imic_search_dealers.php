<?php

if ( !function_exists( 'imic_search_dealers' ) )
{
    function imic_search_dealers( )
    {
        global $imic_options;
        $distance_measure = $imic_options[ 'distance_calculate' ];
        $users            = ( isset( $_POST[ 'values' ] ) ) ? $_POST[ 'values' ] : array( );
        ksort( $users );
        $user_ids = array( );
        if ( !empty( $users ) )
        {
            foreach ( $users as $key => $value )
            {
                $user_ids[ ] = $value;
            }
        }
        $args_user    = array(
             'post_type' => 'user',
            'post__in' => $user_ids,
            'orderby' => 'post__in',
            'posts_per_page' => -1
        );
        $user_listing = new WP_Query( $args_user );
        if ( $user_listing->have_posts() ):
            global $wp_query;
            echo '<div class="main" role="main">
    	<div id="content" class="content full padding-b0">
        	<div class="container"><p>We have found ' . $user_listing->found_posts . ' dealers matching zipcode nearest to longest</p>
                <div class="dealers-search-result">
                    <div class="row">';
            while ( $user_listing->have_posts() ):
                $user_listing->the_post();
                $company      = get_post_meta( get_the_ID(), 'imic_user_company', true );
                $tagline      = get_post_meta( get_the_ID(), 'imic_user_company_tagline', true );
                $user_id      = get_post_meta( get_the_ID(), 'imic_user_reg_id', true );
                $user_avatar  = get_post_meta( get_the_ID(), 'imic_user_logo', true );
                $image_avatar = wp_get_attachment_image_src( $user_avatar, '', '' );
                $user_info    = get_userdata( $user_id );
                echo '
                        <div class="col-md-4 col-sm-4 dealer-block">
                            <div class="dealer-block-inner" style="background-image:url(' . $image_avatar[ 0 ] . ');">
                            	<div class="dealer-block-cont">
                                    <div class="dealer-block-info">
                                        <span class="label label-default">' . floor( array_search( get_the_ID(), $users ) ) . ' ' . $distance_measure . __( ' away', 'framework' ) . '</span>
                                        <span class="dealer-avatar">' . get_the_post_thumbnail() . '</span>
                                        <h5><a href="' . get_author_posts_url( $user_id ) . '">' . $company . '</a></h5>
                                        <span class="meta-data">' . $tagline . '</span>
                                    </div>
                                    <div class="dealer-block-text">
                                        ' . imic_excerpt( 10 ) . '
                                        <div class="dealer-block-add">';
                if ( !empty( $user_info ) )
                {
                    echo '<span>' . __( 'Member since', 'framework' ) . ' <strong>' . date( "M, Y", strtotime( $user_info->user_registered ) ) . '</strong></span>';
                }
                echo '<span>' . __( 'Total listings', 'framework' ) . ' <strong>' . imic_count_user_posts_by_type( $user_id, 'cars' ) . '</strong></span>
                                        </div>
                                    </div>
                                    <div class="text-align-center"><a href="' . get_author_posts_url( $user_id ) . '" class="btn btn-default">' . __( 'View profile', 'framework' ) . '</a></div>
                               	</div>
                            </div>
                        </div>';
            endwhile;
            echo '</div></div></div></div></div>';
        endif;
        wp_reset_postdata();
        //print_r($user_ids);
        die( );
    }
    add_action( 'wp_ajax_nopriv_imic_search_dealers', 'imic_search_dealers' );
    add_action( 'wp_ajax_imic_search_dealers', 'imic_search_dealers' );
}
