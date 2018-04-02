<?php
/**
 * Created by PhpStorm.
 * User: Victor
 * Date: 24.03.2018
 * Time: 19:04
 */

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

abstract class BaseController extends Controller
{
	private $_main = [];
	private $_footer = [];

	public function __construct()
	{
		//print_r();
	}

	protected function render(string $view, array $parameters = [], Response $response = NULL): Response
	{
		$parameters = array_merge($parameters, $this->_main, $this->_footer);
		return parent::render($view, $parameters, $response);
	}

	protected function getModel($name)
	{
		$model = $name.'Model';
		$result = FALSE;

		if (class_exists($model)) {
			$result = new $model;
		}

		return $result;
	}
}