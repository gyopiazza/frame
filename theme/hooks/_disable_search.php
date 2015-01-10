<?php

function frame_disable_search($query, $error = true)
{
	if (is_search())
	{
		$query->is_search = false;
		$query->query_vars['s'] = false;
		$query->query['s'] = false;

		if ($error == true) $query->is_404 = true;
	}
}

add_action('parse_query', 'frame_disable_search');
add_filter('get_search_form', create_function('$a', "return null; ));