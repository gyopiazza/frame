
<?php
    echo '<br>File (should be "content.php"): '.location('file');
?>

<div class="entry">
    <?php
        if (is_single()) :
            the_title( '<h1 class="entry-title">', '</h1>' );
        else :
            the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' );
        endif;
    ?>

    <div class="entry-content"><?php the_content(); ?></div>
</div><!-- .entry-header -->
