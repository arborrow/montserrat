@extends('report')
@section('content')

<div class ="bankdeposit">
<h2>Credit Card (Internet) Bank Deposit Report for {{$report_date->format('F d, Y')}}</h2> 
@if (!$grouped_payments->isEmpty())
     
<hr />
@foreach($grouped_payments as $donation_description => $payments)
<strong><u>{{$donation_description}}</u></strong><br />
    
 <table width="100%">
        <th class="row-donor">Donor</th>
        <th class="row-retreat">Retreat</th>
        <th class="row-pledged_amount">Pledged amount</th>
        <th class="row-payment_amount">Payment amount</th>
        <th class="row-payment_description">Payment description</th>
    
                
    @foreach($payments as $payment)
    <tr>
        <td>{{$payment->donation->contact->display_name}}</td>
        <td>
            @if (isset($payment->donation->retreat))
                {{$payment->donation->retreat_idnumber}} - {{$payment->donation->retreat_name}} ({{$payment->donation->retreat_start_date}})
            @endIf
        </td>
        <td>${{number_format($payment->donation->donation_amount,2)}}</td>
        <td>${{number_format($payment->payment_amount,2)}}</td> 
        <td>{{$payment->payment_description}}</td>
    </tr>    
    @endforeach  
 </table> 
<strong>Total of {{$payments->count()}} {{$donation_description}} payments totaling: ${{number_format($payments->sum('payment_amount'),2)}} </strong>
    <hr />
   @endforeach
   <strong>Grand total of all payments: ${{number_format($grand_total,2)}} <br />
   @endIf    
<br />

    <span class='pagefooter'>
            Report run on {{date('l, F j, Y H:i')}}
    </span>
</div>
@stop