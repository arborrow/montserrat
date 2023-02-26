<!DOCTYPE html>
{{-- Use of snippets not implemented as they do not seem needed --}}
<html>
<head>
	<title>Gift Certificate #{{$gift_certificate->certificate_number}} Redeemed</title>
</head>
<body>
	<p>{{config('polanco.site_name')}} would like to notify you that <a href="{{URL('gift_certificate',$gift_certificate->id)}}">Gift Certificate #{{ $gift_certificate->certificate_number }}</a> has been redeemed.
	<p> On {{$gift_certificate->purchase_date->format('m/d/Y')}}, 
		{!!$gift_certificate->purchaser->contact_link_full_name!!} 
		funded a gift certificate for 
		{!!$gift_certificate->recipient->contact_link_full_name!!}
		in the amount of ${{$gift_certificate->funded_amount}}. 
	</p>
	<p>On {{$order->registration->register_date->format('m/d/Y')}}, the recipient registered for:
		{!! $gift_certificate->registration->event_link !!}.
	</p>
	<p>
		The payments to reallocate the funds from the <a href="{{URL('/payment/'.$negative_reallocation_payment->payment_id)}}">Purchaser</a> 
		and apply them toward the <a href="{{URL('/payment/'.$reallocation_payment->payment_id)}}">Recipient</a> have been made. 
		Kindly ensure that the funds are appropriately reallocated to reflect the use of the gift certificate in Quickbooks.
</body>
</html>
