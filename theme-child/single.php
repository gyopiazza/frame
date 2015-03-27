<?php get_header(); ?>

<?php

global $template;
echo 'Child ' . basename($template);

?>

<?php
    while (have_posts()) : the_post();
        get_template_part('content', get_post_format());
    endwhile;
?>

<?php get_footer(); ?>
