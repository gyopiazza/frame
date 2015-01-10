<?php

//--------------------------------------------------------------------------------------------
// Useful functions to output reusable chunks of HTML in templates
//--------------------------------------------------------------------------------------------

/**
 * Output the pagination HTML
 *
 * @todo Cleanup
 * @param $pages The maximum amount of pages to display
 * @param $range 
 * @return string The pagination HTML
 */

function frame_pagination($pages = null, $range = 4)
{

    if ($pages === null) {
        global $wp_query;
        $pages = $wp_query->max_num_pages;
    }

    $showitems = ($range * 2) + 1;
    global $paged;
    if (empty($paged)) {
        $paged = 1;
    }

    if ($pages == '') {
        global $wp_query;
        $pages = $wp_query->max_num_pages;
        if (!$pages) {
            $pages = 1;
        }
    }

    if (1 != $pages) {
        echo '<ul class="pagination">' . PHP_EOL;

        if ($paged > 1) {
            // echo '<li class="pages-left"><a href="'.get_pagenum_link(1).'" title="'.__('First page','theme').'" id="p-first" class="first-page">&lt;&lt;</a> <a href="'.get_pagenum_link($paged - 1).'" title="'.__('Previous page','theme').'" id="p-prev" class="previous-page">&lt;</a></li>';
            echo '<li class="pages-left"><a href="' . get_pagenum_link($paged - 1) . '" title="' . __('Previous page', 'theme') . '" id="p-prev" class="previous-page"></a></li>';
        } else {
            // echo '<li class="pages-left"><span id="p-first" class="first-page">&lt;&lt;</span> <span id="p-prev" class="previous-page">&lt;</span></li>';
            echo '<li class="pages-left"><span id="p-prev" class="previous-page disabled"></span></li>';
        }

        for ($i = 1; $i <= $pages; $i++) {
            if (1 != $pages && (!($i >= $paged + $range + 1 || $i <= $paged - $range - 1) || $pages <= $showitems)) {
                // if( $i > 1 ) echo '<span class="p-separation">|</span>';
                echo ($paged == $i) ? '<li><span class="current p-num">' . $i . '</span></li>' : '<li><a href="' . get_pagenum_link($i) . '" class="p-num">' . $i . '</a></li>';
            }
        }

        if ($paged < $pages) {
            // echo '<li class="pages-right"><a href="'.get_pagenum_link($paged + 1).'" title="'.__('Next page','theme').'" id="p-next" class="next-page">&gt;</a> <a href="'.get_pagenum_link($pages).'" title="'.__('Última página','theme').'" id="p-last" class="last-page">&gt;&gt;</a></li>';
            echo '<li class="pages-right"><a href="' . get_pagenum_link($paged + 1) . '" title="' . __('Next page', 'theme') . '" id="p-next" class="next-page"></a></li>';
        } else {
            // echo '<li class="pages-right"><span id="p-next" class="next-page">&gt;</span> <span id="p-last" class="last-page">&gt;&gt;</span></li>';
            echo '<li class="pages-right"><span id="p-next" class="next-page"></span></li>';
        }

        echo '</ul>' . PHP_EOL;
    }
}