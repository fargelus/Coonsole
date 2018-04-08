<?php

namespace App\Security;

use Psr\Cache\CacheItemInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\AuthenticationTrustResolverInterface;
use Symfony\Component\Security\Core\Authentication\Provider\AuthenticationProviderInterface;
use Symfony\Component\Security\Core\Authentication\Token\PreAuthenticatedToken;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Http\Authentication\SimplePreAuthenticatorInterface;
use VK\OAuth\VKOAuth;


class SocialAuthenticator implements SimplePreAuthenticatorInterface//, AuthenticationProviderInterface
{
	private $userProvider;
	private $cachePool;

	/*public function __construct(UserProviderInterface $userProvider, CacheItemInterface $cachePool)
	{
		$this->userProvider = $userProvider;
		$this->cachePool = $cachePool;
	}*/

	public function createToken(Request $request, $providerKey)
	{
		//return null;
		$type = $request->query->get('oauth');

		if (!$type) {
			return NULL;
		}
		//print_r($_GET['code']);

		return new PreAuthenticatedToken(
			'anon.',
			[$type, $request->query->get('code')],
			$providerKey
		);

		switch ($type) {
			case 'vk':
				$oauth = new VKOAuth();
				$response = $oauth->getAccessToken(VK_CLIENT_ID, VK_CLIENT_SECRET, VK_REDIRECT, $_GET['code']);
				print_r($response);
				$access_token = $response['access_token'];
				$email = $response['email'];
				break;
		}
	}

	public function supportsToken(TokenInterface $token, $providerKey)
	{
		return $token instanceof PreAuthenticatedToken && $token->getProviderKey() === $providerKey;
	}

	public function authenticateToken(TokenInterface $token, UserProviderInterface $userProvider, $providerKey)
	{

		if (!$userProvider instanceof SocialUserProvider) {
			throw new \InvalidArgumentException(
				sprintf(
					'The user provider must be an instance of ApiKeyUserProvider (%s was given).',
					get_class($userProvider)
				)
			);
		}

		list($type, $code) = $token->getCredentials();
		print_r($type);
		print_r($code);
		$username = 'eblo@gmail.com';
		switch ($type) {
			case 'vk':
				$oauth = new VKOAuth();
				$response = $oauth->getAccessToken(VK_CLIENT_ID, VK_CLIENT_SECRET, VK_REDIRECT, $code);
				print_r($response);
				$access_token = $response['access_token'];
				$email = $response['email'];
				break;
		}
		//$userProvider->getUsernameForApiKey($apiKey);
		/*throw new \Exception($userProvider);
		return new PreAuthenticatedToken(
			$user,
			$apiKey,
			$providerKey,
			$user->getRoles()
		);*/
		//throw new \Exception($providerKey);

		if (!$username) {
			// CAUTION: this message will be returned to the client
			// (so don't put any un-trusted messages / error strings here)
			throw new CustomUserMessageAuthenticationException(
				sprintf('API Key "%s" does not exist.', $code)
			);
		}

		$user = $userProvider->loadUserByUsername($username);

		if (empty($user)) {
			return NULL;
		}

		return new PreAuthenticatedToken(
			$user,
			$code,
			$providerKey,
			$user->getRoles()
		);
	}

	/*public function authenticate(TokenInterface $token)
	{
		$user = $this->userProvider->loadUserByUsername($token->getUsername());

		if ($user && $this->validateDigest($token->digest, $token->nonce, $token->created, $user->getPassword())) {
			$authenticatedToken = new WsseUserToken($user->getRoles());
			$authenticatedToken->setUser($user);

			return $authenticatedToken;
		}
	}

	protected function validateDigest($digest, $nonce, $created, $secret)
	{
		// Check created time is not in the future
		if (strtotime($created) > time()) {
			return false;
		}

		// Expire timestamp after 5 minutes
		if (time() - strtotime($created) > 300) {
			return false;
		}

		// Try to fetch the cache item from pool
		$cacheItem = $this->cachePool->getItem(md5($nonce));

		// Validate that the nonce is *not* in cache
		// if it is, this could be a replay attack
		if ($cacheItem->isHit()) {
			throw new NonceExpiredException('Previously used nonce detected');
		}

		// Store the item in cache for 5 minutes
		$cacheItem->set(null)->expiresAfter(300);
		$this->cachePool->save($cacheItem);

		// Validate Secret
		$expected = base64_encode(sha1(base64_decode($nonce).$created.$secret, true));

		return hash_equals($expected, $digest);
	}*/

	public function supports(TokenInterface $token)
	{
		// TODO: Implement supports() method.
	}
}