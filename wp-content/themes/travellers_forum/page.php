<?php get_header(); ?>

    <div class="row">
        <div class="col-md-12">

            <div id="post_new_event">

				<?php  if (have_posts()): while(have_posts()): the_post(); ?>

                    <h2><?php the_title() ?></h2>
					<?php the_content() ;?>

					<?php the_post() ;?>

				<?php endwhile; ?>
				<?php endif;?>

				<?php wp_reset_postdata(); ?>

            </div>

        </div>
    </div>

<?php get_footer(); ?>
