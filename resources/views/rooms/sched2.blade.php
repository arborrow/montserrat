@extends('template')
@section('content')



    <section class="section-padding">
        <div class="jumbotron text-left">
            <div class="panel panel-default">
                <div class="panel-heading" style="text-align: center">
                    <h1>Room Schedules for</h1>
                    <h1>
                        {!!$previous_link!!}
                        {{$dts[0]->format('F d, Y')}} - {{$dts[31]->format('F d, Y')}}
                        {!!$next_link!!}
                    </h1>
                </div>

                @if (empty($m))
                    <p> Yikes, there is nothing to schedule!</p>
                @else
                <table border="1" class="table">
                        <caption><h2>Legend:
                            <span style="background-color:yellowgreen">A=Available</span>;
                            <span style="background-color:yellow">R=Reserved</span>;
                            <span style="background-color:yellow">O=Occupied</span>;
                            <span style="background-color:lightcoral">C=Cleaning Needed</span>;
                            <span style="background-color:lightcoral">M=Maintenance Required</span>
                        </h2></caption>
                    <thead>
                        <tr>
                            <th>Room</th>
                            @foreach($dts as $dt)
                            <th>{{$dt->day}}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @if ($roomsort->isEmpty())
                            <p> Yikes, there are no rooms!</p>
                        @else

                            @foreach($roomsort as $room)

                            <tr>
                                <td><a href="{{url('room/'.$room->id)}}">{{$room->location->name}} {{$room->name}}</a></td>

                                @foreach($dts as $dt)
                                    @if (($m[$room->id][$dt->toDateString()]['status'] == 'R') ?? ($m[$room->id][$dt->toDateString()]['status'] == 'O'))
                                    <td class='warning'>
                                    {!! Html::link('registration/'.$m[$room->id][$dt->toDateString()]['registration_id'], $m[$room->id][$dt->toDateString()]['status'] , array('title'=>$m[$room->id][$dt->toDateString()]['retreat_name'].' ('.$m[$room->id][$dt->toDateString()]['retreatant_name'].')')) !!}
                                    @else
                                    <td class='success'>
                                        A
                                    @endif
                                    </td>
                                @endforeach

                            @endforeach
                            </tr>

                        @endif
                    </tbody>
                </table>
                @endif
            </div>
        </div>
    </section>
@stop
