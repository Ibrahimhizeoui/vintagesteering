<?php

if ( !function_exists( 'imic_sortable_specification' ) )
{
    function imic_sortable_specification( )
    {
        global $imic_options;
        $spec_value         = $_POST[ 'sorting' ];
        $spec_id            = $_POST[ 'spec_id' ];
        $spec_multi_id      = explode( '-', $spec_id );
        $select_new_class   = ( $spec_multi_id[ 0 ] == "field" ) ? "field-" : "child-";
        $spec_id            = $spec_multi_id[ 1 ] - 2648;
        $numeric_specs_type = ( isset( $imic_options[ 'integer_specs_type' ] ) ) ? $imic_options[ 'integer_specs_type' ] : 0;
        $spec_name          = ( $numeric_specs_type == 0 ) ? $spec_id * 111 : 'child_' . imic_the_slug( $spec_id );
        $specs              = get_post_meta( $spec_id, 'specifications_value', true );
        $key                = find_car_with_position( $specs, $spec_value );
        $vals               = $specs[ $key ][ 'imic_plugin_specification_values_child' ];

        if ( !empty( $vals ) )
        {
            $new_val = explode( ',', $vals );
            echo '<label>Select ' . get_post_meta( $spec_id, 'imic_plugin_sub_field_label', true ) . '</label>';
            echo '<select id="' . $select_new_class . ( ( $spec_id * 111 ) + 2648 ) . '" class="form-control selectpicker custom-cars-fields" name="' . ( $spec_name ) . '">';
            echo '<option value="" disabled selected>' . esc_attr__( 'All', 'framework' ) . '</option>';

            usort($new_val, 'alphaNumericCmp');

            foreach ( $new_val as $val )
            {
                echo '<option value="' . $val . '">' . $val . '</option>';
            }
            echo '</select>';
        }
        die( );
    }
    add_action( 'wp_ajax_nopriv_imic_sortable_specification', 'imic_sortable_specification' );
    add_action( 'wp_ajax_imic_sortable_specification', 'imic_sortable_specification' );
}
