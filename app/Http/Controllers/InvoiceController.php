<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\User;




class InvoiceController extends Controller
{
    //
    public function __construct()
    {
        $secret_key='sk_test_rCyM8e9qljZJzMvysGO9hL6I00pm9VVie9';

        \Stripe\Stripe::setApiKey($secret_key);
    }

    public function admin(){

       // dd(auth()->user()->invoices());
        $user=User::find(auth()->user()->id);
        $invoices = $user->invoices();





        return view('invoices.admin',['invoices'=>$invoices]);

    }

    public function download(Request $request,$id){

        return $request->user()->downloadInvoice($id,['vendor'=>'Mi empresa','product'=>__('Subscripción')]);
    }
}
