@extends('template')
@section('content')

<div class="row bg-cover">
    <div class="col-lg-12 text-center">
        <h2>Room Schedules for</h2>
        <h2>
            {!!$previous_link!!}
            {{$dts[0]->format('F d, Y')}} - {{$dts[31]->format('F d, Y')}} 
            {!!$next_link!!}
        </h2>
        <p class="lead">
            <span class="table-success">A=Available</span>
            <span class="table-warning">R=Reserved</span>
            <span class="table-warning">O=Occupied</span>
            <span class="table-danger">C=Cleaning Needed</span>
            <span class="table-danger">M=Maintenance Required</span>
        </p>
    </div>

    <div class="col-lg-12 text-center">
        @if (empty($m))
            
                <p>Yikes, there is nothing to schedule!</p>
            </div>
        @else
            <table class="table-sm table-bordered table-hover mx-auto">
                <thead>
                    <tr>
                        <th scope="col">Room</th>
                        @foreach($dts as $dt)
                        <th scope="col">{{$dt->day}}</th>
                        @endforeach
                    </tr>                   
                </thead>
                <tbody>
                    @if ($roomsort->isEmpty())
                        <p> Yikes, there are no rooms!</p>
                    @else
                        
                        @foreach($roomsort as $room)
                    
                        <tr>
                            <th scope="row">
                                <a href="{{url('room/'.$room->id)}}">{{$room->location->name}} {{$room->name}}</a>
                            </th>
                            
                            @foreach($dts as $dt)
                                @if (($m[$room->id][$dt->toDateString()]['status'] == 'R') OR ($m[$room->id][$dt->toDateString()]['status'] == 'O')) 
                                <td class="table-warning">
                                {!! Html::link('registration/'.$m[$room->id][$dt->toDateString()]['registration_id'], $m[$room->id][$dt->toDateString()]['status'] , array('title'=>$m[$room->id][$dt->toDateString()]['retreat_name'].' ('.$m[$room->id][$dt->toDateString()]['retreatant_name'].')')) !!} 
                                @else
                                <td class="table-success">
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

    {{-- <section class="section-padding">
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
                    <p></p>
                @else
                
                @endif
            </div>
        </div>
    </section> --}}
@stop
