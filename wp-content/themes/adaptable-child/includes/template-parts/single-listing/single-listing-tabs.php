<?php

//$tab_data1 = get_post_meta(get_the_ID(), 'imic_tab_area1', true);
//$tab_data2 = get_post_meta(get_the_ID(), 'imic_tab_area2', true);
//$tab_data3 = get_post_meta(get_the_ID(), 'imic_tab_area3', true);
//$tab_data4 = get_post_meta(get_the_ID(), 'imic_tab_area4', true);

// Mappin'
function mapItem($items, $func)
{
    $result = [];
    foreach($items as $item)
    {
        $result[] = $func($item);
    }
    return $result;
}

// Each'
function eachItem($items, $func)
{
    foreach($items as $item)
    {
        $func($item);
    }
}

function checkSpecifications($id)
{
	global $imic_options;
    $normal_specifications = (isset($imic_options[ 'normal_specifications' ])) ? $imic_options[ 'normal_specifications' ] : array();
	//var_dump($imic_options);
	//$normal_specifications = (isset($imic_options[ 'vehicle_specs' ])) ? $imic_options[ 'vehicle_specs' ] : array();
    $this_specification = get_post_meta($id, 'feat_data', true);
	//var_dump($this_specification);
    $specCheck = [];

    foreach ($normal_specifications as $normal) {
        $spec_key   = array_search($normal, $this_specification[ 'sch_title' ]);
        $second_key = array_search($normal* 111, $this_specification[ 'sch_title' ]);
        if (is_int($spec_key)) {
            $child_val = '';
            if (is_int($second_key)) {
                $child_val = ' ' . $this_specification[ 'start_time' ][ $second_key ];
            }
            $value_this = $this_specification[ 'start_time' ][ $spec_key ];

            if ($value_this != 'select' && !empty($value_this)) {
                $specCheck[] = $value_this;
            }
        }
    }
	

    //if (empty($specCheck)) return true;
	
	return false;
}

/**
 * [tabSpecifications controls output of tab specification]
 * @param  [int] $id [post id to pass]
 * @return [HTML]     [HTML to output to the page]
 */
