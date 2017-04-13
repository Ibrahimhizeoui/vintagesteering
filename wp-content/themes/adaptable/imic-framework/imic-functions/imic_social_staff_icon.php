<?php

if ( !function_exists( 'imic_social_staff_icon' ) )
{
    function imic_social_staff_icon( $id = '' )
    {
        $output = '';
        if ( $id == '' )
        {
            $id = get_the_ID();
        }
        $staff_icons = get_post_meta( $id, 'imic_social_icon_list', false );
        if ( !empty( $staff_icons[ 0 ] ) || get_post_meta( $id, 'imic_staff_member_email', true ) != '' )
        {
            $output .= '<ul class="social-icons-colored">';
            if ( !empty( $staff_icons[ 0 ] ) )
            {
                foreach ( $staff_icons[ 0 ] as $list => $values )
                {
                    if ( !empty( $values[ 1 ] ) )
                    {
                        $className = preg_replace( '/\s+/', '-', strtolower( $values[ 0 ] ) );
                        $className = 'fa fa-' . $className;
                        $output .= '<li class="' . $values[ 0 ] . '"><a href="' . $values[ 1 ] . '" target ="_blank"><i class="' . $className . '"></i></a></li>';
                    }
                }
            }
            if ( get_post_meta( $id, 'imic_staff_member_email', true ) != '' )
            {
                $output .= '<li class="email"><a href="mailto:' . get_post_meta( $id, 'imic_staff_member_email', true ) . '"><i class="fa fa-envelope"></i></a></li>';
            }
            $output .= '</ul>';
        }
        return $output;
    }
}
