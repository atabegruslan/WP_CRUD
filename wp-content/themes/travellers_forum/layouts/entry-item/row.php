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

			<?php if (isset($displayData['varying_info'])):  ?>
				<?php foreach ($displayData['varying_info'] as $label => $field): ?>
					<p><strong><?php echo ucfirst($label); ?>: </strong><?php echo $field; ?></p>
				<?php endforeach; ?>
			<?php endif; ?>

			<p><?php echo $displayData['excerpt']; ?></p>
		</div>
	</a>
</div>