@extends('layouts.app')

@section('jumbotron')
       @include('partials.jumbotron',['title'=>__('Administrar Curso'),'icon'=>'unlock-alt'])
@endsection

@section('content')
    <div class="pl-5 pr-5">
        <courses></courses>
        

    </div>

@endsection

@push('scripts')
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
@endpush