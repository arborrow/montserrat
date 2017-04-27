@extends('template')
@section('content')
<h1>Welcome to Polanco, the Montserrat Jesuit Retreat House Database!</h1>
<p>{!! $quote !!}</p>
<p>Polanco is a work in progress and is intended to be an in-house tool for managing information and making all of our lives easier.</p>
<div class="responsiveCal">
    <iframe src="https://calendar.google.com/calendar/embed?wkst=2&amp;bgcolor=%23FFFFFF&amp;src=montserratretreat.org_6rll8gg5fu0tmps7riubl0g0cc%40group.calendar.google.com&amp;color=%23711616&amp;ctz=America%2FChicago" style="border:solid 1px #777" width="800" height="600" frameborder="0" scrolling="no"></iframe>
</div>
@stop