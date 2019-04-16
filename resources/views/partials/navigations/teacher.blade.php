@include('partials.navigations.student_teacher')
<li><a class="nav-link" href="{{route('teacher.courses')}}">{{__("Cursos desarrollados por mi")}}</a></li>
<li><a class="nav-link" href="{{route('courses.create')}}">{{__("Crear curso")}}</a></li>
@include('partials.navigations.logged')