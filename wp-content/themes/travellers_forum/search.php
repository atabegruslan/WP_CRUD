<?php get_header(); ?>

<div class="row">
<div class="col-md-12">
<div id="search_results">

<h2><?php printf( __( 'Search Results for: %s' ), get_search_query()); ?></h2>

<?php  if (have_posts()): while(have_posts()): the_post(); ?>

	<?php
	if (get_the_post_thumbnail_url() !== false)
	{
		$imgUrl = get_the_post_thumbnail_url();
	}
	elseif (!is_null(get_event_banner()))
    {
		$imgUrl = get_event_banner();
    }
	else
	{
		$imgUrl = get_stylesheet_directory_uri() . '/images/noimage.jpg';
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
		'title' => get_the_title(),
		'post_type' => get_post_type()
	);

	if (get_post_type() === 'event_listing')
	{
		$date_format = WP_Event_Manager_Date_Time::get_event_manager_view_date_format();

		$displayData['varying_info']['start'] = date_i18n( $date_format, strtotime(get_event_start_date()) );
		$displayData['varying_info']['end'] = date_i18n( $date_format, strtotime(get_event_end_date()) );
		$displayData['varying_info']['location'] = (get_event_location()=='Anywhere') ? __('Online Event','wp-event-manager') : get_event_location();
	}
	else
	{
		$displayData['varying_info']['author'] = get_the_author();
		$displayData['varying_info']['created'] = get_the_date();
	}

	echo render_layout('entry-item.row', $displayData);
	?>

<?php endwhile; ?>

<?php wp_reset_postdata(); ?>

<?php else : ?>
	<h3>Nothing found</h3>
<?php endif; ?>

</div>
</div>
</div>

<?php get_footer(); ?>
