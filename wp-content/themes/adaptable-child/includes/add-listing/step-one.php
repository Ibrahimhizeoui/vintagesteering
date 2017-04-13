<?php // AD LISTING FORM STEP ONE ?>
<div id="listing-add-form-one" class="tab-pane fade <?php echo ($active_tab1 != '') ? $active_tab1 . ' in' : ''; ?>">
    <h3><?php echo esc_attr_e('To add a listing, please fill in the required information below.', 'adaptable-child'); ?></h3>
    <p></p>
    <div class="tabs listing-step-tabs">
        <?php

        if ($imic_options['ad_listing_fields'] == 0)
        { ?>
            <ul class="nav nav-tabs" style="display:none;">
                <li class="<?php echo $active_form_search; ?>">
                    <a data-toggle="tab" href="#searchvehicle" aria-controls="searchvehicle" role="tab"><?php echo esc_attr_e('Search vehicle by Make, Model, Year', 'adaptable-child'); ?></a>
                </li>
                <li class="custom-vehicle-details <?php echo $active_custom_form; ?>" style="display:none;">
                    <a data-toggle="tab" href="#addcustom" aria-controls="addcustom" role="tab"><?php echo esc_attr_e('Add custom vehicle details', 'adaptable-child'); ?></a>
                </li>
            </ul>
            <?php
        } ?>

        <div class="tab-content">
            <!-- VEHICLE SEARCH AD LISTING -->
            <?php
            $first = 0;

            if (!empty($search_fields))
            {
            	$first = 1;
            	if ($imic_options['ad_listing_fields'] == 0) { ?>

                    <div id="searchvehicle" class="tab-pane fade <?php echo $active_tab_search; ?>">
                        <div class="alert alert-warning fade in">
                            <strong><?php echo esc_attr_e('Find', 'adaptable-child'); ?></strong>
                            <?php echo esc_attr_e('Your listing using the dropdowns below. First select its Make, then Model and later select its year. ', 'adaptable-child'); ?>
                            <a data-toggle="tab" href="#addcustom"><?php echo esc_attr_e('Add custom vehicle details', 'adaptable-child'); ?></a>
                        </div>

                        <div class="row"><?php
            			echo '<div class="col-md-6">';
            			foreach($search_fields as $field) {

                            $editable  = get_post_meta($field, 'imic_plugin_status_after_payment', true);
            				$disable   = (($editable == 0) && ($payment_status != 0)) ? 'disabled' : '';
            				$post_data = get_post($field);
                            $spec_slug = $post_data->post_name;
            				$values    = get_post_meta($field, 'specifications_value', true);
            				$required  = get_post_meta($field, 'imic_plugin_required_mandatory', true);
            				$integer   = get_post_meta($field, 'imic_plugin_spec_char_type', true);
            				$slug      = imic_the_slug($field);

            				if ($integer == 0) {
            					$input_id = 'field-' . ($field + 2648);
            				} elseif ($integer == 2) {
            					$input_id = 'char-' . ($field + 2648);
                            } else {
            					$input_id = 'int-' . $field;
            				}

            				$required = ($required == 1) ? 'mandatory' : '';

            				if (!empty($values[0]['imic_plugin_specification_values']))
            				{
            					echo '<select id="' . esc_attr($input_id) . '" name="' . basename(get_permalink($field)) . '" ' . $disable . ' class="sortable-specs form-control selectpicker search-cars-fields finder ' . $required . '">';
                					echo '<option value="0">' . __('Select', 'framework') . '</option>';

                					if ($update_id != '') {
                						if ($integer == 0) {
                							$key = array_search($field, $specifications['sch_title']);
                							$required_value = $specifications['start_time'][$key];
                						} elseif ($integer == 2) {
                							$required_value = get_post_meta($update_id, 'char_' . $spec_slug, true);
                                        } else {
                							$required_value = get_post_meta($update_id, 'int_' . $spec_slug, true);
                						}
                					}

                					$key_select = $count = 0;
                					foreach($values as $value) {

                						$required_select = ($required_value == $value['imic_plugin_specification_values']) ? 'selected' : '';

                						if ($required_select != ''){
                							$key_select = $count;
                						}

                						echo '<option ' . esc_attr($required_select) . ' value="' . $value['imic_plugin_specification_values'] . '">' . $value['imic_plugin_specification_values'] . '</option>';
                						$count++;
                                    }
            					echo '</select>';

            					$child_field_class = ($integer == 0) ? "field-" : "char-";
            					$child_field_class_select = ($integer == 0) ? "field-" : "child-";
            					echo '<div class="' . $child_field_class . (($field * 111) + 2648) . ' sorting-dynamic">';
                					if ((!empty($values[$key_select]['imic_plugin_specification_values_child']))) {
                    					echo '<label>Select ' . get_post_meta($field, 'imic_plugin_sub_field_label', true) . '</label>';
                    					echo '<select ' . esc_attr($disable) . ' id="' . $child_field_class_select . (($field * 111) + 2648) . '" name="' . ($field * 111) . '" class="form-control selectpicker search-cars-fields">';
                        					echo '<option value="0">' . __('Select ', 'framework') . get_the_title($field) . '</option>';
                    						if ($update_id != '') {

                    							$key = array_search($field * 111, $specifications['sch_title']);
                    							$required_value = $specifications['start_time'][$key];
                    							$child_vals = $values[$key_select]['imic_plugin_specification_values_child'];

                                                if (!empty($child_vals)) {
                    								$child_values = explode(',', $child_vals);
                    							}

                    							foreach($child_values as $value) {
                    								$required_select = ($required_value == $value) ? 'selected' : '';
                    								echo '<option ' . esc_attr($required_select) . ' value="' . $value . '">' . $value . '</option>';
                    							}
                    						}
                						echo '</select>';
                    				}
            					echo '</div>';
            				}
            				else
            				{
            					if ($update_id != '')
            					{
            						$required_value = '';
            						$key = array_search($field, $specifications['sch_title']);
            						$required_value = $specifications['start_time'][$key];
            					}

            					echo '<input ' . esc_attr($disable) . ' type="text" id="' . $input_id . '" value="' . $required_value . '" name="' . basename(get_permalink($field)) . '" class="form-control custom-cars-fields finder ' . esc_attr($required) . '" placeholder="' . get_the_title($field) . '*">';
            				}
            			}

                		$status_vehicle = get_post_meta($update_id, 'imic_plugin_ad_payment_status', true);
                		if ($status_vehicle == "3" || $status_vehicle == "0")
                		{
                			if (is_user_logged_in())
                			{ ?>
                                                <input type="submit" id="find-matched-cars" class="btn btn-primary pull-right find-cars" value="<?php
                				echo esc_attr_e('Find', 'adaptable-child'); ?>"><?php
                			}
                			else
                			{
                				echo '<a class="btn btn-primary pull-right" data-toggle="modal" data-target="#PaymentModal">' . __('Login/Register', 'framework') . '</a>';
                			}
                		} ?>
                            <div class="clearfix"></div>
                        </div>

                                <div class="col-md-6">
                                    <div id="finded-results">
                                        <!-- Result -->
                                        <div class="loading-result-found" style="display:none;"><?php _e('Searching...', 'adaptable-child'); ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php
            	}
            }

            $second_active = ($first == 0) ? "active in" : "";

            if (is_user_logged_in())
            { ?>
                <!-- CUSTOM VEHICLE LISTING -->
                <div id="addcustom" class="tab-pane fade <?php echo esc_attr($second_active); echo esc_attr($active_tab_custom); ?>"> <?php
            }
            else
            {
            	echo '<div data-toggle="modal" data-target="#PaymentModal" id="addcustom" class="tab-pane fade ' . esc_attr($second_active) . ' ' . esc_attr($active_tab_custom) . '">';
            }

            if ($imic_options['ad_listing_fields'] == 0)
            {
            	// UNCOMMENT FOR MESSAGE AT TOP OF CUSTOM
            	// <div class="alert alert-warning fade in">
            	// echo esc_attr_e('Custom vehicle ad listing can take more days to review as compared to searched vehicle listing. ','adaptable-child');
            	// <a data-toggle="tab" href="#searchvehicle"> // echo esc_attr_e('Try search again','adaptable-child'); </a>
            	// </div>
            } ?>

            <div class="row">
                <?php

                if (get_query_var('list-cat') != '')
                {
                	$category_slug = get_query_var('list-cat');
                	$term_id = get_term_by('slug', $category_slug, 'listing-category');
                	$parents = get_ancestors($term_id->term_id, 'listing-category');
                	$term_id = $term_id->term_id;
                	$classifieds_details = get_option('imic_classifieds');
                	$classifieds_details = (!empty($classifieds_details)) ? get_option('imic_classifieds') : array();

                	if ((array_key_exists($term_id, $classifieds_details)) && (!empty($classifieds_details)))
                	{
                		$custom_details = $classifieds_details[$term_id]['ad'];
                		$custom_details = explode(',', $custom_details);
                	}
                	else
                	{
                		foreach($parents as $parent)
                		{
                			$list_term = get_term_by('id', $parent, 'listing-category');
                			if ((array_key_exists($list_term->term_id, $classifieds_details)) && (!empty($classifieds_details)))
                			{
                				$custom_details = $classifieds_details[$list_term->term_id]['ad'];
                				$custom_details = explode(',', $custom_details);
                				break;
                			}
                		}
                	}

                	if (empty($custom_details[0]))
                	{
                		$custom_details = $imic_options['custom_vehicle_details'];
                	}
                }
                else
                {
                	$custom_details = (isset($imic_options['custom_vehicle_details'])) ? $imic_options['custom_vehicle_details'] : array();
                }

                if (!empty($custom_details)) {

                	$total_fields = count($custom_details);
                	$half = $total_fields / 2;
                	$half = (imic_is_decimal($half)) ? $half + 1 : $half;
                	$half = floor($half);
                	$st = 1;

                	foreach($custom_details as $field) {

                    	$label = get_post_meta($field, 'imic_plugin_value_label', true);
                		$editable = get_post_meta($field, 'imic_plugin_status_after_payment', true);

                    	if (!is_user_logged_in()) {
                			$editable = 0;
                			$payment_status = 1;
                		}

                		$disable = (($editable == 0) && ($payment_status != 0)) ? 'disabled' : '';

                    	if ($st == 1 || $st == $half + 1) {
                			echo '<div class="col-md-6">';
                		}

                		$values         = get_post_meta($field, 'specifications_value', true);
                		$post_data      = get_post($field);
                		$spec_slug      = $post_data->post_name;
                		$required       = get_post_meta($field, 'imic_plugin_required_mandatory', true);
                		$integer        = get_post_meta($field, 'imic_plugin_spec_char_type', true);
                		$sub_fields     = get_post_meta($field, 'imic_plugin_sub_field_switch', true);
                		$sortable_class = ($sub_fields == 1) ? "sortable-specs" : "";
                        $field_title    = get_the_title($field);

                        // sort values by alpha numeric
                        usort($values , 'alphaNumericCmp');

                    	if ($integer == 0) {
                			$input_id = 'field-' . ($field + 2648);
                		} elseif ($integer == 2) {
                			$input_id = 'char-' . ($field + 2648);
                        } else {
                			$input_id = 'int-' . $field;
                		}

                		$required  = ($required == 1) ? 'mandatory'   : '';
                		$int_value = ($integer  == 1) ? 'integer-val' : '';

                		echo '<label>' . __('Select ', 'framework') . $field_title . '</label>';

                		if ((count($values) > 1) && ($integer == 0 || $integer == 2)) {

                			echo '<select ' . $disable . ' name="' . basename(get_permalink($field)) . '" id="' . $input_id . '" class="' . $sortable_class . ' form-control selectpicker custom-cars-fields ' . $required . '" data-default-field-name="'. esc_attr($field_title) . '">';
                			echo "<option value=\"0\">" . $field_title . "</option>";

                            if ($update_id != '') {
                				if ($integer == 0) {
                					$key = array_search($field, $specifications['sch_title']);
                					$required_value = $specifications['start_time'][$key];
                				} elseif ($integer == 2) {
                					$required_value = get_post_meta($update_id, 'char_' . $spec_slug, true);
                				} else {
                					$required_value = get_post_meta($update_id, 'int_' . $spec_slug, true);
                				}
                			}

                			$key_select = $count = 0;

                			foreach($values as $value) {

                				$required_select = ($required_value == $value['imic_plugin_specification_values']) ? 'selected' : '';

                				if ($required_select != '') {
                					$key_select = $count;
                				}

                				echo '<option ' . esc_attr($required_select) . ' value="' . $value['imic_plugin_specification_values'] . '">' . $value['imic_plugin_specification_values'] . '</option>';
                				$count++;
                			}

                			echo '</select>';
                			if (($sub_fields == 1 && $integer == 0) || ($sub_fields == 1 && $integer == 2))
                			{
                				$child_field_class = ($integer == 0) ? "field-" : "char-";
                				$child_field_class_select = ($integer == 0) ? "field-" : "child-";

                				echo '<div class="' . $child_field_class . (($field * 111) + 2648) . ' sorting-dynamic">';
                				if ((!empty($values[$key_select]['imic_plugin_specification_values_child'])))
                				{
                					echo '<label>' . __('Select ', 'framework') . get_post_meta($field, 'imic_plugin_sub_field_label', true) . '</label>';
                					echo '<select ' . $disable . ' id="' . $child_field_class_select . (($field * 111) + 2648) . '" name="' . ($field * 111) . '" class="form-control selectpicker custom-cars-fields mandatory" data-default-field-name="'. esc_attr($field_title) . '">';
                                    echo '<option value="0">Model (Select ' . get_the_title($field) . ')</option>';
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
                							$required_value = get_post_meta($update_id, 'child_' . $child_field_slug, true);
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
                				if ($integer == 0)
                				{
                					$key = array_search($field, $specifications['sch_title']);
                					$required_value = $specifications['start_time'][$key];
                				}
                				elseif ($integer == 2)
                				{
                					$required_value = get_post_meta($update_id, 'char_' . $spec_slug, true);
                				}
                				else
                				{
                					$required_value = get_post_meta($update_id, 'int_' . $spec_slug, true);
                				}
                			}

                            echo '<input ' . $disable . ' type="text" id="' . $input_id . '" value="' . $required_value . '" name="' . basename(get_permalink($field)) . '" class="form-control custom-cars-fields ' . $required . ' ' . $int_value . '" placeholder="' . get_the_title($field) . '" /> ';
                		}

                		if (($st == $half) || (count($custom_details) == $st))
                		{
                			echo '</div>';
                		}

                		$st++;
                	}
                }
                else
                {
                	echo '<div class="col-md-12 col-sm-12"><h3>' . __('Please select category', 'framework') . '</h3></div>';
                }

                if (is_user_logged_in())
                {
                ?>
                <div class="col-md-12 spaced center">
                    <button id="ss" class="button button--alternate save-searched-value">
                        <?php echo esc_attr_e('Save', 'adaptable-child'); ?>
                        &amp;
                        <?php echo esc_attr_e('continue', 'adaptable-child'); ?>
                    </button>
                </div>
                <?php
                }
                else
                {
                	// echo '<a class="btn btn-primary pull-right" data-toggle="modal" data-target="#PaymentModal">'.__('Login/Register','framework').'</a>';
                }

            if (!empty($custom_details))
            {
            	echo '</div>';
            }
            ?>
            </div>
        </div>
    </div>
</div>
