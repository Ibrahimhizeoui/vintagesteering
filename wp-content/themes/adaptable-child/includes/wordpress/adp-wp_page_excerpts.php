<?php

function my_add_excerpts_to_pages()
{
     add_post_type_support( 'page', 'excerpt' );
}
add_action( 'init', 'my_add_excerpts_to_pages' );
