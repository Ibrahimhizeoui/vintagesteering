<?php
if(!function_exists('adp_get_template_url')) {
    /**
     * [adp_get_template_url description]
     * @param  [string] $TEMPLATE_NAME [name of template file in theme ]
     * @return [string]                [url to template file]
     */
    function adp_get_template_url($TEMPLATE_NAME){
        // use wordpresses default get_pages() to get the url to our specified template file
        $pages = get_pages(array(
            'meta_key' => '_wp_page_template',
            'meta_value' => $TEMPLATE_NAME,
            'sort_order' => 'desc',
        ));

        // throw exception if pages array is empty
        if (empty($pages)) {
            throw new Exception("Pages array is empty, please pass a valid template-name");
        }

        // return permalink to template
        return get_permalink($pages[0]->ID);
    }
}