function tabSpecifications($id)
{
    global $imic_options;

    $normal_specifications = (isset($imic_options[ 'normal_specifications' ])) ? $imic_options[ 'normal_specifications' ] : array();
    $listing_details = (isset($imic_options[ 'listing_details' ])) ? $imic_options[ 'listing_details' ] : 0;
    $this_specification = get_post_meta($id, 'feat_data', true);

    $output = '';
    if (!empty($normal_specifications) && ($listing_details == 0)) {

        foreach ($normal_specifications as $normal) {
            $field_type      = get_post_meta($normal, 'imic_plugin_spec_char_type', true);
            $value_labels    = get_post_meta($normal, 'imic_plugin_value_label', true);
            $label_positions = get_post_meta($normal, 'imic_plugin_lable_position', true);
            $badge_slug      = imic_the_slug($normal);

            if ($field_type == 1) {
                if ($label_positions == 0) {
                    $output .= '<tr>';
                        $output .= '<td>' . get_the_title($normal) . '</td>';
                        $output .= '<td>' . $value_labels . get_post_meta($id, 'int_' . $badge_slug, true) . '</td>';
                    $output .= '</tr>';
                } else {
                    $output .= '<tr>';
                        $output .= '<td>' . get_the_title($normal) . '</td>';
                        $output .= '<td>' . get_post_meta($id, 'int_' . $badge_slug, true) . $value_labels . '</td>';
                    $output .= '</tr>';
                }
            } else {
                /**
                * The below was checking to see if '$specification_data_type' was 0
                * The theme doesn't make it clear what this is but for any new listing
                * created by users, no data gets pulled through
                *
                * Feels almost like this is here for when you import their dummy data
                * but doing so breaks the theme.
                *
                * In this they are also referencing the completely wrong variable ($featured);
                * ========================
                * if ($specification_data_type == '0') {
                *     $spec_key   = array_search($normal, $this_specification[ 'sch_title' ]);
                *     $second_key = array_search($featured* 111, $this_specification[ 'sch_title' ]);
                * } else {
                * $spec_key = $second_key = '';
                *}
                */
                $spec_key   = array_search($normal, $this_specification[ 'sch_title' ]);
                $second_key = array_search($normal* 111, $this_specification[ 'sch_title' ]);

                if (is_int($spec_key))
                {
                    $child_val = '';
                    if (is_int($second_key))
                    {
                        $child_val = ' ' . $this_specification[ 'start_time' ][ $second_key ];
                    }

                    $value_this = $this_specification[ 'start_time' ][ $spec_key ];

                    if ($value_this != 'select' && !empty($value_this))
                    {
                        if ($label_positions == 0)
                        {
                            $output .= '<tr>';
                                $output .= '<td>' . get_the_title($normal) . '</td>';
                                $output .= '<td>' . $value_labels . $value_this . $child_val . '</td>';
                            $output .= '</tr>';
                        } else
                        {
                            $output .= '<tr>';
                                $output .= '<td>' . get_the_title($normal) . '</td>';
                                $output .= '<td>' . $value_this . $child_val . $value_labels . '</td>';
                            $output .= '</tr>';
                        }
                    }
                } else
                {
                    $feat_slug_char     = imic_the_slug($normal);
                    $spec_key_val       = get_post_meta($id, 'char_' . $feat_slug_char, true);
                    $spec_key_val_child = get_post_meta($id, 'child_' . $feat_slug_char, true);

                    if ($spec_key_val != 'select')
                    {
                        if ($label_positions == 0)
                        {
                            $output .= '<tr>';
                                $output .= '<td>' . get_the_title($normal) . '</td>';
                                $output .= '<td>' . $value_labels . $spec_key_val . '</td>';
                            $output .= '</tr>';

                            if ($spec_key_val_child != '')
                            {
                                $child_label = get_post_meta($normal, 'imic_plugin_sub_field_label', true);
                                $output .= '<tr>';
                                    $output .= '<td>' . $child_label . '</td>';
                                    $output .= '<td>' . $spec_key_val_child . '</td>';
                                $output .= '</tr>';
                            }
                        } else
                        {
                            $output .= '<tr>';
                               $output .= '<td>' . get_the_title($normal) . '</td>';
                               $output .= '<td>' . $spec_key_val . $value_labels . '</td>';
                            $output .= '</tr>';
                            if ($spec_key_val_child != '')
                            {
                                $child_label = get_post_meta($normal, 'imic_plugin_sub_field_label', true);
                                $output .= '<tr>';
                                    $output .= '<td>' . $child_label . '</td>';
                                    $output .= '<td>' . $spec_key_val_child . '</td>';
                                $output .= '</tr>';
                            }
                        }
                    }
                }
            }
        }
    } else {
        if (!empty($normal_specification)) {
            foreach ($normal_specification as $normal) {
                $field_type         = get_post_meta($normal, 'imic_plugin_spec_char_type', true);
                $value_labels       = get_post_meta($normal, 'imic_plugin_value_label', true);
                $label_positions    = get_post_meta($normal, 'imic_plugin_lable_position', true);
                $badge_slug         = imic_the_slug($normal);
                $this_specification = get_post_meta(get_the_ID(), 'feat_data', true);
                if ($field_type == 1) {
                    if ($label_positions == 0) {
                        $output .= '<tr>';
                              $output .= '<td>' . get_the_title($normal) . '</td>';
                              $output .= '<td>' . $value_labels . get_post_meta($id, 'int_' . $badge_slug, true) . '</td>';
                        $output .= '</tr>';
                    } else {
                        $output .= '<tr>';
                            $output .= '<td>' . get_the_title($normal) . '</td>';
                            $output .= '<td>' . get_post_meta($id, 'int_' . $badge_slug, true) . $value_labels . '</td>';
                        $output .= '</tr>';
                    }
                } else {
                    if ($specification_data_type == '0') {
                        $spec_key = array_search($normal, $this_specification[ 'sch_title' ]);
                    } else {
                        $spec_key = '';
                    }
                    if (is_int($spec_key)) {
                        $value_this = $this_specification[ 'start_time' ][ $spec_key ];
                        if ($value_this != 'select') {
                            if ($label_positions == 0) {
                                $output .= '<tr>';
                                    $output .= '<td>' . get_the_title($normal) . '</td>';
                                    $output .= '<td>' . $value_labels . $value_this . '</td>';
                                $output .= '</tr>';
                            } else {
                                $output .= '<tr>';
                                    $output .= '<td>' . get_the_title($normal) . '</td>';
                                    $output .= '<td>' . $value_this . $value_labels . '</td>';
                                $output .= '</tr>';
                            }
                        }
                    }
                }
            }
        }
    }

	
	$output .= '<tr>';
		$output .= '<td>No.of doors </td>';
		$output .= '<td>' . get_field('no_of_doors',$id) . '</td>';
	$output .= '</tr>';
	
	$output .= '<tr>';
		$output .= '<td>Seats </td>';
		$output .= '<td>' . get_field('seats',$id) . '</td>';
	$output .= '</tr>';

    // if after this our output is empty, simply return nothing
    if (empty($output)) return;

    // otherwise prepend/append table structure
    $output = sprintf('%1$s%2$s', '<table class="table-specifications table table-striped table-hover"><tbody>', $output);
    $output = sprintf('%1$s%2$s', $output, '</tbody></table>');

    // return output
    return $output;
}

