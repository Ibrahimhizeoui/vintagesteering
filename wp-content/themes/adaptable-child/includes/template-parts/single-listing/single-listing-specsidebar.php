<?php if ((!empty($featured_specifications)) && ($listing_details == 0)) { ?>
    <div class="specification-sidebar">
        <h6 class="specification-sidebar__title">Specification</h6>
        <ul class="specification-sidebar__list list-group">
            <?php
            $this_specification = get_post_meta(get_the_ID(), 'feat_data', true);
            foreach ($featured_specifications as $featured) {

                $field_type         = get_post_meta($featured, 'imic_plugin_spec_char_type', true);
                $value_label        = get_post_meta($featured, 'imic_plugin_value_label', true);
                $label_position     = get_post_meta($featured, 'imic_plugin_lable_position', true);
                $badge_slug         = imic_the_slug($featured);

                /**
                 * The below was checking to see if '$specification_data_type' was 0
                 * The theme doesn't make it clear what this is but for any new listing
                 * created by users, no data gets pulled through
                 *
                 * Feels almost like this is here for when you import their dummy data
                 * but doing so breaks the theme.
                 * ========================
                 * if ($specification_data_type == '0') {
                 * 		$spec_key   = array_search($featured, $this_specification[ 'sch_title' ]);
                 *  	$second_key = array_search($featured * 111, $this_specification[ 'sch_title' ]);
                 * } else {
                 * $spec_key = $second_key = '';
                 * }
                 */

                // Updated for new listings
                $spec_key   = array_search($featured, $this_specification[ 'sch_title' ]);
                $second_key = array_search($featured * 111, $this_specification[ 'sch_title' ]);

                $feat_val = get_post_meta($id, 'int_' . $badge_slug, true);

                if ($field_type == 1 && $feat_val != '') {
                    if ($label_position == 0) {
                        echo '<li class="list-group-item"> <span class="badge">' . get_the_title($featured) . '</span> ' . $value_label . $feat_val . '</li>';
                    } else {
                        echo '<li class="list-group-item"> <span class="badge">' . get_the_title($featured) . '</span> ' . get_post_meta($id, 'int_' . $badge_slug, true) . $value_label . '</li>';
                    }
                } else {
                    if (is_int($spec_key)) {
                        $child_val = '';
                        if (is_int($second_key)) {
                            $child_val = ' ' . $this_specification[ 'start_time' ][ $second_key ];
                        }
                        $spec_feat_val = $this_specification[ 'start_time' ][ $spec_key ];
                        if ($spec_feat_val != '') {
                            if ($label_position == 0) {
                                echo '<li class="list-group-item"> <span class="badge">' . get_the_title($featured) . '</span> ' . $value_label . $this_specification[ 'start_time' ][ $spec_key ] . $child_val . '</li>';
                            } else {
                                echo '<li class="list-group-item"> <span class="badge">' . get_the_title($featured) . '</span> ' . $this_specification[ 'start_time' ][ $spec_key ] . $child_val . $value_label . '</li>';
                            }
                        }
                    } else {
                        $spec_slug           = imic_the_slug($featured);
                        $spec_val_char       = get_post_meta(get_the_ID(), 'char_' . $spec_slug, true);
                        $spec_val_char_child = get_post_meta(get_the_ID(), 'child_' . $spec_slug, true);
                        if ($spec_val_char != '' && $spec_val_char != 'Select') {
                            if ($label_position == 0) {
                                echo '<li class="list-group-item"> <span class="badge">' . get_the_title($featured) . '</span> ' . $value_label . $spec_val_char . ' ' . $spec_val_char_child . '</li>';
                            } else {
                                echo '<li class="list-group-item"> <span class="badge">' . get_the_title($featured) . '</span> ' . $spec_val_char . ' ' . $spec_val_char_child . $value_label . '</li>';
                            }
                        }
                    }
                }
            } ?>
        </ul>
    </div>
<?php } else {
    $args_terms   = array(
        'orderby' => 'name',
        'order' => 'ASC',
        'fields' => 'all'
    );
    $this_terms   = wp_get_post_terms(get_the_ID(), 'listing-category', $args_terms);
    $get_val_term = '';
    foreach ($this_terms as $term) {
        $list_slugs[] = $term->slug;
        if (array_key_exists($term->term_id, $classified_data)) {
            if ($classified_data[ $term->term_id ][ 'featured' ] != '') {
                $get_val_term = $term->term_id;
                break;
            }
        }
    }
    if (!empty($get_val_term)) {
        $featured_specifications = $classified_data[ $get_val_term ][ 'featured' ];
        $featured_specifications = explode(',', $featured_specifications);
        $normal_specification    = $classified_data[ $get_val_term ][ 'detailed' ];
        $normal_specification    = explode(',', $normal_specification);
        ?>
        <div class="specification-sidebar">
            <h6 class="specification-sidebar__title">Specification</h6>
            <ul class="specification-sidebar__list list-group">
                <?php
                foreach ($featured_specifications as $featured) {
                    $field_type         = get_post_meta($featured, 'imic_plugin_spec_char_type', true);
                    $value_label        = get_post_meta($featured, 'imic_plugin_value_label', true);
                    $label_position     = get_post_meta($featured, 'imic_plugin_lable_position', true);
                    $badge_slug         = imic_the_slug($featured);
                    $this_specification = get_post_meta(get_the_ID(), 'feat_data', true);
                    if ($specification_data_type == '0') {
                        $spec_key   = array_search($featured, $this_specification[ 'sch_title' ]);
                        $second_key = array_search($featured * 111, $this_specification[ 'sch_title' ]);
                    } else {
                        $spec_key = $second_key = '';
                    }
                    $feat_val = get_post_meta($id, 'int_' . $badge_slug, true);
                    if ($field_type == 1 && $feat_val != '') {
                        if ($label_position == 0) {
                            echo '<li class="list-group-item"> <span class="badge">' . get_the_title($featured) . '</span> ' . $value_label . get_post_meta($id, 'int_' . $badge_slug, true) . '</li>';
                        } else {
                            echo '<li class="list-group-item"> <span class="badge">' . get_the_title($featured) . '</span> ' . get_post_meta($id, 'int_' . $badge_slug, true) . $value_label . '</li>';
                        }
                    } else {
                        if (is_int($spec_key)) {
                            $child_val = '';
                            if (is_int($second_key)) {
                                $child_val = ' ' . $this_specification[ 'start_time' ][ $second_key ];
                            }
                            $spec_feat_val = $this_specification[ 'start_time' ][ $spec_key ];
                            if ($spec_feat_val != '') {
                                if ($label_position == 0) {
                                    echo '<li class="list-group-item"> <span class="badge">' . get_the_title($featured) . '</span> ' . $value_label . $this_specification[ 'start_time' ][ $spec_key ] . $child_val . '</li>';
                                } else {
                                    echo '<li class="list-group-item"> <span class="badge">' . get_the_title($featured) . '</span> ' . $this_specification[ 'start_time' ][ $spec_key ] . $child_val . $value_label . '</li>';
                                }
                            }
                        }
                    }
                } ?>
            </ul>
        </div>
    <?php }
}
