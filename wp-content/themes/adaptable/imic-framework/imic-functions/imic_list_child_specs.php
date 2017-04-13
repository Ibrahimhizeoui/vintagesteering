<?php

if ( !function_exists( "imic_list_child_specs" ) )
{
    function imic_list_child_specs( )
    {
        $spec_id  = ( isset( $_POST[ 'specid' ] ) ) ? $_POST[ 'specid' ] : '';
        $spec_val = ( isset( $_POST[ 'parent' ] ) ) ? $_POST[ 'parent' ] : '';
        $list_id  = ( isset( $_POST[ 'listid' ] ) ) ? $_POST[ 'listid' ] : '';
        if ( $spec_id != '' && $spec_val != '' )
        {
            $char_slug     = imic_the_slug( $spec_id );
            $spec_value    = '';
            $current_value = get_post_meta( $list_id, 'child_' . $char_slug, true );
            $values        = get_post_meta( $spec_id, 'specifications_value', true );
            echo '<select type="text" class="meta_feat_title rwmb-select" name="child_' . esc_attr( $char_slug ) . '">';
            foreach ( $values as $value )
            {
                if ( $spec_val == $value[ 'imic_plugin_specification_values' ] )
                {
                    $child_vals = $value[ 'imic_plugin_specification_values_child' ];
                    $child_vals = explode( ',', $child_vals );
                    break;
                }
            }
            foreach ( $child_vals as $val )
            {
                $selected = ( $current_value == $val || $current_value == " " . $val ) ? 'selected' : '';
                echo '<option ' . $selected . ' value="' . $val . '">' . $val . '</option>';
            }
            echo '</select>';
        }
        die( );
    }
    add_action( 'wp_ajax_nopriv_imic_list_child_specs', 'imic_list_child_specs' );
    add_action( 'wp_ajax_imic_list_child_specs', 'imic_list_child_specs' );
}
