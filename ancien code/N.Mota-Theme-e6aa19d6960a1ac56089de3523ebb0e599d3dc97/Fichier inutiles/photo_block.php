<div class="photo-block">
    <?php if ( has_post_thumbnail() ) : ?>
        <a href="<?php the_permalink(); ?>">
            <?php the_post_thumbnail( 'medium', ['class' => 'photo-thumbnail'] ); ?>
        </a>
    <?php endif; ?>
    <h3><?php the_title(); ?></h3>
</div>
