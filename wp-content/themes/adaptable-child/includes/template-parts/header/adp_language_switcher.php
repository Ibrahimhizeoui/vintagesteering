<?php
if (function_exists('pll_the_languages'))
{
    include(locate_template('includes/theme/adp-languages.php'));
    // get all languages
    $languages = adp_getPolyLanguages();
    // get the current language
    $currentLanguage = adp_getCurrentLanguage($languages);

    echo '<ul class="languageSwitcher__list">';
        if (isset($languages)) {
            echo adp_getCurrentLanguageHtml($currentLanguage);
            echo '<ul class="languageSwitcher__dropdown">';
                echo adp_getLanguagesHtml($languages);
            echo '</ul>';
        }
    echo '</ul>';
}
