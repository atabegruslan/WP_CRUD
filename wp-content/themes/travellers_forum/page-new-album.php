<?php

acf_form_head();

get_header();

?>
<div class="row">
    <div class="col-md-12">

        <div id="front_create_gallery">

			<h2> <?php the_title(); ?> </h2>

	        <?php

	        acf_form(array(
	            'post_id'        => 'new_post',
	            'post_title'    => true,
	            'post_content'    => true,
	            'new_post'        => array(
	                'post_type'        => 'album',
	                'post_status'    => 'publish'
	            ),
	            'submit_value'	=> 'Create',
	            'html_after_fields' => '<input type="hidden" name="acf[field_type]" value="album"/>'
	        ));

	        ?>

    	</div>
    </div>
</div>

<?php get_footer(); ?>