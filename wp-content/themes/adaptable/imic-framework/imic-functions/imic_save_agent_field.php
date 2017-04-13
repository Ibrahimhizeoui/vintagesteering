<?php

if (!function_exists('imic_save_agent_field'))
{
    function imic_save_agent_field( $user_id )
    {
        $info_id = isset( $_POST[ 'imic_user_info_id' ] ) ? wp_filter_post_kses( $_POST[ 'imic_user_info_id' ] ) : '';
        update_user_meta( $user_id, 'imic_user_info_id', $info_id );
    }
    add_action( 'personal_options_update', 'imic_save_agent_field' );
    add_action( 'edit_user_profile_update', 'imic_save_agent_field' );
}
