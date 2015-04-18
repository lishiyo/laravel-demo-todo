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
		$model = $this->getAction($request);
		// print_r($model->slug);
		return $next($request);
	}

	private function getAction($request)
	{
		$res = $request->route()->getParameter('projects');
		return $res;
	}

}
