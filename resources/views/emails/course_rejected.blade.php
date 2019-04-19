@component('mail::message')
#{{__('Curso Rechazado')}}

{{__('Tu curso :course ha sido rechazado',['course'=>$course->name])}}
<img class="img-responsive" src="{{$course->pathAttachment()}}" alt="{{$course->name}}">

@component('mail::button',['url'=>url('/')])
{{__('Ir a la plataforma')}}

@endcomponent
{{__('Gracias')}},<br>
{{config('app.name')}}
@endcomponent