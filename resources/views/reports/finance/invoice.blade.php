@extends('report')
@section('content')

<div class ="invoice">
<div class ="pageheader">
        
<table>
    <tr>
        <td>
            <img src="https://polanco.montserratretreat.org/img/mrhlogoblack.png"> <br />
            600 N. Shady Shores Dr <br />
            Lake Dallas, TX 75065 <br />
            (940) 321-6020 <br />
            (940) 321-6040 - Fax <br />
            montserratretreat.org <br /> <br />
        </td>
        <td>
            <h3 style="text-align: right">Date: {{date('m/d/Y')}}<br />
                Invoice #{{$donation->donation_id}}</h3>
        </td>
    </tr>
</table>
        </div>
<br /> 
{{$donation->contact->display_name}}<br />
@if (isset($donation->Notes1))
    {{$donation->Notes1}} <br />
@endIf
{{$donation->contact->address_primary_street}} <br />     
{{$donation->contact->address_primary_city}}, {{$donation->contact->address_primary_state}}  {{$donation->contact->address_primary_postal_code}} 
<br /><br />
<strong>Event:</strong> {{$donation->retreat_name}} ({{$donation->retreat_idnumber}})
<div class="payments">
<br />    
<strong>Notes:</strong> {{$donation->Notes}} <br /><br />

 <table>
     <caption style="text-align:left"><strong>Payments</strong></caption>
        <th class="row-payment_date">Date</th>
        <th class="row-payment_description">Description</th>
        <th class="row-payment_type">Payment method</th>
        <th class="row-payment_amount">Amount</th>
                
    @foreach($donation->payments->sortBy('payment_date') as $payment)
    <tr>
        <td>{{$payment->payment_date->format('m/d/Y')}}</td>
        <td>{{$payment->note}}</td>
        <td>{{$payment->payment_description}} #{{$payment->payment_number}}</td>
        <td class="row-payment_amount">${{number_format($payment->payment_amount,2)}}</td>
    </tr>    
    @endforeach  
 </table>
</div>
<br />
<div class="invoice-totals">
<table>
    <tr>
        <td>Total amount: </td>
        <td class="row-payment_amount"> ${{number_format($donation->donation_amount,2)}} </td>
    </tr>
    <tr>
        <td>Total payments: </td>
        <td class="row-payment_amount">${{number_format($donation->payments_paid,2)}} </td>
    </tr>
    <tr>
        <td><strong>Balance due:</strong></td>
        <td class="row-payment_amount"><strong>${{number_format(($donation->donation_amount - $donation->payments_paid),2)}}</strong> </td>
    </tr>    
 @if(isset($donation->donation_install))
 <tr>
     <td><strong>Current amount due:</strong></td>
     <td class="row-payment_amount"><strong>${{number_format(($donation->donation_install),2)}}</strong></td>
 </tr>
 @endif
</table>
</div>
<br />
<strong>Terms:</strong> {{$donation->terms}} <br /> <br />
<br />
<i>Please remit payment to: <br />
    <strong>Montserrat Jesuit Retreat House</strong></i> <br />
    PO Box 1390<br />
    Lake Dallas, TX 75065-1390<br>

<span class='pagefooter'>
    Invoice date: {{date('l, F j, Y H:i')}}
</span>
</div>
@stop
