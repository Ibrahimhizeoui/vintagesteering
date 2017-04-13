<?php

if ( !function_exists( 'imic_sortable_specification_filter' ) )
{
    function imic_sortable_specification_filter( )
    {
        $spec_value    = $_POST[ 'sorting' ];
        $spec_id       = $_POST[ 'spec_id' ];
        $field_id      = $spec_id * 111;
        $spec_multi_id = explode( '-', $spec_id );
        $spec_id       = $spec_multi_id[ 1 ] - 2648;
        $specs         = get_post_meta( $spec_id, 'specifications_value', true );
        $key           = find_car_with_position( $specs, $spec_value );
        $vals          = $specs[ $key ][ 'imic_plugin_specification_values_child' ];
        if ( !empty( $vals ) )
        {
            $new_val     = explode( ',', $vals );
            $child_label = get_post_meta( $spec_id, 'imic_plugin_sub_field_label', true );
            $integer     = get_post_meta( $spec_id, 'imic_plugin_spec_char_type', true );
            $spec_slug   = imic_the_slug( $spec_id );
            if ( $integer == 0 )
            {
                $slug        = "feat_data";
                $child_field = 'variation-' . $spec_id;
            }
            elseif ( $integer == 1 )
            {
                $slug        = "int_" . $spec_slug;
                $child_field = '';
            }
            else
            {
                $slug        = "child_" . $spec_slug;
                $child_field = $slug;
            }
            echo '<div class="accordion-group panel">
        <div class="accordion-heading togglize">
            <a class="accordion-toggle" data-toggle="collapse" data-parent="#" href="#collapseTwo-sub' . esc_attr( $spec_id ) . '">' . $child_label . '<i class="fa fa-angle-down"></i> </a>
        </div>
        <div id="collapseTwo-sub' . esc_attr( $spec_id ) . '" class="accordion-body collapse">
            <div class="accordion-inner">
                <ul id="' . $child_field . '" class="filter-options-list new-filter-list list-group search-fields">';
            foreach ( $new_val as $val )
            {
                $total_cars = imic_count_cars_by_specification( $slug, $val );
                if ( $total_cars >= 1 )
                {
                    echo '<li class="list-group-item">';
                    echo '<span class="badge">' . esc_attr( $total_cars ) . '</span><a href="#">' . esc_attr( $val ) . '</a>';
                    echo '</li>';
                }
            }
            echo '</ul>
            </div>
        </div>
    </div>';
        }
        die( );
    }
    add_action( 'wp_ajax_nopriv_imic_sortable_specification_filter', 'imic_sortable_specification_filter' );
    add_action( 'wp_ajax_imic_sortable_specification_filter', 'imic_sortable_specification_filter' );
}
