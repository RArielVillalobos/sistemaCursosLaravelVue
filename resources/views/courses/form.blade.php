@extends('layouts.app')

@section('jumbotron')
    @include('partials.jumbotron',['title'=>__('Dar de alta nuevo curso'),'icon'=>'edit'])

@endsection

@section('content')
    <div class="pl-5 pr-5">
        <form method="POST" action="{{!$course->id? route('courses.store') : route('courses.update',['slug'=>$course->slug])}}" novalidate enctype="multipart/form-data">
            @if($course->id)
                @method('PUT')
            @endif

            @csrf

            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            {{__('Información de curso')}}

                        </div>
                        <div class="card-body">
                            <div class="form-group row">
                                <label for="name" class="col-sm-4 col-form-label text-md-right">{{__('Nombre del curso')}}</label>
                                <div class="col-md-6">
                                    <input type="text" name="name" id="name" class="form-control{{$errors->has('name')? ' is-invalid' :''}}" value="{{old('name') ?: $course->name}}" required>
                                    @if($errors->has('name'))
                                        <span class="invalid-feedback">
                                            <strong>{{$errors->first('name')}}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="level_id" class="col-sm-4 col-form-label text-md-right">{{__('Nivel del curso')}}</label>
                                <div class="col-md-6">
                                    <select name="level_id" id="level_id" class="form-control">
                                        {{--devolvera un array que tendra como clave el nombre e id --}}
                                        @foreach(\App\Level::pluck('name','id') as $id=>$level)
                                            <option {{(int) old('level_id') === $id || $course->level_id===$id ?'selected' :''}} value="{{$id}}">{{$level}}</option>

                                        @endforeach

                                    </select>

                                </div>

                            </div>

                            <div class="form-group row">
                                <label for="level_id" class="col-sm-4 col-form-label text-md-right">{{__('Nivel del curso')}}</label>
                                <div class="col-md-6">
                                    <select name="category_id" id="category_id" class="form-control">
                                        {{--devolvera un array que tendra como clave el nombre e id --}}
                                        @foreach(\App\Category::groupBy('name')->pluck('name','id') as $id=>$category)
                                            <option {{(int) old('category_id') === $id || $course->category_id===$id ?'selected' :''}} value="{{$id}}">{{$category}}</option>

                                        @endforeach

                                    </select>

                                </div>

                            </div>
                            <div class="form-group ml-3 mr-2">
                                <div class="col-md-6 offset-4">
                                    <input id="picture" name="picture" type="file" class="custom-file-input{{$errors->has('picture') ?' is-invalid' :''}}">
                                    <label class="custom-file-label" for="picture">{{__('Escoge una imagen para tu curso')}}</label>

                                </div>

                            </div>
                            <div class="form-group row">
                                <label for="description" class="col-md-4 col-form-label text-md-right">{{__('Descripcion del curso')}}</label>
                                <div class="col-md-6">
                                    <textarea name="description" rows="8" required class="form-control {{$errors->has('description')?' is-invalid' : ''}}" id="description">{{old('description') ?: $course->description}}</textarea>
                                    @if($errors->has('description'))
                                        <span class="invalid-feedback">
                                            <strong>{{$errors->first('description')}}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>


                        </div>



                    </div>




                </div>
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">{{__('Requisitos para tomar el curso')}}</div>
                        <div class="card-body">
                            <div class="form-group row">
                                <label for="requirements" class="col-md-4 col-form-label text-md-right">{{_('Requerimiento 1')}}</label>
                                <div class="col-md-6 ">
                                    <input name="requirements[]" id="requirement1" value="{{old('requirements.0') ? old('requirements.0') : ($course->requirements_count>0 ? $course->requirements[0]->requirement:'')}}" class="form-control{{$errors->has('requirements.0') ? ' is-invalid':''}}">
                                    @if($errors->has('requirements.0'))
                                        <span class="invalid-feedback">
                                            <strong>{{$errors->first('requirements.0')}}</strong>
                                        </span>
                                    @endif
                                </div>
                                @if($course->requirements_count>0)
                                    <input type="hidden" name="requiremet_id0" value="{{$course->requirements[0]->id}}">

                                @endif


                            </div>
                            <div class="form-group row">
                                <label for="requirements" class="col-md-4 col-form-label text-md-right">{{_('Requerimiento 2')}}</label>
                                <div class="col-md-6 ">
                                    <input name="requirements[]" id="requirement2" value="{{old('requirements.1') ? old('requirements.1') : ($course->requirements_count>1 ? $course->requirements[1]->requirement:'')}}" class="form-control{{$errors->has('requirements.1') ? ' is-invalid':''}}">
                                    @if($errors->has('requirements.1'))
                                        <span class="invalid-feedback">
                                            <strong>{{$errors->first('requirements.1')}}</strong>
                                        </span>
                                    @endif
                                    @if($course->requirements_count>1)
                                        <input type="hidden" name="requiremet_id1" value="{{$course->requirements[1]->id}}">

                                    @endif
                                </div>

                            </div>

                        </div>


                    </div>

                </div>


                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">{{__('Metas del  curso')}}</div>
                        <div class="card-body">
                            <div class="form-group row">
                                <label for="goal1" class="col-md-4 col-form-label text-md-right">{{_('Meta 1')}}</label>
                                <div class="col-md-6 ">
                                    <input name="goals[]" id="goal1" value="{{old('goals.0') ? old('goals.0') : ($course->goals_count>0 ? $course->goals[0]->goal:'')}}" class="form-control{{$errors->has('goals.0') ? ' is-invalid':''}}">
                                    @if($errors->has('goals.0'))
                                        <span class="invalid-feedback">
                                            <strong>{{$errors->first('goals.0')}}</strong>
                                        </span>
                                    @endif
                                </div>
                                @if($course->goals_count>0)
                                    <input type="hidden" name="goals_id0" value="{{$course->goals[0]->id}}">

                                @endif


                            </div>
                            <div class="form-group row">
                                <label for="goal2" class="col-md-4 col-form-label text-md-right">{{_('Meta2')}}</label>
                                <div class="col-md-6 ">
                                    <input name="goals[]" id="goal2" value="{{old('goals.1') ? old('goals.1') : ($course->goals_count>1 ? $course->requirements[1]->goal:'')}}" class="form-control{{$errors->has('goals.1') ? ' is-invalid':''}}">
                                    @if($errors->has('goals.1'))
                                        <span class="invalid-feedback">
                                            <strong>{{$errors->first('goals.1')}}</strong>
                                        </span>
                                    @endif
                                    @if($course->goals_count>1)
                                        <input type="hidden" name="goal_id1" value="{{$course->goals[1]->id}}">

                                    @endif
                                </div>

                            </div>

                        </div>


                    </div>

                </div>

                <div class="col-md-8">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group row mb-0">
                                <div class="col-md-4 offset-5">
                                    <button type="submit" name="revision" class="btn btn-danger">{{__($btnText)}}</button>

                                </div>

                            </div>

                        </div>
                    </div>

                </div>

            </div>


        </form>

    </div>
@endsection