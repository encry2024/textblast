<?php namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

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


		if ($user->checkStatus() == 1) {
			return $next($request);
		}

		Auth::logout();
		return redirect('auth/login');
	}

}
