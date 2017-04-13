<?php

$formSettings = [
    'id' => 7,
    'title' => false,
    'description' => false,
    'display_inactive' => true,
    'field_values' => null,
    'ajax' => true,
    'echo' => true
];
?>

<div class="modal fade" id="infoModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4><?php echo esc_attr_e('Contact The Seller', 'adaptable-child'); ?></h4>
            </div>
            <div class="modal-body modalRequestInfo">
                <?php gravity_form(
                    $formSettings['id'],
                    $formSettings['title'],
                    $formSettings['description'],
                    $formSettings['display_inactive'],
                    $formSettings['field_values'],
                    $formSettings['ajax'],
                    $formSettings['echo']
                ); ?>
            </div>
        </div>
    </div>
</div>
