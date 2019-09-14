<?php
if (!current_user_can('edit_posts'))
{
	wp_redirect(get_home_url(), 301);
	exit();
}
?>

<?php

acf_form_head();

get_header();

?>
<div class="row">
    <div class="col-md-12">

        <div id="front_add_destination">

			<h2> <?php the_title(); ?> </h2>

	        <?php

	        acf_form(array(
	            'post_id'        => 'new_post',
	            'post_title'    => true,
	            'post_content'    => true,
	            'new_post'        => array(
	                'post_type'        => 'destination',
	                'post_status'    => 'publish'
	            ),
	            'submit_value'	=> 'Create',
	            'html_after_fields' => '<input type="hidden" name="acf[field_type]" value="destination"/>'
	        ));

	        ?>

    	</div>
    </div>
</div>

<?php get_footer(); ?>