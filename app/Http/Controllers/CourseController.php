<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Course;

class CourseController extends Controller
{
    //

    //accedemos directamente al curso
    public function show(Course $course){
        //cuando usamos Route Model Binding(cargar modelo desde ruta no podemos usar with sino load)
        //para que se carguen las relaciones debemos usar load y no with
        //asi le decimos que se carguen relaciones adicionales
        $course->load([
            //sobrescibir al modelo, y mostrar columnas seleccionadas
            'category'=>function($q){
                $q->select('id','name');
            },
            'goals'=>function($q){
                $q->select('id','course_id','goal');


            },

            'level'=>function($q){
                $q->select('id','name');
            },
            'requirements'=>function($q){
                $q->select('id','course_id','requirement');
            },
            //tambien podemos acceder a a las relaciones asi
            //de cada reviews tambien obtener la relacion al usuario
            'reviews.user',
            'teacher'

        ])->withCount(['students','reviews'])->get();

        dd($course);



    }
}
