<?php
function adp_wp_hide_menu_links() {
    if( !current_user_can( 'administrator' ) ):
        remove_menu_page( 'edit.php?post_type=gallery' );
        remove_menu_page( 'edit.php?post_type=team' );
        remove_menu_page( 'edit.php?post_type=testimonial' );
        remove_menu_page( 'edit.php?post_type=product' );
        remove_menu_page( 'woocommerce' );
    endif;
}
add_action( 'admin_menu', 'adp_wp_hide_menu_links', 100 );
