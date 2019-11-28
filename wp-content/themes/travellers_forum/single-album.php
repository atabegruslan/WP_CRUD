<?php acf_form_head(); ?>

<?php get_header(); ?>

<div class="row">
    <div class="col-md-12">

        <div class="single_post"> 

			<h2> <?php the_title(); ?> </h2>

			<div id="large_view_frame">
			    <img id="expandedImg">
			</div>

			<?php $images = get_field('gallery'); ?>

		    <ul class="bxslider">
				<?php foreach ($images as $image) : ?>

			        <li><img class="gallery_slide" src="<?php echo $image['url']; ?>" /></li>

				<?php endforeach; ?>
		    </ul>

			<?php if (current_user_can('edit_posts')): ?> 

				<div id="front_edit_gallery"> 

					<h3>Edit</h3>

					<?php acf_form(); ?>
					
				</div>

			<?php endif; ?>

        </div>
    </div>
</div>

<?php get_footer(); ?>