<?php
/*
Template Name: Blog
*/
get_header();
global $imic_options;

//Get Page Banner Type
$id = ( is_home() ) ? get_option('page_for_posts') : get_the_ID();

// Includes the breadcrumbs
get_template_part('bar', 'two');

// includes the controller file for billboards
include(locate_template('includes/billboard/billboard.php'));

// includes the sidebars for the page
include(locate_template('includes/sidebar/sidebar.php'));

$column = get_post_meta($id, 'imic_blog_column', true);

$post_count = get_option('posts_per_page');

$post_type = get_post_meta($id, 'imic_blog_post_type', true);

switch ($post_type)
{
    case 1:
        $array = array('key' => 'imic_select_post_section', 'value' => '1', 'compare' => '=');
        break;
    case 2:
        $array = array('key' => 'imic_select_post_section', 'value' => '0', 'compare' => '=');
        break;
    default:
        $array = array();
}

$browse_listing = imic_get_template_url('template-listing.php');

$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

$args_post = array(
    'post_type' => 'post',
    'paged' => $paged,
    'posts_per_page' => $post_count,
    'meta_query' => array($array)
);

$post_listing = new WP_Query($args_post); ?>

<main class="main" role="main">
    <div id="content" class="content full">
        <div class="container">

            <?php if ($post_listing->have_posts()): ?>

                <ul class="grid-holder col-<?php echo esc_attr($column); ?> posts-grid">
                    <?php while ($post_listing->have_posts()) : $post_listing->the_post(); ?>
                        <?php get_template_part('content', 'single'); ?>
                    <?php endwhile; ?>
                </ul>

                <div class="paginationGroup">
                    <?php imic_pagination($post_listing->max_num_pages, $post_count, $paged); ?>
                </div>

            <?php else: ?>

                <ul class="grid-holder col-<?php echo esc_attr($column); ?> posts-grid posts-grid--empty">
                    <?php get_template_part('content', 'none'); ?>
                </ul>

            <?php endif; ?>

        </div>
    </div>
</main>

<?php wp_reset_postdata(); get_footer(); ?>
