@component('mail::message')
# {{__('Curso Aprobado')}}

{{__('Tu curso :course ha sido aprobado y ya está publicado en la plataforma',['course'=>$course->name])}}
<img class="img-responsive" src="{{$course->pathAttachment()}}" alt="{{$course->name}}">

@component('mail::button',['url'=>url('/courses/'. $course->slug)])
{{__('Ir al curso')}}

@endcomponent
{{__('Gracias')}},<br>
{{config('app.name')}}
@endcomponent