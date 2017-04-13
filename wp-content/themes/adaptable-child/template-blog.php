<?php
/*
Template Name: Blog
*/
get_header();
global $imic_options;

//Get Page Banner Type
$id = (is_home()) ? $id = get_option('page_for_posts') : get_the_ID();

// Includes the breadcrumbs
get_template_part('bar', 'two');

// includes the controller file for billboards
include('includes/billboard/billboard.php');
// includes the sidebars for the page
include('includes/sidebar/sidebar.php');

$post_count = get_post_meta($id, 'imic_blog_post_count', true);
$post_count = ($post_count != '') ? $post_count : get_option('posts_per_page');
$column = get_post_meta($id, 'imic_blog_column', true);
$layout = get_post_meta($id, 'imic_blog_layout', true);
$classic_class = ($layout == 1) ? 'posts-archive' : '';
$array = array();

$post_type = get_post_meta($id, 'imic_blog_post_type', true);
switch ($post_type)
{
    case 1:
        $array = array('key' => 'imic_select_post_section', 'value' => '1', 'compare' => '=');
        break;
    case 2:
        $array = array('key' => 'imic_select_post_section', 'value' => '0', 'compare' => '=');
        break;
}

$browse_listing = imic_get_template_url('template-listing.php'); ?>

<div class="main" role="main content full">
    <div class="container">
        <div class="row">
            <?php $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
            $args_post = array('post_type' => 'post', 'paged' => $paged, 'posts_per_page' => $post_count, 'meta_query' => array($array)); ?>

            <?php if ($post_listing->have_posts()) :

                $post_listing = new WP_Query($args_post);
                $post_thumbid = get_post_thumbnail_id();
                $post_thumb = wp_get_attachment_image_src($post_thumbid, 'medium')[0]; ?>

                <ul class="grid-holder col-<?php echo esc_attr($column); ?> posts-grid">
                    <?php while ($post_listing->have_posts()) : $post_listing->the_post(); ?>
                        <?php get_template_part('content', 'single'); ?>
                    <?php endwhile; ?>
                </ul>

            <?php else: ?>

                <ul class="grid-holder col-<?php echo esc_attr($column); ?> posts-grid posts-grid--none">
                    <?php get_template_part('content', 'none'); ?>
                </ul>

            <?php endif; ?>

            <div class="blogPagination">
                <?php imic_pagination($post_listing->max_num_pages); ?>
            </div>

            <?php wp_reset_postdata(); ?>

            <?php if (is_active_sidebar($pageSidebar)): ?>

                <div class="col-md-<?php echo esc_attr($sidebar_column); ?>">
                    <?php dynamic_sidebar($pageSidebar); ?>
                </div>
            <?php endif; ?>

        </div>
    </div>
</div>

<?php get_footer(); ?>
