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
use VK\OAuth\Scopes\VKOAuthUserScope;
use VK\OAuth\VKOAuth;
use VK\OAuth\VKOAuthDisplay;
use VK\OAuth\VKOAuthResponseType;

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
		//Если не авторизован, то выводим соц. сети
		if (empty($this->getUser())){
			$oauth = new VKOAuth();
			$browser_url = $oauth->getAuthorizeUrl(VKOAuthResponseType::CODE, VK_CLIENT_ID, VK_REDIRECT, VKOAuthDisplay::PAGE, [VKOAuthUserScope::WALL, VKOAuthUserScope::EMAIL], VK_CLIENT_SECRET);
			$this->_main['vk_link'] = $browser_url;
		};
		//$this->_main['user'] = $this->getUser();
		//print_r($this->_main['user']);
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