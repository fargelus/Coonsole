<?php
/**
 * Created by PhpStorm.
 * User: Victor
 * Date: 07.04.2018
 * Time: 0:22
 */

namespace App\Security;

use App\Repository\UserRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\ControllerTrait;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use App\Entity\User;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;


class SocialUserProvider implements UserProviderInterface
{
	private $_em;

	public function __construct(EntityManagerInterface $em)
	{
		//print_r($em);
		$this->_em = $em;
		//$this->_container = $containter;
		//$this->_container = new EntityRepository();
	}

	public function supportsClass($class)
	{
		return User::class === $class;
	}

	public function loadUserByUsername($username)
	{
		$repository = $this->_em->getRepository(User::class);
		$result = $repository->findOneBy(['username' => $username]);
		return $result;
	}

	public function refreshUser(UserInterface $user)
	{
		if (!$user instanceof User) {
			throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', get_class($user)));
		}

		return $user;
	}
}