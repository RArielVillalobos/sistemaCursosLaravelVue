@component('mail::message')
 # {{__('Nuevo estudiante en tu curso')}}

{{__('El estudiante :student se inscrito en tu curso :course, Felicidades ',['student'=>$student,'course'=>$course->name])}}
<img class="img-responsive" src="{{url('storage/courses'.$course->picture)}}" alt="{{$course->name}}">

@component('mail::button',['url'=>url('courses/'.$course->slug),'color'=>'red'])
{{__('Ir al curso')}}
@endcomponent
{{__('Gracias')}}
{{config('app.name')}}

@endcomponent
