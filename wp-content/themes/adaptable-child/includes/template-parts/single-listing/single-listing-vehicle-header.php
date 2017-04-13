<?php
    // get the current id then get the id for the post meta
    $postAuthorId = get_post_field('post_author', get_the_ID());
    $postRelatedToAuthorId = get_user_meta($post_author_id, 'imic_user_info_id', true);

    // get the post meta associated with this user
    $userMeta = get_userdata($postAuthorId);
    $userRelatedPostMeta = get_post_meta($postRelatedToAuthorId);

    // Get the users usersname
    $name = $userData->user_login;

    // If they are a dealer/administrator however, retreive their company name
    if (in_array("dealer", $current_user->roles) || in_array("administrator", $current_user->roles)):
        $name = isset($userRelatedPostMeta['imic_user_company'][0]) ? $userRelatedPostMeta['imic_user_company'][0] : $userData->user_login;
    endif;

    // Get profile link to users page
    $profile_link = get_the_permalink($postRelatedToAuthorId); ?>

<div class="row vehicle-header__top">
    <h2 class="col-md-6 vehicle-header__title"><?php the_title(); ?></h2>
    <div class="col-md-6 vehicle-header__company-info">
        <a href="<?php echo $profile_link; ?>">
            <span class="vehicle-header__company-name"><?php echo $name; ?></span>
            <span class="vehicle-header__logo">
                <?php if (is_array($user_image)): ?>
                    <img src="<?php echo $user_image[0]; ?>" alt="<?php echo $company_name . ' Company Logo'; ?>" title="<?php echo $company_name; ?>" />
                <?php else: ?>
                    <span></span>
                <?php endif; ?>
            </span>
        </a>
    </div>
</div>

<div class="row vehicle-header__bottom">
    <div class="col-md-4 vehicle-header__price">
        <h3 class="amount" data-price-conversion data-vehicle-price="<?php echo $vehicle_numeric_price; ?>"><?php echo esc_attr($vehicle_complete_price);?></h3>
    </div>
    <div class="single-listing-actions col-md-7 col-md-offset-1">
        <div class="pull-right" role="group">
            <?php /* Removed temporarily */
      /*      <a class="button button--bold button--small button--white" href="/finance" >Finance</a>
            <a class="button button--bold button--small button--white" href="/insurance" >Insurance</a>
            <a class="button button--bold button--small button--white" href="/relocation" >Relocation</a>*/
            ?>
            <?php if ($enquiry_form1 != 2): ?>
                <a href="#" data-toggle="modal" data-target="#infoModal" class="button button--bold button--small button--black" title="<?php echo esc_attr_e('Request more info', 'adaptable-child'); ?>">
                    <span><?php echo esc_attr_e('Contact Seller', 'adaptable-child'); ?></span>
                </a>
            <?php endif; ?>
        </div>
    </div>
</div>
