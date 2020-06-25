@extends('report')
@section('content')

<div class="tableplacards" id="tableplacards" style="width:100%; margin:0px;">
    @if (!isset($cresults))
        <p> Currently, there are no registered retreatants.</p>
    @else


        @foreach ($cresults->chunk(2) as $chunk)
            <header>
                Table Placards Page #{{ $loop->index+1 }} of {{$loop->count}} for {{ $event->title }} printed on {{date('l, F j, Y H:i')}}
            </header>
            <table style="table-layout:fixed; width:100%; padding:0in; align:center;">
                @foreach ($chunk as $label)
                    <tr style="height:2.5in;">
                        <td style="text-align:center; font-size:40pt; border-top:1pt dashed black;">
                            <div style="height:1.25in; overflow:hidden; vertical-align:middle; padding-top:0.50in; padding-bottom:0.50in;" class="flipped">
                                <img src="{{URL('/images/mrhlogoblack.png')}}" align="center" width="175px" height="56px">
                                {{ $label }}
                            </div>
                        </td>
                    </tr>

                    <tr style="height:2.5in;">
                        <td style="text-align:center; font-size:40pt; border-bottom:1pt dashed black;">
                            <div style="height:1.25in; overflow:hidden; vertical-align:middle;  padding-top:0.50in; padding-bottom:0.50in;">
                                <img src="{{URL('/images/mrhlogoblack.png')}}" align="center" width="175px" height="56px">
                                {{ $label }}
                            </div>
                        </td>
                    </tr>

                @endforeach
            </table>

            <footer></footer>
        @endforeach


    @endif
</div>
@stop
