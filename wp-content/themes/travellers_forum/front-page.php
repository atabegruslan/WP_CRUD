<?php get_header(); ?>

    <div class="row content_section">
        <div class="col-md-9">

            <div class="row">
                <div class="col-md-12">

                    <h2><a href="<?php echo get_permalink( get_page_by_path( 'destinations' ) ); ?>">Destinations</a></h2>

					<?php
					$destinationsArgs = array(
						'post_type' => 'destination'
					);

					$destinations = new WP_Query($destinationsArgs);
					?>

					<div id="destination_sliders">
	                    <ul class="bxslider destination">

							<?php if ($destinations->have_posts()): while($destinations->have_posts()): $destinations->the_post(); ?>
	                            <li>
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
										'category' => get_the_terms($destinations->ID, 'destination_category'),
										'title' => get_the_title(),
										'tags' => get_the_tags(get_the_ID(), 'post_tag'),
									);

									echo render_layout('entry-item.slide', $displayData);
									?>
	                            </li>
							<?php endwhile; ?>
							<?php endif;?>

	                    </ul>
                    </div>

					<?php wp_reset_postdata(); ?>

                </div>
            </div>

            <div class="row">
                <div class="col-md-12">

                    <h2><a href="<?php echo get_permalink( get_page_by_path( 'events' ) ); ?>">Events</a></h2>

					<?php
					$eventArgs = array(
						'post_type' => 'event_listing',
						'tax_query' => array(
                            'relation' => 'OR',
                            array(
                                'taxonomy' => 'event_listing_category',
                                'field' => 'slug', //can be set to ID
                                'terms' => 'trips' //if field is ID you can reference by cat/term number
                            ),
							array(
								'taxonomy' => 'event_listing_category',
								'field' => 'slug',
								'terms' => 'get_togethers'
							)
						)
					);

					$events = new WP_Query($eventArgs);
					?>
	
					<div id="event_sliders">
	                    <ul class="bxslider event">

							<?php if ($events->have_posts()): while($events->have_posts()): $events->the_post(); ?>
	                            <li>
									<?php
									if (get_event_banner() === false)
									{
										$imgUrl = get_stylesheet_directory_uri() . '/images/noimage.jpg';
									}
									else
									{
										$imgUrl = get_event_banner();
									}

									$date_format = WP_Event_Manager_Date_Time::get_event_manager_view_date_format();

									$displayData = array(
										'link' => get_event_permalink(),
										'img_url' => $imgUrl,
										'title' => get_the_title(),
										'varying_info' => array(
											'start' => date_i18n( $date_format, strtotime(get_event_start_date()) ),
											'end' => date_i18n( $date_format, strtotime(get_event_end_date()) ),
											'location' => (get_event_location()=='Anywhere') ? __('Online Event','wp-event-manager') : get_event_location()
										)
									);

									echo render_layout('entry-item.slide', $displayData);
									?>
	                            </li>
							<?php endwhile; ?>
							<?php endif;?>

	                    </ul>
                    </div>

					<?php wp_reset_postdata(); ?>

                </div>
            </div>

            <div class="row">
                <div class="col-md-12">

                    <h2><a href="<?php echo get_permalink( get_page_by_path( 'galleries' ) ); ?>">Galleries</a></h2>

					<?php
					$galleryArgs = array(
						'post_type' => 'album'
					);

					$gallery = new WP_Query($galleryArgs);
					?>

					<div id="gallery_sliders">
	                    <ul class="bxslider gallery">

							<?php if ($gallery->have_posts()): while($gallery->have_posts()): $gallery->the_post(); ?>
	                            <li>
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
										'category' => get_the_terms($gallery->ID, 'gallery'),
										'title' => get_the_title(),
									);

									echo render_layout('entry-item.slide', $displayData);
									?>
	                            </li>
							<?php endwhile; ?>
							<?php endif;?>

	                    </ul>
                    </div>

					<?php wp_reset_postdata(); ?>

                </div>
            </div>

        </div>
        <div class="col-md-3">

			<?php get_sidebar(); ?>

<!-- 			<div class="row">
				<div class="col-md-12"> -->
					<?php //dynamic_sidebar('news-sidebar'); ?>
<!-- 				</div>
			</div> -->

        </div>
    </div>

<?php get_footer(); ?>