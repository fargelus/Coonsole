<?php
/**
 * Created by PhpStorm.
 * User: Виктор
 * Date: 09.12.2017
 * Time: 1:49
 */

namespace App\Model;

use Doctrine\ORM\Mapping as ORM;

class NewsModel
{
    public function index()
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
        SELECT * FROM product p
        WHERE p.price > :price
        ORDER BY p.price ASC
        ';
        $stmt = $conn->prepare($sql);
        $stmt->execute(['price' => 10]);

    }
}