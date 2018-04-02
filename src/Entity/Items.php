<?php

namespace App\Entity;

use App\Entity\MyId;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ItemsRepository")
 */
class Items
{
	use MyId;

    /**
     * @ORM\Column(type="string", length=60)
     */
    private $name;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

	/**
	 * @ORM\Column(type="text")
	 */
	private $list;

	/**
	 * @ORM\Column(type="text", nullable = true)
	 */
	private $photos;

    /**
     * @ORM\Column(type="string", length = 60)
     */
    private $link;

    /**
     * @ORM\Column(type="string", length = 15)
     */
    private $time_created;

    /**
     * @ORM\Column(type="string", length = 15)
     */
    private $time_updated;

	/**
	 * @ORM\Column(type="integer")
	 */
	private $authorId;

	public function __construct()
	{
		$this->time_created = time();
	}

	/**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }

	/**
	 * @param int $authorId
	 */
	public function setAuthorId($authorId): void
	{
		$this->authorId = $authorId;
	}

	/**
	 * @return mixed
	 */
	public function getList()
	{
		return $this->list;
	}

	/**
	 * @return mixed
	 */
	public function getPhotos()
	{
		return $this->photos;
	}

	/**
	 * @param string $photos
	 *
	 */
	public function setPhotos($photos)
	{
		$this->photos = empty($photos) ? : $photos;
	}

	/**
	 * @param string $list
	 */
	public function setList($list): void
	{
		$this->list = $list;
	}

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * @param mixed $link
     */
    public function setLink($link)
    {
        $this->link = $link;
    }

    /**
     * @return int
     */
    public function getTimeCreated()
    {
        return $this->time_created;
    }

    public function setTimeCreated($time)
	{
		//$this->time_created = $time;
	}

    /**
     * @return mixed
     */
    public function getTimeUpdated()
    {
        return $this->time_updated;
    }

    /**
     * @param mixed $time_updated
     */
    public function setTimeUpdated($time_updated)
    {
        $this->time_updated = $time_updated;
    }

    public function getAuthorId()
	{
		return $this->authorId;
	}


}
