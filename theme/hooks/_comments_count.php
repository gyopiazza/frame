<?php

function frame_comments_count($count)
{
	if (!is_admin())
	{
		global $id;
		$comments_by_type = separate_comments(get_comments('status=approve&post_id=' . $id));
		return count($comments_by_type['comment']);
	}
	else
	{
		return $count;
	}
}

add_filter('get_comments_number', 'frame_comments_count', 0);