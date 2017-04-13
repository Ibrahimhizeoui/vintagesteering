<?php
/**
 * Controls a half/half text/video block on single pages.
 * Available Objects
 * content_overview
 * content_info
 * content_video
 */

$overview = get_sub_field('content_overview');
$info     = get_sub_field('content_info');
$video    = get_sub_field('content_video');
?>

<?php if (!empty($overview) && !empty($info)): ?>
    <section class="pageContent__row pageContent__standardBlock standardBlock">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h1><?php echo $overview; ?></h1>
                    <div class="wysiwyg">
                        <?php echo $info; ?>
                    </div>
                </div>
                <div class="col-md-6">
                    <?php echo $video; ?>
                </div>
            </div>
        </div>
    </section>
<?php endif; ?>
