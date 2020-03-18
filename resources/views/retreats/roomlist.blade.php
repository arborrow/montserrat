@extends('template')
@section('content')

<div class="row bg-cover" id="upcoming">
    <div class="col-12">
        <div class="row"><h1>Room List for {{ $event->title }}</h1>
        </div>
    </div>
    <div class="col-12">
        @if (!isset($results))
            <p> Currently, there are no room assignments.</p>
        @else

            @foreach ($results as $building => $floors)

                <table class="table table-bordered table-striped table-hover">
                    <caption><h3>{{ $building }}</h3></caption>
                    <tr>
                        @foreach ($floors as $floor => $rooms)
                            <td>
                                <table>
                                    <thead>
                                        <tr>
                                            <td>Room #</td>
                                            <td>Retreatant</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($rooms as $room => $retreatant)
                                        <tr>
                                            <td>{{ $room }}</td>
                                            <td>{{ $retreatant }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </td>
                        @endforeach
                    </tr>
                </table>
            @endforeach

        @endif
    </div>
</div>
@stop
