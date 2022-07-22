<?php

require_once 'vendor/autoload.php';

class BackgroundProcessExample extends WP_Background_Process 
{
	protected $action = 'custom_background_process';

	protected function task($item) 
	{
		error_log('custom_background_process');
		error_log($item);
		sleep(5);

		return false;
	}

	protected function complete() 
	{
		parent::complete();
	}
}
