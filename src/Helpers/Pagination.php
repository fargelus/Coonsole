<?php

namespace App\Helpers;

/**
 * Class Pagination
 * Class for calculate stuff, linked with pagination
 */
class Pagination
{
	private $_current_page;
	private $_max_per_page;
	private $_count;

	/**
	 * Pagination constructor.
	 *
	 * @param int $count
	 * @param int $max
	 * @param int $current_page
	 */
	public function __construct(int $count, int $max, int $current_page = 1)
	{
		$this->_count = $count;
		$this->_max_per_page = $max;
		$this->_current_page = $current_page;
	}

	/**
	 * Количество всех страниц
	 * @return int
	 */
	public function totalPages() : int
	{
		if ($this->_count > 0 && $this->_max_per_page > 0) {
			$result = (int) ceil($this->_count / $this->_max_per_page);
		} else {
			$result = 1;
		}

		return $result;
	}

	/**
	 * @param string $sort
	 *
	 * @return int
	 */
	public function getStartId(string $sort = 'DESC') : int
	{
		if ($sort === 'DESC') {
			$id = $this->_count - ($this->_current_page * $this->_max_per_page);
		} else {
			$id = ($this->_current_page - 1) * $this->_max_per_page;
		}

		return ($id < 0) ? 0 : (int) $id;
	}

	/**
	 * @return array
	 */
	public function designData() : array
	{
		return $data = [
			'current_page' => $this->_current_page,
			'total_pages' => $this->totalPages(),
		];
	}
}