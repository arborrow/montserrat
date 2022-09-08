@extends('report')
@section('content')

<div class="namebadges" id="namebadges" style="width:100%; margin:0px;">
    @if (!isset($cresults))
        <p> Currently, there are no registered retreatants.</p>
    @else


        @foreach ($cresults->chunk(8) as $chunk)
            <header>
                Name Badge Page #{{ $loop->index+1 }} of {{$loop->count}} for {{ $event->title }} printed on {{date('l, F j, Y H:i')}}
            </header>
            <table style="table-layout:fixed; width:80%; padding:0in; align:center;">
                @foreach ($chunk as $label)
                  @if ($loop->odd)
                    <tr>
                    <td style="text-align:center; font-size:26pt;">
                      <div style="height:2.20in; overflow:hidden; vertical-align:top;">
                      <img src="{{URL('/images/mrhlogoblack.png')}}" align="center" width="200px" height="64px">
                      <br /><br />
                      <strong>{{ $label }}</strong>
                    </div>
                    </td>
                    @if ($loop->last)
                      <td style="text-align:center; font-size:26pt;">
                      </td>
                    </tr>
                    @endIf
                  @endIf
                @if ($loop->even)
                  <td style="text-align:center; font-size:26pt;">
                      <div style="height:2.20in; overflow:hidden; vertical-align:top;">
                      <img src="{{URL('/images/mrhlogoblack.png')}}" align="center" width="200px" height="64px">
                      <br /><br /><strong>{{ $label }}</strong>
                    </div>
                  </td>
                  </tr>

                  @endIf
                @endforeach
            </table>
            <footer></footer>
        @endforeach


    @endif
</div>
@stop
