<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Security\User\UserLoaderInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements UserInterface, \Serializable
{
	/**
	 * @ORM\Column(type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	private $id;

	/**
	 * @ORM\Column(type="string", length=60, unique=true)
	 */
	private $username;

	/**
	 * @ORM\Column(type="string", length=64)
	 */
	private $password;

	/**
	 * @ORM\Column(type="string", length=32)
	 */
	private $salt;

	/**
	 * @ORM\Column(name="is_active", type="boolean")
	 */
	private $isActive;

	/**
	 * @ORM\Column(type="string", length=1)
	 */
	private $role;

	/**
	 * @ORM\Column(type="datetime")
	 */
	private $date_created;

	public function __construct($username)
	{
		$this->isActive = TRUE;
		$this->username = $username;
		$this->role = APP_USER_USER;
		$this->salt = hash('haval128,3', (uniqid()));
		//$this->email = $email;
		//$this->password = crypt($pass, $this->getSalt());
		// may not be needed, see section on salt below
		// $this->salt = md5(uniqid('', true));
	}

	public function getUsername()
	{
		return $this->username;
	}

	public function getSalt()
	{
		// you *may* need a real salt depending on your encoder
		// see section on salt below
		return $this->salt;
	}

	public function getPassword()
	{
		return $this->password;
	}

	public function setPassword($password)
	{
		$this->password = $password;
	}

	public function getRoles()
	{
		return array('ROLE_USER');
	}

	public function getRole()
	{
		return $this->role;
	}

	public function eraseCredentials()
	{
	}

	/**
	 * @return int
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * @return bool
	 */
	public function getisActive()
	{
		return $this->isActive;
	}

	/**
	 * @param bool $isActive
	 */
	public function setIsActive($isActive): void
	{
		$this->isActive = $isActive;
	}
	
	/** @see \Serializable::serialize() */
	public function serialize()
	{
		return serialize(array(
			$this->id,
			$this->username,
			$this->password,
			// see section on salt below
			$this->salt,
			$this->getRoles(),
		));
	}

	/** @see \Serializable::unserialize() */
	public function unserialize($serialized)
	{
		list (
			$this->id,
			$this->username,
			$this->password,
			// see section on salt below
			$this->salt,
			$this->role,
			) = unserialize($serialized);
	}

}
