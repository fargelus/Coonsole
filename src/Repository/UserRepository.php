<?php

namespace App\Repository;

use Symfony\Bridge\Doctrine\Security\User\UserLoaderInterface;
use Doctrine\ORM\EntityRepository;

class UserRepository extends EntityRepository implements UserLoaderInterface
{
    public function loadUserByUsername($username)
	{
		//print_r($username);
		//die();
		/*
		$builder = $this->createQueryBuilder('User');
		$builder->select('*');
		$builder->where('username = :value')->setParameter('value', $username);
		$result = $builder->getQuery()->getOneOrNullResult();
    	return $result;*/
		//print_r('aga');
		return $this->createQueryBuilder('u')
			->where('u.username = :username')
			->setParameter('username', $username)
			->getQuery()
			->getOneOrNullResult();
	}
/*
	public function findbyId ($id)
	{
		$builder = $this->createQueryBuilder('User');
		$builder->select('*');
		$builder->where('id = :value')->setParameter('value', $id);
		$result = $builder->getQuery()->getOneOrNullResult();
		return $result;
	}

	public function findbyEmail ($email)
	{
		$builder = $this->createQueryBuilder('User');
		$builder->select('*');
		$builder->where('email = :value')->setParameter('value', $email);
		$result = $builder->getQuery()->getOneOrNullResult();
		return $result;
	}*/

    /*
    public function findBySomething($value)
    {
        return $this->createQueryBuilder('u')
            ->where('u.something = :value')->setParameter('value', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */
}
