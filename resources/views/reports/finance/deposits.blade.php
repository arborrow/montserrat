@extends('report')
@section('content')

<div class ="retreat_deposits">
<h2>Open Deposit Report </h2> 
@if (!$grouped_payments->isEmpty())
     
<hr />
@foreach($grouped_payments as $retreat_id => $group_payments)
<strong>{{$retreat_id}} </strong><br />
    
 <table width="100%">
        <th class="row-donor">Donor</th>
        <th class="row-pledged">Date</th>
        <th class="row-pledged">Amount</th>
                
    @foreach($group_payments->sortBy('donation.contact.sort_name') as $payment)
    <tr>
        <td>{{$payment->donation->contact->full_name}}</td>
        <td>{{$payment->payment_date->format('m/d/Y')}}</td>
        <td>${{number_format($payment->payment_amount,2)}}</td>
    </tr>    
    @endforeach  
 </table> 
<strong>Total of {{$group_payments->count()}} Deposit payments for {{$retreat_id}} totaling ${{number_format($group_payments->sum('payment_amount'),2)}} </strong>
    <hr />
   @endforeach
   <strong>Grand total of all payments: ${{number_format($payments->sum('payment_amount'),2)}} <br />
   @endIf    
<br />

    <span class='pagefooter'>
    Report run on {{date('l, F j, Y H:i')}}
    </span>
</div>
@stop
