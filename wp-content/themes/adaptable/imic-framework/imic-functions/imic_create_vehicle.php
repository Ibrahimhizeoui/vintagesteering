<?php

if ( !function_exists( 'imic_create_vehicle' ) )
{
    function imic_create_vehicle( )
    {
        global $imic_options;

        _log($_POST);

        $post_id                 = $_POST[ 'post_id' ];
        $steps                   = $_POST[ 'steps' ];
        $updating_values         = '';
        $phone                   = $_POST[ 'phone' ];
        $email                   = $_POST[ 'email' ];
        $listing_view            = ( isset( $_POST[ 'listing_view' ] ) ) ? $_POST[ 'listing_view' ] : '';
        $fields                  = ( isset( $_POST[ 'values' ] ) ) ? $_POST[ 'values' ] : '';
        $tags                    = ( isset( $_POST[ 'tags' ] ) ) ? $_POST[ 'tags' ] : array( );
        $val                     = $id = $mids = '';
        $data                    = ( isset( $_POST[ 'matched' ] ) ) ? $_POST[ 'matched' ] : '';
        $mids                    = ( isset( $_POST[ 'mids' ] ) ) ? $_POST[ 'mids' ] : '';
        $category                = ( isset( $_POST[ 'category' ] ) ) ? $_POST[ 'category' ] : '';
        $category                = ( $category != "none" ) ? $category : '';
        $remain                  = ( isset( $_POST[ 'remain' ] ) ) ? $_POST[ 'remain' ] : '';
        $plans                   = ( isset( $_POST[ 'plan' ] ) ) ? $_POST[ 'plan' ] : '';
        $user_id                 = get_current_user_id();
        $user_info_id            = get_user_meta( $user_id, 'imic_user_info_id', true );
        $user_remaining_listings = get_post_meta( $user_info_id, 'imic_allowed_listings_' . $plans, true );

        if ( !empty( $mids ) )
        {
            foreach ( $mids as $mid )
            {
                $spec_ids   = explode( '-', $mid );
                $spec_id[ ] = $spec_ids[ 1 ];
            }
            $new_array = array( );
            foreach ( $spec_id as $specs )
            {
                $new_array[ ] = $specs - 2648;
            }

            $updating_values = array_combine( $new_array, $fields );
        }

        $listing_status = ( isset( $imic_options[ 'opt_listing_status' ] ) ) ? $imic_options[ 'opt_listing_status' ] : 'draft';

        $listing_title = '';
        if ( !empty( $updating_values ) )
        {
            $listing_title = implode( ' ', array_filter( $updating_values, function( $v, $k )
            {
                if ( $k == 256 || $k == 28416 || $k == 258 )
                    return $v;
            }, ARRAY_FILTER_USE_BOTH ) );
        }

        $my_post = array(
             'post_title' => $listing_title,
            'post_type' => 'cars',
            'post_status' => $listing_status
        );

        if ( empty( $post_id ) )
        {
            $post_id = wp_insert_post( $my_post );
            update_post_meta( $user_info_id, 'imic_allowed_listings_' . $plans, $user_remaining_listings - 1 );
            $user_plan_summary = get_post_meta( $user_info_id, 'imic_user_plan_' . $plans, true );

            if ( !empty( $user_plan_summary ) )
            {
                foreach ( $user_plan_summary as $key => $value )
                {
                    $new_value[ $key ] = $value . ',' . $post_id;
                }
                update_post_meta( $user_info_id, 'imic_user_plan_' . $plans, $new_value );
            }

            update_post_meta( $post_id, 'imic_pages_Choose_slider_display', '1' );
            update_post_meta( $post_id, 'imic_browse_by_specification_switch', '2' );
            $valid_with_plan = get_post_meta( $plans, 'imic_plan_validity_expire_listing', true );

            //Listing not showing in front end if user doesn't set any plan
            $listing_end_date = get_post_meta( $post_id, 'imic_plugin_listing_end_dt', true );

            if ( $listing_end_date == '' && $valid_with_plan != 1 )
            {
                update_post_meta( $post_id, 'imic_plugin_listing_end_dt', '2020-01-01' );
            }
        }

        if ( $category != '' )
        {
            $cat_slug    = $category;
            $category_id = get_term_by( 'slug', $cat_slug, 'listing-category' );
            $term_id     = $category_id->term_id;
            $parents     = get_ancestors( $term_id, 'listing-category' );
            $list_terms  = array( );

            foreach ( $parents as $parent )
            {
                $list_term     = get_term_by( 'id', $parent, 'listing-category' );
                $list_terms[ ] = $list_term->slug;
            }

            $list_terms[ ] = $cat_slug;
            wp_set_object_terms( $post_id, $list_terms, 'listing-category' );
        }

        if ( $data != '' )
        {
            $id = explode( '-', $data );

            if ( !empty( $id ) )
            {
                $id         = $id[ 1 ] - 2648;
                $val        = get_post_meta( $id, 'feat_data', true );
                $int_specs  = imic_get_all_integer_specifications( 1 );
                $char_specs = imic_get_all_integer_specifications( 2 );

                foreach ( $int_specs as $int_spec )
                {
                    $pre_val = get_post_meta( $id, 'int_' . $int_spec, true );
                    update_post_meta( $post_id, 'int_' . $int_spec, $pre_val );
                }

                foreach ( $char_specs as $char_spec )
                {
                    $pre_val = get_post_meta( $id, 'char_' . $char_spec, true );
                    update_post_meta( $post_id, 'char_' . $char_spec, $pre_val );
                }
            }
        }

        if ( !empty( $mids ) )
        {
            $spec_in   = array( );
            $int_count = 0;

            foreach ( $mids as $mid )
            {
                $specs_int = explode( '-', $mid );
                if ( $specs_int[ 0 ] == "int" )
                {
                    $post_data = get_post( $specs_int[ 1 ] );
                    $spec_slug = $post_data->post_name;
                    update_post_meta( $post_id, 'int_' . $spec_slug, $fields[ $int_count ] );
                }
                elseif ( $specs_int[ 0 ] == "char" )
                {
                    $spec_id = $specs_int[ 1 ] - 2648;
                    if ( get_post_type( $specs_int[ 1 ] ) == "specification" )
                    {
                        $post_data = get_post( $specs_int[ 1 ] );
                        $spec_slug = $post_data->post_name;
                        update_post_meta( $post_id, 'char_' . $spec_slug, $fields[ $int_count ] );
                    }
                    elseif ( get_post_type( $spec_id ) == "specification" )
                    {
                        $post_data = get_post( $spec_id );
                        $spec_slug = $post_data->post_name;
                        update_post_meta( $post_id, 'char_' . $spec_slug, $fields[ $int_count ] );
                    }
                }
                elseif ( $specs_int[ 0 ] == "child" )
                {
                    $spec_id   = $specs_int[ 1 ] - 2648;
                    $spec_id   = $spec_id / 111;
                    $post_data = get_post( $spec_id );
                    $spec_slug = $post_data->post_name;
                    update_post_meta( $post_id, 'child_' . $spec_slug, $fields[ $int_count ] );
                }
                $spec_in[ ] = $specs_int[ 1 ];
                $int_count++;
            }
            $int_val_array = array_combine( $spec_in, $fields );
        }

        $tags = array_map( 'intval', $tags );
        $tags = array_unique( $tags );
        wp_set_object_terms( $post_id, $tags, 'cars-tag' );

        switch ( $steps )
        {
            case 'listing-add-form-one':
                $step = 1;
                break;
            case 'listing-add-form-two':
                $step = 2;
                break;
            case 'listing-add-form-three':
                $step = 3;
                break;
            case 'listing-add-form-four':
                $step = 4;
                break;
            case 'listing-add-form-five"':
                $step = 5;
                break;
            default:
                $step = '';
        }

        $already_step = get_post_meta( $post_id, 'imic_plugin_ads_steps', true );
        if ( $already_step < $step )
        {
            update_post_meta( $post_id, 'imic_plugin_ads_steps', $step );
        }

        update_post_meta( $post_id, 'imic_plugin_contact_phone', $phone );
        update_post_meta( $post_id, 'imic_plugin_contact_email', $email );
        update_post_meta( $post_id, 'imic_plugin_listing_view', $listing_view );

        $specs_ids = array( );
        $ints      = array( );

        $args_specification    = array(
             'post_type' => 'specification',
            'posts_per_page' => '-1',
            'post_status' => 'publish'
        );
        $specification_listing = new WP_Query( $args_specification );
        if ( $specification_listing->have_posts() ):
            while ( $specification_listing->have_posts() ):
                $specification_listing->the_post();
                $int = get_post_meta( get_the_ID(), 'imic_plugin_spec_char_type', true );
                if ( $int == 0 )
                {
                    $specs_ids[ ] = get_the_ID();
                }
                else
                {
                    $ints[ ] = get_the_ID();
                }
            endwhile;
        endif;
        wp_reset_postdata();

        $specification_values = get_post_meta( $post_id, 'feat_data', true );
        if ( empty( $specification_values[ 'start_time' ] ) )
        {
            for ( $i = 0; $i < count( $specs_ids ); $i++ )
            {
                $id   = $specs_ids[ $i ];
                $vals = get_post_meta( $id, 'specifications_value', true );
                if ( imic_get_child_values_status( $vals ) == 1 )
                {
                    $feat_data[ 'start_time' ][ ] = '';
                    $feat_data[ 'sch_title' ][ ]  = $id * 111;
                }
                $feat_data[ 'start_time' ][ ] = 'select';
                $feat_data[ 'sch_title' ][ ]  = $id;
            }

            if ( !empty( $feat_data ) )
            {
                update_post_meta( $post_id, 'feat_data', $feat_data );
            }
        }
        $specification_values = get_post_meta( $post_id, 'feat_data', true );
        if ( !empty( $specification_values[ 'start_time' ] ) )
        {
            for ( $i = 0; $i < count( $specification_values[ 'start_time' ] ); $i++ )
            {
                $value = $specification_values[ 'start_time' ][ $i ];
                $id    = $specification_values[ 'sch_title' ][ $i ];
                if ( !empty( $updating_values ) )
                {
                    if ( $i == 0 )
                    {
                        foreach ( $updating_values as $key => $values )
                        {
                            $key_id = array_search( $key, $specification_values[ 'sch_title' ] );
                            if ( !is_int( $key_id ) )
                            {
                                if ( get_post_type( $key ) == 'specification' )
                                {
                                    $vals = get_post_meta( $key, 'specifications_value', true );
                                    if ( imic_get_child_values_status( $vals ) == 1 )
                                    {
                                        $new_feat_data[ 'start_time' ][ ] = $values;
                                        $new_feat_data[ 'sch_title' ][ ]  = $key * 111;
                                    }
                                    $new_feat_data[ 'start_time' ][ ] = $values;
                                    $new_feat_data[ 'sch_title' ][ ]  = $key;
                                }
                            }
                        }
                    }
                    if ( isset( $updating_values[ $id ] ) )
                    {
                        $value = $updating_values[ $id ];
                    }
                }
                $new_feat_data[ 'start_time' ][ ] = $value;
                $new_feat_data[ 'sch_title' ][ ]  = $id;
            }
        }

        if ( !empty( $new_feat_data ) )
        {
            update_post_meta( $post_id, 'feat_data', $new_feat_data );
        }

        $title = ( isset( $imic_options[ 'highlighted_specs' ] ) ) ? $imic_options[ 'highlighted_specs' ] : array( );

        $specifications = get_post_meta( $post_id, 'feat_data', true );

        $new_title = imic_vehicle_title( $post_id, $title, $specifications );

        $new_slug  = sanitize_title( $new_title );
        $this_slug = imic_the_slug( $post_id );

        if ( $this_slug != $new_slug )
        {
            $update_title = array(
                 'ID' => $post_id,
                'post_title' => $new_title,
                'post_name' => $new_slug
            );
            wp_update_post( $update_title );
        }

        if ( $val != '' )
        {
            update_post_meta( $post_id, 'feat_data', $val );
        }
        echo esc_attr( $post_id );
        die( );
    }
    add_action( 'wp_ajax_nopriv_imic_create_vehicle', 'imic_create_vehicle' );
    add_action( 'wp_ajax_imic_create_vehicle', 'imic_create_vehicle' );
}
