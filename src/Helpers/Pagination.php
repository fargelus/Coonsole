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

	public function __construct($count, $max, $current_page = 1)
	{
		$this->_count = $count;
		$this->_max_per_page = $max;
		$this->_current_page = $current_page;
	}

	public function totalPages() {
		if ($this->_count > 0 && $this->_max_per_page > 0) {
			$result = (int) ceil($this->_count / $this->_max_per_page);
		} else {
			$result = 1;
		}

		return $result;
	}

	public function getStartId ($sort = 'DESC') {
		if ($sort === 'DESC') {
			$id = $this->_count - ($this->_current_page * $this->_max_per_page);
		} else {
			$id = ($this->_current_page - 1) * $this->_max_per_page;
		}

		return $id;
	}
}