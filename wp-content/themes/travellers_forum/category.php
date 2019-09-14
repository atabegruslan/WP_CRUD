<?php get_header(); ?>

<h1><?php single_cat_title(); ?></h1>

<?php 

	$category = get_queried_object();

	$args = array( 
		'post_type' => 'post',
		'post_status' => 'publish',
		'posts_per_page' => 8,
		'orderby' => 'title',
		'order' => 'ASC',
		'tax_query' => array(
		    array(
		        'taxonomy' => 'category',
		        'field'    => 'term_id',
		        'terms'    => $category->term_id,
		        ),
		    ),
	);

	$the_query = new WP_Query( $args );

?>

<?php if ($the_query->have_posts()): while($the_query->have_posts()): $the_query->the_post(); ?>

	<?php
	if (get_the_post_thumbnail_url() === false)
	{
		$imgUrl = get_stylesheet_directory_uri() . '/images/noimage.jpg';
	}
	else
	{
		$imgUrl = get_the_post_thumbnail_url();
	}

	$displayData = array(
		'link' => get_the_permalink(),
		'img_url' => $imgUrl,
		//'category' => get_the_terms($the_query->ID, get_post_type()),
		'title' => get_the_title(),
		'varying_info' => array(
			'author' => get_the_author(),
			'created' => get_the_date()
		)
	);

	echo render_layout('entry-item.row', $displayData);
	?>

<?php endwhile; ?>
<?php endif;?>

<?php wp_reset_postdata(); ?>

<?php get_footer(); ?>