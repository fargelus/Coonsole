<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

trait MyId
{
	/**
	 * @ORM\Id
	 * @ORM\GeneratedValue
	 * @ORM\Column(type="integer")
	 */
	private $id;

	/**
	 * @return mixed
	 */
	public function getId()
	{
		return $this->id;
	}
}