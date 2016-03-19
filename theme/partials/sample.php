<?php

/**
 * Sample partial file
 *
 * Demo of a basic slider
 *
 * @package frame
 */

/**
 * Usage:
 *
 * frame_partial('sample', array(
 *     'interval' => 2000
 *     'slides' => array(
 *         array('Image 1', 'http://...'),
 *         array('Image 2', 'http://...'),
 *         array('Image 3', 'http://...')
 *     )
 * ));
 */



?>

<div class="slider">
    <?php foreach($slides as $title => $image): ?>
        <div class="slide">
            <img src="<?php echo $image; ?>" alt="<?php echo $title; ?>">
        </div>
    <?php endforeach; ?>
</div>
