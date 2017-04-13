<?php

function adp_getPolyLanguages()
{
    // get all available languages in raw format with flag images
    return pll_the_languages(array(
        'raw'        => 1,
        'show_flags' => 1
    ));
}

/**
 * adp_getCurrentLanguage current language array data
 * @param  [array] $languages all site languages
 * @return [array] element with just out current language data
 */
function adp_getCurrentLanguage($languages)
{
    if (empty($languages)) return;

    // gets the current language in use
    $currentLanguageString = pll_current_language();

    return array_filter($languages, function($key){
        return $key['current_lang'] == true;
    })[$currentLanguageString];
}

/**
 * adp_getCurrentLanguageHtml description
 * @param  [array] $language data for our current language
 * @return [html] built <li>
 */
function adp_getCurrentLanguageHtml($language)
{
    if (empty($language)) return;

    // retriece css classes as string
    $lang_classes = implode(' ', $language['classes']) . ' ' . 'languageSwitcher__item';

    // build html
    $output = '';
    $output .= "<li class=\"{$lang_classes}\">";
        $output .= "<span hreflang=\"{$language['locale']}\" href=\"{$language['url']}\">";
            $output .= "<span class=\"languageSwitcher__text\">{$language['slug']}</span>";
        $output .= "</span>";
    $output .= "</li>";

    return $output;
}

/**
 * adp_getLanguagesHtml Loop through languages and get HTML
 * @param  [array] $languages array of languages
 * @return [html] built <li>'s
 */
function adp_getLanguagesHtml($languages)
{
    if (empty($languages)) return;

    foreach($languages as $language)
    {
        // don't output current language
        if ($language['current_lang'] == true) continue;

        // create string from clases
        $lang_classes = implode(' ', $language['classes']) . ' ' . 'languageSwitcher__item languageSwitcher__item--sub';

        $output = '';
        $output .= "<li class=\"{$lang_classes}\">";
            $output .= "<a hreflang=\"{$language['locale']}\" href=\"{$language['url']}\">";
                $output .= "<span class=\"languageSwitcher__text\">{$language['slug']}</span>";
            $output .= "</a>";
        $output .= "</li>";
    }

    return $output;
}
