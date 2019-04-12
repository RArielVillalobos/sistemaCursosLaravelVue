<?php

namespace App\Http\Controllers;

use App\Rules\StrengthPassword;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    //

    public function index (){
        $user=auth()->user()->load('socialAccount');
        return view('profile.index',['user'=>$user]);
    }

    public function update(Request $request){
        $this->validate($request,[
            //password iguales aun que vengan vacios
            'password'=>['confirmed',new StrengthPassword]
        ]);

        //SI PASA LA VALIDACION

        $user=auth()->user();
        $user->password=bcrypt($request->input('password'));
        $user->save();

        return back()->with('message',['success',__('Usuario actualizado correctamente')]);


    }
}
