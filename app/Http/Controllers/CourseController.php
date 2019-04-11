<?php

namespace App\Http\Controllers;

use App\Mail\NewStudentInCourse;
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
        //cuando usamos load la propiedad withCount([]) no funciona, debemos definirlo desde el modelo y lo sacara autoamticamente
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

        ])->get();

        //obtenemos los cursos que tienen la misma categoria
        //la funcion relatedCourse esta definida en el modelo
        $cursosMismaCategoria=$course->relatedCourses();
        return view('courses.detail',['course'=>$course,'related'=>$cursosMismaCategoria]);



    }

    public function inscribe(Course $course){
        //ver vista previa del email con markdown
        //return new NewStudentInCourse($course,'Admin');
        //queremos ingresar a la tabla students e insertar un registro, solo necesitamos pasarle el parametro id del estudiante
        $course->students()->attach(auth()->user()->student->id);

        //hacer el envio del correo
        //enviamos el email al profesor
        \Mail::to($course->teacher->user)->send(new NewStudentInCourse($course,auth()->user()->name));
        return back()->with('message',['success',__('Inscripto correctamente en el curso')]);
    }

    public function subscribed(){
        //queremos obtener los cursos cuando tenga estudiantes,
        $courses=Course::whereHas('students',function($query){
            $query->where('user_id',auth()->user()->id);

        })->get();


        return view('courses.subscribed',['courses'=>$courses]);
    }

    public function addReview(){

    }
}
