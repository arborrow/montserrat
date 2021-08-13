<!DOCTYPE html>
{{-- Use of snippets not implemented as they do not seem needed --}}
<html>
<head>
	<title>Registration updated</title>
</head>
<body>
	<p>{{config('polanco.site_name')}} would like to notify you that <a href="{{URL('registration',$registration->id)}}">Registration #{{ $registration->id }}</a> for {!!$registration->retreatant->contact_link_full_name!!} has recently been updated as follows:</p>
	<p>for: <a href="{{ URL('retreat',$retreat->id) }}">{{ $retreat->retreat_name }}</a> ({{ $retreat->idnumber }}) - {{$retreat->retreat_type}}</p>
	<p>The registration has been canceled; however, it appears to have a deposit in the amount of: ${{ $registration->deposit }}.
	<p>Kindly ensure that the appropriate changes are made to the financial history.
</body>
</html>
