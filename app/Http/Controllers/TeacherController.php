<?php

namespace App\Http\Controllers;

use App\Mail\MessageToStudent;
use App\Student;
use App\User;
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

    public function sendMessageStudent(Request $request){
        //obteniendo informacion enviada por ajax
        $info=$request->info;
        $data=[];
        //parseamos la informacion que viene de ajax y la pasamos al arreglo, obtendremos un arreglo
        parse_str($info,$data);

        //buscamos al usuario(el id lo enviamos por ajax)
       $user= User::find($data['user_id']);

       try{

           \Mail::to($user)->send(New MessageToStudent(auth()->user()->name,$data['message']));
           $success=true;


       }catch (\Exception $e){
           //guardo mensaje de error, por si ocurre un error y no se que es
           $error=$e->getMessage();
           $success=false;


       }
        return response()->json(['res'=>$success]);
    }
}
