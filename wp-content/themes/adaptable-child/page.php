<?php
get_header();

$id = (is_home()) ? $id = get_option('page_for_posts') : get_the_ID();

get_template_part('bar', 'two');

// includes the controller file for billboards
include('includes/billboard/billboard.php');

// includes the controller file for sidebars
include('includes/sidebar/sidebar.php'); ?>

<div class="main pageContent" role="main">
    <div class="content full">
        <div class="container">
            <div class="row">
                <?php if (have_rows('p_c_page_content')): ?>
                    <?php while (have_rows('p_c_page_content')) : the_row(); ?>
                        <?php get_template_part('includes/template-parts/generic/fc', get_row_layout()); ?>
                    <?php endwhile; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>
