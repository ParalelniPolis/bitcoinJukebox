<?php

namespace App;

use Nette;
use Nette\Application\Routers\RouteList;
use Nette\Application\Routers\Route;


class RouterFactory
{

	/**
	 * @return Nette\Application\IRouter
	 */
	public static function createRouter()
	{
		$router = new RouteList;
		$router[] = new Route('admin[/<presenter>[/<action>[/<genre>]]]', [
			'module' => 'Modules:Admin',
			'presenter' => 'Dashboard',
			'action' => 'default',
			'genre' => NULL
		]);
		$router[] = new Route('<presenter>[/<action>[/<id>]]', [
			'module' => 'Modules:Front',
			'presenter' => 'Homepage',
			'action' => 'default',
			'id' => NULL
		]);
		return $router;
	}

}
