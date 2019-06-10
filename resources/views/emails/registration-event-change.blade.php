<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<p>{{config('polanco.site_name')}} would like to notify you that <a href="{{URL('registration',$registration->id)}}">Registration #{{ $registration->id }}</a> for {!!$registration->retreatant->contact_link_full_name!!} has recently been updated as follows:</p>
	<p>from - <a href="{{ URL('retreat',$original_event->id) }}">{{ $original_event->retreat_name }}</a> ({{ $original_event->idnumber }}) - {{$original_event->retreat_type}}</p>
	<p>to - <a href="{{ URL('retreat',$retreat->id) }}">{{ $retreat->retreat_name }}</a> ({{ $retreat->idnumber }}) - {{$retreat->retreat_type}}</p>
	<p>Kindly ensure that the appropriate changes are made to the financial history.
</body>
</html>
