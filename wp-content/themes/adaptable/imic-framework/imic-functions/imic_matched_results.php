<?php

if (!function_exists('imic_matched_results')) {
    function imic_matched_results()
    {
        $vals = (isset($_POST[ 'values' ])) ? $_POST[ 'values' ] : '';
        $ids = (isset($_POST[ 'ids' ])) ? $_POST[ 'ids' ] : '';
        $posts_page = -1;
        //echo "sai";
        array_pop($vals);
        global $imic_options;
        $arrays = array();
        if ((is_array($ids)) && (is_array($vals))) {
            $data = array_combine($ids, $vals);
            //print_r($data);
            if (!empty($data)) {
                $count = 1;
                foreach ($data as $key => $value) {
                    if (strpos($key, 'int') !== false) {
                        $arrays[ $count ] = array(
                             'key' => $key,
                            'value' => $value,
                            'compare' => '<=',
                            'type' => 'numeric',
                        );
                    } else {
                        $arrays[ $count ] = array(
                             'key' => 'feat_data',
                            'value' => $value,
                            'compare' => 'LIKE',
                        );
                    }
                    ++$count;
                }

                //}
                $arrays[ $count + 1 ] = array(
                     'key' => 'imic_plugin_ad_payment_status',
                    'value' => '1',
                    'compare' => '=',
                );
            }
            $badges_type = (isset($imic_options[ 'badges_type' ])) ? $imic_options[ 'badges_type' ] : '0';
            $specification_type = (isset($imic_options[ 'short_specifications' ])) ? $imic_options[ 'short_specifications' ] : '0';
            if ($badges_type == '0') {
                $badge_ids = $imic_options[ 'badge_specs' ];
            } else {
                $badge_ids = array();
            }
            if ($specification_type == 0) {
                $detailed_specs = $imic_options[ 'specification_list' ];
            } else {
                $detailed_specs = array();
            }
            $highlighted_specs = $imic_options[ 'highlighted_specs' ];
            $args_cars = array(
                 'post_type' => 'cars',
                'meta_query' => $arrays,
                'posts_per_page' => -1,
                'post_status' => 'publish',
            );
            $cars_listing = new WP_Query($args_cars);
            if ($cars_listing->have_posts()):
                while ($cars_listing->have_posts()):
                    $cars_listing->the_post();
            if (is_plugin_active('imi-classifieds/imi-classified.php')) {
                $badge_ids = imic_classified_badge_specs(get_the_ID(), $badge_ids);
                $detailed_specs = imic_classified_short_specs(get_the_ID(), $detailed_specs);
            }
            $specifications = get_post_meta(get_the_ID(), 'feat_data', true);
            $details_value = imic_vehicle_all_specs(get_the_ID(), $detailed_specs, $specifications);
            $new_highlighted_specs = imic_filter_lang_specs_admin($highlighted_specs, get_the_ID());
            $highlighted_specs = $new_highlighted_specs;
            $highlight_value = imic_vehicle_title(get_the_ID(), $highlighted_specs, $specifications);
            $highlight_value = ($highlight_value == '') ? get_the_title(get_the_ID()) : $highlight_value;
            ?>
              	<!-- Result Item -->
              	<div class="search-find-results">
             	<h5><?php
                    echo esc_attr($highlight_value);
            ?></h5>
           		<ul class="inline">
         		<?php
                    foreach ($details_value as $detail) {
                        echo '<li>'.$detail.'</li>';
                    }
            ?>
             	</ul>
         		<button id="matched-<?php
                    echo get_the_ID() + 2648;
            ?>" class="btn btn-info btn-sm save-searched-value">Select &amp; continue</button>
             	</div><?php
                endwhile; else:
?>
		<div class="search-find-results">
    	<h5><?php
                _e('No Match Found', 'framework');
            ?></h5>
      	</ul>
    	<a data-toggle="tab" href="#addcustom"><?php
                _e('Continue with Custom Details', 'framework');
            ?></a>
     	</div>
	<?php
            endif;
            wp_reset_postdata();
        } else {
            ?>
            <div class="search-find-results">
    	       <h5><?php _e('No Match Found', 'framework'); ?></h5>
               <a data-toggle="tab" href="#addcustom"><?php _e('Continue with Custom Details', 'framework'); ?></a>
           </div>
   		</ul>
<?php
        }
        die();
    }
    add_action('wp_ajax_nopriv_imic_matched_results', 'imic_matched_results');
    add_action('wp_ajax_imic_matched_results', 'imic_matched_results');
}
