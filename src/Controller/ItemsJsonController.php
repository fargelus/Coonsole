<?php

namespace App\Controller;

use App\Entity\Items;
use App\Entity\User;
use App\Repository\ItemsRepository;
use App\Model\ItemsModel;
use Doctrine\ORM\UnexpectedResultException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\ORM\EntityManagerInterface;
use App\Helpers\Pagination;

class ItemsJsonController extends ApiController
{
	/** @var int - Количество новостей на одной странице */
    protected $_max_count = 10;

	/**
	 * @Route("/json/items/")
	 *
	 * @return Response
	 */
    public function index()
    {
		/**@var ItemsRepository $repository */
		$repository = $this->getDoctrine()->getRepository(Items::class);

		try {
			$count = $repository->countAll();
		} catch (UnexpectedResultException $e) {
			$count = 0;
		}

		$pagination = new Pagination($count, $this->_max_count);
		$list = $repository->getList($pagination->getStartId());
		$result = [
			'news' => $list,
			'pagination' => $pagination->designData(),
		];

		return $this->respond($result);
    }
}