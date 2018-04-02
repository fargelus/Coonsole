<?php

namespace App\Controller;

use App\Entity\Items;
use App\Entity\User;
use App\Repository\ItemsRepository;
use function App\xss_clear;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\ORM\EntityManagerInterface;
use App\Helpers\Imagick;

class ItemsController extends BaseController
{
	/** @var int - Количество новостей на одной странице */
    protected $_count = 10;
    protected $_ext_type = ['gif','jpg','jpeg','png'];

	/**
	 * @Route("/")
	 * @Route("/items/")
	 *
	 * @return Response
	 */
    public function index()
    {

    	$paginator = new \App\Helpers\Pagination(30, 2, 2);
    	//$paginator->get('count');

		/**@var ItemsRepository $repository */
		$repository = $this->getDoctrine()->getRepository(Items::class);
		$list = NULL;

		try {
			$count = $repository->countAll();
		} catch (\Exception $e) {
			$count = 0;
		}



		$list = ($count < $this->_count) ? $repository->getItemsperpage(0) : $repository->getItemsperpage($count - $this->_count);
		$tmpl_params = [
			'news' => $list
		];

		$content = $this->render('news/news_preview.twig', $tmpl_params);

//		$user = new User('gmac.net.ru@gmail.com', '199855');

		//print_r($password);
		/*$user = new User('gmac.net.ru@gmail.com');
		$encoder = $this->container->get('security.password_encoder');
		$password = $encoder->encodePassword($user, '199855');
		$user->setPassword($password);

		$em = $this->getDoctrine()->getManagerForClass(User::class);
		$em->persist($user);
		$em->flush();*/
		return $content;
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

		$repository = $this->getDoctrine()->getRepository(News::class);
        $count = $repository->countAll();

		if ($count < $this->_count * $page && $page !== 1 ) {
			throw $this->createNotFoundException('Нет такой страницы, 404 ');
		}

		$list = ($count < $this->_count) ? $repository->getNewsperpage(0) : $repository->getNewsperpage($count - $page * $this->_count);

		$tmpl_params = [
			'news'	=>	$list,
			'meta'	=>	'lel',
		];

		$content = $this->render('news/news_preview.twig', $tmpl_params);
        return $content;
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
		//if ($user === NULL) {}
		$this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
		$lel = NULL;
		//$post_data = $request->request->all();
		if ($request->getRealMethod() === 'POST') {
			try {
				if (empty($_POST['name'])) {
					throw new \Exception('Отсутствует название');
				}

				if (empty($_POST['description'])) {
					throw new \Exception('Отсутствует описание');
				}

				if (empty($_POST['list'])) {
					throw new \Exception('Отсутствует список игр');
				}

				$files_count = count($_FILES['file']['name']);
				$photos = [];
				if ($files_count > 5) {
					throw new \Exception('Слишком много фотографий!');
				} else {
					$uploads_dir = APP_DIR . '/../public/upload';
					for ($i = 0; $i < $files_count; $i++ ) {
						if ($_FILES["file"]["error"][$i] === UPLOAD_ERR_OK) {
							$name = basename($_FILES["file"]["name"][$i]);
							$ext = explode('.',$name);
							$ext = end($ext);
							if (in_array($ext, $this->_ext_type, TRUE)) {
								$new_name = uniqid('img_') . '.' . $ext;
								if (move_uploaded_file($_FILES["file"]["tmp_name"][$i], "$uploads_dir/$new_name")) {
									if (extension_loaded('imagick')) {
										$thumbnail = new \Imagick();
										$thumbnail->readImage(realpath($uploads_dir.'/'.$new_name));
										$thumbnail->setImageCompression(imagick::COMPRESSION_DXT3);
										$thumbnail->setImageCompressionQuality(40);
										$thumbnail->stripImage();

										//TODO Fix: Разобраться со сжатием, иногда размер больше, чем был
										//if ($thumbnail->getImageLength() < filesize($uploads_dir.'/'.$new_name)) {
										$thumbnail->writeImage($uploads_dir.'/'.$new_name);
									}
									$photos[] = "/upload/$new_name";
								};

								//$thumbnail = new \Imagick($photos);
								//$thumbnail = $im->clone;


								//$imagick = new \Imagick($photos);
								//print_r($imagick->getImageCompressionQuality());
							}
						}
					}
				}

				$list_games = explode('\n', xss_clear($_POST['list']));

				$query = $em->getConnection()->prepare("SELECT max(id) as max FROM items");
				$query->execute();
				$res = $query->fetch();
				$link_id = $res['max'];

				if (empty($link_id) || $link_id === 0) {
					$link_id = 1;
				}

				$name = xss_clear($_POST['name']);

				$item = new Items();
				$item->setName($name);
				$item->setList(json_encode($list_games));
				$item->setDescription(xss_clear($_POST['description']));
				$item->setLink($link_id.'-'.strtolower($name));
				$item->setTimeUpdated(time());
				$item->setAuthorId($user->getId());
				$item->setPhotos(json_encode($photos));

				$em->persist($item);
				$em->flush();

				return new Response(print_r($_POST,true), 200);
				//throw new \Exception('haha');
				//if (count($_FILES['file']) > 3) {
				//$lel = ;
				//throw new \Exception($lel);
					//hrow new \Exception(count(print_r($_FILES)));
				//}
			} catch (\Exception $e) {
				return new Response($e->getMessage().' '.$e->getLine().' ', 400);
			}
			//
			//die('aga');
			//die('lol');
			//$lel = 'ds';
			//return new Response($lel);
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