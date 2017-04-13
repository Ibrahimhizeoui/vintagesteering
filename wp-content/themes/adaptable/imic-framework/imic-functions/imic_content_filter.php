<?php

if ( !function_exists( 'imic_content_filter' ) )
{
    function imic_content_filter( $content )
    {
        // array of custom shortcodes requiring the fix
        $block = join( "|", array(
             "imic_button",
            "icon",
            "iconbox",
            "imic_image",
            "anchor",
            "paragraph",
            "divider",
            "heading",
            "alert",
            "blockquote",
            "dropcap",
            "code",
            "label",
            "container",
            "spacer",
            "span",
            "one_full",
            "one_half",
            "one_third",
            "one_fourth",
            "one_sixth",
            "two_third",
            "progress_bar",
            "imic_count",
            "imic_tooltip",
            "imic_video",
            "htable",
            "thead",
            "tbody",
            "trow",
            "thcol",
            "tcol",
            "pricing_table",
            "pt_column",
            "pt_package",
            "pt_button",
            "pt_details",
            "pt_price",
            "list",
            "list_item",
            "list_item_dt",
            "list_item_dd",
            "accordions",
            "accgroup",
            "acchead",
            "accbody",
            "toggles",
            "togglegroup",
            "togglehead",
            "togglebody",
            "tabs",
            "tabh",
            "tab",
            "tabc",
            "tabrow",
            "section",
            "page_first",
            "page_last",
            "page",
            "modal_box",
            "imic_form",
            "fullcalendar",
            "staff",
            "fullscreenvideo"
        ) );
        // opening tag
        $rep   = preg_replace( "/(<p>)?\[($block)(\s[^\]]+)?\](<\/p>|<br \/>)?/", "[$2$3]", $content );
        // closing tag
        $rep   = preg_replace( "/(<p>)?\[\/($block)](<\/p>|<br \/>)?/", "[/$2]", $rep );
        return $rep;
    }
    add_filter( "the_content", "imic_content_filter" );
}
