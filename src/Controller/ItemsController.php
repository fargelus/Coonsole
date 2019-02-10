<?php

namespace App\Controller;

use App\Entity\Items;
use App\Entity\User;
use App\Repository\ItemsRepository;
use App\Model\ItemsModel;
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

class ItemsController extends BaseController
{
	/** @var int - Количество товаров на одной странице */
    protected $_max_count = 2;

	/**
	 * @Route("/")
	 * @Route("/items/")
	 *
	 * @return Response
	 */
    public function index()
    {
		/**@var ItemsRepository $repository */
		$repository = $this->getDoctrine()->getRepository(Items::class);

		try {
			$count = $repository->countAll();
		} catch (\Exception $e) {
			$count = 0;
		}

		$pagination = new Pagination($count, $this->_max_count);
		$list = $repository->getList($pagination->getStartId(), $this->_max_count);
		$tmpl_params = [
			'items' => $list,
            'pages' => $pagination->totalPages(),
			'pagination' => $pagination->designData(),
		];

		return $this->render('index.twig', $tmpl_params);
    }

    /**
     * @Route("/items/page/{page}", requirements={"page"="\d+"})
	 *
	 * @param int $page - Номер страницы
	 * @return Response
     */
    public function list_page(int $page = 1)
    {
        if ($page === 0)
        {
            return $this->redirectToRoute('app_news_list_page', array('page' => 1));
        }

		/**@var ItemsRepository $repository */
		$repository = $this->getDoctrine()->getRepository(Items::class);
		try {
			$count = $repository->countAll();
		} catch (\Exception $e) {
			$count = 0;
		}
		$pagination = new Pagination($count, $this->_max_count, $page);

		if ($page > $pagination->totalPages()) {
			throw $this->createNotFoundException('Нет такой страницы, 404 ');
		}

		$list = $repository->getList($pagination->getStartId(FALSE), $this->_max_count);

		$tmpl_params = [
			'paged_items'	=>	$list,
		];

        return new JsonResponse($tmpl_params);
    }

	/**
	 * @Route("/items/add", name="items_add")
	 *
	 * @param Request $request
	 * @param UserInterface $user
	 * @param EntityManagerInterface $em
	 * @return Response
	 */
	public function add(Request $request, UserInterface $user = NULL, EntityManagerInterface $em)
	{
		$this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
		$lel = NULL;
		if ($request->getRealMethod() === 'POST') {
			/**@var ItemsModel $model */
			try {
				$model = $this->getModel('Items');
				$data = $model->validationAdd();

				$query = $em->getConnection()->prepare("SELECT max(id) as max FROM items");
				$query->execute();
				$res = $query->fetch();
				$link_id = (empty($res['max']) || $res['max'] === 0) ? 1 : $res['max'] + 1;

				$item = new Items();
				$item->setName($data['name']);
				$item->setList($data['list']);
				$item->setDescription($data['description']);
				$item->setLink($link_id.'-'.strtolower($data['name']));
				$item->setAuthorId($user->getId());
				$item->setPhotos($data['photos']);

				$em->persist($item);
				$em->flush();

				return new Response(print_r($_POST,true), 200);
			} catch (\Exception $e) {
				return new Response($e->getMessage().' '.$e->getLine().' ', 400);
			}
		}
		//$lel = $this->getUser();
		//$lel = $user->getId();
		//$lel = $request->getUser();
		//$lel = print_r($request->request->all(), TRUE);
		$content = $this->render('items/item_add.twig', ['lel' => $lel]);
		return $content;
	}

	/**
	 * @Route("/news/edit/")
	 * @Route("/news/edit/{link}", name="news_edit")
	 *
	 * @param Request $request
	 * @param UserInterface $user
	 * @param string $link - ссылка на страницу
	 * @return Response
	 */
	public function edit(Request $request, UserInterface $user = NULL, string $link = NULL)
	{
		/**@var User $user*/
		if ($user === NULL || $link === NULL || $user->getRole() > APP_USER_ADMIN) {
			return $this->redirectToRoute('app_news_index');
		}

		$repository = $this->getDoctrine()->getRepository(News::class);
		/**@var News $news  */
		$news = $repository->findOneBy([
			'link' => $link
		]);

		if (empty($news)) {
			throw $this->createNotFoundException('Нет такой новости, 404');
		} elseif ($news->getAuthorId() !== $user->getId()){
			throw $this->createNotFoundException('Нет прав на редактирование');
		}

		if ($request->getRealMethod() === 'POST') {
			$lel = 'aga';
		}
		$content = $this->render('news/news_edit.twig', ['lel' => $lel]);

		//$this->denyAccessUnlessGranted('IS_AUTHAENTICATED_FULLY');
		//if ($user === NULL) {}
		/*
		$lel = NULL;
		//$post_data = $request->request->all();
		if ($request->getRealMethod() === 'POST') {
			$lel = 'aga';
		}
		//$lel = $this->getUser();
		$lel = $user->getId();
		//$lel = $request->getUser();
		//$lel = print_r($request->request->all(), TRUE);
		*/
		return $content;
	}

    /**
     * @Route("/items/{link}", name="items_show")
	 *
	 * @param string $link - ссылка на страницу
	 * @return Response
     */
    public function show (string $link)
    {
		/**@var ItemsRepository $repository */
		$repository = $this->getDoctrine()->getRepository(Items::class);
        //print_r($repository->countAll());
		/**@var Items $item */
		$item = $repository->findOneBy([
            'link' => $link
        ]);

        if (empty($item)) {
			throw $this->createNotFoundException('Нет такой новости, 404');
		}

		//print_r($item);

		//$item['photos'] = json_decode($item['photos'], TRUE);

		$item_photos['url'] = json_decode($item->getPhotos(), TRUE);
        //print_r($item_photos);

		$tmpl_params = [
			'post'	=>	[
				'id' => $item->getId(),
				'link' => $item->getLink(),
				'description' => $item->getDescription(),
				'photos' => json_decode($item->getPhotos(), TRUE),
				'name' => $item->getName(),

			],
			'meta'	=>	'lel',
		];
		$content = $this->render('items/item_show.twig', $tmpl_params);
		//$url = $this->generateUrl( 'news_show', array('name'=>'my-bkig-post'),UrlGeneratorInterface::ABSOLUTE_URL);

        return $content;
    }

}
