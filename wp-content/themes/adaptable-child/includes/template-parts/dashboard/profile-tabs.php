<div class="tabs profile-tabs">
    <ul class="nav nav-tabs">
        <li class="active"> <a data-toggle="tab" href="#personalinfo" aria-controls="personalinfo" role="tab"><?php echo esc_attr_e('Personal Info', 'adaptable-child'); ?></a></li>
        <li> <a data-toggle="tab" href="#socialinfo" aria-controls="socialinfo" role="tab"><?php echo esc_attr_e('Social Info', 'adaptable-child'); ?></a></li>
        <li> <a data-toggle="tab" href="#billinginfo" aria-controls="billinginfo" role="tab"><?php echo esc_attr_e('Billing Info', 'adaptable-child'); ?></a></li>
        <li> <a data-toggle="tab" href="#changepassword" aria-controls="changepassword" role="tab"><?php echo esc_attr_e('Change Password', 'adaptable-child'); ?></a></li>
    </ul>
    <form action="" method="post" enctype="multipart/form-data">
        <div class="tab-content">
            <?php
            // personal info tab
            include('profile-tab-personal.php');

            // social info tab
            include('profile-tab-social.php');

            // billing info tab
            include('profile-tab-billing.php');

            // change password tab
            include('profile-tab-change-password.php');
            ?>
        </div>
        <div class="tab-submission">
            <button type="submit" class="button button--black"><?php echo esc_attr_e('Update details', 'adaptable-child'); ?></button>
        </div>
    </form>
</div>
