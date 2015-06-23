<?php namespace App\Http\Middleware;

use Closure;

class CheckAuthStatus {

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		$user = $request->user();

		if ($user && $user->checkStatus() == 1) {
			return $next($request);
		} else if ($user && $user->checkStatus() == 0) {
			return "Account has been disableds";
		}
	}

}
