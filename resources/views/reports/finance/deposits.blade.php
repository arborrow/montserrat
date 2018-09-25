@extends('report')
@section('content')

<div class ="retreat_deposits">
<h2>Open Deposits Report </h2> 
@if (!$grouped_donations->isEmpty())
     
<hr />
@foreach($grouped_donations as $retreat_id => $group_donations)
<strong>{{$retreat_id}} </strong><br />
    
 <table width="100%">
        <th class="row-donor">Donor</th>
        <th class="row-pledged">Date</th>
        <th class="row-pledged">Amount</th>
        <th class="row-paid">Retreat</th>
                
    @foreach($group_donations->sortBy('contact.sort_name') as $donation)
    <tr>
        <td>{{$donation->contact->display_name}}</td>
        <td>{{$donation->payments->max('payment_date')}}</td>
        <td>${{number_format($donation->payments->sum('payment_amount'),2)}}</td>
        <td>{{$donation->retreat->title.'('.$donation->retreat->idnumber.')'.' ['.$donation->retreat->start_date.']' }}</td>
    </tr>    
    @endforeach  
 </table> 
<strong>Total of {{$group_donations->count()}} Deposits for {{$donation->retreat->title}} totaling ${{number_format($group_donations->sum('payments_paid'),2)}} </strong>
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
