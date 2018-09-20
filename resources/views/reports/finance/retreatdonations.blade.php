@extends('report')
@section('content')

<div class ="retreatdonations">
<h2>Retreat Donations for Retreat #{{$retreat->idnumber}} - {{$retreat->retreat_name}} ({{$retreat->start_date->format('F d, Y')}}) </h2> 
@if (!$grouped_donations->isEmpty())
     
<hr />
@foreach($grouped_donations as $donation_description => $group_donations)
<strong>{{$donation_description}} </strong><br />
    
 <table width="100%">
        <th class="row-donor">Donor</th>
        <th class="row-pledged">Pledged</th>
        <th class="row-paid">Paid</th>
        <th class="row-balance">Balance</th>

                
    @foreach($group_donations->sortBy('contact.sort_name') as $donation)
    <tr>
        <td>{{$donation->contact->display_name}}</td>
        <td>{{number_format($donation->donation_amount,2)}}</td>
        <td>{{number_format($donation->payments->sum('payment_amount'),2)}}</td>
        <td>${{number_format(($donation->donation_amount - $donation->payments->sum('payment_amount')),2)}}</td>
    </tr>    
    @endforeach  
 </table> 
<strong>Total of {{$group_donations->count()}} donations for {{$donation_description}} totaling ${{number_format($group_donations->sum('payments_paid'),2)}} </strong>
    <hr />
   @endforeach
   <strong>Grand total of all payments: ${{number_format($donations->sum('payments_paid'),2)}} <br />
   @endIf    
<br />

    <span class='pagefooter'>
    Report run on {{date('l, F j, Y H:i')}}
    </span>
</div>
@stop