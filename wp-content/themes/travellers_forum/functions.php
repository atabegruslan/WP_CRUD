<?php

function my_register_styles()
{
	// Bootstrap
	wp_register_style( 'bs3_style', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css' );

	// Carousel
	wp_register_style( 'bxslider_style', 'https://cdnjs.cloudflare.com/ajax/libs/bxslider/4.2.15/jquery.bxslider.min.css' );

	// WISIWIG Editor Input
	wp_register_style( 'froala_editor', 'https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.9.4/css/froala_editor.css' );
	wp_register_style( 'froala_style', 'https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.9.4/css/froala_style.css' );
	wp_register_style( 'font_awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css' );

	// Calendar DateTime Input
	// wp_register_style( 'datetimepicker', '//cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/e8bddc60e73c1ec2475f827be36e1957af72e2ea/build/css/bootstrap-datetimepicker.css' );

	// Multi-Selector Input
	// wp_register_style( 'select2', 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/css/select2.min.css' );

	wp_register_style( 'front_style', get_template_directory_uri() . '/style.css' );
}
add_action('init', 'my_register_styles');

function my_enqueue_styles()
{
	wp_enqueue_style( 'front_style' );
	wp_enqueue_style( 'bs3_style' ); // Bootstrap
	wp_enqueue_style( 'bxslider_style' ); // Carousel

	if ( is_page('create-news') )
	{
		//WISIWIG Editor Input
		wp_enqueue_style( 'froala_editor' );
		wp_enqueue_style( 'froala_style' );
		wp_enqueue_style( 'font_awesome' );

		// Calendar DateTime Input
		// wp_enqueue_style( 'datetimepicker' );

		// Multi-Selector Input
		// wp_enqueue_style( 'select2' );
	}
}
add_action( 'wp_enqueue_scripts', 'my_enqueue_styles' );

function my_register_scripts()
{
	wp_register_script( 'front_script', get_template_directory_uri() . '/js/script.js' );

	// jQuery
	wp_register_script( 'jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js' );

	// Bootstrap
	wp_register_script( 'bs3_script', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js' );

	// Carousel
	wp_register_script( 'bxslider_script', 'https://cdnjs.cloudflare.com/ajax/libs/bxslider/4.2.15/jquery.bxslider.min.js' );

	//WISIWIG Editor Input
	wp_register_script( 'froala_editor', 'https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.9.4/js/froala_editor.min.js' );
	wp_register_script( 'font_awesome', 'https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.9.4/js/third_party/font_awesome.min.js' );

	// Calendar DateTime Input
	// wp_register_script( 'moment_locales', '//cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment-with-locales.js' );
	// wp_register_script( 'datetimepicker', '//cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/e8bddc60e73c1ec2475f827be36e1957af72e2ea/src/js/bootstrap-datetimepicker.js' );

	// Multi-Selector Input
	// wp_register_script( 'select2', 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.full.min.js' );

	// For mobiles
	wp_register_script( 'hammer', 'https://hammerjs.github.io/dist/hammer.js' );
}
add_action('init', 'my_register_scripts');

function my_enqueue_scripts()
{
	wp_enqueue_script( 'jquery' ); // jQuery
	wp_enqueue_script( 'bs3_script' ); // Bootstrap
	wp_enqueue_script( 'bxslider_script' ); // Carousel
	//if ( is_front_page() )
	//{
		wp_enqueue_script( 'front_script' );
	//}

	//WISIWIG Editor Input
	if ( is_page('create-news') )
	{
		//WISIWIG Editor Input
		wp_enqueue_script( 'froala_editor' );
		wp_enqueue_script( 'font_awesome' );

		// Calendar DateTime Input
		// wp_enqueue_script( 'moment_locales' );
		// wp_enqueue_script( 'datetimepicker' );

		// Multi-Selector Input
		// wp_enqueue_script( 'select2' );
	}

	// For mobiles
	wp_enqueue_script( 'hammer' );
}
add_action( 'wp_enqueue_scripts', 'my_enqueue_scripts' );

add_theme_support( 'menus' );

register_nav_menus(
	array(
		'uacmenu' => __('uac_menu_links'),
		'contentsmenu' => __('contents_menu_links'),
		'miscmenu' => __('misc_menu_links')
	)
);

add_theme_support( 'post-thumbnails' );
add_theme_support( 'category-thumbnails' );
add_theme_support( 'html5' );

remove_filter( 'the_content', 'wpautop' );
remove_filter( 'the_excerpt', 'wpautop' );

//Add gallery size
add_image_size('thumbnail-gallery','135','87',true);

// hide top admin bar when admin login
show_admin_bar( false );

function cpt_post_search($query)
{
	if ($query->is_search)
	{
		$post_type = $_GET['post_type'];

		if (empty($post_type))
		{
			$post_type = array( 'post', 'event_listing', 'album', 'destination' );
		}

		$query->set( 'post_type', $post_type );
	}

	return $query;
}
add_filter( 'pre_get_posts', 'cpt_post_search' );

function render_layout($layout, $displayData = array())
{
	$layout = str_replace('.', '/', $layout);
	$layout = __DIR__."/layouts/".$layout.".php";

	include($layout);
}

function customWidgetInit()
{
	register_sidebar(
		array(
			'name' => 'Sidebar',
			'id'   => 'news-sidebar'
		)
	);
}
add_action('widgets_init', 'customWidgetInit');

function stringToColorCode($str)
{
	$code = dechex(crc32($str));
	$code = substr($code, 0, 6);

	return $code;
}

function front_post_album_save_additional_fields($post_id)
{
	$post_type = $_POST['acf']['field_type'];

	if ($post_type === 'album')
	{
	    $image_id = $_POST['acf']['field_5d739bf8baba2'];
	    add_post_meta($post_id, '_thumbnail_id', $image_id);

	    $galleries = $_POST['acf']['field_5d739c206945c'];
	    //wp_set_post_categories($post_id, $galleries);
	    wp_set_post_terms($post_id, $galleries, 'gallery');
	}

	if ($post_type === 'destination')
	{
	    $image_id = $_POST['acf']['field_5d73f9f72b76a'];
	    add_post_meta($post_id, '_thumbnail_id', $image_id);

	    $destination_categories = $_POST['acf']['field_5d73fa1ca25d9'];
	    wp_set_post_terms($post_id, $destination_categories, 'destination_category');		
	}
}
add_action('acf/save_post', 'front_post_album_save_additional_fields', 10);

function dropdown_filter($output) 
{
    //$output = preg_replace( '/<select (.*?) >/', '<select $1 multiple>', $output);
    return $output;
}
add_filter('wp_dropdown_cats', 'dropdown_filter', 10, 2);

// Pagination
if (!function_exists('wpex_pagination'))
{	
	function wpex_pagination()
	{
		global $wp_query;

		$prev_arrow = is_rtl()
			? '<img src="' . get_template_directory_uri() . '/images/btn_back.png" alt="prev page" />'
			: '<img src="' . get_template_directory_uri() . '/images/btn_back.png" alt="prev page" />';
		$next_arrow = is_rtl()
			? '<img src="' . get_template_directory_uri() . '/images/btn_next.png" alt="next page" />'
			: '<img src="' . get_template_directory_uri() . '/images/btn_next.png" alt="next page" />';

		$big = 999999999; // need an unlikely integer

		// https://codex.wordpress.org/Pagination
		// https://codex.wordpress.org/Function_Reference/paginate_links
		// https://www.wpexplorer.com/pagination-wordpress-theme/

		$pages = paginate_links(
			array(
		        'base'      => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
		        'format'    => '?paged=%#%',
		        'current'   => max(1, get_query_var('paged')),
		        'total'     => $wp_query->max_num_pages,
		        'type'      => 'array',
				'prev_text'	=> $prev_arrow,
				'next_text' => $next_arrow,
	    	) 
	    );

	    if(is_array($pages))
	    {
        	$paged = (get_query_var('paged') == 0) ? 1 : get_query_var('paged');

        	echo '<ul class="page-numbers">';

	        foreach ($pages as $page)
	        {
	        	echo "<li>$page</li>";
	        }

			echo '</ul>';
        }
	}
}