/**
 * Outputs Features of listing, similar to tabSpecifications() but these are Features
 * that a user sets themselves.
 * @param  [post id] $id [Post id we pass into this]
 * @return [type]     [description]
 */
function tabFeatures($id)
{
    $output = '';
    $features = get_the_terms($id, 'cars-tag');

    if (empty($features)) {
        return;
    }

    $output .= '<div class="tab-info">';
        $output .= '<ul class="add-features-list">';
            eachItem($features, function($feature) use (&$output){
                $output .= '<li>' . $feature->name . '</li>';
            });
        $output .= '</ul>';
    $output .= '</div>';

    return $output;
}

//function tabLocation($id)
//{
//    // get user data
//    $post_author_id = get_post_field('post_author', $id);
//    $this_user = get_user_meta($post_author_id, 'imic_user_info_id', true);
//
//    // Get users zipcode
//    $zipCode = get_post_meta($this_user,'imic_user_zip_code',true);
//
//    if (empty($zipCode)) return;
//
//    // return a shortcode to output a googlemap using the zipcode
//    return do_shortcode('[gmap address="'.$zipCode.'"]');
//}

/**
 * Overrides old tablocation to use the cars location rather than the users zip location
 * @param integer $postId
 * @return string
 */

function tabLocation($postId)
{
    // Get continent & country fields
    $continent = get_post_meta($postId, 'char_location', true);
    $country = get_post_meta($postId, 'child_location', true);

    // return a shortcode to output a googlemap using the country and continent
    return do_shortcode("[gmap address={$country}, {$continent}]");
}

/**
 * Return The content field (listing description)
 * @param  [int] $id Post id
 * @return [string] Description of listing
 */
function tabDescription($id)
{
    $postObj = get_post($id);

    $content = '';

    if (isset($postObj) && !empty($postObj->post_content))
    {
        return $postObj->post_content;
    }

    return $content;
}

// Tabs HTML
function tabHtml($title, $active_class, $count)
{
    $output = '';

    switch ($title)
    {
        case 'description';
            if (empty(tabDescription(get_the_ID()))) break;

            $output = "<li class=\"{$active_class}\" data-tab-nav>";
                $output .= "<a data-toggle=\"tab\" href=\"#tab-{$count}\">{$title}</a>";
            $output .= "</li>";
            break;
        case 'specifications';
            if (checkSpecifications( get_the_ID() )) break;

            $output = "<li class=\"{$active_class}\" data-tab-nav>";
                $output .= "<a data-toggle=\"tab\" href=\"#tab-{$count}\">{$title}</a>";
            $output .= "</li>";
            break;
        case 'features';
            if ( empty(tabFeatures(get_the_ID()))) break;

            $output = "<li class=\"{$active_class}\" data-tab-nav>";
                $output .= "<a data-toggle=\"tab\" href=\"#tab-{$count}\">{$title}</a>";
            $output .= "</li>";
            break;
        case 'location';
            if ( empty(tabLocation(get_the_ID()))) break;

            $output = "<li class=\"{$active_class}\" data-tab-nav data-tab-location>";
                $output .= "<a data-toggle=\"tab\" href=\"#tab-{$count}\">{$title}</a>";
            $output .= "</li>";
            break;
    }

    return $output;
}

/**
 * tabContentHtml - Controls flow for what tab field to output
 * @param  [string] $field  [name of tab field]
 * @param  [string] $active [whether its active or not]
 * @param  [string] $count  [the current iteration]
 * @return [HTML]         [Call to function to retrieve HTML, then output that to frontend]
 */
function tabContentHtml($field, $active, $count)
{
    $output = '';
    $tabDescription = '';

    switch ($field)
    {
        case 'description';
            if (empty(tabDescription(get_the_ID()))) break;
            $tabDescription .= tabDescription(get_the_ID());
            break;
        case 'specifications';
            if (checkSpecifications( get_the_ID() )) break;

            $tabDescription .= tabSpecifications(get_the_ID());
            break;
        case 'features';
            if (empty(tabFeatures(get_the_ID()))) break;

            $tabDescription .= tabFeatures(get_the_ID());
            break;
        case 'location';
            if ( empty(tabLocation(get_the_ID()))) break;

            $tabDescription .= tabLocation(get_the_ID());
            break;
    }

    if (empty($tabDescription)) return;

    $output = "<div id=\"tab-{$count}\" class=\"tab-pane fade {$active}\" data-tab-content>";
        $output .= "<div class=\"tab-info\">";
            $output .= $tabDescription;
        $output .= '</div>';
    $output .= '</div>';

    return $output;
}
