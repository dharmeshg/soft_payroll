<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Models\User;

use Auth;
use Config;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    //protected $redirectTo = 'admin/home';
    // protected $redirectTo = RouteServiceProvider::HOME;
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //dd(Config::get('database'));
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request)
    {   
        $input = $request->all();
   
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');
        $user_data = User::where('email',$input['email'])->first();
        //dd(Auth::email());
        if(isset( $user_data->email ) && $user_data->email == $input['email'] &&  $user_data->status != 0) {
            if (Auth::attempt($credentials) ) {
                if (in_array(Auth::user()->is_school, [1,2])) {
                   return redirect()->intended('/institute/home')
                            ->withSuccess('Signed in');
                }elseif (in_array(Auth::user()->is_school, [3]) && in_array(Auth::user()->role, ['Employee'])) {
                   return redirect()->intended('emp_dashboard/employeehome')
                            ->withSuccess('Signed in');
                }elseif (in_array(Auth::user()->is_school, [3]) && in_array(Auth::user()->role, ['HOD'])) {
                   return redirect()->intended('emp_dashboard/employeehome')
                            ->withSuccess('Signed in');
                }
                // elseif (in_array(Auth::user()->is_school, [3]) && in_array(Auth::user()->role, ['Dean'])) {
                //    return redirect()->intended('emp_dashboard/employeehome')
                //             ->withSuccess('Signed in');
                // }elseif (in_array(Auth::user()->is_school, [3]) && in_array(Auth::user()->role, ['Rector'])) {
                //    return redirect()->intended('emp_dashboard/employeehome')
                //             ->withSuccess('Signed in');
                elseif (in_array(Auth::user()->is_school, [3]) && in_array(Auth::user()->role, ['HOU'])) {
                    return redirect()->intended('emp_dashboard/employeehome')
                             ->withSuccess('Signed in');
                 }elseif (in_array(Auth::user()->is_school, [3]) && in_array(Auth::user()->role, ['HOF'])) {
                    return redirect()->intended('emp_dashboard/employeehome')
                             ->withSuccess('Signed in');
                }else {
                    return redirect()->intended('/admin/home')
                            ->withSuccess('Signed in');
                }
            }else{
                return redirect('login')
                    ->with('error','Email-Address And Password Are Wrong.');
            }
        }
        else{
                return redirect('login')
                    ->with('error','You do not have login access.');
            }
    }
}
