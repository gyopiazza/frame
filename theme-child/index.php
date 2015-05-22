<?php get_header(); ?>

<?php

echo 'Child <br>';
echo 'File (should be "index.php"): '.location('file');
echo '<br>';


?>

<?php while (have_posts()) : the_post(); ?>

<div class="entry">
    <?php the_title(sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>'); ?>
</div><!-- .entry-header -->

<?php endwhile; ?>

<?php get_footer(); ?>
