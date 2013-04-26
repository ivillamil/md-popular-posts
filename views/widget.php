<ul class="block nom nop nol clearfix" role="tabs">
    <li><a href="#leido" class="plus active" data-content="leido">Leido</a></li>
    <li><a href="#comentado" class="plus" data-content="comentado">Comentado</a></li>
</ul>

<div class="" data-content="leido">
    <ul class="nom nol nop sidelist active pdd1">
    <?php while($popular_views->have_posts()) : $popular_views->the_post(); ?>
        <li class="block ribbon <?php echo md_get_category_class( get_the_ID() ) ?>">
            <a href="<?php the_permalink() ?>" title="<?php echo esc_attr( get_the_title() ) ?>"><?php the_title() ?></a>
        </li>
    <?php endwhile; ?>
    </ul>
</div>

<div class="" data-content="comentado">
    <ul class="nom nol nop sidelist pdd1">
    <?php while($popular_comments->have_posts()) : $popular_comments->the_post(); ?>
        <li class="block ribbon <?php echo md_get_category_class( get_the_ID() ) ?>">
            <a href="<?php the_permalink() ?>" title="<?php echo esc_attr( get_the_title() ) ?>"><?php the_title() ?></a>
        </li>
    <?php endwhile; ?>
    </ul>
</div>