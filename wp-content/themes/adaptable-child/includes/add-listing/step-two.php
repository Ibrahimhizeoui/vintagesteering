<!-- AD LISTING FORM STEP TWO -->

<div id="listing-add-form-two" class="tab-pane fade <?php echo ($active_tab2 != '') ? $active_tab2 . ' in' : ''; ?>">
    <h3><?php echo esc_attr_e('Select any additional features of your car', 'adaptable-child'); ?></h3>
    <p><?php echo esc_attr_e('Features selected can either factory fitted or after market features.', 'adaptable-child'); ?></p>

    <div class="panel">
        <div class="panel-body">
            <ul class="optional-features-list" id="dynamic-tags">
                <?php
                if (get_query_var('list-cat'))
                {
                    $category_slug = get_query_var('list-cat');
                    $term_id = get_term_by('slug', $category_slug, 'listing-category');
                    $parents = get_ancestors($term_id->term_id, 'listing-category');
                    array_push($parents, $term_id->term_id);
                    $list_tags = get_terms('cars-tag', array(
                        'hide_empty' => false
                    ));
                    $term_list = wp_get_post_terms($update_id, 'cars-tag', array(
                        "fields" => "ids"
                    ));
                    foreach($list_tags as $tag)
                    {
                        $cat_slugs = get_option('taxonomy_' . $tag->term_id . '_metas');
                        $cat_slugs = $cat_slugs['cats'];
                        if (!empty($cat_slugs))
                        {
                            $cat_slugs = explode(',', $cat_slugs);
                        }
                        else
                        {
                            $cat_slugs = array();
                        }

                        foreach($parents as $parent)
                        {
                            $list_term = get_term_by('id', $parent, 'listing-category');
                            if (in_array($list_term->slug, $cat_slugs))
                            {
                                $selected = (in_array($tag->term_id, $term_list)) ? 'checked' : '';
                                echo '<li class="checkbox"><label><input ' . $selected . ' value="1" id="' . $tag->term_id . '" type="checkbox" class="vehicle-tags"> ' . $tag->name . '</input></label></li>';
                                $data = 1;
                                break;
                            }
                        }
                    }
                }
                else
                {
                    $features = get_terms('cars-tag', array(
                        'hide_empty' => false
                    ));

                    $term_list = wp_get_post_terms($update_id, 'cars-tag', array(
                        "fields" => "ids"
                    ));

                    foreach($features as $feature)
                    {
                        $selected = (in_array($feature->term_id, $term_list)) ? 'checked' : '';
                        echo '<li class="checkbox"><label><input ' . $selected . ' value="1" id="' . $feature->term_id . '" type="checkbox" class="vehicle-tags"> ' . $feature->name . '</input></label></li>';
                    }
                } ?>
            </ul>
        </div>
    </div>
    <?php
    if (is_user_logged_in())
    { ?>
        <div class="col-md-12 center spaced">
            <button id="ss" class="button button--alternate save-searched-value">
                <?php echo esc_attr_e('Save ', 'adaptable-child'); ?>
                &amp;
                <?php echo esc_attr_e(' continue', 'adaptable-child'); ?>
            </button>
        </div>
    <?php
    }
    else
    {
        echo '<a class="btn btn-primary pull-right" data-toggle="modal" data-target="#PaymentModal">' . __('Login/Register', 'framework') . '</a>';
    } ?>
</div>
