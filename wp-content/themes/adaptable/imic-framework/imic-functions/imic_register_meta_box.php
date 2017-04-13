<?php

//Meta Box for Sidebar on all Posts/Page
if ( !function_exists( 'imic_register_meta_box' ) )
{
    add_action( 'admin_init', 'imic_register_meta_box' );
    function imic_register_meta_box( )
    {
        // Check if plugin is activated or included in theme
        if ( !class_exists( 'RW_Meta_Box' ) )
            return;
        $prefix   = 'imic_';
        $meta_box = array(
             'id' => 'template-sidebar1',
            'title' => __( "Select Sidebar", 'framework' ),
            'pages' => array(
                 'post',
                'page',
                'cars',
                'product'
            ),
            'context' => 'normal',
            'fields' => array(
                 array(
                     'name' => 'Select Sidebar from list',
                    'id' => $prefix . 'select_sidebar_from_list',
                    'desc' => __( "Select Sidebar from list, if using page builder then please add sidebar from element only.", 'framework' ),
                    'type' => 'select',
                    'options' => imic_get_all_sidebars()
                ),
                array(
                     'name' => __( 'Columns Layout', 'framework' ),
                    'id' => $prefix . 'sidebar_columns_layout',
                    'desc' => __( "Select Columns Layout .", 'framework' ),
                    'type' => 'select',
                    'options' => array(
                         '3' => __( 'One Fourth', 'framework' ),
                        '4' => __( 'One Third', 'framework' ),
                        '6' => __( 'Half', 'framework' )
                    ),
                    'std' => 3
                )
            )
        );
        new RW_Meta_Box( $meta_box );
        $prefix     = 'imic_';
        $meta_boxes = array(
             'id' => 'template-featured1',
            'title' => __( "Select Featured Sidebar", 'framework' ),
            'pages' => array(
                 'cars'
            ),
            'context' => 'normal',
            'fields' => array(
                 array(
                     'name' => 'Featured Sidebar',
                    'id' => $prefix . 'select_featured_from_list',
                    'desc' => __( "Select Sidebar for featured section of details page.", 'framework' ),
                    'type' => 'select',
                    'options' => imic_get_all_sidebars()
                )
            )
        );
        new RW_Meta_Box( $meta_boxes );
    }
}
