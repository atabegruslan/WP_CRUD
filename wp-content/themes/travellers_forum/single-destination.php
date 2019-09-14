<?php acf_form_head(); ?>

<?php get_header(); ?>

<div class="row">
    <div class="col-md-12">

        <div class="single_post">

            <h2> <?php the_title(); ?> </h2>

            <img class="feature_img" src="<?php echo get_the_post_thumbnail_url(); ?>" />

            <p><?php the_field('country'); ?></p>
            <p><?php the_field('city'); ?></p>

            <div>
                <?php
                $query   = get_post(get_the_ID());
                $content = apply_filters('the_content', $query->post_content);

                echo $content;
                ?>
            </div>

            <?php if (current_user_can('edit_posts')): ?> 

                <div id="front_edit_destination"> 

                    <h3>Edit</h3>

                    <?php acf_form(); ?>
                    
                </div>

            <?php endif; ?>

        </div>
    </div>
</div>

<?php get_footer(); ?>