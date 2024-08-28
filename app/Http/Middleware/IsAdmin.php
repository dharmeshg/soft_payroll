<?php
  
namespace App\Http\Middleware;
use Request;
  
use Closure;
   
class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(auth()->user()->is_school == 0 ){
            return $next($request);
        }
/*        $routeName = Request::route()->getName();
        $salesUser = [ 'institution.list' ];
        if( auth()->user()->is_school == 1  && in_array($routeName, $salesUser) ) {
            return $next($request);
        }
        dd($routeName);
*/   
        return redirect('home')->with('error',"You don't have admin access.");
    }
}