<div class="row item_entry">
	<a href="<?php echo $displayData['link']; ?>">
		<div class="col-md-4 item_img">
	        <img class="feature_img" src="<?php echo $displayData['img_url'] ;?>" />
		</div>
		<div class="col-md-8 item_annotation">
			<h3><?php echo $displayData['title']; ?></h3>

			<?php if (isset($displayData['post_type'])):  ?>
				<div class="post_type">
					<?php
						$strTransl = array(
							'post' => 'News',
							'event_listing' => 'Event',
							'destination' => 'Destination',
							'album' => 'Gallery'
						);

						$bgColor = stringToColorCode(md5($displayData['post_type'])); 
						$typeLabel = $strTransl[$displayData['post_type']];
					?>

					<p style="background-color:<?php echo $bgColor; ?>;">
						<?php echo $typeLabel; ?>
					</p>
				</div>
			<?php endif; ?>

			<?php if (isset($displayData['category'])): ?>
	            <ul class="post-categories">
	                <?php foreach ($displayData['category'] as $category): ?>
	                    <li>
	                        <a href="<?php echo get_category_link($category->term_id); ?>">
	                            <?php echo $category->name; ?>
	                        </a>
	                    </li>
	                <?php endforeach; ?>
	            </ul>
	        <?php endif; ?>

			<?php if (isset($displayData['tags']) && $displayData['tags'] !== false): ?>
	            <ul class="post-tags">
	                <?php foreach ($displayData['tags'] as $tag): ?>
	                    <li>
	                        <a href="<?php echo get_tag_link($tag->term_id); ?>">
	                            <?php echo $tag->name; ?>
	                        </a>
	                    </li>
	                <?php endforeach; ?>
	            </ul>
	        <?php endif; ?>

	        <div class="author">
	            <strong>Author: </strong>
	            <a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>">
	                <?php echo get_the_author(); ?>
	            </a>
	        </div>

	        <div class="created">
	            <strong>Created: </strong>
	            <a href="<?php echo get_day_link(get_post_time('Y'), get_post_time('m'), get_post_time('j'));  ?>">
	                <?php the_time('jS') ?>
	            </a> 
	            <a href="<?php echo get_month_link(get_post_time('Y'), get_post_time('m'));  ?>">
	                <?php the_time('F') ?>
	            </a> 
	            <a href="<?php echo get_year_link(get_post_time('Y'));  ?>">
	                <?php the_time('Y') ?>
	            </a> 
	            <?php the_time('g:i a') ?>
	        </div>

			<?php if (isset($displayData['varying_info'])):  ?>
				<?php foreach ($displayData['varying_info'] as $label => $field): ?>
					<p><strong><?php echo ucfirst($label); ?>: </strong><?php echo $field; ?></p>
				<?php endforeach; ?>
			<?php endif; ?>

			<p><?php echo $displayData['excerpt']; ?></p>
		</div>
	</a>
</div>