<?php

namespace App\Security;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Guard\Authenticator\AbstractFormLoginAuthenticator;
use Symfony\Component\Security\Core\Security;

class FormLoginAuthenticator extends AbstractFormLoginAuthenticator
{
	public function __construct(RouterInterface $router, UserPasswordEncoderInterface $encoder)
	{
		$this->router = $router;
		$this->encoder = $encoder;
	}

	public function getCredentials(Request $request)
	{
		/*if ($request->getPathInfo() != '/login_check') {
			return;
		}*/

		$email = $request->request->get('_username');
		$request->getSession()->set(Security::LAST_USERNAME, $email);
		$password = $request->request->get('_password');
		return [
			'username' => $email,
			'password' => $password,
		];
	}

	public function getUser($credentials, UserProviderInterface $userProvider)
	{
		$email = $credentials['username'];

		return $userProvider->loadUserByUsername($email);
	}

	public function checkCredentials($credentials, UserInterface $user)
	{
		$plainPassword = $credentials['password'];
		//$encoder = $this->container->get('security.password_encoder');
		print_r($plainPassword);
		if ($this->encoder->isPasswordValid($user, $plainPassword)) {
			//print_r('valid');
			return true;
		}
		//$request = new Request();
		//$request->getSession()->set(Security::AUTHENTICATION_ERROR, 'ne valid');
		throw new BadCredentialsException();
		//throw new ALO('Не дошло');
	}

	public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
	{
		//$url = $this->router->generate('welcome');

		//return new RedirectResponse($url);
		return NULL;
	}

	public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
	{
		$request->getSession()->set(Security::AUTHENTICATION_ERROR, $exception);

		//$url = $this->router->generate('login');
		/*$data = array(
			'message' => strtr($exception->getMessageKey(), $exception->getMessageData())

			// or to translate this message
			// $this->translator->trans($exception->getMessageKey(), $exception->getMessageData())
		);
		return $data;*/

		//return new RedirectResponse($url);
	}

	protected function getLoginUrl()
	{
		return $this->router->generate('login');
	}

	protected function getDefaultSuccessRedirectUrl()
	{
		return $this->router->generate('index');
	}

	public function supportsRememberMe()
	{
		return true;
	}

	public function supports(Request $request)
	{
		return TRUE;
	}

}