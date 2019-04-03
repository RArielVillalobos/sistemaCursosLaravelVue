<?php

namespace App\Policies;

use App\User;
use App\Course;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Role;
use Illuminate\Support\Collection;

class CoursePolicy
{
    use HandlesAuthorization;

    //dice si un usuario se puede subscribir o no a un curso
    public function opt_for_course(User $user,Course $course){
        //si el usuario no es profesor o no es el que imparte el curso si puede tomarlo
        return ! $user->teacher||$user->teacher->id !==$course->id;



    }

    public function subscribe(User $user){
        //comprobamos que el usuario no sea admin
        //que el usuario no este subscrito a un plan
        return  $user->role_id !==Role::ADMIN && ! $user->subscribed('main');


    }

    public function inscribe(User $user, Course $course){
        //comprueba si dentro de la relacion n a n alguna de los estudiantes es este estudiante (el usuario actual)
        return $course->students->contains($user->student->id);


    }


}
