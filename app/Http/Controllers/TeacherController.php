<?php

namespace App\Http\Controllers;

use App\Student;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    //

    public function courses(){

    }

    public function students(){

        $students=Student::with('user','courses.reviews')
            //que tenga cursos
            ->whereHas('courses',function ($query){
                                                                                                    //que no este borrado(logico)
                $query->where('teacher_id',auth()->user()->teacher->id)->select('id','teacher_id','name')->withTrashed();
            })->get();

        //archivo
        //para añadir una columna
        $actions='students.datatables.actions';


        //va a comprobar si existe en el directorio ,si existe, lo va a devolver sino existe devuelve texto plano
        //que la columna sea html, que la respete como tal
        return \DataTables::of($students)->addColumn('actions',$actions)->rawColumns(['actions','courses_formatted'])->make(true);


    }
}
