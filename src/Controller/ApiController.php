<?php
/**
 * Created by PhpStorm.
 * User: Victor
 * Date: 24.07.2018
 * Time: 13:55
 */

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;

class ApiController extends BaseController
{
	/**
	 * @var int
	 */
	protected $_status_code = 200;

	/**
	 * @return int
	 */
	public function getStatusCode() : int
	{
		return $this->_status_code;
	}

	/**
	 * @param int $code
	 *
	 * @return $this
	 */
	public function setStatusCode(int $code) : ApiController
	{
		$this->_status_code = $code;

		return $this;
	}

	/**
	 * @param array $data
	 * @param array $headers
	 *
	 * @return JsonResponse
	 */
	public function respond(array $data, array $headers = []) : JsonResponse
	{
		return new JsonResponse($data, $this->getStatusCode(), $headers);
	}

	/**
	 * @param string $errors
	 * @param array $headers
	 *
	 * @return JsonResponse
	 */
	public function respondWithErrors(string $errors, array $headers = []) : JsonResponse
	{
		$data = [
			'errors' => $errors,
		];

		return $this->respond($data, $headers);
	}

	/**
	 * @param string $message
	 *
	 * @return JsonResponse
	 */
	public function respondUnauthorized(string $message = 'Unauthorized!') : JsonResponse
	{
		return $this->setStatusCode(401)->respondWithErrors($message);
	}

}