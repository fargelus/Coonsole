<?php

namespace App\Helpers;

class Curl
{
	/**
	 * @var bool|resource
	 */
	private $_curl = FALSE;

	private $_counter = 0;

	private $_last_response;

	private $_with_headers;


	/**
	 * Иницилизация
	 * @param string $url
	 */
	public function init(string $url) : void
	{
		$this->_curl = curl_init($url);
		$this->_counter++;
		//базовые опции
		$this->option(CURLOPT_FOLLOWLOCATION, TRUE);
		$this->option(CURLOPT_HEADER, FALSE);
		$this->option(CURLOPT_RETURNTRANSFER, TRUE);
		$this->option(CURLOPT_SSL_VERIFYPEER, 0);
		$this->option(CURLOPT_SSL_VERIFYHOST, 0);
	}

	/**
	 * Отправка запроса
	 */
	public function exec() : void
	{
		if ($this->is_curl()) {
			$result = curl_exec($this->_curl);
			$headers = [];
			if ($this->_with_headers) {
				list($headers, $result) = $this->parse_response_with_headers($result);
			}
			$this->_last_response = [
				'result' => $result,
				'info' => curl_getinfo($this->_curl),
				'error' => curl_error($this->_curl),
				'errno' => curl_errno($this->_curl),
				'headers' => $headers
			];

			$this->close();
		} else {
			throw new Exceptions\Curl_Runtime(__METHOD__ . ' curl not initialized');
		}
	}

	public function result()
	{
		return $this->get('result');
	}

	public function info()
	{
		return $this->get('info');
	}

	public function error()
	{
		return $this->get('error');
	}

	public function errno()
	{
		return $this->get('errno');
	}

	public function headers()
	{
		return $this->get('headers');
	}

	private function get(string $key)
	{
		return isset($this->_last_response[$key]) ? $this->_last_response[$key] : FALSE;
	}

	/**
	 * @param int $key
	 * @param mixed $value
	 */
	public function option(int $key, $value)
	{
		if ($this->is_curl()) {
			curl_setopt($this->_curl, $key, $value);
		}
	}

	/**
	 * Инициализирован ли cURL
	 * @return bool
	 */
	private function is_curl() : bool
	{
		return (!empty($this->_curl) && is_resource($this->_curl));
	}

	public function close() : void
	{
		if ($this->is_curl()) {
			curl_close($this->_curl);
			$this->_curl = FALSE;
		}
	}

	/**
	 * Разбирает ответ на заголовки и тело
	 *
	 * @param string $response
	 * @return array
	 */
	protected function parse_response_with_headers($response) {
		list($header_str, $response) = explode("\r\n\r\n", $response, 2);

		// If you are doing a POST, and the content length is 1,025 or greater,
		// then curl exploits a feature of http 1.1: 100 (Continue) Status.
		// http://php.net/manual/en/function.curl-setopt.php#82418
		if($header_str === 'HTTP/1.1 100 Continue') {
			list($header_str, $response) = explode("\r\n\r\n", $response, 2);
		}

		$headers = [];
		$data = explode("\n", $header_str);
		$headers['status'] = trim($data[0]);
		array_shift($data);
		foreach($data as $part){
			$tmp = strstr($part, ':');
			$middle = [
				str_replace($tmp, '', $part),
				ltrim($tmp, ': ')
			];

			foreach ($middle as &$value) {
				$value = trim($value);
				if(empty($value)) {
					continue 2;
				}
			}
			unset($value);
			$middle[0] = strtolower(trim($middle[0]));
			// только для заголовка куки может быть несколько значений
			if ($middle[0] === 'set-cookie') {
				$headers[$middle[0]][] = trim($middle[1]);
			} else {
				$headers[$middle[0]] = trim($middle[1]);
			}
		}

		return [$headers, $response];
	}

	/**
	 * Проставляет опцию для возвращаения заголовков
	 * @param bool $with
	 */
	public function with_headers(bool $with)
	{
		$this->_with_headers = $with;
		$this->option(CURLOPT_HEADER, $this->_with_headers);
	}

}