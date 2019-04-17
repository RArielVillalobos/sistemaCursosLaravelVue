<?php

namespace App\Policies;

use App\Teacher;
use App\User;
use App\Course;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Role;
use Illuminate\Support\Collection;

class CoursePolicy
{
    use HandlesAuthorization;

    //retorna verdero
    //dice si un usuario se puede subscribir o no a un curso
    //si el usuario  no es el que imparte el curso retorna verdadero osea puede tomar el curso

    public function opt_for_course(User $user,Course $course){


        return !$user->teacher!=null  || $user->teacher->id !=$course->teacher_id;



    }
    //retorna verdero
    public function subscribe(User $user){
        //comprobamos que el usuario no sea admin
        //que el usuario no este subscrito a un plan
        return  $user->role_id !==Role::ADMIN && ! $user->subscribed('main');


    }
    //retorna verdero si no esta inscrito
    public function inscribe(User $user, Course $course){
        //se va a poder inscribir si no esta inscrito en el curso
        //comprueba si dentro de la relacion n a n alguna de los estudiantes es este estudiante (el usuario actual)
        return !$course->students->contains($user->student->id);


    }
    //retorna verdero(puede hacer la review)
    public function review(User $user, Course $course){
        //si todavia no ha hecho una valoracion va a poder usarla
        //comprueba si dentro de la relacion hay un user_id igual al de autenticado
        return !$course->reviews->contains('user_id',$user->id);


    }




}
