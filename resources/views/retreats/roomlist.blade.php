@extends('report')
@section('content')

<div class="roomlist" id="roomlist">
    @if (!isset($results))
        <p> Currently, there are no room assignments.</p>
    @else

        @foreach ($results as $building => $floors)
            <header>
                <h2>
                    {{ $event->title }} Room List
                </h2>
                <h3>
                    {{ $event->start_date->format('F d, Y h:i A') }} - {{ $event->end_date->format('F d, Y h:i A') }}
                </h3>
            </header>
            <table class="table table-bordered table-striped table-hover" id='buildings'>
                <caption>
                    <h1>{{ $building }}</h1>
                </caption>
                <tr>
                    @foreach ($floors as $floor => $rooms)
                        <td class='rooms'>
                            <table class='rooms'>
                                <thead>
                                    <tr>
                                        <th class='room' stlye='width:10%'>Room #</th>
                                        <th class='retreatant' stlye='width:80%'>Retreatant</th>
                                        <th class='blank'>Time</th>
                                        <th class='blank'>Temp</th>
                                        <th class='blank'>Init.</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($rooms as $room => $retreatant)
                                    <tr class='room'>
                                        <td class='room' stlye='width:10%'> {{ $room }} </td>
                                        <td class='retreatant' stlye='width:80%'> {{ $retreatant }} </td>
                                        <td class='blank'> </td>
                                        <td class='blank'> </td>
                                        <td class='blank'> </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </td>
                    @endforeach
                </tr>
            </table>
            <hr />
            <footer>
                Printed on {{date('l, F j, Y H:i')}}
                <img src="{{URL('/images/mrhlogoblack.png')}}" align="right" width="200px" height="64px">
            </footer>
        @endforeach

    @endif
</div>
@stop
