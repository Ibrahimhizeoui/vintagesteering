<?php

if ( !function_exists( 'imic_register_sidebars' ) )
{
    function imic_register_sidebars( )
    {
        if ( function_exists( 'register_sidebar' ) )
        {
            register_sidebar( array(
                 'name' => __( 'Home Page Sidebar', 'framework' ),
                'id' => 'main-sidebar',
                'description' => '',
                'class' => '',
                'before_widget' => '<div id="%1$s" class="widget sidebar-widget %2$s">',
                'after_widget' => '</div>',
                'before_title' => '<h3 class="widgettitle">',
                'after_title' => '</h3>'
            ) );
            register_sidebar( array(
                 'name' => __( 'Home Page Sidebar Second', 'framework' ),
                'id' => 'main-sidebar-2',
                'description' => '',
                'class' => '',
                'before_widget' => '<div id="%1$s" class="widget sidebar-widget %2$s">',
                'after_widget' => '</div>',
                'before_title' => '<h3 class="widgettitle">',
                'after_title' => '</h3>'
            ) );
            register_sidebar( array(
                 'name' => __( 'Contact Sidebar', 'framework' ),
                'id' => 'inner-sidebar',
                'description' => '',
                'class' => '',
                'before_widget' => '<div id="%1$s" class="widget sidebar-widget %2$s">',
                'after_widget' => '</div>',
                'before_title' => '<h3 class="widgettitle">',
                'after_title' => '</h3>'
            ) );
            register_sidebar( array(
                 'name' => __( 'Page Sidebar', 'framework' ),
                'id' => 'page-sidebar',
                'description' => '',
                'class' => '',
                'before_widget' => '<div id="%1$s" class="widget sidebar-widget %2$s">',
                'after_widget' => '</div>',
                'before_title' => '<h3 class="widgettitle">',
                'after_title' => '</h3>'
            ) );
            register_sidebar( array(
                 'name' => __( 'Details Page Sidebar', 'framework' ),
                'id' => 'details-sidebar',
                'description' => '',
                'class' => '',
                'before_widget' => '<div id="%1$s" class="widget sidebar-widget %2$s">',
                'after_widget' => '</div>',
                'before_title' => '<h3 class="widgettitle">',
                'after_title' => '</h3>'
            ) );
            register_sidebar( array(
                 'name' => __( 'Post Sidebar', 'framework' ),
                'id' => 'post-sidebar',
                'description' => '',
                'class' => '',
                'before_widget' => '<div id="%1$s" class="widget sidebar-widget %2$s">',
                'after_widget' => '</div>',
                'before_title' => '<h3 class="widgettitle">',
                'after_title' => '</h3>'
            ) );
            register_sidebar( array(
                 'name' => __( 'Car Sidebar', 'framework' ),
                'id' => 'car-sidebar',
                'description' => '',
                'class' => '',
                'before_widget' => '<div id="%1$s" class="widget sidebar-widget %2$s">',
                'after_widget' => '</div>',
                'before_title' => '<h3 class="widgettitle">',
                'after_title' => '</h3>'
            ) );
            register_sidebar( array(
                 'name' => __( 'Shop Sidebar', 'framework' ),
                'id' => 'shop-sidebar',
                'description' => '',
                'class' => '',
                'before_widget' => '<div id="%1$s" class="widget sidebar-widget %2$s">',
                'after_widget' => '</div>',
                'before_title' => '<h3 class="widgettitle">',
                'after_title' => '</h3>'
            ) );
            register_sidebar( array(
                 'name' => __( 'Footer Widgets', 'framework' ),
                'id' => 'footer-sidebar',
                'description' => '',
                'class' => '',
                'before_widget' => '<div class="col-md-4 col-sm-4 widget footer_widget %2$s">',
                'after_widget' => '</div>',
                'before_title' => '<h4 class="footer-widget-title">',
                'after_title' => '</h4>'
            ) );
        }
    }
    add_action( 'init', 'imic_register_sidebars', 35 );
}
