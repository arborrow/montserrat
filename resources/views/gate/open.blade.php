@extends('template')
@section('content')
@if(!$hours)
<h1>The gate is now open.</h1>
@else
<h1>The gate will remain open for {{ $hours }} hours.</h1>
@endif
@stop