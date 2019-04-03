<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Student;
use App\UserSocialAccount;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\DB;
use App\User;

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
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function logout(Request $request)
    {
        auth()->logout();
        //forzar borrado sesion
        session()->flush();
        return redirect('/login');

    }

    public function redirecToProvider(string $driver)
    {
        return Socialite::driver($driver)->redirect();

    }

    public function handleProviderCallback(string $driver)
    {
        //si algo no va bien
        if (!request()->has('code') || request()->has('denied')) {
            Session::flash('message', ['danger', __('Inicio de sesion cancelado')]);
            return redirect('login');

        }
        $socialUser = Socialite::driver($driver)->user();

        $userNuevo=null;
        $success = true;
        $email = $socialUser->email;
        //buscamos usuario que coincida el email con el email del usuario y obtenemos el primer registro
        //si ya existe no lo damos de alta
        $check = User::whereEmail($email)->first();


        if ($check) {
            $userNuevo = $check;

        } else {

            DB::beginTransaction();
            try{
                $userNuevo=User::create([
                    'name'=>$socialUser->name,
                    'email'=>$email,
                ]);



                UserSocialAccount::create([
                    'user_id'=>$userNuevo->id,
                    'provider'=>$driver,
                    'provider_uid'=>$socialUser->id

                ]);
                Student::create([
                    'user_id'=>$userNuevo->id,

                ]);




            }catch (\Exception $e){
                $success=$e->getMessage();

                DB::rollBack();

            }

        }


        if($success===true){
            DB::commit();
            auth()->loginUsingId($userNuevo->id);
            return redirect(route('home'));
        }
        Session::flash('message',['danger',$success]);
        return redirect('login');

    }
}