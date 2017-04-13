<?php

if ( !function_exists( 'imic_vehicle_add' ) )
{
    function imic_vehicle_add( )
    {
        global $imic_options;

        $highlighted_specs = $imic_options[ 'highlighted_specs' ];
        $unique_specs      = $imic_options[ 'unique_specs' ];

        if ( is_user_logged_in() )
        {
            if ( ( isset( $_SESSION[ 'saved_vehicle_id1' ] ) ) || ( isset( $_SESSION[ 'saved_vehicle_id2' ] ) ) || ( isset( $_SESSION[ 'saved_vehicle_id3' ] ) ) )
            {
                $vehicle_1       = ( isset( $_SESSION[ 'saved_vehicle_id1' ] ) ) ? $_SESSION[ 'saved_vehicle_id1' ] : '';
                $vehicle_2       = ( isset( $_SESSION[ 'saved_vehicle_id2' ] ) ) ? $_SESSION[ 'saved_vehicle_id2' ] : '';
                $vehicle_3       = ( isset( $_SESSION[ 'saved_vehicle_id3' ] ) ) ? $_SESSION[ 'saved_vehicle_id3' ] : '';
                $ids             = array(
                    $vehicle_1,
                    $vehicle_2,
                    $vehicle_3
                );
                $time            = date( 'U' );
                $car             = array( );
                $user_id         = get_current_user_id();
                $user_info_id    = get_user_meta( $user_id, 'imic_user_info_id', true );
                $saved_cars_user = get_post_meta( $user_info_id, 'imic_user_saved_cars', true );

                if ( !empty( $saved_cars_user ) )
                {
                    foreach ( $saved_cars_user as $cars )
                    {
                        $car[ ] = $cars;
                    }
                }

                foreach ( $ids as $id )
                {
                    if ( $id != '' )
                    {
                        if ( !imic_search_array( $id, $car ) )
                        {
                            $car[ ] = array(
                                 $id,
                                $time
                            );
                        }
                    }
                }

                update_post_meta( $user_info_id, 'imic_user_saved_cars', $car );
                $saved_cars = get_post_meta( $user_info_id, 'imic_user_saved_cars', true );
                $i          = 0;

                foreach ($saved_cars as $car)
                {
                    $specifications        = get_post_meta( $car[ 0 ], 'feat_data', true );
                    $unique_values         = imic_vehicle_price( $car[ 0 ], $unique_specs, $specifications );
                    $new_highlighted_specs = imic_filter_lang_specs_admin( $highlighted_specs, $car[ 0 ] );
                    $highlighted_specs     = $new_highlighted_specs;
                    $highlight_values      = imic_vehicle_title( $car[ 0 ], $highlighted_specs, $specifications );
                    $highlight_values      = ( $highlight_values == '' ) ? get_the_title( $car[ 0 ] ) : $highlight_values;
                    echo '
                	<li>
                    	<div class="checkb"><input class="compare-check" type="checkbox" value="0" id="saved-' . $car[ 0 ] . '"></div>
                        <div class="imageb"><a href="' . esc_url( get_permalink( $car[ 0 ] ) ) . '">' . get_the_post_thumbnail( $car[ 0 ] ) . '</a></div>
                        <div class="textb">
                        	<a href="' . esc_url( get_permalink( $car[ 0 ] ) ) . '">' . $highlight_values . '</a>
                            <span class="price">' . $unique_values . '</span>
                       	</div>
                        <div rel="specific-saved-ad" class="delete delete-box-saved"><div class="specific-id" style="display:none;"><span class="saved-id">' . $car[ 0 ] . '</span></div><a href="#"><i class="icon-delete"></i></a></div>
                    </li>';

                    if ( $i++ >= 3 )
                    {
                        break;
                    }
                }
                unset( $_SESSION[ 'saved_vehicle_id1' ] );
                unset( $_SESSION[ 'saved_vehicle_id2' ] );
                unset( $_SESSION[ 'saved_vehicle_id3' ] );
            }
            else
            {
                $print           = '';
                $car             = array( );
                $vehicle_id      = $_POST[ 'vehicle_id' ];
                $date            = date( 'U' );
                $save_car_data   = array(
                    $vehicle_id,
                    $date
                );
                $user_id         = get_current_user_id();
                $user_info_id    = get_user_meta( $user_id, 'imic_user_info_id', true );
                $saved_cars_user = get_post_meta( $user_info_id, 'imic_user_saved_cars', true );

                if ( !empty( $saved_cars_user ) )
                {
                    foreach ( $saved_cars_user as $cars )
                    {
                        $car[ ] = $cars;
                    }
                }

                if ( !imic_search_array( $save_car_data[ 0 ], $car ) )
                {
                    $print  = 1;
                    $car[ ] = $save_car_data;
                }

                update_post_meta( $user_info_id, 'imic_user_saved_cars', $car );

                if ( $print == 1 )
                {
                    $specifications = get_post_meta( $vehicle_id, 'feat_data', true );
                    if ( !empty( $specifications ) )
                    {
                        $unique_values         = imic_vehicle_price( $vehicle_id, $unique_specs, $specifications );
                        $new_highlighted_specs = imic_filter_lang_specs_admin( $highlighted_specs, $vehicle_id );
                        $highlighted_specs     = $new_highlighted_specs;
                        $highlight_values      = imic_vehicle_title( $vehicle_id, $highlighted_specs, $specifications );
                        $highlight_values      = ( $highlight_values == '' ) ? get_the_title( $vehicle_id ) : $highlight_values;
                        echo '
                    	<li>
                        	<div class="checkb"><input class="compare-check" type="checkbox" value="0" id="saved-' . $vehicle_id . '"></div>
                            <div class="imageb"><a href="' . esc_url( get_permalink( $vehicle_id ) ) . '">' . get_the_post_thumbnail( $vehicle_id ) . '</a></div>
                            <div class="textb">
                            	<a href="' . esc_url( get_permalink( $vehicle_id ) ) . '">' . $highlight_values . '</a>
                                <span class="price">' . $unique_values . '</span>
                           	</div>
                            <div rel="specific-saved-ad" class="delete delete-box-saved"><div class="specific-id" style="display:none;"><span class="saved-id">' . $vehicle_id . '</span></div><a href="#"><i class="icon-delete"></i></a></div>
                        </li>';
                    }
                }
            }
        }
        else
        {
            if ( empty( $_SESSION[ 'saved_vehicle_id1' ] ) )
            {
                $vehicle_id = $_POST[ 'vehicle_id' ];
            }
            elseif ( empty( $_SESSION[ 'saved_vehicle_id2' ] ) )
            {
                $vehicle_id = $_POST[ 'vehicle_id' ];
            }
            elseif ( empty( $_SESSION[ 'saved_vehicle_id3' ] ) )
            {
                $vehicle_id = $_POST[ 'vehicle_id' ];
            }

            if ( empty( $_SESSION[ 'saved_vehicle_id1' ] ) )
            {
                $_SESSION[ 'saved_vehicle_id1' ] = $vehicle_id;
                $specifications                  = get_post_meta( $_SESSION[ 'saved_vehicle_id1' ], 'feat_data', true );
                $unique_value                    = imic_vehicle_price( $_SESSION[ 'saved_vehicle_id1' ], $unique_specs, $specifications );
                $new_highlighted_specs           = imic_filter_lang_specs_admin( $highlighted_specs, $_SESSION[ 'saved_vehicle_id1' ] );
                $highlighted_specs               = $new_highlighted_specs;
                $highlight_value                 = imic_vehicle_title( $_SESSION[ 'saved_vehicle_id1' ], $highlighted_specs, $specifications );
                $highlight_value                 = ( $highlight_value == '' ) ? get_the_title( $_SESSION[ 'saved_vehicle_id1' ] ) : $highlight_value;
                echo '
            	<li>
                	<div class="checkb"><input class="compare-check" type="checkbox" value="0" id="saved-' . $_SESSION[ 'saved_vehicle_id1' ] . '"></div>
                    <div class="imageb"><a href="' . esc_url( get_permalink( $_SESSION[ 'saved_vehicle_id1' ] ) ) . '">' . get_the_post_thumbnail( $_SESSION[ 'saved_vehicle_id1' ] ) . '</a></div>
                    <div class="textb">
                    	<a href="' . esc_url( get_permalink( $_SESSION[ 'saved_vehicle_id1' ] ) ) . '">' . $highlight_value . '</a>
                        <span class="price">' . $unique_value . '</span>
                   	</div>
                    <div id="one" class="delete session-save-car"><a href="#"><i class="icon-delete"></i></a></div>
                </li>';
            }
            elseif ( empty( $_SESSION[ 'saved_vehicle_id2' ] ) )
            {
                $_SESSION[ 'saved_vehicle_id2' ] = $vehicle_id;
                $specifications                  = get_post_meta( $_SESSION[ 'saved_vehicle_id2' ], 'feat_data', true );
                $unique_value                    = imic_vehicle_price( $_SESSION[ 'saved_vehicle_id2' ], $unique_specs, $specifications );
                $new_highlighted_specs           = imic_filter_lang_specs_admin( $highlighted_specs, $_SESSION[ 'saved_vehicle_id2' ] );
                $highlighted_specs               = $new_highlighted_specs;
                $highlight_value                 = imic_vehicle_title( $_SESSION[ 'saved_vehicle_id2' ], $highlighted_specs, $specifications );
                $highlight_value                 = ( $highlight_value == '' ) ? get_the_title( $_SESSION[ 'saved_vehicle_id2' ] ) : $highlight_value;
                echo '
            	<li>
                	<div class="checkb"><input class="compare-check" type="checkbox" value="0" id="saved-' . $_SESSION[ 'saved_vehicle_id2' ] . '"></div>
                    <div class="imageb"><a href="' . esc_url( get_permalink( $_SESSION[ 'saved_vehicle_id2' ] ) ) . '">' . get_the_post_thumbnail( $_SESSION[ 'saved_vehicle_id2' ] ) . '</a></div>
                    <div class="textb">
                    	<a href="' . esc_url( get_permalink( $_SESSION[ 'saved_vehicle_id2' ] ) ) . '">' . $highlight_value . '</a>
                        <span class="price">' . $unique_value . '</span>
                   	</div>
                    <div id="two" class="delete session-save-car"><a href="#"><i class="icon-delete"></i></a></div>
                </li>';
            }
            elseif ( empty( $_SESSION[ 'saved_vehicle_id3' ] ) )
            {
                $_SESSION[ 'saved_vehicle_id3' ] = $vehicle_id;
                $specifications                  = get_post_meta( $_SESSION[ 'saved_vehicle_id3' ], 'feat_data', true );
                $unique_value                    = imic_vehicle_price( $_SESSION[ 'saved_vehicle_id3' ], $unique_specs, $specifications );
                $new_highlighted_specs           = imic_filter_lang_specs_admin( $highlighted_specs, $_SESSION[ 'saved_vehicle_id3' ] );
                $highlighted_specs               = $new_highlighted_specs;
                $highlight_value                 = imic_vehicle_title( $_SESSION[ 'saved_vehicle_id3' ], $highlighted_specs, $specifications );
                $highlight_value                 = ( $highlight_value == '' ) ? get_the_title( $_SESSION[ 'saved_vehicle_id3' ] ) : $highlight_value;
                echo '
            	<li>
                	<div class="checkb"><input class="compare-check" type="checkbox" value="0" id="saved-' . $_SESSION[ 'saved_vehicle_id3' ] . '"></div>
                    <div class="imageb"><a href="' . esc_url( get_permalink( $_SESSION[ 'saved_vehicle_id3' ] ) ) . '">' . get_the_post_thumbnail( $_SESSION[ 'saved_vehicle_id3' ] ) . '</a></div>
                    <div class="textb">
                    	<a href="' . esc_url( get_permalink( $_SESSION[ 'saved_vehicle_id3' ] ) ) . '">' . $highlight_value . '</a>
                        <span class="price">' . $unique_value . '</span>
                   	</div>
                    <div id="three" class="delete session-save-car"><a href="#"><i class="icon-delete"></i></a></div>
                </li>';

            }
            else
            {
                echo '<li>' . __( 'Please login/register to add more', 'framework' ) . '</li>';
            }
        }
        die( );
    }
    add_action( 'wp_ajax_nopriv_imic_vehicle_add', 'imic_vehicle_add' );
    add_action( 'wp_ajax_imic_vehicle_add', 'imic_vehicle_add' );
}
