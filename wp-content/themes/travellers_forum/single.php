<?php get_header(); ?>

<div class="row">
    <div class="col-md-12">

        <div class="single_post">

            <h2> <?php the_title(); ?> </h2>
            <div>
                <?php
                    $query   = get_post(get_the_ID());
                    $content = apply_filters('the_content', $query->post_content);

                    echo $content;
                ?>
            </div>

        </div>
    </div>
</div>

<?php comments_template(); ?>

<?php get_footer(); ?>