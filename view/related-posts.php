<!-- related-post-template.php -->
<div class="sr-related-post-container">
    <div class="post">
        <?php $get_related_posts->the_post_thumbnail() ? $get_related_posts->the_post_thumbnail() :'' ?>
        <a href="<?php the_permalink() ?>"><?php $get_related_posts->the_title() ?></a>
    </div>
</div>
