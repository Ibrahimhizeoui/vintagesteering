<?php

if ( !function_exists('imic_agent_fields'))
{
    function imic_agent_fields( $user )
    {
        $info_id = get_the_author_meta( 'imic_user_info_id', $user->ID ); ?>
        <h3><?php _e( 'User Info ID', 'framework' ); ?></h3>
        <table class="form-table">
            <tr>
                <th>
                    <label for="User Info ID"><?php _e( 'Dealers Info ID', 'framework' ); ?></label>
                </th>
                <td>
                    <label>
                        <input type="text" name="imic_user_info_id" value ="<?php echo esc_attr( $info_id ); ?>" />
                    </label>
                </td>
            </tr>
        </table>
        <?php
    }
    add_action('show_user_profile', 'imic_agent_fields');
    add_action('edit_user_profile', 'imic_agent_fields');
}
