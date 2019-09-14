<div class="slide slide_entry">
    <a href="<?php echo $displayData['link']; ?>">
        <div class="item_img">
            <img class="feature_img" src="<?php echo $displayData['img_url']; ?>" />
        </div>
        <div class="annotation">
            <h3><?php echo $displayData['title']; ?></h3>

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
            <br>
            <?php endif; ?>

            <?php foreach ($displayData['varying_info'] as $label => $field): ?>
                <p><strong><?php echo ucfirst($label); ?>: </strong><?php echo $field; ?></p>
            <?php endforeach; ?>
        </div>
    </a>
</div>