@extends('report')
@section('content')

<div class="namebadges" id="namebadges">
    @if (!isset($results))
        <p> Currently, there are no registered retreatants.</p>
    @else

        @foreach ($results as $result)
            <p>{!!$result!!}</p>
        @endforeach

    @endif
</div>
@stop
