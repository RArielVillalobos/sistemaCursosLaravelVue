<?php

namespace App\Http\Controllers;

use App\Course;
use App\EloquentVueTables;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    //va a usar el componente de vue table2
    public function courses(){
        return view('admin.courses');
    }

    public function coursesJson(Request $request){

        $buscar=$request->buscar;
        $criterio=$request->criterio;

        //dd($request->all());

       // if(request()->ajax()){
        if(!$request->ajax()){
            return redirect('/');
        }
        if($buscar==''){
            $cursos=Course::paginate(10);
        }else{
            $cursos=Course::where('status','=',$criterio)->where('name','like','%'.$buscar.'%')->orderBy('id','desc')->paginate(10);
        }



        return ['pagination'=>[
            'total'=>$cursos->total(),
            'current_page'=>$cursos->currentPage(),
            'per_page'=>$cursos->perPage(),
            'last_page'=>$cursos->lastPage(),
            'from'=>$cursos->firstItem(),
            'to'=>$cursos->lastItem(),
        ],
            'cursos'=>$cursos
            ];

    }

    public function updateCourseStatus(Request $request){


        $id=$request->id;
        $nuevoStatus=$request->status;

        $course=Course::findOrFail($id);
        if($course->status!==Course::PUBLISHED && !$course->previus_approved && $nuevoStatus===Course::PUBLISHED){
            $course->previus_approved=true;
            //\Mail::to($course->teacher->user)->send(new CourseApproved($course));
        }

        if($course->status!==Course::REJECTED && !$course->previus_rejected && $nuevoStatus===Course::REJECTED){
            $course->previus_rejected=true;
            //    \Mail::to($course->teacher->user)->send(new CourseRejected($course));
        }
        if($course->status=$nuevoStatus){
            $course->save();

        }else{
            return abort(401);
        }





    }
}
