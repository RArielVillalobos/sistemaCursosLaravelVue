<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\User;
use Laravel\Cashier\Invoice;


class InvoiceController extends Controller
{
    //
    public function __construct()
    {
        $secret_key='sk_test_rCyM8e9qljZJzMvysGO9hL6I00pm9VVie9';

        \Stripe\Stripe::setApiKey($secret_key);
    }

    public function admin(){
        $invoices=new Collection();
       // dd(auth()->user()->invoices());
        $user=User::find(auth()->user()->id);
        $invoices = $user->invoices();





        return view('invoices.admin',['invoices'=>$invoices]);

    }

    public function download($id){

        dd($id);
    }
}
