<?php

namespace App\Entity;

use App\Entity\MyId;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\NewsRepository")
 */
class News
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


    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
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
     * @return mixed
     */
    public function getTimeCreated()
    {
        return $this->time_created;
    }

    /**
     * @param mixed $time_created
     */
    public function setTimeCreated($time_created)
    {
        $this->time_created = $time_created;
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
