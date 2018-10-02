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
            <h3 style="text-align: right">Invoice# {{$donation->donation_id}}</h3>
        </td>
    </tr>
</table>
        </div>
<br /> 
<br />
{{$donation->contact->display_name}}<br />
{{$donation->Notes1}} <br />
{{$donation->contact->address_primary_street}} <br />     
{{$donation->contact->address_primary_city}}, {{$donation->contact->address_primary_state}}  {{$donation->contact->address_primary_postal_code}} 
<br /><br />
Event: {{$donation->retreat->title}} ({{$donation->retreat->idnumber}})
<div class="payments">
    <h3>Payments</h3>   
 <table>
        <th class="row-payment_date">Date</th>
        <th class="row-payment_type">Payment method</th>
        <th class="row-payment_number">Reference #</th>
        <th class="row-payment_amount">Amount</th>
        <th class="row-payment_note">Notes</th>
                
    @foreach($donation->payments->sortBy('payment_date') as $payment)
    <tr>
        <td>{{$payment->payment_date->format('m/d/Y')}}</td>
        <td>{{$payment->payment_description}}</td>
        <td>{{$payment->payment_number}}</td>
        <td class="row-payment_amount">${{number_format($payment->payment_amount,2)}}</td>
        <td>{{$payment->note}}</td>
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
        <td><strong>Current amount due:</strong></td>
        <td class="row-payment_amount"><strong>${{number_format(($donation->donation_amount - $donation->payments_paid),2)}}</strong> </td>
    </tr>    
 
</table>
</div>
<br />
<strong>Notes:</strong> {{$donation->Notes}} <br /><br />
<strong>Terms:</strong> {{$donation->terms}} <br /> <br />
<br />
<i>Make payments payable to: <strong>Montserrat Jesuit Retreat House</strong></i> <br /><br />

<span class='pagefooter'>
    Invoice date: {{date('l, F j, Y H:i')}}
</span>
</div>
@stop
