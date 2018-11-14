<?php

namespace Acme\SumoMail;

use Illuminate\Support\ServiceProvider;

class SumoMailServiceProvider extends ServiceProvider 
{
	public function register()
	{
		$this->app->bind('sumomail', '\Acme\SumoMail\SumoMail');
	}
}