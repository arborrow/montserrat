@extends('report')
@section('content')

<div class ="bankdeposit">
@if (!$grouped_payments->isEmpty())
<h2>Bank Deposit Report for {{$report_date}}</h2> 
     
<hr />
@foreach($grouped_payments as $donation_description => $payments)
<strong>{{$donation_description}} </strong><br />
    
 <table width="100%">
        <th class="row-2 row-donor">Donor</th>
        <th class="row-3 row-retreat_id">Retreat ID</th>
        <th class="row-4 row-retreat_date">Retreat Date</th>
        <th class="row-5 row-pledged_amount">Pledged amount</th>
        <th class="row-6 row-payment_amount">Payment amount</th>
        <th class="row-7 row-payment_description">Payment description</th>
    
                
    @foreach($payments as $payment)
    <tr>
        <td>{{$payment->donation->contact->display_name}}</td>
        <td>{{$payment->donation->retreat->idnumber}}</td>
        <td>{{$payment->donation->retreat->start_date}}</td>
        <td>${{number_format($payment->donation->donation_amount,2)}}</td>
        <td>${{number_format($payment->payment_amount,2)}}</td> 
        <td>{{$payment->payment_description}}</td>
    </tr>    
    @endforeach  
 </table> 
<strong>Total of {{$payments->count()}} payments for {{$donation_description}} totaling ${{number_format($payments->sum('payment_amount'),2)}} </strong>
    <hr />
   @endforeach
   @endIf    
<br />

        <span class="logo">
            {!! Html::image('img/mrhlogoblack.png','Home',array('title'=>'Home','class'=>'logo','align'=>'right')) !!}
       
        </span>    
    <span class='pagefooter'>
                600 N Shady Shores Drive<br />
                Lake Dallas, TX 75065<br />
                (940) 321-6020<br /> 
            <a href='http://montserratretreat.org/' target='_blank'>montserratretreat.org</a>
            Report run: as of {{date('l, F j, Y')}}
        
    </span>
</div>
@stop