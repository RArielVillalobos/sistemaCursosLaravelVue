<form action="{{route('courses.destroy',['slug'=>$course->slug])}}" method="post">
    @csrf

    @method('DELETE')
    <button class="btn btn-danger">
        <i class="fa fa-trash">{{__('Eliminar curso')}}</i>
    </button>




</form>