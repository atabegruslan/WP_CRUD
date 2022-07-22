<?php

/*
Plugin Name: Queue Task
Plugin URI:  
Description: Queue Task
Version:     1.0
Author:      Ruslan Aliyev
Author URI:  
License:     License
License URI: 
*/

require_once 'BackgroundProcessExample.php';

add_action('init', 'process_handler');
function process_handler() 
{
	$background_process = new BackgroundProcessExample();

	// Add items to the queue.
	$counter = 0;
	do 
	{
		$counter ++;
		$background_process->push_to_queue( $counter );
	} 
	while ( $counter < 10 );

	// Start the queue.
	$background_process->save()->dispatch();
}
