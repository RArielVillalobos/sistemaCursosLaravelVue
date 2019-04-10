<div class="col-2">
    @auth
        @can('opt_for_course',$course)
            {{-- si no esta subscrito en algun plan o no es admin--}}
            @can('subscribe',\App\Course::class)
                <a class="btn btn-subscribe btn-bottom btn-block" href="{{route('subscription.plans')}}">
                    <i class="fa fa-bolt">{{__(" Subscribirme")}}</i>
                </a>

            @else
                @can('inscribe',$course)
                    <a class="btn btn-subscribe btn-bottom btn-block" href="{{route('courses.inscribe',[$course->slug])}}">
                        <i class="fa fa-bolt">{{__(" Inscribirme")}}</i>
                    </a>


                @else
                    <a class="btn btn-subscribe btn-bottom btn-block" href="#">
                        <i class="fa fa-bolt">{{__(" Inscrito")}}</i>
                    </a>

                @endcan

            @endcan


        @else
            <a class="btn btn-subscribe btn-bottom btn-block" href="#">
                <i class="fa fa-user">{{__(" Soy autor")}}</i>
            </a>

        @endcan
    @else
        <a class="btn btn-subscribe btn-bottom btn-block" href="{{route('login')}}">
            <i class="fa fa-user">{{__(" Acceder")}}</i>
        </a>
    @endauth
</div>