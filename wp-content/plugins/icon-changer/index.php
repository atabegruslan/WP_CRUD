<?php

/*
Plugin Name: Icon Changer
Plugin URI:  https://github.com/atabegruslan/WP-Template-Plugin_MyPortfolioBlog
Description: Change icons in Dashboard
Version:     1.0
Author:      Ruslan Aliyev
Author URI:  https://github.com/atabegruslan/WP-Template-Plugin_MyPortfolioBlog
License:     License
License URI: https://github.com/atabegruslan/WP-Template-Plugin_MyPortfolioBlog
*/

function change_cpt_dashicon()
{
	// Method 1 - https://developer.wordpress.org/resource/dashicons/

	/*
	?>

		<style>
			#adminmenu #menu-posts-work div.wp-menu-image::before
			{
				content: "\f161";
			}
		</style>

	<?php
	*/

	// Method 2 - https://gist.github.com/chuckreynolds/527537909ce945aa1382

	global $menu;

	foreach ($menu as $id => $menuItem)
	{
		if (strcmp($menuItem[0], 'Albums') === 0)
		{
			$menu[$id][6] = 'dashicons-format-gallery';
		}

		if (strcmp($menuItem[0], 'Destinations') === 0)
		{
			$menu[$id][6] = 'dashicons-admin-site-alt';
		}
	}
}

add_action('admin_head', 'change_cpt_dashicon');

function correct_english_plurals()
{
	global $menu;

	foreach ($menu as $id => $menuItem)
	{
		if (strcmp($menuItem[0], 'Gallerys') === 0)
		{
			$menu[$id][0] = 'Galleries';
		}
	}
}

add_action('admin_menu', 'correct_english_plurals');

function title_to_upper($title)
{
	$title = strtoupper($title);

	return $title;
}

add_filter('the_title', 'title_to_upper');