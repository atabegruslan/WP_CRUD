<?php wp_head(); ?>

<div class="container">

    <div class="row" id="header_1">
        <div class="col-md-6">
			<?php
			$args = array(
				'theme_location' => 'miscmenu',
				'menu_class' => 'misc_menu'
			);
			wp_nav_menu($args);
			?>
        </div>
        <div class="col-md-6">
            <?php
            $args = array(
                'theme_location' => 'uacmenu',
                'menu_class' => 'uac_menu'
            );
            wp_nav_menu($args);
            ?>
        </div>
    </div>

    <div class="row" id="header_2">
		<?php get_search_form(); ?>
    </div>

    <div class="row" id="header_3">
        <div class="col-md-12">
            <?php
            $args = array(
                'theme_location' => 'contentsmenu',
                'menu_class' => 'contents_menu'
            );
            wp_nav_menu($args);
            ?>
        </div>
    </div>