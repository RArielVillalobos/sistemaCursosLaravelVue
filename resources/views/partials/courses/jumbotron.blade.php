<div class="row mb-4">
    <div class="col-md-12">
        <div class="card " style=" background-image: url({{url('/images/jumbotron.png')}})" >
            <div class="text-white text-center py-5 px-4 my-5 d-flex justify-content-around">
                <div class="col-5">
                    <img class="img-fuild" src="{{$course->pathAttachment()}}">

                </div>
                <div class="col-5 text-left">
                    <h1>{{__('Curso')}}: {{$course->name}}</h1>
                    <h4>{{__('Profesor')}}: {{$course->teacher->user->name}}</h4>
                    <h5>{{__('Categoria')}}: {{$course->category->name}}</h5>
                    <h5>{{__('Fecha de publicación')}}: {{$course->created_at->format('d/m/y')}}</h5>
                    <h5>{{__('Fecha de actualización')}}: {{$course->updated_at->format('d/m/y')}}</h5>
                    <h6>{{__('Estudiantes inscritos')}}: {{$course->students_count}}</h6>
                    <h6>{{__('Número de valoraciones inscritos')}}: {{$course->reviews_count}}</h6>

                    @include('partials.courses.rating')


                </div>

            </div>


        </div>

    </div>


</div>