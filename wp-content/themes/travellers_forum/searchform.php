<form action="<?php echo home_url( '/' ); ?>" method="get">

	<div class="input-group add-on">
		<input type="text" name="s" id="search" placeholder="Search....." class="form-control" value="<?php the_search_query(); ?>" />
		<div class="input-group-btn">
			<button class="btn btn-default" id="searchsubmit" value="Search" type="submit"><i class="glyphicon glyphicon-search"></i></button>
		</div>
	</div>

    <div class="input-group">
        <div class="filters">
            <input type="checkbox" id="cb_post" name="post_type[]" value="post">News
        </div>
        <div class="filters">
            <input type="checkbox" id="cb_event_listing" name="post_type[]" value="event_listing">Events
        </div>
        <div class="filters">
            <input type="checkbox" id="cb_album" name="post_type[]" value="album">Galleries
        </div>
        <div class="filters">
            <input type="checkbox" id="cb_destination" name="post_type[]" value="destination">Destinations
        </div>
    </div>

</form>
