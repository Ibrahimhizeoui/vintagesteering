<?php

//Add New Custom Menu Option
if ( !class_exists( 'IMIC_Custom_Nav' ) )
{
    class IMIC_Custom_Nav
    {
        public function add_nav_menu_meta_boxes( )
        {

            add_meta_box( 'mega_nav_link', __( 'Mega Menu', 'framework' ), array(
                 $this,
                'nav_menu_link'
            ), 'nav-menus', 'side', 'low' );
        }
        public function nav_menu_link( )
        {
            global $_nav_menu_placeholder, $nav_menu_selected_id;
            $_nav_menu_placeholder = 0 > $_nav_menu_placeholder ? $_nav_menu_placeholder - 1 : -1; ?>

            <div id="posttype-wl-login" class="posttypediv">
                <div id="tabs-panel-wishlist-login" class="tabs-panel tabs-panel-active">
                    <ul id="wishlist-login-checklist" class="categorychecklist form-no-clear">
                        <li>
                            <label class="menu-item-title">
                                <input type="checkbox" class="menu-item-object-id" name="menu-item[<?php echo esc_attr( $_nav_menu_placeholder ); ?>][menu-item-object-id]" value="<?php echo esc_attr( $_nav_menu_placeholder ); ?>">
                                <?php _e( 'Create Column', 'framework' ); ?>
                            </label>
                            <input type="hidden" class="menu-item-db-id" name="menu-item[<?php echo esc_attr( $_nav_menu_placeholder ); ?>][menu-item-db-id]" value="0">
                            <input type="hidden" class="menu-item-object" name="menu-item[<?php echo esc_attr( $_nav_menu_placeholder ); ?>][menu-item-object]" value="page">
                            <input type="hidden" class="menu-item-parent-id" name="menu-item[<?php echo esc_attr( $_nav_menu_placeholder ); ?>][menu-item-parent-id]" value="0">
                            <input type="hidden" class="menu-item-type" name="menu-item[<?php echo esc_attr( $_nav_menu_placeholder ); ?>][menu-item-type]" value="">
                            <input type="hidden" class="menu-item-title" name="menu-item[<?php echo esc_attr( $_nav_menu_placeholder ); ?>][menu-item-title]" value="<?php _e( 'Column', 'framework' ); ?>">
                            <input type="hidden" class="menu-item-classes" name="menu-item[<?php echo esc_attr( $_nav_menu_placeholder ); ?>][menu-item-classes]" value="custom_mega_menu">
                        </li>
                    </ul>
                </div>
                <p class="button-controls">
                    <span class="add-to-menu">
                        <input type="submit" class="button-secondary submit-add-to-menu right" value="<?php _e( 'Add to Menu', 'framework' ); ?>" name="add-post-type-menu-item" id="submit-posttype-wl-login">
                        <span class="spinner"></span>
                    </span>
                </p>
            </div>
            <?php
        }
    }
}

$custom_nav = new IMIC_Custom_Nav;

// Initialize custom navigation
add_action('admin_init', array(
     $custom_nav,
    'add_nav_menu_meta_boxes'
));
