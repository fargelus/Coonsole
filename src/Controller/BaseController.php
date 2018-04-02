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
		$this->before();
	}

	protected function before()
	{

	}

	protected function after()
	{
		//Здесь мы собираем всякое говнецо
	}

	protected function render(string $view, array $parameters = [], Response $response = NULL): Response
	{
		$this->after();
		$parameters = array_merge($parameters, $this->_main, $this->_footer);
		return parent::render($view, $parameters, $response);
	}

	/**
	 * @param $name - Имя класса
	 *
	 * @return object
	 * @throws \ReflectionException
	 * @throws \Exception
	 */
	protected function getModel($name)
	{
		$model = '\App\Model\\'.ucfirst($name).'Model';
		if (!class_exists($model)) {
			throw new \Exception('Undefined model');
		}
		$result = new \ReflectionClass($model);

		return $result->newInstance();
	}
}