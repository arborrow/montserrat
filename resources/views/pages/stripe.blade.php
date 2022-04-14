@extends('template')
@section('content')
<h1>Stripe</h1>
<p>Stripe landing page for testing API.<p>
    <ol>
    @foreach($reports as $report)
    <li>{{ $report->id }} ({{ $report->object }})   
    @endforeach
    </ol>
@stop
