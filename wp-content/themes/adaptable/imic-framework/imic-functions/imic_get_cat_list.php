<?php

if ( !function_exists( 'imic_get_cat_list' ) )
{
    function imic_get_cat_list( )
    {
        $amp_categories_obj = get_categories( 'exclude=1' );

        $amp_categories = array( );
        if ( count( $amp_categories_obj ) > 0 )
        {
            foreach ( $amp_categories_obj as $amp_cat )
            {
                $amp_categories[ $amp_cat->cat_ID ] = $amp_cat->name;
            }
        }
        return $amp_categories;
    }
}
