<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    //

    public function index (){
        $user=auth()->user()->load('socialAccount');
        return view('profile.index',['user'=>$user]);
    }

    public function update(Request $request){
        dd($request->all());

    }
}
