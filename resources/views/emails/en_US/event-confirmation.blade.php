{{-- Snippets and language preference (Spanish/English) implemented --}}
<!DOCTYPE html>
<html>
<head>
	<title>Retreat Confirmation</title>
</head>
<body>
	<p>
		Dear {{ $participant->retreatant->first_name }}, <br><br>

		@include('snippets.event-confirmation.en_US.welcome')
		<br><br>
		@include('snippets.event-confirmation.en_US.checkin')
		<br><br>
		@include('snippets.event-confirmation.en_US.confirm')
		<br><br>
		@include('snippets.event-confirmation.en_US.notices')
		<br>
		@include('snippets.event-confirmation.en_US.signature')
		<br><br>
		@include('snippets.event-confirmation.en_US.provided')
		<br><br>
		@include('snippets.event-confirmation.en_US.bring')
	</p>
</body>
</html>
