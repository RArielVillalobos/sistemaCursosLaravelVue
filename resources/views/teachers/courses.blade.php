@extends('layouts.app')

@section('jumbotron')
    @include('partials.jumbotron',['title'=>__('Cursos que imparto'),'icon'=>'building'])

@endsection

@section('content')
    <div class="pl-5 pr-5">
        <div class="row justify-content-center">
            @forelse($courses as $course)
                <div class="col-md-8 offset-md-2 listing-block">
                    <div class="media" style="height: 200px;">
                        <img style="height: 200px; width: 200px" class="img-rounded" src="{{asset($course->pathAttachment())}}" alt="{{$course->name}}">
                        <div class="media-body pl-3" style="height: 200px">
                            <div class="price">
                                <small class="badge-danger text-white text-center">{{$course->category->name}}</small>
                                <small>{{__('Curso:')}} {{$course->name}}</small>
                                <small>{{__('Estudiantes:')}} {{$course->students_count}}</small>
                            </div>
                            <div class="stats">
                                {{$course->created_at->format('d/m/Y')}}
                                @include('partials.courses.rating',['rating'=>$course->custom_rating])
                                @include('partials.courses.teacher_action_buttons')
                            </div>


                        </div>
                    </div>

                </div>

            @empty
                <div class="alert alert-dark">
                    {{__('No tienes cursos todavia')}}
                    <a class="btn btn-course btn-block" href="{{route('courses.create')}}">
                        {{__('Crear mi primer curso')}}


                    </a>

                </div>

            @endforelse

            <div class="col-md-6">
                {{$courses->links()}}
            </div>


        </div>

    </div>

@endsection