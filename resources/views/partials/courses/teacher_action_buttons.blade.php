
<div class="btn-group">
    @if((int)$course->status===\App\Course::PUBLISHED)

        <a class="btn btn-course" href="{{route('courses.detail',['slug'=>$course->slug])}}">
            <i class="fa fa-eye">{{__('Detalle')}}</i>
        </a>
        <a class="btn btn-warning  btn-course" href="{{route('courses.edit',['slug'=>$course->slug])}}">
            <i class="fa fa-pencil">{{__('Editar curso')}}</i>
        </a>
        @include('partials.courses.btn_forms.delete')
    @elseif((int)$course->status===\App\Course::PENDING)

        <a class="btn btn-primary text-white" href="#">
            <i class="fa fa-eye">{{__('Curso pendiente de revision')}}</i>
        </a>
        <a class="btn btn-course" href="{{route('courses.detail',['slug'=>$course->slug])}}">
            <i class="fa fa-eye"></i>
        </a>
        <a class="btn btn-warning btn-course" href="{{route('courses.edit',['slug'=>$course->slug])}}">
            <i class="fa fa-pencil">{{__('Editar curso')}}</i>
        </a>
        @include('partials.courses.btn_forms.delete')

    @else
        <a class="btn btn-warning btn-course" href="#">
            <i class="fa fa-pause">{{__('Curso rechazado')}}</i>
        </a>
        @include('partials.courses.btn_forms.delete')
    @endif

</div>