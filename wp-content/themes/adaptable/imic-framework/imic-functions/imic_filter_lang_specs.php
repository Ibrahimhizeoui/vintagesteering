<?php

if ( !function_exists( 'imic_filter_lang_specs' ) )
{
    function imic_filter_lang_specs( $specs, $listing_terms = array( ) )
    {
        $new_specs = array( );
        if ( ( !empty( $specs ) ) && ( class_exists( 'SitePress' ) ) )
        {
            foreach ( $specs as $spec )
            {
                if ( !empty( $listing_terms ) )
                {
                    if ( class_exists( 'SitePress' ) && ICL_LANGUAGE_CODE == imic_langcode_post_id( $spec ) )
                    {
                        if ( has_term( $listing_terms, 'listing-category', $spec ) )
                        {
                            $new_specs[ ] = $spec;
                        }
                    }
                }
                else
                {
                    if ( class_exists( 'SitePress' ) && ICL_LANGUAGE_CODE == imic_langcode_post_id( $spec ) )
                    {
                        $new_specs[ ] = $spec;
                    }
                }
            }
        }
        else
        {
            if ( !empty( $listing_terms ) )
            {
                foreach ( $specs as $spec )
                {
                    if ( has_term( $listing_terms, 'listing-category', $spec ) )
                    {
                        $new_specs[ ] = $spec;
                    }
                }
            }
            else
            {
                $new_specs = $specs;
            }
        }
        return $new_specs;
    }
}
