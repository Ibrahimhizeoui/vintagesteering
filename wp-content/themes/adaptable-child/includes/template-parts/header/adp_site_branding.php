<?php global $imic_options; ?>

<h1>
    <?php
    if (!empty($imic_options['logo_upload']['url'])) {
        echo '<a href="' . esc_url( home_url() ) . '" title="' . get_bloginfo('name') . '" class="default-logo"><img src="' . $imic_options['logo_upload']['url'] . '" alt="Logo"></a>';
    } else {
        echo '<a href="' . esc_url( home_url() ) . '" title="' . get_bloginfo('name') . '" class="default-logo theme-blogname">'. get_bloginfo('name') .'</a>';
    }

    if (!empty($imic_options['retina_logo_upload']['url'])) {
        echo '<a href="' . esc_url( home_url() ) . '" title="' . get_bloginfo('name') . '" class="retina-logo"><img src="' . $imic_options['retina_logo_upload']['url'] . '" alt="Logo" width="' . $imic_options['retina_logo_width'] .'" height="' . $imic_options['retina_logo_height'] .'"></a>';
    } elseif (!empty($imic_options['logo_upload']['url'])) {
        echo '<a href="' . esc_url( home_url() ) . '" title="' . get_bloginfo('name') . '" class="retina-logo"><img src="' . $imic_options['logo_upload']['url'] . '" alt="Logo"></a>';
    } else {
        echo '<a href="' . esc_url( home_url() ) . '" title="' . get_bloginfo('name') . '" class="retina-logo theme-blogname">'. get_bloginfo('name') .'</a>';
    }
    ?>
</h1>
