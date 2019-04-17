<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Requests\CourseRequest;
use App\Mail\NewStudentInCourse;
use Illuminate\Http\Request;
use App\Course;
use App\Review;
use Illuminate\Support\Facades\Storage;

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

    public function addReview(Request $request){


        Review::create([
            'course_id'=>$request->course_id,
            'user_id'=>auth()->user()->id,
            'rating'=>(int) $request->rating_input,
            'comment'=>$request->message

        ]);

        return back()->with('message',['success',__('Muchas gracias por valorar el curso')]);

    }

    public function create(){
        $course=new Course();
        $btnText=__('Enviar Curso para revision');
        return view('courses.form',['course'=>$course,'btnText'=>$btnText]);
    }

    //con solo pasarle como paramentro el CourseRequest y la instancia, hara toda la validacion completa y cortara la ejecuccion si falla
    //no tenemos que pasar el Request $request como parametro, porque ya viene en el CourseRequest
    public function store(CourseRequest $courseRequest){
        //lo guardara en storage/app/public/courses
        //recoredemos que la funcion estatica retorna el nombre de archivo
        $picture=Helper::uploadFile('picture','courses');

        //dentro de la peticion exista una nueva variable que se llame picture , que sera la imagen (el string del nombre q se guardara en bd)
        //tambien agregamos un teacher_id y un status
        $courseRequest->merge(['picture'=>$picture]);
        $courseRequest->merge(['teacher_id'=>auth()->user()->teacher->id]);
        $courseRequest->merge(['status'=>Course::PENDING]);
        $courseRequest->merge(['slug'=>str_slug($courseRequest['name'],'-')]);
        //insertara en la bd todos los datos que trae el request, nombre de curso,categoria,nivel,etc
        //todos los campos del formulario menos el token sino generara error al no estar activado en asignacion masiva o podemos rellenar el la variable fillable en el modelo
        //Course::create($courseRequest->except('_token'));
        Course::create($courseRequest->input());
        //recordemos que dentro del modelo Course esta el evento para generar las metas y requisitos cada vez q se actualice o se cree un curso

        return back()->with('message',['success',__('Curso enviado  correctamente,recibira un correo con cualquier información')]);



    }

    public function edit($slug){
        //evitar consultas duplicadas
        $course=Course::with(['requirements','goals'])->withCount(['requirements','goals'])
        ->whereSlug($slug)->first();
        $btnText=__('Actualizar curso');
        return view('courses.form',['course'=>$course,'btnText'=>$btnText]);


    }

    public function update (CourseRequest $courseRequest,Course $course){
        $course_id=$courseRequest->request->all()['course_id'];
        if($courseRequest->has('picture')){
            Storage::delete('courses/'.$course->picture);
            $picture=Helper::uploadFile('picture','courses');
            $courseRequest->merge(['picture'=>$picture]);


        }

        //se actualiza todo el formulario

        //dd($course);
        $course=Course::find($course_id);
        $course->fill($courseRequest->input());
        $course->save();

        return back()->with('message',['success',__('Curso actualizado correctamente')]);



    }
}
