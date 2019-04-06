<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware(function($request,$next){
            if(auth()->user()->subscribed('main')){
                return redirect('/')->with('message',['danger',__('Ya estas suscripto a otro plan')]);
            }

            return $next($request);

        })->only('plans','processSubscription');
    }

    public function plans(){

        return view('subscriptions.plans');


    }

    public function processSubscription(Request $request){


    }
}
