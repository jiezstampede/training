<?php

namespace Acme\SumoImage;

use Illuminate\Support\ServiceProvider;

class SumoImageServiceProvider extends ServiceProvider 
{
	public function register()
	{
		$this->app->bind('sumoimage', '\Acme\SumoImage\SumoImage');
	}
}