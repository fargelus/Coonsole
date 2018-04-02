<?php

namespace App\Repository;

use App\Entity\Items;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ObjectRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class ItemsRepository extends ServiceEntityRepository
{

    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Items::class);
    }


	/**
	 * @return int - Возвращает количество
	 * @throws \Doctrine\ORM\NoResultException
	 * @throws \Doctrine\ORM\NonUniqueResultException
	 */
	public function countAll(): int
    {
    	$builder = $this->createQueryBuilder('Items');
    	$query = $builder->select('COUNT(Items)');
    	$count = (int) $query->getQuery()->getSingleScalarResult();

        return $count;
    }


    /**
     * @param int $page - номер страницы
     * @return array
	 * @throws
     */
    public function getItemsperpage($page)
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = 'SELECT * FROM items n
        WHERE n.id >= :id
        ORDER BY n.id ASC LIMIT 10';
        $stmt = $conn->prepare($sql);
        $stmt->execute(['id' => (int)$page]);

        return $stmt->fetchAll();
    }
}
