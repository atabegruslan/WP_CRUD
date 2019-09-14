<?php 
	if (!current_user_can('edit_posts'))
	{
	    wp_redirect(get_home_url(), 301);
	    exit();
	}
?> 

<?php get_header(); ?>

<div class="row">
    <div class="col-md-12">

        <div>

			<h2> <?php the_title(); ?> </h2>

			<?php 
				 $args = array(
					'hierarchical'       => 1,
					'taxonomy'           => 'category',
					'name'               => 'category',
					'id'                 => 'category',
					'class'              => 'category form-control'
				); 
			?> 

			<form method="POST" enctype="multipart/form-data">

				<div class="form-group">
					<label for="title">Title</label>
					<input type="text" name="title" class="form-control" id="title">
				</div>
				<div class="form-group">
					<label for="contents">Contents</label>
					<textarea name="contents" id="contents"></textarea>
				</div>

				<div class="form-group">
					<label for="category">Category</label>
					<?php wp_dropdown_categories( $args ); ?>
				</div>

				<!--
				<div class="form-group">
					<label for="test_category">Test Category</label>
					<select class="form-control" id="test_category" name="test_category[]" multiple="multiple">
						<option value="test1">Test 1</option>
						<option value="test2">Test 2</option>
						<option value="test3">Test 3</option>
					</select>
				</div>

				<div class="form-group">
					<label for="test_time">Test Time</label>
					<div class='input-group date datetimepicker' id='test_datetimepicker'>
						<input type='text' class="form-control" name="test_time" id="test_time" />
						<span class="input-group-addon">
							<span class="glyphicon glyphicon-calendar"></span>
						</span>
					</div>
				</div>
				-->

				<div class="form-group">
					<label for="featured_image">Featured Image</label>
				    <input name="featured_image" id="featured_image" type="file" />
				</div>

				<?php wp_nonce_field( 'cpt_nonce_action', 'cpt_nonce_field' ); ?>

				<input type="submit" class="btn btn-default" value="Create">

			</form>

		</div>
	</div>
</div>

<?php get_footer(); ?>

<?php
if (isset( $_POST['cpt_nonce_field'] ) && wp_verify_nonce( $_POST['cpt_nonce_field'], 'cpt_nonce_action' ) )
{
	$args = array(
		'post_title'    => $_POST['title'],
		'post_content'  => $_POST['contents'],
		'post_type'     => 'post',
		'post_status'   => 'publish',
		'post_author'   => get_current_user_id(),
//		'meta_input' => array(
//	        'custom_field' => 'xxx'
//	    )
	);

	$news_id = wp_insert_post($args);

	// Category
	$taxonomy = 'category';
	//$termObj  = get_term_by( 'id', $_POST['category'], $taxonomy);
	//wp_set_object_terms($news_id, (int) $_POST['category'], $taxonomy);
    wp_set_post_terms($news_id, $_POST['category'], $taxonomy);

    // Featured Image
    require_once(ABSPATH . 'wp-admin/includes/image.php');
    require_once(ABSPATH . 'wp-admin/includes/file.php');
    require_once(ABSPATH . 'wp-admin/includes/media.php');

    $img_id = media_handle_upload('featured_image', 0);

    if (is_wp_error($img_id)) 
    {
		echo "Image Upload Error";
    } 
    else
    {
		//update_user_meta($news_id, 'featured_image', $img_id);
		add_post_meta($news_id, '_thumbnail_id', $img_id);
    }

	echo $news_id;
}
?>
