<?php namespace BrngyWiFi\Http\Middleware;

use Closure;
use \Auth;
use Request;
class RedirectBaseOnRole {

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		if (Request::is('admin*'))
		{
		    if(Auth::user()->role_id == 2){
				return redirect('/leader');
			}
		}else if (Request::is('leader*')){
			if(Auth::user()->role_id == 1){
				return redirect('/admin');
			}
		}
		return $next($request);
	}

}
