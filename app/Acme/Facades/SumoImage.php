<?php

namespace Acme\Facades;

use Illuminate\Support\Facades\Facade;

class SumoImage extends Facade 
{
	protected static function getFacadeAccessor()
	{
		return 'sumoimage';
	}
}