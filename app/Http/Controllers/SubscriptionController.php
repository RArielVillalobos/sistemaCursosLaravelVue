<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Stripe\Stripe;



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
        $token2=request('stripeToken');
        $token2=Stripe::setApiKey(env('SECRET_KEY'));


        try{
            if(\request()->has('coupon')){
                \request()->user()->newSubscription('main',\request('type'))->withCoupon(\request('coupon'))
                ->create($token2);

            }else{
                \request()->user()->newSubscription('main',\request('type'))
                    ->create($token2);
            }

            return redirect(route('subscription.admin'))->with('message',['success',__('La subscripcion se ha llevado correctamente')]);

        }catch (\Exception $exception){
            $error=$exception->getMessage();

            return back()->with('message',['danger',$error]);

        }

    }

    public function admin(){
        return view('subscriptions.admin');
    }
}
