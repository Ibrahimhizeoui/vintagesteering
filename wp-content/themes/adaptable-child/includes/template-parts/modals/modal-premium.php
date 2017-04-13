<?php
// Modal Settings here
$premiumContent = get_field('mc_premium_description', 'option'); ?>

<div id="premiumModal" class="zoom-anim-dialog mfp-hide modal-dialog modal-dialog--plain">
    <div class="modal-content">
        <div class="modal-body">
            <?php echo $premiumContent; ?>
        </div>
    </div>
</div>
