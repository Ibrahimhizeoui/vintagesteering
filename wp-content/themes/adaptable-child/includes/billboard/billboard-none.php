<?php
// Billboard Title Text
$billboard_title = get_field('b_billboard_title') ? get_field('b_billboard_title') : get_the_title();

// Billboard Image Data
$billboard_image_id = get_field('b_billboard_image') ? get_field('b_billboard_image') : get_field('b_billboard_option_image', 'option');
$billboard_image_attributes = wp_get_attachment_image_src( $billboard_image_id, 'large' );
$billboard_image_url =  $billboard_image_attributes ? $billboard_image_attributes[0] : '';

// Billboard Date
// if we're on a post page we want to display the date
if (is_singular('post')) {
    $billboard_date = get_the_date();

    $post_thumb = wp_get_attachment_image_src(get_post_thumbnail_id(), 'banner');

    if ($post_thumb) {
        $billboard_image_attributes = $post_thumb;
        $billboard_image_url = $billboard_image_attributes[0];
    }
}

// If we're viewing a custom post type of user or we're viewing an author page
if (is_singular('user') || is_author()) {
    // remove the title from
    $billboard_title = '';

    /**
     * change the banner to the users own if they have uploaded one,
     * otherwise just do nothing and refer to default above
     */
    $user_banner = wp_get_attachment_image_src(get_post_meta(get_the_ID(), 'imic_user_logo', true), 'banner');

    if ($user_banner) {
        $billboard_image_attributes = $user_banner;
        $billboard_image_url = $billboard_image_attributes[0];
    }
}

// If we're on the posts page
if ( is_home() ) {
    $postsID = isset($id) ? $id : get_theID();

    $billboard_title = get_field('b_billboard_title', $postsID) ? get_field('b_billboard_title', $postsID) : 'Set a title in the posts page for this banner';
}

if (is_category()) {

    $billboard_title = 'Category: ' . single_cat_title('', false);

}

?>

<header class="billboard billboard--overlay billboard--slim" style="background-image: url('<?php echo $billboard_image_url; ?>');">
    <div class="billboard__content">
        <?php if (is_singular( 'post' )): ?>
            <span class="billboard__date"><?php echo $billboard_date; ?></span>
        <?php endif; ?>

        <?php if (!empty($billboard_title)): ?>
            <h1 class="billboard__title"><?php echo $billboard_title; ?></h1>
        <?php endif; ?>
    </div>
</header>
