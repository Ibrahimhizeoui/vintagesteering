<?php

if ( !function_exists( 'imic_filter_lang_specs_admin' ) )
{
    function imic_filter_lang_specs_admin( $specs, $id )
    {
        $new_specs = array( );
        if ( ( !empty( $specs ) ) && ( class_exists( 'SitePress' ) ) )
        {
            foreach ( $specs as $spec )
            {
                if ( class_exists( 'SitePress' ) && imic_langcode_post_id( $id ) == imic_langcode_post_id( $spec ) )
                {
                    $new_specs[ ] = $spec;
                }
            }
        }
        else
        {
            $new_specs = $specs;
        }
        return $new_specs;
    }
}
