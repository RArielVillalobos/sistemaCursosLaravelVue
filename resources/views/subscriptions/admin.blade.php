@extends('layouts.app')


@section('jumbotron')
    @include('partials.jumbotron',[
    'title'=>__("Subscribite ahora a uno de nuestros planes"),
    'icon'=>'globe'
    ]);

@endsection

@section('content')

    <div class="pl-5 pr-5">
        <div class="row justify-content-center">
            <table class="table table-hover table-dark">

                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Plan</th>
                            <th scope="col">Id Subscripción</th>
                            <th scope="col">Cantidad</th>
                            <th scope="col">Alta</th>
                            <th scope="col">Finaliza</th>
                            <th scope="col">Cancelar/Renaudar</th>
                        </tr>

                    </thead>
                <tbody>
                    @forelse($subscriptions as $subscription)
                        <tr>
                            <td>{{$subscription->id}}</td>
                            <td>{{$subscription->name}}</td>
                            <td>{{$subscription->stripe_plan}}</td>
                            <td>{{$subscription->stripe_id}}</td>
                            <td>{{$subscription->quantity}}</td>
                            <td>{{$subscription->created_at->format('d/m/Y')}}</td>
                            <td>{{$subscription->ends_at?$subscription->ends_at->format('d/m/Y'): __('Subscripción activa')}}</td>
                            <td>
                                @if($subscription->ends_at)
                                    <form action="{{route('subscriptions.resume')}}" method="post">
                                        @csrf
                                        <input type="hidden" name="plan" value="{{$subscription->name}}">
                                        <button type="submit" class="btn btn-success">{{__('Renaudar')}}</button>

                                    </form>


                                @else
                                    <form action="{{route('subscription.cancel')}}" method="post">
                                        @csrf
                                        <input type="hidden" name="plan" value="{{$subscription->name}}">
                                        <button type="submit" class="btn btn-danger">{{__('Cancelar')}}</button>

                                    </form>

                                @endif
                            </td>
                        </tr>


                    @empty
                        <tr>
                            <td colspan="8">{{__('No hay ninguna subscripcion disponible')}}</td>
                        </tr>

                    @endforelse

                </tbody>


            </table>

        </div>

    </div>


@endsection