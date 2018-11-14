<?php

namespace Acme\General;

use Illuminate\Support\ServiceProvider;

class GeneralServiceProvider extends ServiceProvider 
{
	public function register()
	{
		$this->app->bind('general', '\Acme\General\General');
	}
}