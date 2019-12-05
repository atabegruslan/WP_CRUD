<div class="slide slide_entry">
    <div class="item_img">
        <img class="feature_img" src="<?php echo $displayData['img_url']; ?>" />
    </div>
    <div class="annotation">
        <a href="<?php echo $displayData['link']; ?>">
            <h3><?php echo $displayData['title']; ?></h3>
        </a>

        <?php if (isset($displayData['category']) && $displayData['category'] !== false): ?>
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

        <br>

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

        <br>

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

        <?php if (isset($displayData['varying_info']) && $displayData['varying_info'] !== false): ?>
            <?php foreach ($displayData['varying_info'] as $label => $field): ?>
                <p><strong><?php echo ucfirst($label); ?>: </strong><?php echo $field; ?></p>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>