<?php

namespace App\Http\Controllers;

use App\Course;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //withcount devuelve un conteo
        //with devuelve la relacion entera
        $courses=Course::withCount(['students'])
            ->with('category','teacher','reviews')
            ->where('status',Course::PUBLISHED)
            //ordenarlos desendentemente
            ->latest()
            ->paginate(12);


        return view('home',['courses'=>$courses]);
    }
}
