<?php

/**
 * Filter Yoast SEO Metabox Priority
 */

function base_filter_yoast_seo_metabox()
{
	return 'low';
}

add_filter('wpseo_metabox_prio', 'base_filter_yoast_seo_metabox');
