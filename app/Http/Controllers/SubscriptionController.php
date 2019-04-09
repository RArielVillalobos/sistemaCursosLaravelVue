<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Stripe\Stripe;
use Laravel\Cashier\Cashier;



class SubscriptionController extends Controller
{
    //
    public function __construct()
    {
        //Cashier::useCurrency('usd', '$');
        $secret_key='sk_test_rCyM8e9qljZJzMvysGO9hL6I00pm9VVie9';

        \Stripe\Stripe::setApiKey($secret_key);

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
       // Stripe::setApiKey(env('SECRET_KEY'));

       //$token3= Stripe::setApiKey(config('services.stripe.secret'));
        $token=$request->input('stripeToken');




        //Stripe::setApiKey($token);


        try{
            if($request->has('coupon')){
                $request->user()->newSubscription('main',$request->input('type'))->withCoupon(\request('coupon'))
                ->create($token);

            }else{
                \request()->user()->newSubscription('main',\request('type'))
                    ->create($token);
            }

            return redirect(route('subscription.admin'))->with('message',['success',__('La subscripcion se ha llevado correctamente')]);

        }catch (\Exception $exception){
            $error=$exception->getMessage();

            return back()->with('message',['danger',$error]);

        }

    }

    public function admin(){
        $subscriptions=auth()->user()->subscriptions;
        return view('subscriptions.admin',['subscriptions'=>$subscriptions]);
    }

    public function resume(Request $request){
        $subscripcion=$request->user()->subscription($request->plan);


                //renauda subscripcion
        if ($subscripcion->cancelled() && $subscripcion->onGracePeriod()) {
               $subscripcion->resume();
                return back()->with('message',['success',__('Has renaudado tu subscripcion correctamente')]);


            //

        }else{
            return back()->with('message',['danger',__('Error')]);
        }






    }
    public function cancel(Request $request){
        //Stripe::setApiKey(env('SECRET_KEY'));
        //Stripe::setApiKey('sk_test_rCyM8e9qljZJzMvysGO9hL6I00pm9VVie9');
        $plan=$request->user()->subscription($request->plan);
        //dd($plan);

        $plan->cancel();

        return back()->with('message',['success',__('Has Cancelado se ha cancelado correctamente')]);
    }
}
