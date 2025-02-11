<div id="photo-info" class="photo-info">
    <div class="photo-info-left">
        <h2><?php the_title(); ?></h2>
        <p>Réf. : <?php echo get_field('reference'); ?></p>
        <p>Catégorie : <?php echo get_field('categorie'); ?></p>
        <p>Format : <?php echo get_field('format'); ?></p>
        <p>Date de prise de vue : <?php echo get_field('date'); ?></p>
    </div>
    <div class="photo-info-right">
        <img src="<?php echo get_field('fichier'); ?>" alt="<?php the_title(); ?>">
    </div>
    <div class="photo-info-bottom">
        <a href="#" id="contact-link" data-ref="<?php echo get_field('reference'); ?>">Contact</a>
        <div class="nav-links">
            <?php previous_post_link('%link', 'Précédent'); ?>
            <?php next_post_link('%link', 'Suivant'); ?>
        </div>
    </div>
</div>

<div class="nav-links">
    <?php 
        $prev_post = get_previous_post();
        $next_post = get_next_post();

        if ($prev_post) :
            $prev_thumbnail = get_field('fichier', $prev_post->ID);
    ?>
        <a href="<?php echo get_permalink($prev_post->ID); ?>" class="nav-link prev" data-thumb="<?php echo $prev_thumbnail; ?>">
            Précédent
        </a>
    <?php endif; ?>

    <?php if ($next_post) :
        $next_thumbnail = get_field('fichier', $next_post->ID);
    ?>
        <a href="<?php echo get_permalink($next_post->ID); ?>" class="nav-link next" data-thumb="<?php echo $next_thumbnail; ?>">
            Suivant
        </a>
    <?php endif; ?>
</div>
