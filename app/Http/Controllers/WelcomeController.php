<?php namespace App\Http\Controllers;

use Tumblr\API as tumblrMain;
use OAuth\OAuth1\Service\Tumblr;
use OAuth\Common\Storage\Session;
use OAuth\Common\Consumer\Credentials;
use Illuminate\Http\Request;

class WelcomeController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Welcome Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders the "marketing page" for the application and
	| is configured to only allow guests. Like most of the other sample
	| controllers, you are free to modify or remove it as you desire.
	|
	*/

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('guest');
	}

	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
		return view('welcome');
	}

	public function loginWithTumblr(Request $request)
	{
		// We need to use a persistent storage to save the token, because oauth1 requires the token secret received before the redirect (request token request) in the access token request.

		$storage = new Session();
		$tumblrService = \OAuth::consumer('Tumblr');

		if (!empty($_GET['oauth_token'])) {
		    $token = $storage->retrieveAccessToken('Tumblr');
		    $tokenSecret = $token->getRequestTokenSecret();
		    // This was a callback request from tumblr, get the token
		    $tumblrService->requestAccessToken(
		        $_GET['oauth_token'],
		        $_GET['oauth_verifier'],
		        $tokenSecret
		    );
			// public function request($path, $method = 'GET', $body = null, array $extraHeaders = array());
		    $result = json_decode($tumblrService->request('tagged?tag=gif', 'GET', null, array(), true));
		    // $result = json_decode($tumblrService->request('user/info', 'GET', null));
		    // Send a request now that we have access token => returns json
		    // $consumerKey = env('TUMBLR_client_id');
		    // $consumerSecret = env('TUMBLR_client_secret');
		    // $client = new tumblrMain\Client($consumerKey, $consumerSecret);


		 //    $requestHandler = $client->getRequestHandler();
			// $requestHandler->setBaseUrl('http://www.tumblr.com/');
		 //    $resp = $requestHandler->request('POST', 'oauth/access_token', array('oauth_verifier' => $_GET['oauth_verifier'], 'oauth_token' => $_GET['oauth_token']));

		 //    $out = $resp->body;
			// $data = array();
			// parse_str($out, $data);
			// var_dump($resp);
			// var_dump($data);
			// $new_token = $data["oauth_token"];
			// $new_secret = $data["oauth_token_secret"];
			// echo $new_token . " plus " . $new_secret;

			// $client->setToken('DRu3uG7TCLSinji6iljpauoeawgTvklX9hmmKGZvaNc6iSicEs', 'LiFuSgpPEaqR9Lm3ktBRhhT3IYJcCOqYfIhzcYyh6jWFQEQbuR');

		 //    $result = $client->getUserInfo();

		    echo '<pre>' . print_r($result, true) . '</pre>';



		}  else {
			$token = $tumblrService->requestRequestToken();
			$url = $tumblrService->getAuthorizationUri(array('oauth_token' => $token->getRequestToken()));
			return redirect((string)$url);
		}


		// elseif (!empty($_GET['go']) && $_GET['go'] === 'go') {
		//     // extra request needed for oauth1 to request a request token :-)
		//     $token = $tumblrService->requestRequestToken();
		//     $url = $tumblrService->getAuthorizationUri(array('oauth_token' => $token->getRequestToken()));

		//     // $url => https://www.tumblr.com/oauth/authorize?oauth_token=odGQcvblQtdSgP9kJbhk1XeUs0SU8PSApFAtUtx2OtZwX2Ievw
		//     // return to tumblr login url
  //       	return redirect((string)$url);
		// } else {
		// 	$uriFactory = new \OAuth\Common\Http\Uri\UriFactory();
		// 	$currentUri = $uriFactory->createFromSuperGlobalArray($_SERVER);
		// 	$currentUri->setQuery('');
		//     $url = $currentUri->getRelativeUri() . '?go=go';
		//     return redirect((string)$url);
		// }
	}


}
