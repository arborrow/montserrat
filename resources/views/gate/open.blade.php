@extends('template')
@section('content')
@if(!$hours)
<h1>{{$message}}</h1>
@else
<h1>You have requested to open the gate for {{ $hours }} hours. {{$message}}</h1>
@endif
@stop
