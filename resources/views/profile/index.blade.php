@extends('layouts.app')

@section('jumbotron')
    @include('partials.jumbotron',['title'=>__('Configura tu perfil'),'icon'=>'user-circle'])


@endsection

@push('styles')

<link rel="stylesheet" src="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
@endpush

