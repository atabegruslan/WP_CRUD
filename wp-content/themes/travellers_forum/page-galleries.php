<?php get_header(); ?>

<?php
    $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
    $args  = array(
    	'post_type'      => 'album',
        'posts_per_page' => 3,
        'paged'          => $paged
    );

    $wp_query = new WP_Query($args);
?>

<?php  if ($wp_query->have_posts()): while($wp_query->have_posts()): $wp_query->the_post(); ?>

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
            'category' => get_the_terms($wp_query->ID, 'gallery'),
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

<div class="row">
    <div class="pagination">
        <?php wpex_pagination() ;?>
    </div>
</div>

<?php wp_reset_postdata(); ?>

<?php get_footer(); ?>