<?php

// if(!function_exists('imicQuickEditProperty')){
//     add_filter('wp_dropdown_users', 'imicQuickEditProperty');
//     function imicQuickEditProperty($output)
//     {
//         global $post;
//         //global $post is available here, hence you can check for the post type here
//         $user_query = get_users( array( 'role' => 'subscriber' ) );
//         // This gets the array of ids of the subscribers
//         $subscribers_id = wp_list_pluck( $user_query, 'ID' );
//         // Now use the exclude parameter to exclude the subscribers
//         $users = get_users( array( 'exclude' => $subscribers_id ) );
//
//         $output = "<select id=\"post_author_override\" name=\"post_author_override\" class=\"\">";
//
//             foreach($users as $user)
//             {
//                 $sel = ($post->post_author == $user->ID) ? "selected='selected'" : '';
//                 $output .= '<option value="'.$user->ID.'"'.$sel.'>'.$user->user_login.'</option>';
//             }
//
//         $output .= "</select>";
//         return $output;
//     }
// }
