<?php namespace App\Http\Middleware;

use Closure;

class ShowModel {

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		$response = $next($request);
		$model = $this->getAction($request);
		print_r($model->slug);
		return $response;
	}

	private function getAction($request)
	{
		$res = $request->route()->getParameter('projects');
		return $res;
	}

}
