@extends('report')
@section('content')

<div class ="invoice">
<img src="https://polanco.montserratretreat.org/img/mrhlogoblack.png"> <br />
600 N. Shady Shores Dr <br />
Lake Dallas, TX 75065 <br />
(940) 321-6020 <br />
(940) 321-6040 - Fax <br />
montserratretreat.org <br /> <br /> 
<div style="text-align: center">><h2>Invoice# {{$donation->donation_id}} for {{$donation->retreat->title}}</h2></div><br /> 
<br />
{{$donation->contact->display_name}}<br />
{{$donation->Notes1}} <br />
{{$donation->contact->address_primary_street}} <br />     
{{$donation->contact->address_primary_city}}, {{$donation->contact->address_primary_state}}  {{$donation->contact->address_primary_postal_code}} <br /><br />    
<h2>Payments</h2>   
 <table width="100%" style="border: 1px solid black">
        <th class="row-payment_date">Date</th>
        <th class="row-payment_type">Payment type</th>
        <th class="row-payment_number">#</th>
        <th class="row-payment_amount">Amount</th>
        <th class="row-payment_note">Notes</th>
                
    @foreach($donation->payments->sortBy('payment_date') as $payment)
    <tr>
        <td>{{$payment->payment_date->format('m/d/Y')}}</td>
        <td>{{$payment->payment_description}}</td>
        <td>{{$payment->payment_number}}</td>
        <td>${{number_format($payment->payment_amount,2)}}</td>
        <td>{{$payment->note}}</td>
    </tr>    
    @endforeach  
 </table> 
<br />
<h2>
Total amount: ${{number_format($donation->donation_amount,2)}} <br />
Total payments: ${{number_format($donation->payments_paid,2)}} <br />
Current amount due: ${{number_format(($donation->donation_amount - $donation->payments_paid),2)}} <br />
</h2>   
<br />
Description: {{$donation->donation_description}} <br />
Notes: {{$donation->Notes}} <br />
Terms: {{$donation->terms}} <br /> 
<br />
<span class='pagefooter'>
Make payments payable to: Montserrat Jesuit Retreat House <br /><br />
    Invoice date: {{date('l, F j, Y H:i')}}
</span>
</div>
@stop
