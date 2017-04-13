<?php
// Modal Settings here
$approvalSealContent = get_field('mc_approval_seal_description', 'option'); ?>

<div id="approvalSealModal" class="zoom-anim-dialog mfp-hide modal-dialog modal-dialog--plain">
    <div class="modal-content">
        <div class="modal-body">
            <?php echo $approvalSealContent; ?>
        </div>
    </div>
</div>
