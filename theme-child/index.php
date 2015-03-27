<?php get_header(); ?>

<?php

global $template;
echo 'Child ' . basename($template);

?>

<?php while (have_posts()) : the_post(); ?>

<div class="entry">
    <?php
        if (is_single()) :
            the_title( '<h1 class="entry-title">', '</h1>' );
        else :
            the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' );
        endif;
    ?>
</div><!-- .entry-header -->

<?php endwhile; ?>

<?php get_footer(); ?>
