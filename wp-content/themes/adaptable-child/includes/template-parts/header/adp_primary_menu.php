<?php
$menu_locations = get_nav_menu_locations();

if (!empty($menu_locations['primary-menu'])): ?>
    <div class=" dd-menu toggle-menu">
        <?php wp_nav_menu(array(
            'theme_location' => 'primary-menu',
            'container' => '',
            'items_wrap' => '<ul id="%1$s" class="sf-menu">%3$s</ul>',
            'walker' => new imic_mega_menu_walker)
        ); ?>
    </div>
<?php endif; ?>
