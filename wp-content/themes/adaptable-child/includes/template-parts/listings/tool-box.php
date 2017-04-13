<?php namespace LukeRoberts;

// Instantiate our Currency Class
$currencies = new Currency();

// Get the current in use currency.
$currentCurrency = $currencies->getCurrentCurrency();
?>

<ul class="utility-icons tools-bar">
    <li>
        <a href="#"><i class="fa fa-star-o"></i></a>
        <div class="tool-box">
            <div class="tool-box-head">
                <?php if (is_user_logged_in()): ?>
                    <a href="<?php echo esc_url(add_query_arg('saved', 1, $listing_page_url));?>" class="basic-link pull-right">
                        <?php _e('View all', 'adaptable-child');?>
                    </a>
                <?php endif; ?>
                <h5><?php _e('Saved cars', 'adaptable-child');?></h5>
            </div>

            <div class="tool-box-in">
                <ul class="saved-cars-box listing tool-car-listing">
                    <?php if ((!isset($_SESSION['saved_vehicle_id1'])) && (!isset($_SESSION['saved_vehicle_id2'])) && (!isset($_SESSION['saved_vehicle_id3']))):
                        if (is_user_logged_in()):
                            $user_id = get_current_user_id();
                            $user_info_id = get_user_meta($user_id, 'imic_user_info_id', true);
                            $saved_cars = get_post_meta($user_info_id, 'imic_user_saved_cars', true);

                            if (!empty($saved_cars)):
                                $total = 0;
                                $highlighted_specs = (isset($imic_options['highlighted_specs'])) ? $imic_options['highlighted_specs'] : '';
                                $unique_specs = $imic_options['unique_specs'];

                                foreach ($saved_cars as $car):
                                    $new_highlighted_specs = imic_filter_lang_specs_admin($highlighted_specs, $car[0]);
                                    $highlighted_specs = $new_highlighted_specs;
                                    $specifications = get_post_meta($car[0], 'feat_data', true);

                                    // Get the vehicle price as JUST a numerical value
                                    $vehicle_numeric_price = preg_replace("/[^0-9]/", "", imic_vehicle_price($car[0], $unique_specs, $specifications));

                                    // Convert price dependent on what the user has selected or default which is GBP
                                    $vehicle_converted_price = convert_currency($vehicle_numeric_price, $from = 'GBP', $in = $currentCurrency);

                                    // Format the currency price
                                    $vehicle_formatted_price = format_currency($vehicle_converted_price, $currentCurrency, true) ;

                                    // The complete price which checks if the format price is empty
                                    $vehicle_complete_price = !empty($vehicle_formatted_price) ? $vehicle_formatted_price : 'TBC';

                                    $highlight_value = imic_vehicle_title($car[0], $highlighted_specs, $specifications);

                                    echo '<li>'; ?>
                                        <div class="checkb"><input id="saved-<?php echo esc_attr($car[0]); ?>" value="0" type="checkbox" class="compare-check"></div>
                                        <div class="imageb"><a href="<?php echo esc_url(get_permalink($car[0])); ?>"><?php echo get_the_post_thumbnail($car[0]); ?></a></div>
                                        <div class="textb">
                                            <a href="<?php echo esc_url(get_permalink($car[0])); ?>"><?php echo $highlight_value; ?></a>
                                            <span class="price" data-price-conversion data-vehicle-price="<?php echo $vehicle_numeric_price; ?>"><?php echo esc_attr($vehicle_complete_price);?></span>
                                        </div>
                                        <div rel="specific-saved-ad" class="delete delete-box-saved">
                                            <div class="specific-id" style="display:none;">
                                                <span class="saved-id"><?php echo esc_attr($car[0]); ?></span>
                                            </div>
                                            <a href="#"><i class="icon-delete"></i></a>
                                        </div>
                                    </li>
                                    <?php
                                    if ($total++ == 2) break;
                                endforeach;
                            else:
                                echo '<li class="blank">'.__('No saved searches', 'framework').'</li>';
                            endif;
                        endif;
                    endif;

                    if (!empty($_SESSION['saved_vehicle_id1'])):
                        $highlighted_specs = $imic_options['highlighted_specs'];
                        $new_highlighted_specs = imic_filter_lang_specs_admin($highlighted_specs, $_SESSION['saved_vehicle_id1']);
                        $highlighted_specs = $new_highlighted_specs;
                        $unique_specs = $imic_options['unique_specs'];
                        $specifications = get_post_meta($_SESSION['saved_vehicle_id1'], 'feat_data', true);

                        // Get the vehicle price as JUST a numerical value
                        $vehicle_numeric_price = preg_replace("/[^0-9]/", "", imic_vehicle_price($_SESSION['saved_vehicle_id1'], $unique_specs, $specifications));

                        // Convert price dependent on what the user has selected or default which is GBP
                        $vehicle_converted_price = convert_currency($vehicle_numeric_price, $from = 'GBP', $in = $currentCurrency);

                        // Format the currency price
                        $vehicle_formatted_price = format_currency($vehicle_converted_price, $currentCurrency, true) ;

                        // The complete price which checks if the format price is empty
                        $vehicle_complete_price = !empty($vehicle_formatted_price) ? $vehicle_formatted_price : 'TBC';

                        $highlight_value = imic_vehicle_title($_SESSION['saved_vehicle_id1'], $highlighted_specs, $specifications); ?>
                        <li>
                            <div class="checkb">
                                <input value="0" id="saved-<?php echo esc_attr($_SESSION['saved_vehicle_id1']);?>" class="compare-check" type="checkbox">
                            </div>
                            <div class="imageb">
                                <a href="<?php echo esc_url(get_permalink($_SESSION['saved_vehicle_id1']));?>"><?php echo get_the_post_thumbnail($_SESSION['saved_vehicle_id1']);?></a>
                            </div>
                            <div class="textb">
                                <a href="<?php echo esc_url(get_permalink($_SESSION['saved_vehicle_id1']));?>"><?php echo esc_attr($highlight_value); ?></a>
                                <span class="price" data-price-conversion data-vehicle-price="<?php echo $vehicle_numeric_price; ?>"><?php echo esc_attr($vehicle_complete_price);?></span>
                            </div>
                            <div id="one" class="delete session-save-car"><a href="#"><i class="icon-delete"></i></a></div>
                        </li>
                    <?php endif;

                    if (!empty($_SESSION['saved_vehicle_id2'])):
                        $highlighted_specs = $imic_options['highlighted_specs'];
                        $new_highlighted_specs = imic_filter_lang_specs_admin($highlighted_specs, $_SESSION['saved_vehicle_id2']);
                        $highlighted_specs = $new_highlighted_specs;
                        $unique_specs = $imic_options['unique_specs'];
                        $specifications = get_post_meta($_SESSION['saved_vehicle_id2'], 'feat_data', true);

                        // Get the vehicle price as JUST a numerical value
                        $vehicle_numeric_price = preg_replace("/[^0-9]/", "", imic_vehicle_price($_SESSION['saved_vehicle_id2'], $unique_specs, $specifications));

                        // Convert price dependent on what the user has selected or default which is GBP
                        $vehicle_converted_price = convert_currency($vehicle_numeric_price, $from = 'GBP', $in = $currentCurrency);

                        // Format the currency price
                        $vehicle_formatted_price = format_currency($vehicle_converted_price, $currentCurrency, true) ;

                        // The complete price which checks if the format price is empty
                        $vehicle_complete_price = !empty($vehicle_formatted_price) ? $vehicle_formatted_price : 'TBC';

                        $highlight_value = imic_vehicle_title($_SESSION['saved_vehicle_id2'], $highlighted_specs, $specifications); ?>
                        <li>
                            <div class="checkb">
                                <input value="0" id="saved-<?php echo esc_attr($_SESSION['saved_vehicle_id2']);?>" class="compare-check" type="checkbox">
                            </div>
                            <div class="imageb">
                                <a href="<?php echo esc_url(get_permalink($_SESSION['saved_vehicle_id2'])); ?>">
                                    <?php echo get_the_post_thumbnail($_SESSION['saved_vehicle_id2']); ?>
                                </a>
                            </div>
                            <div class="textb">
                                <a href="<?php echo esc_url(get_permalink($_SESSION['saved_vehicle_id2']));?>"><?php echo esc_attr($highlight_value);?></a>
                                <span class="price" data-price-conversion data-vehicle-price="<?php echo $vehicle_numeric_price; ?>"><?php echo esc_attr($vehicle_complete_price);?></span>
                            </div>
                            <div id="two" class="delete session-save-car"><a href="#"><i class="icon-delete"></i></a></div>
                        </li>
                    <?php endif;

                    if (!empty($_SESSION['saved_vehicle_id3'])):
                        $highlighted_specs = $imic_options['highlighted_specs'];
                        $new_highlighted_specs = imic_filter_lang_specs_admin($highlighted_specs, $_SESSION['saved_vehicle_id3']);
                        $highlighted_specs = $new_highlighted_specs;
                        $unique_specs = $imic_options['unique_specs'];
                        $specifications = get_post_meta($_SESSION['saved_vehicle_id3'], 'feat_data', true);

                        // Get the vehicle price as JUST a numerical value
                        $vehicle_numeric_price = preg_replace("/[^0-9]/", "", imic_vehicle_price($_SESSION['saved_vehicle_id3'], $unique_specs, $specifications));

                        // Convert price dependent on what the user has selected or default which is GBP
                        $vehicle_converted_price = convert_currency($vehicle_numeric_price, $from = 'GBP', $in = $currentCurrency);

                        // Format the currency price
                        $vehicle_formatted_price = format_currency($vehicle_converted_price, $currentCurrency, true) ;

                        // The complete price which checks if the format price is empty
                        $vehicle_complete_price = !empty($vehicle_formatted_price) ? $vehicle_formatted_price : 'TBC';

                        $highlight_value = imic_vehicle_title($_SESSION['saved_vehicle_id3'], $highlighted_specs, $specifications); ?>
                        <li>
                            <div class="checkb">
                                <input value="0" id="saved-<?php echo esc_attr($_SESSION['saved_vehicle_id3']);?>" class="compare-check" type="checkbox">
                            </div>
                            <div class="imageb">
                                <a href="<?php echo esc_url(get_permalink($_SESSION['saved_vehicle_id3']));?>"><?php echo get_the_post_thumbnail($_SESSION['saved_vehicle_id3']);?></a>
                            </div>
                            <div class="textb">
                                <a href="<?php echo esc_url(get_permalink($_SESSION['saved_vehicle_id3']));?>"><?php echo esc_attr($highlight_value);?></a>
                                <span class="price" data-price-conversion data-vehicle-price="<?php echo $vehicle_numeric_price; ?>"><?php echo esc_attr($vehicle_complete_price);?></span>
                            </div>
                            <div id="three" class="delete session-save-car"><a href="#"><i class="icon-delete"></i></a></div>
                        </li>
                    <?php endif;

                    if (!empty($_SESSION['saved_vehicle_id1']) && !empty($_SESSION['saved_vehicle_id2']) && !empty($_SESSION['saved_vehicle_id3'])) {
                        echo '<li>'.__('Please login/register to add more', 'framework').'</li>';
                    }
                    if (empty($_SESSION['saved_vehicle_id1']) && empty($_SESSION['saved_vehicle_id2']) && empty($_SESSION['saved_vehicle_id3']) && empty($saved_cars) && (!is_user_logged_in())) {
                        echo '<li class="blank">'.__('No Saved Cars yet', 'framework').'</li>';
                    } ?>
                </ul>
            </div>

            <div class="tool-box-foot">
                <?php if ((!empty($_SESSION['saved_vehicle_id1']) || !empty($_SESSION['saved_vehicle_id2']) || !empty($_SESSION['saved_vehicle_id3'])) && (is_user_logged_in())): ?>
                    <a href="#" rel="popup-save" class="btn btn-xs btn-primary pull-right save-car"><div class="vehicle-details-access" style="display:none;"><span class="vehicle-id">unsaved</span></div>Save</a>
                <?php endif; ?>

                <p class="compare-in-description">Select listings above to compare</p>
                <a href="<?php echo esc_url(imic_get_template_url('template-compare.php'));?>" class="button button--full compare-in-box" disabled><?php _e('Compare', 'adaptable-child');?></a>
            </div>
        </div>
    </li>
    <li><a href="#"><i class="fa fa-folder-o"></i></a>
        <div class="tool-box">
            <div class="tool-box-head">
                <?php
                $user_id = get_current_user_id();
                $user_info_id = get_user_meta($user_id, 'imic_user_info_id', true);
                $search_cars = get_post_meta($user_info_id, 'imic_user_saved_search', true);

                if (is_user_logged_in() && !empty($search_cars)): ?>
                   <a href="<?php echo esc_url(add_query_arg('search', 1, $listing_page_url));?>" class="basic-link pull-right"><?php _e('View all', 'adaptable-child');?></a>
               <?php endif; ?>

                <h5><?php _e('Saved searches', 'adaptable-child');?></h5>
            </div>

            <div class="tool-box-in">
                <ul id="search-saved" class="listing tool-search-listing">
                    <?php if ((!isset($_SESSION['search_page1'])) && (!isset($_SESSION['search_page2'])) && (!isset($_SESSION['search_page3']))) {
                        if (is_user_logged_in()) {
                            if (!empty($search_cars)) {
                                $total = 0;
                                foreach ($search_cars as $search) {
                                    $res = preg_replace('/[^a-zA-Z]/', '', $search[0]);
                                    echo '<li>';
                                       echo '<div class="link"><a href="'.esc_url($search[2]).'">'.esc_attr($search[0]).'</a></div>';
                                        echo '<div id="specific-search-ad" class="delete delete-box-search"><div class="specific-id" style="display:none;"><span class="search-id">'.esc_attr($res).'</span></div><a href="#"><i class="icon-delete"></i></a></div>';
                                    echo '</li>';

                                    if ($total++ == 3) break;
                                }
                            } else {
                                echo '<li id="blank-search">';
                                    echo '<div class="link">'.__('No Saved Searches Yet', 'framework').'</div>';
                                echo '</li>';
                            }
                        }
                    }

                    if (!empty($_SESSION['search_page1'])) {
                        $values = $_SESSION['search_page1']; ?>
                        <li>
                            <div class="link"><a href="<?php echo esc_url($values[1]); ?>"><?php echo esc_attr($values[0]); ?></a></div>
                            <div id="four" class="delete session-save-car">
                                <a href="#"><i class="icon-delete"></i></a>
                            </div>
                        </li><?php
                    }

                    if (!empty($_SESSION['search_page2'])) {
                        $values = $_SESSION['search_page2']; ?>
                        <li>
                            <div class="link">
                                <a href="<?php echo esc_url($values[1]);?>"><?php echo esc_attr($values[0]);?></a>
                            </div>
                            <div id="four" class="delete session-save-car"><a href="#"><i class="icon-delete"></i></a></div>
                        </li><?php
                    }

                    if (!empty($_SESSION['search_page3'])) {
                        $values = $_SESSION['search_page3']; ?>
                        <li>
                            <div class="link">
                                <a href="<?php echo esc_url($values[1]);?>"><?php echo esc_attr($values[0]);?></a>
                            </div>
                            <div id="four" class="delete session-save-car"><a href="#"><i class="icon-delete"></i></a></div>
                        </li><?php
                    } else {
                        '<li>'.__('No saved searches yet', 'framework').'</li>';
                    }

                    if (!empty($_SESSION['search_page1']) && !empty($_SESSION['search_page2']) && !empty($_SESSION['search_page3'])) {
                        echo '<li>'.__('Please login/register to add more', 'framework').'</li>';
                    }

                    if (empty($_SESSION['search_page1']) && empty($_SESSION['search_page2']) && empty($_SESSION['search_page3']) && empty($search_cars) && (!is_user_logged_in())) {
                        echo '<li id="blank-search">
                            <div class="link">'.__('No Saved Searches Yet', 'framework').'</div>
                        </li>';
                    } ?>
                </ul>
            </div>

            <div class="tool-box-foot">
                <?php  if ((!empty($_SESSION['search_page1'])) || (!empty($_SESSION['search_page2'])) || (!empty($_SESSION['search_page3'])) && (is_user_logged_in())) {
                    echo '<a href="#" id="popup-search" class="btn btn-xs btn-primary pull-right save-search"><div class="vehicle-details-access" style="display:none;"><span class="vehicle-id">unsaved</span></div>Save</a>';
                } ?>
            </div>
        </div>
    </li>
    <li>
        <a href="#"><i class="fa fa-clock-o"></i></a>
        <div class="tool-box">
            <div class="tool-box-head">
                <h5><?php _e('Recently viewed cars', 'adaptable-child');?></h5>
            </div>

            <div class="tool-box-in">
                <ul id="viewed-cars-listbox" class="listing tool-car-listing">
                    <li id="blank-viewed">
                        <div class="textb">
                            <?php echo _e('You do not have any viewed listings yet', 'adaptable-child'); ?>
                        </div>
                    </li>

                    <?php if (!empty($_SESSION['viewed_vehicle_id1'])):
                        $highlighted_specs = $imic_options['highlighted_specs'];
                        $new_highlighted_specs = imic_filter_lang_specs_admin($highlighted_specs, $_SESSION['viewed_vehicle_id1']);
                        $highlighted_specs = $new_highlighted_specs;
                        $unique_specs = $imic_options['unique_specs'];
                        $specifications = get_post_meta($_SESSION['viewed_vehicle_id1'], 'feat_data', true);

                        // Get the vehicle price as JUST a numerical value
                        $vehicle_numeric_price = preg_replace("/[^0-9]/", "", imic_vehicle_price($_SESSION['viewed_vehicle_id1'], $unique_specs, $specifications));

                        // Convert price dependent on what the user has selected or default which is GBP
                        $vehicle_converted_price = convert_currency($vehicle_numeric_price, $from = 'GBP', $in = $currentCurrency);

                        // Format the currency price
                        $vehicle_formatted_price = format_currency($vehicle_converted_price, $currentCurrency, true) ;

                        // The complete price which checks if the format price is empty
                        $vehicle_complete_price = !empty($vehicle_formatted_price) ? $vehicle_formatted_price : 'TBC';

                        $highlight_value = imic_vehicle_title($_SESSION['viewed_vehicle_id1'], $highlighted_specs, $specifications); ?>

                        <li>
                            <div class="checkb">
                                <input value="0" id="view-<?php echo esc_attr($_SESSION['viewed_vehicle_id1']);?>" class="compare-viewed" type="checkbox">
                            </div>
                            <div class="imageb">
                                <a href="<?php echo esc_url(get_permalink($_SESSION['viewed_vehicle_id1']));?>"><?php echo get_the_post_thumbnail($_SESSION['viewed_vehicle_id1']);?></a>
                            </div>
                            <div class="textb">
                                <a href="<?php echo esc_url(get_permalink($_SESSION['viewed_vehicle_id1']));?>"><?php echo esc_attr($highlight_value); ?></a>
                                <span class="price" data-price-conversion data-vehicle-price="<?php echo $vehicle_numeric_price; ?>"><?php echo esc_attr($vehicle_complete_price);?></span>
                            </div>
                            <div id="seven" class="delete session-save-car"><a href="#"><i class="icon-delete"></i></a></div>
                        </li>
                    <?php endif;

                    if (!empty($_SESSION['viewed_vehicle_id2'])) {
                        $highlighted_specs = $imic_options['highlighted_specs'];
                        $new_highlighted_specs = imic_filter_lang_specs_admin($highlighted_specs, $_SESSION['viewed_vehicle_id2']);
                        $highlighted_specs = $new_highlighted_specs;
                        $unique_specs = $imic_options['unique_specs'];
                        $specifications = get_post_meta($_SESSION['viewed_vehicle_id2'], 'feat_data', true);

                        // Get the vehicle price as JUST a numerical value
                        $vehicle_numeric_price = preg_replace("/[^0-9]/", "", imic_vehicle_price($_SESSION['viewed_vehicle_id2'], $unique_specs, $specifications));

                        // Convert price dependent on what the user has selected or default which is GBP
                        $vehicle_converted_price = convert_currency($vehicle_numeric_price, $from = 'GBP', $in = $currentCurrency);

                        // Format the currency price
                        $vehicle_formatted_price = format_currency($vehicle_converted_price, $currentCurrency, true) ;

                        // The complete price which checks if the format price is empty
                        $vehicle_complete_price = !empty($vehicle_formatted_price) ? $vehicle_formatted_price : 'TBC';

                        $highlight_value = imic_vehicle_title($_SESSION['viewed_vehicle_id2'], $highlighted_specs, $specifications);?>

                        <li>
                            <div class="checkb">
                                <input value="0" id="view-<?php echo esc_attr($_SESSION['viewed_vehicle_id2']);?>" class="compare-viewed" type="checkbox">
                            </div>
                            <div class="imageb">
                                <a href="<?php echo esc_url(get_permalink($_SESSION['viewed_vehicle_id2']));?>"><?php echo get_the_post_thumbnail($_SESSION['viewed_vehicle_id2']);?></a>
                            </div>
                            <div class="textb">
                                <a href="<?php echo esc_url(get_permalink($_SESSION['viewed_vehicle_id2']));?>"><?php echo esc_attr($highlight_value);?></a>
                                <span class="price" data-price-conversion data-vehicle-price="<?php echo $vehicle_numeric_price; ?>"><?php echo esc_attr($vehicle_complete_price);?></span>
                            </div>

                            <div id="eight" class="delete session-save-car"><a href="#"><i class="icon-delete"></i></a></div>
                        </li><?php
                    }

                    if (!empty($_SESSION['viewed_vehicle_id3'])):
                        $highlighted_specs = $imic_options['highlighted_specs'];
                        $new_highlighted_specs = imic_filter_lang_specs_admin($highlighted_specs, $_SESSION['viewed_vehicle_id3']);
                        $highlighted_specs = $new_highlighted_specs;
                        $unique_specs = $imic_options['unique_specs'];
                        $specifications = get_post_meta($_SESSION['viewed_vehicle_id3'], 'feat_data', true);

                        // Get the vehicle price as JUST a numerical value
                        $vehicle_numeric_price = preg_replace("/[^0-9]/", "", imic_vehicle_price($_SESSION['viewed_vehicle_id3'], $unique_specs, $specifications));

                        // Convert price dependent on what the user has selected or default which is GBP
                        $vehicle_converted_price = convert_currency($vehicle_numeric_price, $from = 'GBP', $in = $currentCurrency);

                        // Format the currency price
                        $vehicle_formatted_price = format_currency($vehicle_converted_price, $currentCurrency, true) ;

                        // The complete price which checks if the format price is empty
                        $vehicle_complete_price = !empty($vehicle_formatted_price) ? $vehicle_formatted_price : 'TBC';

                        $highlight_value = imic_vehicle_title($_SESSION['viewed_vehicle_id3'], $highlighted_specs, $specifications); ?>

                        <li>
                            <div class="checkb">
                                <input value="0" id="view-<?php echo esc_attr($_SESSION['viewed_vehicle_id3']);?>" class="compare-viewed" type="checkbox">
                            </div>
                            <div class="imageb">
                                <a href="<?php echo esc_url(get_permalink($_SESSION['viewed_vehicle_id3']));?>"><?php echo get_the_post_thumbnail($_SESSION['viewed_vehicle_id3']);?></a>
                            </div>
                            <div class="textb">
                                <a href="<?php echo esc_url(get_permalink($_SESSION['viewed_vehicle_id3']));?>"><?php echo esc_attr($highlight_value);?></a>
                                <span class="price" data-price-conversion data-vehicle-price="<?php echo $vehicle_numeric_price; ?>"><?php echo esc_attr($vehicle_complete_price);?></span>
                            </div>
                            <div id="nine" class="delete session-save-car"><a href="#"><i class="icon-delete"></i></a></div>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
            <div class="tool-box-foot">
                <p class="compare-in-description">Select listings above to compare</p>
                <a href="<?php echo imic_get_template_url('template-compare.php');?>" class="button button--full compare-viewed-box" disabled><?php _e('Compare', 'adaptable-child');?></a>
            </div>
        </div>
    </li>
</ul>
