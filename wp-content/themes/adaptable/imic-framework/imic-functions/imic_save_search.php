<?php

if ( !function_exists( 'imic_save_search' ) )
{
    function imic_save_search( )
    {
        //echo "sai";
        $title   = $_POST[ 'search_title' ];
        $desc    = $_POST[ 'search_desc' ];
        $url     = $_POST[ 'search_url' ];
        $created = date( 'U' );
        $alert   = 1;
        $exist   = $print = '';
        if ( is_user_logged_in() ) //echo "ss";
        {
            if ( ( isset( $_SESSION[ 'search_page1' ] ) ) || ( isset( $_SESSION[ 'search_page2' ] ) ) || ( isset( $_SESSION[ 'search_page3' ] ) ) )
            {
                $exist1              = $exist2 = $exist3 = $print1 = $print2 = $print3 = '';
                $vehicle_search_1    = ( isset( $_SESSION[ 'search_page1' ] ) ) ? $_SESSION[ 'search_page1' ] : array( );
                $vehicle_search_2    = ( isset( $_SESSION[ 'search_page2' ] ) ) ? $_SESSION[ 'search_page2' ] : array( );
                $vehicle_search_3    = ( isset( $_SESSION[ 'search_page3' ] ) ) ? $_SESSION[ 'search_page3' ] : array( );
                $user_id             = get_current_user_id();
                $user_info_id        = get_user_meta( $user_id, 'imic_user_info_id', true );
                $saved_searches_user = get_post_meta( $user_info_id, 'imic_user_saved_search', true );
                if ( !empty( $saved_searches_user ) )
                {
                    foreach ( $saved_searches_user as $searches )
                    {
                        if ( !empty( $vehicle_search_1 ) )
                        {
                            if ( !in_array( $vehicle_search_1[ 2 ], $searches ) )
                            {
                                $exist1 = 1;
                            }
                            else
                            {
                                $exist1 = 2;
                            }
                        }
                        if ( !empty( $vehicle_search_2 ) )
                        {
                            if ( !in_array( $vehicle_search_2[ 2 ], $searches ) )
                            {
                                $exist2 = 2;
                            }
                            else
                            {
                                $exist2 = 2;
                            }
                        }
                        if ( !empty( $vehicle_search_3 ) )
                        {
                            if ( !in_array( $vehicle_search_3[ 2 ], $searches ) )
                            {
                                $exist3 = 2;
                            }
                            else
                            {
                                $exist3 = 2;
                            }
                        }
                        $search[ ] = $searches;
                    }
                }
                if ( $exist1 == 1 || $exist1 == '' )
                {
                    $print1 = 1;
                    if ( !empty( $vehicle_search_1 ) )
                    {
                        $search[ ] = $vehicle_search_1;
                    }
                }
                if ( $exist2 == 1 || $exist2 == '' )
                {
                    $print2 = 1;
                    if ( !empty( $vehicle_search_2 ) )
                    {
                        $search[ ] = $vehicle_search_2;
                    }
                }
                if ( $exist3 == 1 || $exist3 == '' )
                {
                    $print3 = 1;
                    if ( !empty( $vehicle_search_3 ) )
                    {
                        $search[ ] = $vehicle_search_3;
                    }
                }
                //print_r($search);
                update_post_meta( $user_info_id, 'imic_user_saved_search', $search );
                if ( $print1 == 1 )
                {
                    if ( !empty( $vehicle_search_1 ) )
                    {
                        echo '<li>
             <div class="link"><a href="' . $vehicle_search_1[ 2 ] . '">' . $vehicle_search_1[ 0 ] . '</a></div>
             <div class="delete"><a href="javascript:void(0);"><i class="icon-delete"></i></a></div>
             </li>';
                    }
                }
                if ( $print2 == 1 )
                {
                    if ( !empty( $vehicle_search_2 ) )
                    {
                        echo '<li>
             <div class="link"><a href="' . $vehicle_search_2[ 2 ] . '">' . $vehicle_search_2[ 0 ] . '</a></div>
             <div class="delete"><a href="javascript:void(0);"><i class="icon-delete"></i></a></div>
             </li>';
                    }
                }
                if ( $print3 == 1 )
                {
                    if ( !empty( $vehicle_search_3 ) )
                    {
                        echo '<li>
             <div class="link"><a href="' . $vehicle_search_3[ 2 ] . '">' . $vehicle_search_3[ 0 ] . '</a></div>
             <div class="delete"><a href="javascript:void(0);"><i class="icon-delete"></i></a></div>
             </li>';
                    }
                }
                unset( $_SESSION[ 'search_page1' ] );
                unset( $_SESSION[ 'search_page2' ] );
                unset( $_SESSION[ 'search_page3' ] );
            }
            else
            {
                $search              = array( );
                $search_vals         = array(
                     $title,
                    $desc,
                    $url,
                    $created,
                    $alert
                );
                $user_id             = get_current_user_id();
                $user_info_id        = get_user_meta( $user_id, 'imic_user_info_id', true );
                $saved_searches_user = get_post_meta( $user_info_id, 'imic_user_saved_search', true );
                if ( !empty( $saved_searches_user ) )
                {
                    foreach ( $saved_searches_user as $searches )
                    {
                        if ( !in_array( $url, $searches ) )
                        {
                            $exist = 1;
                        }
                        else
                        {
                            $exist = 2;
                        }
                        $search[ ] = $searches;
                    }
                }
                if ( $exist == 1 || $exist == '' )
                {
                    $print     = 1;
                    $search[ ] = $search_vals;
                }
                //print_r($search);
                update_post_meta( $user_info_id, 'imic_user_saved_search', $search );
                if ( $print == 1 )
                {
                    echo '<li>
             <div class="link"><a href="' . $url . '">' . $title . '</a></div>
             <div class="delete"><a href="javascript:void(0);"><i class="icon-delete"></i></a></div>
             </li>';
                }
            }
        }
        else
        {
            if ( empty( $_SESSION[ 'search_page1' ] ) )
            {
                $vehicle_id = array(
                     $title,
                    $desc,
                    $url,
                    date( 'U' ),
                    1
                );
            }
            elseif ( empty( $_SESSION[ 'search_page2' ] ) )
            {
                $vehicle_id = array(
                     $title,
                    $desc,
                    $url,
                    date( 'U' ),
                    1
                );
            }
            elseif ( empty( $_SESSION[ 'search_page3' ] ) )
            {
                $vehicle_id = array(
                     $title,
                    $desc,
                    $url,
                    date( 'U' ),
                    1
                );
            }
            if ( empty( $_SESSION[ 'search_page1' ] ) )
            {
                $_SESSION[ 'search_page1' ] = $vehicle_id;
                echo '<li>
                                        	<div class="link"><a href="' . $vehicle_id[ 2 ] . '">' . $vehicle_id[ 0 ] . '</a></div>
                                            <div id="four" class="delete session-save-car"><a href="#"><i class="icon-delete"></i></a></div>
                                        </li>';
            }
            elseif ( empty( $_SESSION[ 'search_page2' ] ) )
            {
                $_SESSION[ 'search_page2' ] = $vehicle_id;
                echo '<li>
                                        	<div class="link"><a href="' . $vehicle_id[ 2 ] . '">' . $vehicle_id[ 0 ] . '</a></div>
                                            <div id="five" class="delete session-save-car"><a href="#"><i class="icon-delete"></i></a></div>
                                        </li>';
            }
            elseif ( empty( $_SESSION[ 'search_page3' ] ) )
            {
                $_SESSION[ 'search_page3' ] = $vehicle_id;
                echo '<li>
                                        	<div class="link"><a href="' . $vehicle_id[ 2 ] . '">' . $vehicle_id[ 0 ] . '</a></div>
                                            <div id="six" class="delete session-save-car"><a href="#"><i class="icon-delete"></i></a></div>
                                        </li>';
            }
            else
            {
                echo '<li>' . __( 'Please login/register to add more', 'framework' ) . '</li>';
            }
        }

        die( );
    }
    add_action( 'wp_ajax_nopriv_imic_save_search', 'imic_save_search' );
    add_action( 'wp_ajax_imic_save_search', 'imic_save_search' );
}
