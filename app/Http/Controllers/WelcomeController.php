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
			// public function request($path, $method = 'GET', $body = null, array $extraHeaders = array(), $attachApiKey = false);
			$api_key = env('TUMBLR_client_id');
			$tag = 'daredevil';
			$limit = 100;

			$queryStr = "api_key={$api_key}&tag={$tag}&limit={$limit}";
		    $result = json_decode($tumblrService->request("tagged?" . $queryStr, 'GET'), true);

		    $res = ($result["response"]);
		    foreach($res as $index => $post) {
		    	 echo '<pre> blog_name: ' . print_r($post["blog_name"], true) . '</pre>' . "\n";
		    	 echo '<pre> note count: ' . print_r($post["note_count"], true) . '</pre>' . "\n";
		    	 echo '<pre> followed: ' . print_r($post["followed"], true) . '</pre>' . "\n";
		    	 echo '<pre> timestamp: ' . print_r($post["timestamp"], true) . '</pre>' . "\n";
		    }


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
