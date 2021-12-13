@extends('template')
@section('content')
<div class="row">
	<div class="col-lg-12 text-center">
		<h1>Welcome to Polanco, the Montserrat Jesuit Retreat House Database!</h1>
		<p><a href="https://en.wikipedia.org/wiki/Juan_Alfonso_de_Polanco" target="_blank">Polanco</a> is your friendly assistant for managing information and making all of our lives a little easier.</p>
		<p><a href="https://bible.usccb.org/bible/readings/" target="_blank">Today's Readings</a></p>
		<p>{!! $quote !!}</p>
		<div class="responsiveCal">
			<iframe src="https://calendar.google.com/calendar/embed?wkst=2&amp;bgcolor=%23FFFFFF&amp;src=montserratretreat.org_6rll8gg5fu0tmps7riubl0g0cc%40group.calendar.google.com&amp;color=%23711616&amp;ctz=America%2FChicago" style="border:solid 1px #777" width="800" height="600" frameborder="0" scrolling="no"></iframe>
		</div>
	</div>
</div>
@stop
