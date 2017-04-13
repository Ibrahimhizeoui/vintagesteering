<?php
global $imic_options;

$header_socialSites = $imic_options['header_social_links'];

foreach ($header_socialSites as $key => $value):
    if (filter_var($value, FILTER_VALIDATE_URL)):
        $string = substr($key, 3);
        echo '<li class="'.$string.'"><a href="' . esc_url($value) . '" target="_blank"><i class="fa ' . $key . '"></i></a></li>';
    endif;
endforeach; ?>
