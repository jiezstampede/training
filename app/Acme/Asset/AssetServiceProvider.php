<?php

namespace Acme\Asset;

use Illuminate\Support\ServiceProvider;

class AssetServiceProvider extends ServiceProvider 
{
	public function register()
	{
		$this->app->bind('asset', '\Acme\Asset\Asset');
	}
}