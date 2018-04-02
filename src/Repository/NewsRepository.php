<?php

namespace App\Repository;

use App\Entity\News;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ObjectRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class NewsRepository extends ServiceEntityRepository
{

    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, News::class);
    }


	/**
	 * @return int - Возвращает количество
	 * @throws \Doctrine\ORM\NoResultException
	 * @throws \Doctrine\ORM\NonUniqueResultException
	 */
	public function countAll(): int
    {
    	$builder = $this->createQueryBuilder('News');
    	$query = $builder->select('COUNT(News)');
    	$count = (int) $query->getQuery()->getSingleScalarResult();

        return $count;
    }


    /**
     * @param int $page - номер страницы
     * @return array
	 * @throws
     */
    public function getNewsperpage($page)
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = 'SELECT * FROM news n
        WHERE n.id >= :id
        ORDER BY n.id ASC LIMIT 10';
        $stmt = $conn->prepare($sql);
        $stmt->execute(['id' => (int)$page]);

        return $stmt->fetchAll();
    }
}
