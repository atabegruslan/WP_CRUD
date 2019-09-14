    <div class="row" id="footer">
        <div class="col-md-12">
            <?php
            $args = array(
                'theme_location' => 'miscmenu',
                'menu_class' => 'misc_menu'
            );
            wp_nav_menu($args);
            ?>
        </div>
    </div>

</div>

<?php wp_footer();  ?>