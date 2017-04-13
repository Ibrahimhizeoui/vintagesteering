<!-- AD LISTING FORM STEP THREE -->
<div id="listing-add-form-three" class="tab-pane fade <?php echo ($active_tab3 != '') ? $active_tab3 . ' in' : ''; ?>">
    <h3><?php echo esc_attr_e('Please fill in the following details below', 'adaptable-child'); ?></h3>
    <div class="row">
        <div class="col-md-6">
            <?php

            if (!empty($additional_details))
            {
            	foreach($additional_details as $field)
            	{
            		$label     = get_post_meta($field, 'imic_plugin_value_label', true);
            		$editable  = get_post_meta($field, 'imic_plugin_status_after_payment', true);
            		$disable   = (($editable == 0) && ($payment_status != 0)) ? 'disabled' : '';
            		$values    = get_post_meta($field, 'specifications_value', true);
            		$post_data = get_post($field);
            		$spec_slug = $post_data->post_name;
            		$required  = get_post_meta($field, 'imic_plugin_required_mandatory', true);
            		$integer   = get_post_meta($field, 'imic_plugin_spec_char_type', true);
                    $field_title    = get_the_title($field);

                    switch ($integer) {
                        case 0:
                            $input_id = 'field-' . ($field + 2648);
                            break;
                        case 2:
                            $input_id = 'char-' . ($field + 2648);
                            break;
                        default:
                            $input_id = 'int-' . $field;
                    }

            		$sub_fields = get_post_meta($field, 'imic_plugin_sub_field_switch', true);
            		$sortable_class = ($sub_fields == 1) ? "sortable-specs" : "";
            		$required = ($required == 1) ? 'mandatory' : '';
            		$int_value = ($integer == 1) ? ' integer-val' : '';

            		echo '<label>' . __('Select ', 'framework') . get_the_title($field) . '</label>';
            		if ((count($values) > 1) && ($integer == 0 || $integer == 2))
            		{
            			echo '<select ' . $disable . ' name="' . basename(get_permalink($field)) . '" id="' . $input_id . '" class="' . $sortable_class . ' form-control selectpicker custom-cars-fields mandatory' . $required . '" data-default-field-name="'. get_the_title($field) . ' (Select)'. '">';
            			echo '<option value="0">' . get_the_title($field) . ' (Select)' . '</option>';
            			if ($update_id != '')
            			{
                            switch($integer) {
                                case 0:
                                    $key = array_search($field, $specifications['sch_title']);
                                    $required_value = $specifications['start_time'][$key];
                                    break;
                                case 2:
                                    $required_value = get_post_meta($update_id, 'char_' . $spec_slug, true);
                                    break;
                                default:
                                    $required_value = get_post_meta($update_id, 'int_' . $spec_slug, true);
                            }
            			}

            			$key_select = $count = 0;

                        usort($values , 'alphaNumericCmp');

            			foreach($values as $value)
            			{
            				$required_select = ($required_value == $value['imic_plugin_specification_values']) ? 'selected' : '';
            				if ($required_select != '')
            				{
            					$key_select = $count;
            				}
            				echo '<option ' . $required_select . ' value="' . $value['imic_plugin_specification_values'] . '">' . $value['imic_plugin_specification_values'] . '</option>';
            				$count++;
            			}

            			echo '</select>';
            			if ($sub_fields == 1 && ($integer == 0 || $integer == 2))
            			{
            				$child_field_class = ($integer == 0) ? "field-" : "char-";
            				$child_field_class_select = ($integer == 0) ? "field-" : "child-";

                            echo '<div class="' . $child_field_class . (($field * 111) + 2648) . ' sorting-dynamic">';
            				if ((!empty($values[$key_select]['imic_plugin_specification_values_child'])))
            				{
            					echo '<label>' . __('Select ', 'framework') . get_post_meta($field, 'imic_plugin_sub_field_label', true) . '</label>';
            					echo '<select ' . $disable . ' id="' . $child_field_class_select . (($field * 111) + 2648) . '" name="' . ($field * 111) . '" class="mandatory form-control selectpicker abc456 custom-cars-fields" data-default-field-name="'. esc_attr($field_title) . '">';
                                    echo '<option value="0">' . get_the_title($field) . '</option>';
                					if ($update_id != '')
                					{
                						if ($specification_data_type == "0")
                						{
                							$key = array_search($field * 111, $specifications['sch_title']);
                							$required_value = $specifications['start_time'][$key];
                						}
                						else
                						{
                							$child_field_slug = imic_the_slug($field);
                							$required_value = get_post_meta($field, 'char_' . $child_field_slug, true);
                						}

                						$child_vals = $values[$key_select]['imic_plugin_specification_values_child'];

                						if (!empty($child_vals))
                						{
                							$child_values = explode(',', $child_vals);
                						}

                						foreach($child_values as $value)
                						{
                							$required_select = ($required_value == $value) ? 'selected' : '';
                							echo '<option ' . $required_select . ' value="' . $value . '">' . $value . '</option>';
                						}
                					}
            					echo '</select>';
            				}
            				echo '</div>';
            			}
            		}
            		else
            		{
            			if ($update_id != '')
            			{
            				$required_value = '';
                            switch ($integer) {
                                case 0:
                                    $key = array_search($field, $specifications['sch_title']);
                                    $required_value = $specifications['start_time'][$key];
                                    break;
                                case 2:
                                    $required_value = get_post_meta($update_id, 'char_' . $spec_slug, true);
                                    break;
                                default:
                                    $required_value = get_post_meta($update_id, 'int_' . $spec_slug, true);
                            }
            			}

            			if ($label != '')
            			{
            				echo '<div class="input-group" data-integer-group >
                                <input '.esc_attr($disable).' type="text" id="' . esc_attr($input_id) . '" value="' . $required_value . '" name="' . basename(get_permalink($field)) . '" class="form-control ' . esc_attr($required) . esc_attr($int_value) . '" placeholder="' . get_the_title($field) . '" data-default-field-name="'. basename(get_permalink($field)) . '">
                                <span class="input-group-addon filter-option">' . $label . '</span>
                            </div>';
            			}
            			else
            			{
            				echo '<input '.$disable.' type="text" id="'.$input_id.'" value="'. $required_value .'" name="'.basename(get_permalink($field)).'" class="form-control custom-cars-fields '. esc_attr($required) . esc_attr($int_value) .'" placeholder="'.get_the_title($field).'">';
            			}
            		}
            	}
            } ?>
            <div class="listing-step-three-conf">
                <?php if ($update_id) {
                	$car_phone_no = get_post_meta($update_id, 'imic_plugin_contact_phone', true);
                	$car_email_ad = get_post_meta($update_id, 'imic_plugin_contact_email', true);
                } else {
                	$car_phone_no = get_post_meta($user_info_id, 'imic_user_telephone', true);
                	$car_email_ad = $current_user->user_email;
                } ?>

                <h6 class="upper"><?php echo esc_attr_e('How can buyers contact you?', 'adaptable-child'); ?></h6>

                <div class="listing-step-three-conf__continue">

                    <div class="form-group">
                        <label><?php echo esc_attr_e('Enter Your Phone Number*', 'adaptable-child'); ?></label>
                        <input value="<?php echo esc_attr($car_phone_no); ?>" id="vehicle-contact-phone" type="text" class="form-control" placeholder="Phone Number">
                    </div>
                    <div class="form-group">
                        <label><?php echo esc_attr_e('Enter Your Email Address', 'adaptable-child'); ?></label>
                        <input value="<?php echo esc_attr($car_email_ad); ?>" id="vehicle-contact-email" type="email" class="form-control" placeholder="Email Address">
                    </div>
                    <?php
                    if (is_user_logged_in())
                    { ?>
                        <button id="ss" class="button button--alternate button--full save-searched-value">
                            <?php echo esc_attr_e('Save ', 'adaptable-child'); ?>
                            &amp;
                            <?php echo esc_attr_e(' continue', 'adaptable-child'); ?>
                        </button><?php
                    }
                    else
                    {
                        echo '<a class="button button--black button--full" data-toggle="modal" data-target="#PaymentModal">' . __('Login/Register', 'framework') . '</a>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
