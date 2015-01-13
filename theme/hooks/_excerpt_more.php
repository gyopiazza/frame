<?php

function frame_excerpt_more($more)
{
	return '…';
}

add_filter('excerpt_more', 'frame_excerpt_more');