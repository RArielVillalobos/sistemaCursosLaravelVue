@extends('layouts.app')

@section('jumbotron')
    @include('partials.jumbotron',['title'=>__('Configura tu perfil'),'icon'=>'user-circle'])


@endsection

@push('styles')

<link rel="stylesheet" src="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
@endpush

@section('content')
    <div class="pl-5 pr-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card-header">
                    {{__('Actualiza tus datos')}}

                </div>
                <div class="card-body" style="background: white">
                    <form action="{{route('profile.update')}}" method="post" novalidate id="formulario">
                        @csrf
                        @method('PUT')

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{__('Correo electrónico')}}</label>
                            <div class="col-md-6">
                                                 {{-- queremos el old y si no esta queremos el email de la variable usuario--}}
                                <input required autofocus id="email" name="email" value="{{old('email') ?: $user->email}}" type="email" readonly class="form-control {{$errors->has('email') ? ' is_invalid' :''}}">

                                @if($errors->has('email'))
                                    <span class="invalid-feedback"><strong>{{$errors->first('email')}}</strong></span>
                                @endif
                            </div>


                        </div>
                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{__('Contraseña')}}</label>
                            <div class="col-md-6">

                                <input required autofocus id="password" name="password" type="password"  class="form-control {{$errors->has('password') ? ' is_invalid' :''}}">

                                @if($errors->has('password'))
                                    <span class="invalid-feedback"><strong>{{$errors->first('password')}}</strong></span>
                                @endif
                            </div>


                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{__('Confirma la contraseña')}}</label>
                            <div class="col-md-6">

                                <input  required autofocus id="password-confirm" name="password_confirmation" type="password"  class="form-control {{$errors->has('password') ? ' is_invalid' :''}}">

                                @if($errors->has('password'))
                                    <span class="invalid-feedback"><strong>{{$errors->first('password')}}</strong></span>
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

            </div>

        </div>

    </div>


@endsection

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