<head>
    <title><?php wp_title('|', true, 'right'); ?><?php bloginfo('name'); ?></title>

    <meta charset="<?php bloginfo('charset'); ?>" />

    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0">
    <meta name="format-detection" content="telephone=no">

    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

    <?php if (isset($options['custom_favicon']) && $options['custom_favicon'] != "") { ?>
        <link rel="shortcut icon" href="<?php echo esc_url($options['custom_favicon']['url']); ?>" />
    <?php }
    wp_head(); ?>
</head>
