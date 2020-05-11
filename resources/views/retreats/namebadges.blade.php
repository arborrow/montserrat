@extends('report')
@section('content')

<div class="namebadges" id="namebadges">
    @if (!isset($cresults))
        <p> Currently, there are no registered retreatants.</p>
    @else


        @foreach ($cresults->chunk(6) as $chunk)
        Name Badge Page #{{ $loop->index+1 }} of {{$loop->count}} for {{ $event->title }} printed on {{date('l, F j, Y H:i')}}
        <table>
                @foreach ($chunk as $label)
                  @if ($loop->odd)
                    <tr>
                    <td>
                      <img src="{{URL('/images/mrhlogoblack.png')}}" align="center" width="200px" height="64px"><br />
                      {{ $label }}
                    </td>
                  @endIf
                  @if ($loop->even)
                    <td>
                      <img src="{{URL('/images/mrhlogoblack.png')}}" align="center" width="200px" height="64px"></br>
                      {{ $label }}
                    </td>
                  </tr>
                  @endIf
                @endforeach
            </table>
        @endforeach

    @endif
</div>
@stop
