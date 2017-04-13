<?php

/**
 * Controls a simple text based layout through wysiwyg editor
 * Available ACF Objects
 * editor
 */

$editor = get_sub_field('editor');
?>

<section class="pageContent__row pageContent__wysiwyg wysiwygEditor">
    <div class="container">
        <div class="row">
            <?php echo $editor; ?>
        </div>
    </div>
</section>
