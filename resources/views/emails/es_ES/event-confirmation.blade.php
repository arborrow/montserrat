<!DOCTYPE html>
<html>
	<head>
		<title>
			Confirmando su retiro
		</title>
	</head>
	<body>
		<p>
			Saludos {{ $participant->retreatant->first_name }}, <br><br>
					@include('snippets.event-confirmation.es_ES.welcome')
					<br><br>
					@include('snippets.event-confirmation.es_ES.checkin')
					<br><br>
					@include('snippets.event-confirmation.es_ES.confirm')
					<br><br>
					@include('snippets.event-confirmation.es_ES.notices')
					<br><br>
					@include('snippets.event-confirmation.es_ES.signature')
					<br><br>
					@include('snippets.event-confirmation.es_ES.provided')
					<br><br>
					@include('snippets.event-confirmation.es_ES.bring')
		</p>
	</body>
</html>
