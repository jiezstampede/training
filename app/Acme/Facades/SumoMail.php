<?php

namespace Acme\Facades;

use Illuminate\Support\Facades\Facade;

class SumoMail extends Facade 
{
	protected static function getFacadeAccessor()
	{
		return 'sumomail';
	}
}