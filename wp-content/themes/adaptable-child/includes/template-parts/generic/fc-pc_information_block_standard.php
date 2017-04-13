<?php
/**
 * Controls a standard half/half text/text block on single pages.
 *
 * Available Objects
 * content_overview
 * content_info
 */

$overview = get_sub_field('content_overview');
$info = get_sub_field('content_info');
?>

<?php if (!empty($overview) && !empty($info)): ?>
    <section class="pageContent__row pageContent__standardBlock standardBlock">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h1><?php echo $overview; ?></h1>
                </div>
                <div class="col-md-6">
                    <?php echo $info; ?>
                </div>
            </div>
        </div>
    </section>
<?php endif; ?>
