<?php

namespace App\Http\Controllers;

use App\Course;
use App\VueTables\EloquentVueTables;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    //va a usar el componente de vue table2
    public function courses(){
        return view('admin.courses');
    }

    public function coursesJson(){
        //if(request()->ajax()){

            $vueTables=new EloquentVueTables;
            $data=$vueTables->get(new Course,['id','name','status'],['reviews']);

            return response()->json($data);
        //}else{
          //  abort(401);
       // }



    }
}
