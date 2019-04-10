@extends('layouts.app')

@section('jumbotron')
    @include('partials.jumbotron',['title'=>'Cursos a los que estas suscrito','icon'=>'table'])
@endsection

@section('content')
    <div class="pd-5 pr-5">
        <div class="row justify-content-center">
            @forelse($courses as $course)
                <div class="col-md-3">
                    @include('partials.courses.card_course')

                </div>

            @empty
                <div class="alert alert-dark">
                    {{__C('Todavia no estas suscrito a un curso')}}
                </div>

            @endforelse

        </div>

    </div>

@endsection