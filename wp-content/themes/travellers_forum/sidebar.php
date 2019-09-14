<div class="row">
	<div class="col-md-12">

		<h2><a href="<?php echo get_permalink( get_page_by_path( 'news' ) ); ?>">News</a></h2>

		<?php
		$args = array(
			'post_type' => 'post',
			'posts_per_page' => 5
		);

		$news = new WP_Query($args);
		?>

		<?php  if ($news->have_posts()): while($news->have_posts()): $news->the_post(); ?>

			<div class="news_bulletin">
				<h3><a href="<?php the_permalink(); ?>"><?php the_title() ?></a></h3>

                <div class="news_excerpt"><?php the_content() ;?></div>

				<?php
				if (get_the_post_thumbnail_url() === false)
				{
					$imgUrl = get_stylesheet_directory_uri() . '/images/noimage.jpg';
				}
				else
				{
					$imgUrl = get_the_post_thumbnail_url();
				}
				?>
                <div class="news_img">
				    <img class="feature_img" src="<?php echo $imgUrl; ?>">
                </div>
			</div>

		<?php endwhile; ?>
		<?php endif;?>

		<?php wp_reset_postdata(); ?>

	</div>
</div>
