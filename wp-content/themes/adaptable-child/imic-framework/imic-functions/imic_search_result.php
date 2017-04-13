<?php
function imic_search_result( )
{
    global $imic_options;

    $data     = ( isset( $_POST[ 'values' ] ) ) ? $_POST[ 'values' ] : '';
    $paginate = ( isset( $_POST[ 'paginate' ] ) ) ? $_POST[ 'paginate' ] : '';
    $category = ( isset( $_POST[ 'category' ] ) ) ? $_POST[ 'category' ] : '';
    $tags     = ( isset( $_POST[ 'tags' ] ) ) ? $_POST[ 'tags' ] : array( );
    $catToSet = $data['list-cat'];
    $arrays            = $term_array = $list_terms_ids = $list_terms_slug = array( );
    $order             = $term_slug = $have_int = '';
    $posts_page        = get_option( 'posts_per_page' );
    $paged             = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : '';
    $value             = $pagin = $offset = $off = '';
    $count             = 1;
    $filters_type      = ( isset( $imic_options[ 'filters_type' ] ) ) ? $imic_options[ 'filters_type' ] : '';
    $data_page         = ( $filters_type == 1 ) ? 'yes' : '';
    $default_image_src = ( isset( $imic_options[ 'default_car_image' ] ) ) ? $imic_options[ 'default_car_image' ][ 'url' ] : '';


    if ( !empty( $data ) )
    {
        foreach ( $data as $key => $value )
        {
            if ( $key != 'page_id' && $key != "lang" )
            {
                $count = count( $arrays );
                if ( ( $value == "ASC" ) || ( $value == "DESC" ) )
                {
                    $order = $value;
                }
                elseif ( $key == "pg" )
                {
                    $posts_page = $value;
                    $off        = $value;
                }
                elseif ( $key == "paged" )
                {
                    $paged      = $value;
                    $posts_page = get_option( 'posts_per_page' );
                }
                elseif ( $key == "list-cat" )
                {
                    $term_slug   = $value;
                    $category_id = get_term_by( 'slug', $value, 'listing-category' );
                    $term_id     = $category_id->term_id;
                    $parents     = get_ancestors( $term_id, 'listing-category' );
                    $list_terms  = array( );

                    foreach ( $parents as $parent )
                    {
                        $list_term          = get_term_by( 'id', $parent, 'listing-category' );
                        $list_terms_slug[ ] = $list_term->slug;
                        $list_terms_ids[ ]  = $list_term->term_id;
                    }
                    $list_terms[ ]   = $value;
                    $term_array[ 0 ] = array(
                         'taxonomy' => 'listing-category',
                        'field' => 'slug',
                        'terms' => $list_terms,
                        'operator' => 'IN'
                    );
                }
                else
                {
                    if ( strpos( $key, 'int_' ) !== false || strpos( $key, 'range_' ) !== false )
                    {
                        if ( strpos( $key, 'range_' ) !== false )
                        {
                            $new_val            = explode( "-", $value );
                            $value              = $new_val[ 1 ];
                            $pm_value           = $new_val[ 0 ];
                            $key                = explode( "_", $key );
                            $key                = "int_" . $key[ 1 ];
                            $arrays[ $count++ ] = array(
                                 'key' => $key,
                                'value' => $pm_value,
                                'compare' => '>=',
                                'type' => 'numeric'
                            );
                        }

                        $arrays[ $count ] = array(
                             'key' => $key,
                            'value' => $value,
                            'compare' => '<=',
                            'type' => 'numeric'
                        );
                        $have_int         = 1;

                    }
                    elseif ( strpos( $key, 'char_' ) !== false || strpos( $key, 'child_' ) !== false )
                    {
                        $value            = str_replace( '%20', ' ', $value );
                        $arrays[ $count ] = array(
                             'key' => $key,
                            'value' => $value,
                            'compare' => '='
                        );
                    }
                    else
                    {
                        $arrays[ $count ] = array(
                             'key' => 'feat_data',
                            'value' => serialize( strval( $value ) ),
                            'compare' => 'LIKE'
                        );
                    }
                }
                $count++;
            }
        }
    }

    $arrays[ $count++ ] = array(
         'key' => 'imic_plugin_ad_payment_status',
        'value' => '1',
        'compare' => '='
    );
    $arrays[ $count++ ] = array(
         'key' => 'imic_plugin_listing_end_dt',
        'value' => date( 'Y-m-d' ),
        'compare' => '>='
    );

    if ( $paged == 1 )
    {
        $offset = $off;
    }
    elseif ( $paged > 1 )
    {
        $offs   = $paged - 1;
        $offset = $off + ( $posts_page * $offs );
    }

    if ( !empty( $tags ) )
    {
        $term_array[ 1 ] = array(
             'taxonomy' => 'cars-tag',
            'field' => 'slug',
            'terms' => $tags,
            'operator' => 'IN'
        );
    }

    if ( $data_page == "yes" )
    {
        if ( $category == 1 )
        {
            $class_list           = 12;
            $search_filter_custom = get_option('imic_classifieds');

            if (!empty( $search_filter_custom ) )
            {
                foreach ( $search_filter_custom as $key => $value )
                {
                    if ( $key == $term_id )
                    {
                        $filters = $value[ 'filter' ];
                        if ( $filters != '' )
                        {
                            $search_filters = explode( ',', $filters );
                        }
                        break;
                    }
                    else
                    {
                        foreach ( $list_terms_ids as $id )
                        {
                            if ( $key == $id )
                            {
                                $filters = $value[ 'filter' ];
                                if ( $filters != '' )
                                {
                                    $search_filters = explode( ',', $filters );
                                }
                                break;
                            }
                        }
                    }
                }
            } else {
                $search_filters = (isset($imic_options['search_filter_listing'])) ? $imic_options['search_filter_listing'] : array();
            }

            if ( !empty( $search_filters ) ) { ?>
                <div class="col-md-3 search-filters">

                    <h6 class="filters-title"><?php _e('Refine Search', 'framework');?></h6>

                    <?php
                    $filters_type = (isset($imic_options['filters_type'])) ? $imic_options['filters_type'] : '';

                    if (is_plugin_active('imi-classifieds/imi-classified.php')) {
                        $selected_cat = get_query_var('list-cat');
                        $data_page = ($filters_type == 1) ? 'yes' : '';
                        $list_termss = array();

                        if ($selected_cat) {
                            $category_ids = get_term_by('slug', $selected_cat, 'listing-category');
                            $term_ids = $category_ids->term_id;
                            $parent = get_ancestors($term_ids, 'listing-category');
                            foreach ($parent as $parents) {
                                $list_term = get_term_by('id', $parents, 'listing-category');
                                $list_termss[] = $list_term->slug;
                            }
                            $list_termss[] = $selected_cat;
                        }

                        $listing_cats = get_terms('listing-category', array('parent' => 0, 'number' => 10, 'hide_empty' => false));

                        if (!empty($listing_cats)) {
                            echo '<div class="row parent-category-row">';
                                echo '<div class="act-cat" id="list-1">';
                                    echo '<select data-page="'.$data_page.'" data-empty="true" name="list-cat" class="form-control selectpicker get-child-cat">';
                                        $this_cat = $act = '';

                                        $list_terms = [];
                                        $list_termss[] = $catToSet;

                                        foreach ($listing_cats as $cat) {

                                            $term_children = get_terms('listing-category', array('parent' => $cat->term_id));

                                            $disabled = (empty($term_children)) ? 'blank' : '';

                                            if ($this_cat != 'selected' && $act != 1) {
                                                $cat_id = (in_array($cat->slug, $list_termss)) ? $cat->term_id : '';
                                                $counter = (in_array($cat->slug, $list_termss)) ? 1 : 0;
                                            }

                                            $this_cat = (in_array($cat->slug, $list_termss)) ? 'selected' : '';

                                            if ($this_cat == 'selected') {
                                                $act = 1;
                                            }

                                            echo '<option '.$this_cat.' data-val="'.$disabled.'" value="'.$cat->slug.'">'.$cat->name.'</option>';
                                        }
                                    echo '</select>';
                                echo '</div>';

                                if (get_query_var('list-cat')) {
                                    while (($counter <= count($list_termss)) && ($cat_id != '')) {
                                        $meet = 0;
                                        $listing_cats = get_terms('listing-category', array('parent' => $cat_id));
                                        if (!empty($listing_cats)) {
                                            echo '<div class="act-cat" id="list-'.($counter + 1).'">';
                                                echo '<label>'.__('Select Category').'</label>';
                                                echo '<select data-page="'.$data_page.'" data-empty="true" name="list-cat" class="form-control selectpicker get-child-cat">';
                                                    echo '<option value="" selected disabled>'.__('Select', 'framework').'</option>';
                                                    $this_cat = $act = '';
                                                    foreach ($listing_cats as $cat) {

                                                        $term_children = get_term_children($cat->term_id, 'listing-category');

                                                        $disabled = (empty($term_children)) ? 'blank' : '';

                                                        if ($this_cat != 'selected' && $act != 1) {
                                                            $cat_id = (in_array($cat->slug, $list_termss)) ? $cat->term_id : '';
                                                        }
                                                        $this_cat = (in_array($cat->slug, $list_termss)) ? 'selected' : '';
                                                        if ($this_cat == 'selected') {
                                                            $act = 1;
                                                        }
                                                        echo '<option '.$this_cat.' data-val="'.$disabled.'" value="'.$cat->slug.'">'.$cat->name.'</option>';
                                                    }
                                                echo '</select>';
                                            echo '</div>';
                                        }
                                        ++$counter;
                                    }
                                }
                                echo '<div class="loading-fields" id="loading-field" style="display:none;">';
                                    echo '<label>'.__('Select Category', 'framework').'</label>';
                                    echo '<input class="form-control" type="text" value="'.__('Loading...', 'framework').'">';
                                echo '</div>';
                            echo '</div>';
                        }
                    } ?>

                    <div id="Search-Filters">
                        <div class="filters-sidebar">
                            <div class="accordion" id="toggleArea">
                                <!-- Filter by Year -->
                                <?php
                                $series             = 1;
                                $numeric_specs_type = ( isset( $imic_options[ 'integer_specs_type' ] ) ) ? $imic_options[ 'integer_specs_type' ] : 0;
                                foreach ($search_filters as $filter)
                                {
                                    $integer     = get_post_meta( $filter, 'imic_plugin_spec_char_type', true );
                                    $tabs        = get_post_meta( $filter, 'specifications_value', true );
                                    $value_label = get_post_meta( $filter, 'imic_plugin_value_label', true );
                                    $spec_slug   = imic_the_slug( $filter );

                        if ( $integer == 0 )
                        {
                            $slug        = $spec_slug;
                            $comparision = "";
                        }
                        elseif ( $integer == 1 )
                        {
                            if ( $numeric_specs_type == 0 )
                            {
                                $slug        = "int_" . $spec_slug;
                                $comparision = "<span>" . __( "Less Than ", "framework" ) . '</span>';
                            }
                            else
                            {
                                $slug        = "range_" . $spec_slug;
                                $comparision = '';
                            }
                        }
                        else
                        {
                            $slug        = "char_" . $spec_slug;
                            $comparision = "";
                        }
                        $get_child_filter  = ( imic_get_child_values_status( $tabs ) == 1 ) ? 'get-child-filter' : '';
                        $slider_range_step = ( isset( $imic_options[ 'range_steps' ] ) ) ? $imic_options[ 'range_steps' ] : 100; ?>

                        <!-- Filter by Make -->

                                <div class="accordion-group panel">
                                    <div class="accordion-heading togglize">
                                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#" href="#collapseTwo-<?php echo esc_attr( $series ); ?>"><?php echo get_the_title( $filter ); ?>
                                            <i class="fa fa-angle-down"></i>
                                        </a>
                                    </div>

                                    <div id="collapseTwo-<?php echo esc_attr( $series ); ?>" class="accordion-body collapse">
                                        <div class="accordion-inner">
                                            <ul data-ids="<?php echo 'fieldfltr-' . ( $filter + 2648 ); ?>" id="<?php echo esc_attr( $slug ); ?>" class="filter-options-list list-group search-fields">
                                                <?php if ( $integer == 1 && $numeric_specs_type == 1 ) { ?>
                                                    <li>
                                                        <b><?php
                                                        echo esc_attr( $value_label ); ?> <span class="left">0</span> -
                                                        <span class="right">10000</span></b> <input id="ex2" type="text" class="span2" value="" data-slider-min="0" data-slider-max="100000" data-slider-step="<?php
                                                        echo esc_attr( $slider_range_step ); ?>" data-slider-value="[0,10000]" data-imic-start="" data-imic-end=""/>
                                                        <a data-range="0-10000" class="range-val btn-primary btn-sm btn"><?php _e( 'Filter', 'framework' ); ?></a>
                                                    </li> <?php
                        }
                        else
                        {
                            foreach ( $tabs as $tab )
                            {
                                $prefix = '';

                                if ( $integer == 0 )
                                {
                                    $specification = "feat_data";
                                }
                                else
                                {
                                    $specification = $slug;
                                }

                                $total_cars = imic_count_cars_by_specification( $specification, $tab[ 'imic_plugin_specification_values' ], $term_slug ); ?>

                                <?php if ( $total_cars >= 1 ): ?>
                                    <li class="list-group-item">
                                        <span class="badge"><?php
                                        echo esc_attr( $total_cars ); ?></span><?php echo $comparision; ?>
                                        <a class="<?php echo $get_child_filter; ?>" href="#"><?php echo esc_attr( $prefix . $tab[ 'imic_plugin_specification_values' ] ); ?></a>
                                    </li>
                                <?php endif; ?>
                                                    <?php
                            }
                        }
?>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                <?php
                        if ( imic_get_child_values_status( $tabs ) == 1 )
                        {
                            $child_label = get_post_meta( $filter, 'imic_plugin_sub_field_label', true );

                            echo '<div id="fieldfltr-' . ( ( $filter * 111 ) + 2648 ) . '">';
                            echo '<div class="accordion-group panel">';
                            echo '<div class="accordion-heading togglize">';
                            echo '<a class="accordion-toggle" data-toggle="collapse" data-parent="#" href="#collapseTwo-sub' . esc_attr( $series ) . '">' . $child_label . '<i class="fa fa-angle-down"></i> </a>';
                            echo '</div>';

                            echo '<div id="collapseTwo-sub' . esc_attr( $series ) . '" class="accordion-body collapse">';
                            echo '<div class="accordion-inner">';
                            echo '<ul id="sub-' . esc_attr( $slug ) . '" class="filter-options-list list-group search-fields">';
                            echo '<li>' . __( 'Select ', 'framework' ) . get_the_title( $filter ) . '</li>';
                            echo '</ul>';
                            echo '</div>';
                            echo '</div>';
                            echo '</div>';
                            echo '</div>';
                        }
?>
                            <?php
                        $series++;
                    }
?>
                        </div>

                        <!-- End Toggle -->
                        <?php
                    $class_list = 9;
                }
                else
                {
                    echo ' <div class="col-md-3 search-filters">
                            <div class="filters-sidebar">';
                }

                $list_tags = array( );
                $tag       = '';
                if ( $term_slug != '' )
                {
                    $listing_tags = get_terms( 'cars-tag', array(
                         'hide_empty' => true
                    ) );
                    foreach ( $listing_tags as $tag )
                    {
                        $tag_description  = get_option( "taxonomy_" . $tag->term_id . "_metas" );
                        $tag_descriptions = explode( ',', $tag_description[ 'cats' ] );
                        if ( in_array( $term_slug, $tag_descriptions ) )
                        {
                            $list_tags[ ] = $tag->slug;
                        }
                        else
                        {
                            foreach ( $list_terms_slug as $slug_c )
                            {
                                if ( in_array( $slug_c, $tag_descriptions ) )
                                {
                                    $list_tags[ ] = $tag->slug;
                                    break;
                                }
                            }
                        }
                    }
                }
?>
                    <?php
                if ( !empty( $list_tags ) )
                {
                    echo '<h3>' . __( 'Deep Search', 'framework' ) . '</h3>
                        <div class="widget_tag_cloud matched-tags-list">';
                    foreach ( $list_tags as $tab )
                    {
                        $tag_name = get_term_by( 'slug', $tab, 'cars-tag' );
                        echo '<a href="javascript:void(0);" class="">' . $tag_name->name . '</a>';
                    }
                    echo '</div><br/>';
                }
                else
                {
                    //echo '<a href="javascript:void(0);">'.__('Filters not found, please select category.','framework').'</li>';
                } ?>

                <!-- End Toggle -->
                <a href="#" id="reset-filters-search" class="search-filters__saving link link--green"><?php _e( 'Reset search', 'framework' );?></a>
                <a id="saved-search" href="#" class="search-filters__saving link link--red" data-target="#searchmodal" data-toggle="modal">
                    <div class="vehicle-details-access" style="display:none;"><span class="vehicle-id"><?php echo esc_attr( get_the_ID() ); ?></span></div>
                    <?php _e( 'Save search', 'framework' ); ?>
                </a>

                <?php
                $class_list = 9;
                echo ' </div>
                </div>'; ?>
                </div>

                <!-- Listing Results -->
                <div class="col-md-<?php echo esc_attr( $class_list ); ?> results-container">

                    <div class="actions-bar">
                        <div class="row">
                            <div class="col-md-3 col-sm-3 search-actions">
                                <?php $listing_page_url = imic_get_template_url('template-dashboard.php'); ?>
                                <?php include(get_stylesheet_directory() . '/includes/template-parts/listings/tool-box.php'); ?>
                            </div>
                            <div class="col-md-9 col-sm-9">
                                <div class="pull-right results-sorter">
                                    <button type="button" class="listing-sort-btn" data-toggle="dropdown" aria-expanded="false"><?php _e('Sort by', 'framework');?></button>
                                    <button type="button" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                        <span class="caret"></span>
                                        <span class="sr-only"><?php _e('Toggle Dropdown', 'framework');?></span>
                                    </button>
                                    <?php $sorting_specs = get_post_meta('250', 'imic_sort_by_specification', false); ?>
                                    <ul class="dropdown-menu sorter">
                                        <?php foreach ($sorting_specs as $sort): ?>
                                            <li class="sort-para">
                                                <div style="display:none;">
                                                    <span class="price-var"><?php echo esc_attr('int_'.imic_the_slug($sort));?></span>
                                                    <span class="price-val"><?php echo esc_attr(1000000000);?></span>
                                                    <span class="price-order"><?php _e('DESC', 'framework');?></span>
                                                </div>
                                                <a href="javascript:void(0);"><?php echo get_the_title($sort); _e(' (High to Low)', 'framework');?></a>
                                            </li>
                                            <li class="sort-para">
                                                <div style="display:none;">
                                                    <span class="price-var"><?php echo esc_attr('int_'.imic_the_slug($sort));?></span>
                                                    <span class="price-val"><?php echo esc_attr(1000000000);?></span>
                                                    <span class="price-order"><?php _e('ASC', 'framework');?></span>
                                                </div>
                                                <a href="javascript:void(0);"><?php echo get_the_title($sort); _e(' (Low to High)', 'framework'); ?></a>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                                <div class="toggle-view view-count-choice pull-right">
                                    <ul id="quick-paginate" class="utility-icons utility-icons--wide">
                                        <li><a href="#">10</a></li>
                                        <li><a href="#">20</a></li>
                                        <li><a href="#">50</a></li>
                                    </ul>
                                </div>
                                <!-- Small Screens Filters Toggle Button -->
                                <button class="btn btn-default visible-xs" id="Show-Filters"><?php _e('Search Filters', 'framework'); ?></button>
                            </div>
                        </div>
                    </div>

                    <div class="results-container-in">
                           <div class="waiting" style="display:none;">
                               <div class="spinner">
                                    <div class="rect1"></div>
                                    <div class="rect2"></div>
                                    <div class="rect3"></div>
                                    <div class="rect4"></div>
                                    <div class="rect5"></div>
                                </div>
                            </div>
                            <div id="results-holder" class="results-list-view">
                        <?php
        }
    }
    $logged_user_pin    = '';
    $user_id            = get_current_user_id();
    $logged_user        = get_user_meta( $user_id, 'imic_user_info_id', true );
    $logged_user_pin    = get_post_meta( $logged_user, 'imic_user_zip_code', true );
    $badges_type        = ( isset( $imic_options[ 'badges_type' ] ) ) ? $imic_options[ 'badges_type' ] : '0';
    $specification_type = ( isset( $imic_options[ 'short_specifications' ] ) ) ? $imic_options[ 'short_specifications' ] : '0';
    if ( $badges_type == "0" )
    {
        $badge_ids = ( isset( $imic_options[ 'badge_specs' ] ) ) ? $imic_options[ 'badge_specs' ] : array( );
    }
    else
    {
        $badge_ids = array( );
    }
    $args_cats        = array(
         'orderby' => 'name',
        'order' => 'ASC',
        'fields' => 'all'
    );
    $classifieds_data = get_option( 'imic_classifieds' );
    $img_src          = '';
    $additional_specs = ( isset( $imic_options[ 'additional_specs' ] ) ) ? $imic_options[ 'additional_specs' ] : '';
    if ( $specification_type == 0 )
    {
        $detailed_specs = ( isset( $imic_options[ 'specification_list' ] ) ) ? $imic_options[ 'specification_list' ] : array( );
    }
    else
    {
        $detailed_specs = array( );
    }
    $detailed_specs       = imic_filter_lang_specs( $detailed_specs );
    $category_rail        = ( isset( $imic_options[ 'category_rail' ] ) ) ? $imic_options[ 'category_rail' ] : '0';
    $additional_specs_all = get_post_meta( $additional_specs, 'specifications_value', true );
    $highlighted_specs    = ( isset( $imic_options[ 'highlighted_specs' ] ) ) ? $imic_options[ 'highlighted_specs' ] : array( );
    $unique_specs         = ( isset( $imic_options[ 'unique_specs' ] ) ) ? $imic_options[ 'unique_specs' ] : '';
    if ( $have_int == 1 )
    {
        $args_cars = array(
             'post_type' => 'cars',
            'orderby' => 'meta_value_num',
            'order' => $order,
            'tax_query' => $term_array,
            'meta_query' => $arrays,
            'posts_per_page' => $posts_page,
            'post_status' => 'publish',
            'offset' => $offset
        );
    }
    else
    {
        $args_cars = array(
             'post_type' => 'cars',
            'order' => $order,
            'tax_query' => $term_array,
            'meta_query' => $arrays,
            'posts_per_page' => $posts_page,
            'post_status' => 'publish',
            'offset' => $offset
        );
    }
    $cars_listing = new WP_Query( $args_cars );

    if ( $cars_listing->have_posts() ):
        while ( $cars_listing->have_posts() ): $cars_listing->the_post();

            $id = get_the_ID();

            if ( is_plugin_active( "imi-classifieds/imi-classified.php" ) )
            {
                $badge_ids      = imic_classified_badge_specs( $id, $badge_ids );
                $detailed_specs = imic_classified_short_specs( $id, $detailed_specs );
            }

            $plan = get_post_meta($id, 'imic_plugin_car_plan', true);
            $plan_premium = get_post_meta('10'.$plan, 'imic_pricing_premium_badge', true);

            $post_author_id = get_post_field( 'post_author', $id );
            $user_info_id   = get_user_meta( $post_author_id, 'imic_user_info_id', true );
            $car_pin        = get_post_meta( $user_info_id, 'imic_user_lat_long', true );
            $car_pin        = explode( ',', $car_pin );
            $post_author_id = get_post_field( 'post_author', $id );
            $user_info_id   = get_user_meta( $post_author_id, 'imic_user_info_id', true );
            $author_role    = get_option( 'blogname' );

            if ( !empty( $user_info_id ) ) {
                $term_list = wp_get_post_terms($user_info_id, 'user-role', array(
                     "fields" => "names"
                ));

                if ( !empty( $term_list ) ) {
                    $author_role = $term_list[ 0 ];
                } else {
                    $author_role = get_option( 'blogname' );
                }
            }

            $save1                 = ( isset( $_SESSION[ 'saved_vehicle_id1' ] ) ) ? $_SESSION[ 'saved_vehicle_id1' ] : '';
            $save2                 = ( isset( $_SESSION[ 'saved_vehicle_id2' ] ) ) ? $_SESSION[ 'saved_vehicle_id2' ] : '';
            $save3                 = ( isset( $_SESSION[ 'saved_vehicle_id3' ] ) ) ? $_SESSION[ 'saved_vehicle_id3' ] : '';
            $specifications        = get_post_meta( $id, 'feat_data', true );
            $unique_value          = imic_vehicle_price( $id, $unique_specs, $specifications );

            /* Override price */
                // Instantiate our Currency Class
                $currencies = new LukeRoberts\Currency();

                // Get the current in use currency.
                $currentCurrency = $currencies->getCurrentCurrency();

                // Get the vehicle price as JUST a numerical value
                $vehicle_numeric_price = preg_replace("/[^0-9]/", "", imic_vehicle_price($id, $unique_specs, $specifications));

                // Convert price dependent on what the user has selected or default which is GBP
                $vehicle_converted_price = convert_currency($vehicle_numeric_price, $from = 'GBP', $in = $currentCurrency);
                // Format the currency price
                $vehicle_formatted_price = format_currency($vehicle_converted_price, $currentCurrency, true) ;

            // The complete price which checks if the format price is empty
            $vehicle_complete_price = !empty($vehicle_formatted_price) ? $vehicle_formatted_price : 'TBC';
            $new_highlighted_specs = imic_filter_lang_specs_admin( $highlighted_specs, $id );
            $highlighted_specs     = $new_highlighted_specs;
            $highlight_value       = imic_vehicle_title( $id, $highlighted_specs, $specifications );
            $highlight_value       = ( $highlight_value == '' ) ? get_the_title() : $highlight_value;
            $details_value         = imic_vehicle_all_specs( $id, $detailed_specs, $specifications );
            $video                 = get_post_meta( $id, 'imic_plugin_video_url', true );
            $user_id               = get_current_user_id();
            $current_user_info_id  = get_user_meta( $user_id, 'imic_user_info_id', true );

            $userLocationString = '';
            $userLocation = [
                'country' => esc_attr(get_post_meta($current_user_info_id, 'imic_user_country', true)),
                'city'    => esc_attr(get_post_meta($current_user_info_id, 'imic_user_city', true))
            ];

            if (!empty($userLocation['city']) && !empty($userLocation['country'])) {
                $userLocationString = implode(', ', $userLocation);
            }

            if ( $current_user_info_id != '' ) {
                $saved_car_user = get_post_meta( $current_user_info_id, 'imic_user_saved_cars', true );
            }

            if ( ( empty( $saved_car_user ) ) || ( $current_user_info_id == '' ) || ( $saved_car_user == '' ) ) {
                $saved_car_user = array(
                    $save1,
                    $save2,
                    $save3
                );
            }

            // Badges
            $badges = imic_vehicle_all_specs($id, $badge_ids, $specifications );
            $badgeString = [];
            if (!empty($badges)) {
                // create array of badges
                foreach ($badges as $badge) {
                    $badgeString[] = '<span class="label label-default">'.esc_attr($badge).'</span>';
                }
                // Add premium badge if it exists
                if ($plan_premium) {
                    $badgeString[] = '<span class="label label-success" data-premium-modal data-mfp-src="#premiumModal">'.esc_attr('Premium listing', 'framework').'</span>';
                }
            }
            $badgeString = implode($badgeString, '');

            $save_icon         = ( imic_value_search_multi_array( $id, $saved_car_user ) ) ? 'fa-star' : 'fa-star-o';
            $save_icon_disable = ( imic_value_search_multi_array( $id, $saved_car_user ) ) ? 'disabled' : ''; ?>

            <!-- Result Item -->
            <div class="result-item format-standard" data-vehicle-id="<?php echo $id; ?>">
                <div class="result-item-image">
                    <?php if(has_post_thumbnail()): ?>
                        <a href="<?php echo esc_url(get_permalink()); ?>" class="media-box"><?php the_post_thumbnail('280x230'); ?></a>
                    <?php else: ?>
                        <a href="<?php echo esc_url(get_permalink()); ?>" class="media-box"><img src="<?php echo $default_image_src; ?>"></a>
                    <?php endif; ?>

                    <div class="result-badges">
                        <?php echo $badgeString; ?>
                    </div>
                </div>

                <div class="result-item-in">
                    <div class="result-item-cont">
                        <div class="result-item-block col1">
                            <h6 class="result-item-title">
                                <a href="<?php echo esc_url( get_permalink() ); ?>"><?php echo esc_attr( $highlight_value ); ?></a>
                                <?php
                                if ( $category_rail == "1" && is_plugin_active( "imi-classifieds/imi-classified.php" ) ):
                                    echo imic_get_cats_list( get_the_ID(), "dropdown" );
                                endif; ?>
                            </h6>

                            <div class="result-item-features">
                                <ul class="inline">
                                    <?php
                                    if (!empty($details_value)):
                                        foreach ($details_value as $detail):
                                            if (!empty($detail)):
                                                echo '<li>'.$detail.'</li>';
                                            endif;
                                        endforeach;
                                    endif; ?>
                                </ul>
                            </div>
                        </div>
                        <div class="result-item-block col2">
                            <div class="result-item-pricing">
                                <div class="price" data-price-conversion data-vehicle-price="<?php echo $vehicle_numeric_price; ?>"><?php echo esc_attr( $vehicle_complete_price ); ?></div>
                            </div>
                            <div class="result-item-action-buttons">
                                <a <?php echo esc_attr( $save_icon_disable ); ?> href="#" class="save-car">
                                    <div class="vehicle-details-access" style="display:none;">
                                        <span class="vehicle-id"><?php echo esc_attr( get_the_ID() ); ?></span>
                                    </div>
                                    <i class="fa <?php echo esc_attr( $save_icon ); ?>" data-favourite-star></i>
                                </a>

                                <div class="view-distance">
                                    <p class="result-user-location">
                                    <?php
                                        $continent = get_post_meta(get_the_ID(), 'char_location', true);
                                        $country = get_post_meta(get_the_ID(), 'child_location', true);
                                    ?>
                                    <?php echo strtolower($country) !== "location" ? $country : ''; ?>
                                    <?php echo !empty($continent) && (strtolower($country) !== "location") ? ', ': '';?>
                                    <?php echo !empty($continent) ? "{$continent}" : ''; ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="result-item-links">

                        <div class="result-item-quicklinks">
                        <?php /* Removed temporarily */ /*
                            <a href="/finance">Finance</a>
                            <a href="/insurance">Insurance</a>
                            <a href="/relocation">Relocation</a>
                        */ ?>
                        </div>

                        <?php if ( $plan_premium ): ?>
                            <?php $premium_icon = wp_get_attachment_image_src( get_field( 'id_premium_badge_image_default', 'option' ), 'thumb' ); ?>

                            <div class="result-item-approvalseal" data-approval-seal-modal data-mfp-src="#approvalSealModal">
                                <img src="<?php echo $premium_icon[0]; ?>" title="Approved Listing" alt="<?php echo get_bloginfo('name'); ?> Approved Listing" width="<?php echo $premium_icon[1]; ?>" height="<?php echo $premium_icon[2]; ?>" />
                            </div>
                            <?php
                        endif; ?>
                    </div>
                </div>
            </div>
            <?php endwhile;
        else: ?>
            <div class="text-align-center error-404">
                <hr class="sm">
                <p><strong><?php echo esc_attr_e( 'Sorry - No listing found for this criteria', 'framework' ); ?></strong></p>
                <p><?php echo esc_attr_e( 'Please search again with different filters.', 'framework' ); ?></p>
            </div>
        <?php endif;

    echo '<div class="clearfix"></div>';
    $paginate = ( $paged == '' ) ? 1 : $paged;
    imic_listing_pagination( "page-" . $paginate, $cars_listing->max_num_pages, $paged );
    wp_reset_postdata();
    if ( $data_page == "yes" ) {
        echo '</div></div></div>';
    }
    die();
}

add_action( 'wp_ajax_nopriv_imic_search_result', 'imic_search_result' );
add_action( 'wp_ajax_imic_search_result', 'imic_search_result' );
