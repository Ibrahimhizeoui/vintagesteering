<?php
get_header();

$id = (is_home()) ? get_option('page_for_posts') : get_the_ID();

$browse_listing = imic_get_template_url("template-listing.php");

// breadcrumbs
get_template_part('bar', 'two');

$page_header = get_field('b_billboard_type');
switch ($page_header)
{
    case 'standard':
        get_template_part('includes/billboard/billboard', 'standard');
        break;
    case 'video':
        get_template_part('includes/billboard/billboard', 'video');
        break;
    default:
        get_template_part('includes/billboard/billboard', 'none');
}

$sidebar_column = get_post_meta(get_the_ID(),'imic_sidebar_columns_layout',true);

$pageSidebar = get_post_meta(get_the_ID(),'imic_select_sidebar_from_list', true);
if (!empty($pageSidebar) && is_active_sidebar($pageSidebar)) {
    $left_col = 12-$sidebar_column;
    $class = $left_col;
} else {
    $class = 12;
}

$blog_masonry = 2;

$randArgs = [
	'post_type'   => 'post',
	'numberposts' => 3,
	'orderby'     => 'rand',
    'post__not_in' => array(get_the_ID())
];

$randomPosts = get_posts($randArgs); ?>

<!-- Start Body Content -->
<main class="main" role="main">
    <div id="content" class="content full">
        <div class="container">
            <div class="row">
                <div class="col-md-<?php echo esc_attr($class); ?> single-post">
        			<article class="post-content">
                        <?php if(have_posts()) : while(have_posts()) : the_post();
                            the_content();
                        endwhile; endif; ?>
                    </article>
                </div>

                <?php if(is_active_sidebar($pageSidebar)) { ?>
                    <!-- Sidebar -->
                    <div class="col-md-<?php echo esc_attr($sidebar_column); ?>">
                        <?php dynamic_sidebar($pageSidebar); ?>
                    </div>
                <?php } ?>

            </div>
        </div>
    </div>
    <aside class="related-posts-grid">

        <div class="listing-header">
            <div class="container">
                <div class="row">
                    <div class="col-xs-6 col-sm-8 listing-header-title">
                        <h6><?php echo _e('Related Articles', 'adaptable-child'); ?></h6>
                    </div>
                    <div class="col-xs-6 col-sm-4 listing-header-link">
                        <a class="link link--green" href="<?php echo home_url().'/all-cars'; ?>">View All</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="container">
            <ul class="col-3 posts-grid">
                <?php foreach( $randomPosts as $post ) : setup_postdata( $post ); ?>
                    <?php $post_thumbid = get_post_thumbnail_id($post->ID); ?>
                    <?php $post_thumb = wp_get_attachment_image_src($post_thumbid, 'medium')[0]; ?>

                    <li class="grid-item post format-standard">
                        <div class="grid-item-inner">
                            <?php if (has_post_thumbnail(get_The_ID())): ?>
                                <a href="<?php echo esc_url(get_permalink($post->ID));?>" class="media-box" style="background-image: url('<?php echo $post_thumb; ?>');"></a>
                            <?php endif; ?>

                            <div class="grid-content">
                                <div class="post-date"><?php echo get_the_date(); ?></div>
                                <h3 class="post-title"><a href="<?php echo esc_url(get_permalink(get_the_ID())); ?>"><?php echo get_the_title($post->ID);?></a></h3>
                                <p class="post-text"><?php echo imic_excerpt(18, $post->ID); ?></p>
                            </div>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </aside>
</main>
    <!-- End Body Content -->
<?php get_footer(); ?>
