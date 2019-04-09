@extends('layouts.app')

@section('jumbotron')
    @include('partials.jumbotron',['title'=>'Manejar mis facturas','icon'=>'archive'])

@endsection

@section('content')
    <div class="pl-5 pr-5">
        <div class="row justify-content-center">
            <table class="table table-hover table-dark">
                <thead>
                    <tr>
                        <th>{{__('Fecha de la subscripción')}}</th>
                        <th>{{__('Coste de la subscripción')}}</th>
                        <th>{{__('Cupón')}}</th>
                        <th>{{__('Descarga Factura')}}</th>
                    </tr>
                </thead>
                <tbody>


                    @forelse($invoices as $invoice)
                        @php
                            $start_date = new DateTime();
                            $start_date->setTimestamp($invoice->period_start);
                            $fecha= $start_date->format("d-m-Y");
                        @endphp

                        <tr>

                            <td>{{$fecha}}</td>
                            <td>{{$invoice->total()}}</td>
                            @if($invoice->hasDiscount())
                                <td>
                                    {{__('Cupón')}}: ({{$invoice->coupon()}} // {{$invoice->discount()}}
                                </td>

                             @else
                                <td>{{__('No se ha utilizado cupón')}}</td>
                            @endif
                            <td><a class="btn btn-course" href="{{route('invoices.download',['id'=>$invoice->id])}}">{{_('Descargar factura')}}</a></td>
                        </tr>


                    @empty
                        <tr>
                            <td colspan="4">No hay facturas</td>
                        </tr>

                    @endforelse
                </tbody>

            </table>

        </div>

    </div>


@endsection