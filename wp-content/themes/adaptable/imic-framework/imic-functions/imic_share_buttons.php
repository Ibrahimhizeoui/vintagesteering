<?php

if ( !function_exists( 'imic_share_buttons' ) )
{
    function imic_share_buttons( )
    {
        $posttitle     = get_the_title();
        $postpermalink = get_permalink();
        $postexcerpt   = get_the_excerpt();
        global $imic_options;
        $facebook_share_alt  = ( isset( $imic_options[ 'facebook_share_alt' ] ) ) ? $imic_options[ 'facebook_share_alt' ] : '';
        $twitter_share_alt   = ( isset( $imic_options[ 'twitter_share_alt' ] ) ) ? $imic_options[ 'twitter_share_alt' ] : '';
        $google_share_alt    = ( isset( $imic_options[ 'google_share_alt' ] ) ) ? $imic_options[ 'google_share_alt' ] : '';
        $tumblr_share_alt    = ( isset( $imic_options[ 'tumblr_share_alt' ] ) ) ? $imic_options[ 'tumblr_share_alt' ] : '';
        $pinterest_share_alt = ( isset( $imic_options[ 'pinterest_share_alt' ] ) ) ? $imic_options[ 'pinterest_share_alt' ] : '';
        $reddit_share_alt    = ( isset( $imic_options[ 'reddit_share_alt' ] ) ) ? $imic_options[ 'reddit_share_alt' ] : '';
        $linkedin_share_alt  = ( isset( $imic_options[ 'linkedin_share_alt' ] ) ) ? $imic_options[ 'linkedin_share_alt' ] : '';
        $email_share_alt     = ( isset( $imic_options[ 'email_share_alt' ] ) ) ? $imic_options[ 'email_share_alt' ] : '';
        $vk_share_alt        = ( isset( $imic_options[ 'vk_share_alt' ] ) ) ? $imic_options[ 'vk_share_alt' ] : '';

        //echo '<div class="social-share-bar">';
        if ( $imic_options[ 'sharing_style' ] == '0' )
        {
            if ( $imic_options[ 'sharing_color' ] == '0' )
            {
                //echo '<h4><i class="fa fa-share-alt"></i> '.__('Share','framework').'</h4>';
                echo '<ul class="utility-icons social-icons social-icons-colored branded">';
            }
            elseif ( $imic_options[ 'sharing_color' ] == '1' )
            {
                //echo '<h4><i class="fa fa-share-alt"></i> '.__('Share','framework').'</h4>';
                echo '<ul class="utility-icons social-icons social-icons-colored share-buttons-tc">';
            }
            elseif ( $imic_options[ 'sharing_color' ] == '2' )
            {
                //echo '<h4><i class="fa fa-share-alt"></i> '.__('Share','framework').'</h4>';
                echo '<ul class="utility-icons social-icons social-icons-colored share-buttons-gs">';
            }
        }
        elseif ( $imic_options[ 'sharing_style' ] == '1' )
        {
            if ( $imic_options[ 'sharing_color' ] == '0' )
            {
                //echo '<h4><i class="fa fa-share-alt"></i> '.__('Share','framework').'</h4>';
                echo '<ul class="utility-icons social-icons social-icons-colored share-buttons-squared">';
            }
            elseif ( $imic_options[ 'sharing_color' ] == '1' )
            {
                //echo '<h4><i class="fa fa-share-alt"></i> '.__('Share','framework').'</h4>';
                echo '<ul class="utility-icons social-icons social-icons-colored share-buttons-tc share-buttons-squared">';
            }
            elseif ( $imic_options[ 'sharing_color' ] == '2' )
            {
                //echo '<h4><i class="fa fa-share-alt"></i> '.__('Share','framework').'</h4>';
                echo '<ul class="utility-icons social-icons social-icons-colored share-buttons-gs share-buttons-squared">';
            }
        }
        echo '<li class="share-title"></li>';
        if ( $imic_options[ 'share_icon' ][ '1' ] == '1' )
        {
            echo '<li class="facebook"><a href="https://www.facebook.com/sharer/sharer.php?u=' . $postpermalink . '&amp;t=' . $posttitle . '" target="_blank" title="' . $facebook_share_alt . '"><i class="fa fa-facebook"></i></a></li>';
        }
        if ( $imic_options[ 'share_icon' ][ '2' ] == '1' )
        {
            echo '<li class="twitter"><a href="https://twitter.com/intent/tweet?source=' . $postpermalink . '&amp;text=' . $posttitle . ':' . $postpermalink . '" target="_blank" title="' . $twitter_share_alt . '"><i class="fa fa-twitter"></i></a></li>';
        }
        if ( $imic_options[ 'share_icon' ][ '3' ] == '1' )
        {
            echo '<li class="google"><a href="https://plus.google.com/share?url=' . $postpermalink . '" target="_blank" title="' . $google_share_alt . '"><i class="fa fa-google-plus"></i></a></li>';
        }
        if ( $imic_options[ 'share_icon' ][ '4' ] == '1' )
        {
            echo '<li class="tumblr"><a href="http://www.tumblr.com/share?v=3&amp;u=' . $postpermalink . '&amp;t=' . $posttitle . '&amp;s=" target="_blank" title="' . $tumblr_share_alt . '"><i class="fa fa-tumblr"></i></a></li>';
        }
        if ( $imic_options[ 'share_icon' ][ '5' ] == '1' )
        {
            echo '<li class="pinterest"><a href="http://pinterest.com/pin/create/button/?url=' . $postpermalink . '&amp;description=' . $postexcerpt . '" target="_blank" title="' . $pinterest_share_alt . '"><i class="fa fa-pinterest"></i></a></li>';
        }
        if ( $imic_options[ 'share_icon' ][ '6' ] == '1' )
        {
            echo '<li class="reddit"><a href="http://www.reddit.com/submit?url=' . $postpermalink . '&amp;title=' . $posttitle . '" target="_blank" title="' . $reddit_share_alt . '"><i class="fa fa-reddit"></i></a></li>';
        }
        if ( $imic_options[ 'share_icon' ][ '7' ] == '1' )
        {
            echo '<li class="linkedin"><a href="http://www.linkedin.com/shareArticle?mini=true&url=' . $postpermalink . '&amp;title=' . $posttitle . '&amp;summary=' . $postexcerpt . '&amp;source=' . $postpermalink . '" target="_blank" title="' . $linkedin_share_alt . '"><i class="fa fa-linkedin"></i></a></li>';
        }
        if ( $imic_options[ 'share_icon' ][ '8' ] == '1' )
        {
            echo '<li class="email"><a href="mailto:?subject=' . $posttitle . '&amp;body=' . $postexcerpt . ':' . $postpermalink . '" target="_blank" title="' . $email_share_alt . '"><i class="fa fa-envelope"></i></a></li>';
        }
        if ( ( isset( $imic_options[ 'share_icon' ][ '9' ] ) ) && ( $imic_options[ 'share_icon' ][ '9' ] == '1' ) )
        {
            echo '<li class="vk"><a href="http://vk.com/share.php?url=' . $postpermalink . '" target="_blank" title="' . $vk_share_alt . '"><i class="fa fa-vk"></i></a></li>';
        }
        echo '</ul>
            ';
    }
}
