<?php 

namespace Acme\Menu;

use Illuminate\Support\Collection;

class Menu
{
  public function active($item, $current)
  {		
  		$topItem="";
		if(strpos($current, "-")){
			$topItem = strtok($current, '-');
		}
		if ($item == $topItem || $item == $current) {
		      return 'in active ';
		}
  }
}