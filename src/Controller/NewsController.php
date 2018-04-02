<?php

namespace App\Controller;

use App\Model\NewsModel;
use App\Entity\News;
use App\Entity\User;
use App\Repository\NewsRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\User\UserInterface;


class NewsController extends BaseController
{
	/** @var int - Количество новостей на одной странице */
    protected $_count = 10;

	/**
	 * Route("/")
	 * @Route("/news/")
	 *
	 * @return Response
	 */
    public function index()
    {
    	$repository = $this->getDoctrine()->getRepository(News::class);
        $count = $repository->countAll();

        $list = ($count < $this->_count) ? $repository->getNewsperpage(0) : $repository->getNewsperpage($count - $this->_count);

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
     * @Route("/news/page/{page}", requirements={"page"="\d+"})
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
	 * @Route("/news/add", name="news_add")
	 *
	 * @param Request $request
	 * @param UserInterface $user
	 * @return Response
	 */
	public function add(Request $request, UserInterface $user = NULL)
	{
		//if ($user === NULL) {}
		$this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
		$lel = NULL;
		//$post_data = $request->request->all();
		if ($request->getRealMethod() === 'POST') {
			$lel = 'aga';
		}
		//$lel = $this->getUser();
		$lel = $user->getId();
		//$lel = $request->getUser();
		//$lel = print_r($request->request->all(), TRUE);
		$content = $this->render('news/news_add.twig', ['lel' => $lel]);
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
     * @Route("/news/{link}", name="news_show")
	 *
	 * @param string $link - ссылка на страницу
	 * @return Response
     */
    public function show (string $link)
    {
		$repository = $this->getDoctrine()->getRepository(News::class);
        $news = $repository->findOneBy([
            'link' => $link
        ]);

        if (empty($news)) {
			throw $this->createNotFoundException('Нет такой новости, 404');
		}

		$tmpl_params = [
			'post'	=>	$news,
			'meta'	=>	'lel',
		];
		$content = $this->render('news/news_show.twig', $tmpl_params);
		//$url = $this->generateUrl( 'news_show', array('name'=>'my-bkig-post'),UrlGeneratorInterface::ABSOLUTE_URL);

        return $content;
    }

}