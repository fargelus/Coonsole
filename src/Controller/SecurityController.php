<?php

namespace App\Controller;

use App\Model\NewsModel;
use App\Entity\News;
use App\Entity\User;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use App\Repository\NewsRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use VK\OAuth\VKOAuth;

class SecurityController extends BaseController
{

	/**
	 * @Route("/login", name="login")
	 *
	 * @return Response
	 * @throws
	 */
    public function loginAction(Request $request, AuthenticationUtils $authUtils)
    {
		$error = $authUtils->getLastAuthenticationError();

		if (isset($_GET['oauth'])) {
			switch ($_GET['oauth']) {
				case 'vk':
					if (isset($_GET['code'])) {
						$oauth = new VKOAuth();
						$response = $oauth->getAccessToken(VK_CLIENT_ID, VK_CLIENT_SECRET, VK_REDIRECT, $_GET['code']);
						print_r($response);
						$access_token = $response['access_token'];
						$email = $response['email'];
					}
					break;
			}
		}

		// last username entered by the user
		$lastUsername = $authUtils->getLastUsername();

		return $this->render('security.twig', array(
			'last_username' => $lastUsername,
			'error'         => $error,
		));
		//$content = $this->render('news/news_preview.twig', $tmpl_params);
		//return $content;
    }

	/**
	 *  Route("/login_check", name="security_login_check")
	 */
	/*public function loginCheckAction()
	{

	}*/

	/**
	 * @Route("/logout", name="logout")
	 */
	public function logoutAction()
	{

	}

	/**
	 * @Route("/register", name="register")
	 *
	 * @return Response
	 */
	public function registerAction(Request $request, AuthenticationUtils $authUtils)
	{

		$error = $authUtils->getLastAuthenticationError();

		// last username entered by the user
		$lastUsername = $authUtils->getLastUsername();

		return $this->render('security.twig', array(
			'last_username' => $lastUsername,
			'error'         => $error,
		));
		//$content = $this->render('news/news_preview.twig', $tmpl_params);
		//return $content;
	}
}