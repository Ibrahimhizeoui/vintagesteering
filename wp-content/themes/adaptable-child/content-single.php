<?php $post_thumbid = get_post_thumbnail_id(); ?>
<?php $post_thumb = wp_get_attachment_image_src($post_thumbid, 'medium')[0]; ?>

<li class="grid-item post format-standard">
    <div class="grid-item-inner">
        <?php if (has_post_thumbnail(get_The_ID())): ?>
            <a href="<?php echo esc_url(get_permalink(get_the_ID()));?>" class="media-box" style="background-image: url('<?php echo $post_thumb; ?>');"></a>
        <?php endif; ?>

        <div class="grid-content">
            <div class="post-date"><?php echo get_the_date(); ?></div>
            <h3 class="post-title"><a href="<?php echo esc_url(get_permalink(get_the_ID())); ?>"><?php echo get_the_title();?></a></h3>
            <p class="post-text"><?php echo imic_excerpt(18); ?></p>
        </div>
    </div>
</li>
