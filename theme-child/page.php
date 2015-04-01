<?php get_header(); ?>

<?php

echo 'Child <br>';
echo 'File (should be "page.php"): '.location('file');

?>

<?php
    while (have_posts()) : the_post();
        get_template_part('content');
    endwhile;
?>

<?php get_footer(); ?>
