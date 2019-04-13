@extends('layouts.app')

@section('jumbotron')
    @include('partials.jumbotron',['title'=>__('Configura tu perfil'),'icon'=>'user-circle'])


@endsection

@push('styles')

<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
@endpush

@section('content')
    <div class="pl-5 pr-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card-header">
                    {{__('Actualiza tus datos')}}
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif


                </div>
                <div class="card-body" style="background: white">
                    <form action="{{route('profile.update')}}" method="post" novalidate id="formulario">
                        @csrf
                        @method('PUT')

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{__('Correo electrónico')}}</label>
                            <div class="col-md-6">
                                                 {{-- queremos el old y si no esta queremos el email de la variable usuario--}}
                                <input id="email" name="email" value="{{old('email') ?: $user->email}}" type="email" readonly class="form-control {{$errors->has('email') ? ' is_invalid' :''}}">

                                @if($errors->has('email'))
                                    <span class="invalid-feedback"><strong>{{$errors->first('email')}}</strong></span>
                                @endif
                            </div>


                        </div>
                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{__('Contraseña')}}</label>
                            <div class="col-md-6">

                                <input  id="password" name="password" type="password"  class="form-control {{$errors->has('password') ? 'is_invalid' :''}}">

                                @if($errors->has('password'))
                                    <span class="invalid-feedback"><strong>{{$errors->first('password')}}</strong></span>
                                @endif
                            </div>


                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{__('Confirma la contraseña')}}</label>
                            <div class="col-md-6">

                                <input  id="password-confirm" name="password_confirmation" type="password"  class="form-control {{$errors->has('password_confirmation') ? 'is_invalid' :''}}"  required autofocus>

                                @if($errors->has('password_confirmation'))
                                    <span class="invalid-feedback"><strong>{{$errors->first('password_confirmation')}}</strong></span>
                                @endif
                            </div>


                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">{{__('Actualizar datos')}}</button>


                            </div>


                        </div>
                    </form>


                </div>
                @if(!$user->teacher)
                    <div class="card">
                        <div class="card-header">
                            {{__('Convertirme en profesor de la plataforma')}}

                        </div>
                        <div class="card-body">
                            <form action="{{route('solicitude.teacher')}}" method="post">
                                @csrf
                                <button type="submit" class="btn btn-outline-primary btn-block">
                                    <i class="fa fa-graduation-cap"></i>{{__('Solicitar')}}
                                </button>


                            </form>

                        </div>

                    </div>

                @else
                    <div class="card">
                        <div class="card-header">
                            {{__('Administrar los cursos que imparto')}}
                        </div>
                        <div class="card-body">
                            <a href="{{route('teacher.courses')}}" class="btn btn-secondary btn-block ">
                                <i class="fa fa-leanpub"></i> {{__('Administrar ahora')}}
                            </a>

                        </div>

                    </div>
                    <div class="card">
                        <div class="card-header">
                            {{__('Mis Estudiantes')}}

                        </div>
                        <div class="card-body">
                            <table class="table table-striped table-bordered rowrap display" cellspacing="0" id="students-table">
                                <thead>
                                    <tr>
                                        <th>{{__('ID')}}</th>
                                        <th>{{__('Nombre')}}</th>
                                        <th>{{__('Email')}}</th>
                                        <th>{{__('Cursos')}}</th>
                                        <th>{{__('Acciones')}}</th>
                                    </tr>

                                </thead>

                            </table>

                        </div>

                    </div>


                @endif

            </div>


        </div>


    </div>
    @include('partials.modal')


@endsection

@push('scripts')
    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.18/datatables.min.js"></script>


    <script type="text/javascript">

            let dt;
            let modal=$('#exampleModal');

            $(document).ready( function () {
            //convierte mi tabla en datatables
               $('#students-table').DataTable({
                   pageLength:5,
                   lengthMenu:[5,10,25,50,75,100],
                   //mensaje de procesamiento
                   processing:true,
                   //que cada vez que ordenemos,busquemos o cualquier otra cosa, la peticion se haga en el servidor
                   serverSide:true,
                   ajax: '{{route('teacher.students')}}',
                   language:{
                       url :'//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json'
                   },
                   columns:[
                       {data:'user.id'},
                       {data:'user.name'},
                       {data:'user.email'},
                       {data:'courses_formatted'},
                       {data:'actions'}
                   ]
               });

           $(document).on('click','.btnEmail',function (e) {
               e.preventDefault();

               const id=$(this).data('id');

               modal.find('.modal-title').text('{{__('Enviar mensaje')}}');
               //mostramos el boton de boton
               modal.find('#modalAction').text('{{__('Enviar mensaje')}}').show();
               let $form=$("<form id='studentMessage'></form>");
               //insertar cosas en el medio
               $form.append(`<input type="hidden" name="user_id" value=${id}>`);
               $form.append(`<textarea class="form-control" name="message"></textarea>`);
               //insertar todo en el formulario
               modal.find('.modal-body').html($form);
               modal.modal();


           })
        } );
    </script>


@endpush


{{-- @push('scripts')
   <script>
       $(document).ready(function () {
           $('#formulario').submit(function (e) {
               e.preventDefault();
               var email=$('#email').val();
               $.post('{{route('profile.update')}}',{email:email},function (response) {

                   console.log(response);

               })
           });


       });
   </script>
@endpush--}}