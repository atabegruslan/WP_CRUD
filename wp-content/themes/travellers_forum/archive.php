<?php get_header(); ?>

<div class="row">
	<div class="col-md-12">

		<h1><?php echo get_the_archive_title(); ?></h1>

		<?php if (is_tag()): ?>

			<h2>Tag Archive: <?php echo single_tag_title(); ?></h2>

		<?php elseif (is_author()): ?>

			<?php 
				$curauth = ( get_query_var( 'author_name' ) ) 
					? get_user_by( 'slug', get_query_var( 'author_name' ) ) 
					: get_userdata( get_query_var( 'author' ) ); 
			?>

			<h2>Author Archive: <?php echo $curauth->nickname; ?></h2>

		<?php elseif (is_day()): ?>

			<h2>
				Day Archive: 
				<?php 
					echo get_query_var('year') . ' ' 
						. $GLOBALS['wp_locale']->get_month(get_query_var('monthnum')) . ' '
						. get_query_var('day'); 
				?>
			</h2>

		<?php elseif (is_month()): ?>

			<h2>
				Month Archive: 
				<?php echo get_query_var('year') . ' ' . $GLOBALS['wp_locale']->get_month(get_query_var('monthnum')); ?>
			</h2>

		<?php elseif (is_year()): ?>

			<h2>Year Archive: <?php echo get_query_var('year'); ?></h2>

			<?php
				/*
				$args = array(
					'type'      => 'yearly',
				    'post_type' => array( 'post', 'event_listing', 'album', 'destination' ),
				    'year'      => get_query_var('year'),
				);
				$wp_query = new WP_Query($args); 
				*/
			?>

		<?php else: ?>

			<h2><?php single_cat_title(); ?></h2>

			<?php 
				$obj = get_queried_object();

				$args = array(
					'post_type' => get_post_type(),
					'post_status' => 'publish',
					'posts_per_page' => 8,
					'orderby' => 'title',
					'order' => 'ASC',
					'tax_query' => array(
						array(
							'taxonomy' => $obj->taxonomy,
							'field' => 'term_id',
							'terms' => $obj->term_id,
						)
					)
				);

				$wp_query = new WP_Query( $args );
			?>

		<?php endif; ?>

		<?php if ($wp_query->have_posts()): while($wp_query->have_posts()): $wp_query->the_post(); ?>

			<?php
				if (get_the_post_thumbnail_url() === false)
				{
					$imgUrl = get_stylesheet_directory_uri() . '/images/noimage.jpg';
				}
				else
				{
					$imgUrl = get_the_post_thumbnail_url();
				}

				$termToTaxTransl = array(
					'post' => 'category',
					'event_listing' => 'event_listing_category',
					'destination' => 'destination_category',
					'album' => 'gallery'
				);

				$displayData = array(
					'link' => get_the_permalink(),
					'img_url' => $imgUrl,
					'category' => get_the_terms(get_the_ID(), $termToTaxTransl[get_post_type()]),
					'tags' => get_the_tags(get_the_ID(), 'post_tag'),
					'title' => get_the_title(),
				);

				echo render_layout('entry-item.row', $displayData);
			?>

		<?php endwhile;endif; ?>

		<?php wp_reset_postdata(); ?>

	</div>
</div>

<?php get_footer(); ?>
