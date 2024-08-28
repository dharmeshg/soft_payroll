<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Auth;


class DynamicDatabaseConnection
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $database_name = Auth::user()->dbname;
            $database_username = Auth::user()->dbuser;
            $database_password = Auth::user()->dbpassword;
            //dd($database_name);
            config(['database.connections.mysql2.database' => $database_name]);
            config(['database.connections.mysql2.username' => $database_username]);
            config(['database.connections.mysql2.password' => $database_password]);

            // Set your config here using $user->company
            // ...
        }
        /*Config::set('database.connections.mysql.database', $user->company);

        DB::purge('u');
        DB::reconnect('club');*/

        return $next($request);
    }
}
