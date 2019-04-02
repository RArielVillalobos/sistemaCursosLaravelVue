<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Course;

class CourseController extends Controller
{
    //

    //accedemos directamente al curso
    public function show(Course $course){
        dd($course);

    }
}
