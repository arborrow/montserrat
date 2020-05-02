<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<p>
		Dear {{ $participant->retreatant->first_name }}, <br><br>

		We are praying for you as your upcoming retreat approaches. You will find a beautiful campus, made holy by the thousands who have prayed here, that is both hospitable and restorative.<br><br>

		Check-in for your retreat is between 4:00 – 6:00 p.m. on {{ $participant->retreat_start_date->format('l F j, Y') }}. Dinner will be served from 6:00 – 7:00 p.m. When you arrive, please come to Campion Hall to receive your room key and retreat packet. Below are some possible suggestions regarding what to bring. Some frequently asked questions can be found on our FAQs webpage but feel free to call or email should you need more information.<br><br>

		We look forward to welcoming and accompanying you during the retreat.<br><br>

		<strong><u>Special COVID-19 Considerations:</u></strong><br>
		• First and foremost, <strong><u>stay home if you are sick</u></strong>, especially if you have a fever, cough or other COVID-19 related symptoms.<br>
		• For those 65 and older or have any health issues that might put one <u>at a higher risk</u> from COVID-19, consider staying home. <br>
		• While here at Montserrat, you are expected to <u>practice social distancing</u> by maintaining appropriated distance between yourself and others. <br>
		• Practice <u>good hygiene</u> including: frequent hand washing and using hand sanitizer when entering common spaces. <br>
		• Be vigilant to <u>cover all coughs and sneezes</u> with elbow and be mindful to not touch your face. <br>
		• After entering the <u>chapel</u> (or other common spaces), sanitize your hands and <u>wear a face mask</u> during talks and Mass. <br>
		• After entering the Simons Common Dining Hall, sanitize hands and keep appropriate distance (no more than one person per table unless they are of the same household). <br>

		In the Lord,<br><br>
		Fr. Anthony Borrow, S.J.<br>
		Director<br><br>

		P.S. If you have a moment, kindly <a href="{{ url('intercept/'.$encodedUrl ) }}">click here to confirm your attendance</a>. If your plans have changed kindly let us know by calling us at 940-321-6020 or emailing us at registration@montserratretreat.org. We would be happy to help you reschedule your retreat.<br><br>

		What is provided:<br>
		• All meals, snacks and beverages<br>
		• Bed linens, pillows, towels, and washcloths<br>
		• Each room has a private bath and individually controlled cooling/heating units<br><br>

		What to bring:<br>
		• <strong>In light of COVID-19, you are expected to bring a <u>face mask</u></strong><br>
		• Personal medicines, toiletries and hairdryer<br>
		• Comfortable, casual clothes and walking shoes<br>
		• A pen, journal or notebook<br>
		• A water bottle for taking beverages out of the dining hall<br>
		• All buildings are air-conditioned in the summer, so a light jacket or sweater may be helpful<br>
	</p>
</body>
</html>
