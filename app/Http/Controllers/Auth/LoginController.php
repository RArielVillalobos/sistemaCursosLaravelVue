<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Laravel\Socialite\Facades\Socialite;

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
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function redirecToProvider(string $driver){
        return Socialite::driver($driver)->redirect();

    }

    public function handleProviderCallback(string $driver){
        //si algo no va bien
        if(!request()->has('code') || request()->has('denied')){
            session()->flash('message',['danger',__('Inicio de sesion cancelado')]);
            return redirect('login');

        }
        $socialUser=Socialite::driver($driver)->user();
        dd($socialUser);

    }
}
