<!-- SIDEBAR -->
<div class="listing-form-steps-wrapper">
    <!-- AD LISTING PROGRESS BAR -->
    <div class="listing-form-progress">
        <div class="progress-label"> <span><?php  echo esc_attr_e('Ad Completeness','adaptable-child'); ?></span> </div>
        <div class="progress">
            <div class="progress-bar progress-bar-primary" data-appear-progress-animation="<?php  echo esc_attr($animation); ?>"></div>
        </div>
    </div>
    <!-- AD LISTING FORM STEPS -->
    <ul class="listing-form-steps">
        <li class="tabs-listing <?php  echo esc_attr($tab_class1.' '.$active_tab1); ?>" data-target="#listing-add-form-one" data-rel="listing-add-form-one" data-toggle="tab">
            <a href="javascript:void(0);">
                <span class="step-state"></span>
                <strong class="step-title"><?php  echo esc_attr_e('Create Listing','adaptable-child'); ?></strong>
            </a>
        </li>
        <li class="tabs-listing <?php  echo esc_attr($tab_class2.' '.$active_tab2); ?>" data-target="#listing-add-form-two" data-rel="listing-add-form-two" data-toggle="tab">
            <a href="javascript:void(0);">
                <span class="step-state"></span>
                <strong class="step-title"><?php  echo esc_attr_e('Select Features','adaptable-child'); ?></strong>
            </a>
        </li>
        <li class="tabs-listing <?php  echo esc_attr($tab_class3.' '.$active_tab3); ?>" data-target="#listing-add-form-three" data-rel="listing-add-form-three" data-toggle="tab">
            <a href="javascript:void(0);">
                <span class="step-state"></span>
                <strong class="step-title"><?php  echo esc_attr_e('Add details','adaptable-child'); ?></strong>
            </a>
        </li>
        <li class="tabs-listing <?php  echo esc_attr($tab_class4.' '.$active_tab4); ?>" data-target="#listing-add-form-four" data-rel="listing-add-form-four" data-toggle="tab">
            <a href="javascript:void(0);">
                <span class="step-state"></span>
                <strong class="step-title"><?php  echo esc_attr_e('Add photos ','adaptable-child'); ?>&amp;<?php  echo esc_attr_e(' comments','adaptable-child'); ?></strong>
            </a>
        </li>
        <li class="tabs-listing <?php  echo esc_attr($tab_class5.' '.$active_tab5); ?>" data-target="#listing-add-form-five" data-rel="listing-add-form-five" data-toggle="tab">
            <a href="javascript:void(0);">
                <span class="step-state"></span>
                <strong class="step-title"><?php  echo esc_attr_e('Publish Listing','adaptable-child'); ?></strong>
            </a>
        </li>
        <div id="message"></div>
    </ul>
</div>
