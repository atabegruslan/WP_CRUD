<?php get_header(); ?>

<div class="row">
	<div class="col-md-12">

		<?php if (is_category()): ?>

			<div id="archive_category">
				<p>archive_category</p>
			</div>

		<?php elseif (is_tag()): ?>

			<div id="archive_tag">
				<p>archive_tag</p>
			</div>

		<?php elseif (is_author()): ?>

			<div id="archive_author">
				<p>archive_author</p>
			</div>

		<?php elseif (is_day()): ?>

			<div id="archive_day">
				<p>archive_day</p>
			</div>

		<?php elseif (is_month()): ?>

			<div id="archive_month">
				<p>archive_month</p>
			</div>

		<?php elseif (is_year()): ?>

			<div id="archive_year">
				<p>archive_year</p>
			</div>

		<?php else: ?>

			<div id="archive_others">

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

				<?php endwhile; ?>
				<?php endif;?>

				<?php wp_reset_postdata(); ?>
			</div>

		<?php endif; ?>

	</div>
</div>

<?php get_footer(); ?>
