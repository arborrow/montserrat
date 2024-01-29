@extends('template')
@section('content')

<div class ="reconcile_open_deposits">
<h2>Open Deposit Reconciliation Report </h2><br />
@if (!$diffpg->isEmpty())
The following contacts appear to have a payment for an open deposit but no corresponding registration.
<hr />
<table width="100%">
       <th class="row-donor">Donor</th>
       <th class="row-pledged">Payment date</th>
       <th class="row-pledged">Amount</th>
@foreach($diffpg as $contact => $contact_payments)

    @foreach($contact_payments->sortBy('donation.contact.sort_name') as $payment)

    <tr>
        <td>{!!$payment->donation->contact->contact_link_full_name!!}</td>
        <td>{{$payment->payment_date->format('m/d/Y')}}</td>
        <td><a href="{{ URL('payment/'.$payment->payment_id) }}">${{number_format($payment->payment_amount,2)}}</a></td>
    </tr>
    @endforeach
   @endforeach
 </table>
   <strong>Grand total of {{$diffpg->count()}} contacts having unreconciled open deposits: ${{number_format($diffpg->sum('payment_amount'),2)}} </strong> <br />
   @endIf
<br />
@if (!$diffrg->isEmpty())
The following contacts appear to have a registration for an open deposit but no corresponding payment.
<hr />
<table width="100%">
       <th class="row-donor">Retreatant</th>
       <th class="row-pledged">Date</th>
       <th class="row-pledged">Deposit Amount</th>

@foreach($diffrg as $contact => $contact_registrations)

    @foreach($contact_registrations as $registration)

    <tr>
        <td>{!!$registration->contact->contact_link_full_name!!}</td>
        <td><a href="{{ URL('registration/'.$registration->id) }}">{{$registration->register_date->format('m/d/Y')}}</a></td>
        <td>${{ number_format($registration->deposit,2) }}
    </tr>
    @endforeach
   @endforeach
 </table>
   <strong>Grand total of {{$diffrg->count()}} contacts having unreconciled registrations. <br />
   @endIf
<br />
@if ($diffpg->isEmpty() && $diffrg->isEmpty())
  <div class="row">
  	<div class="col-lg-12 text-center">
  		<div class="text-danger"> Nothing to see here, please disperse<br />
  	<a href="https://www.youtube.com/watch?v=aKnX5wci404">
      {{ html()->img(asset('images/nothing.png'), 'Nothing to see here')->attribute('title', "Nothing to see here") }}
    </a>
  		</div>
  	</div>
  </div>
@endIf
</div>
@stop
