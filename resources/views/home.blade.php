@extends('template')
@section('content')
<div class="row">
  <div class="col-12 text-center">
    <h1>Welcome to Polanco!</h1>
    <p><a href="https://en.wikipedia.org/wiki/Juan_Alfonso_de_Polanco" target="_blank">Polanco</a> is your friendly assistant for managing information and making all of our lives a little easier.</p>
    <p><a href="https://bible.usccb.org/bible/readings/" target="_blank">Today's Readings</a></p>
    <p>{!! $quote !!}</p>
  </div>
</div>
@stop
