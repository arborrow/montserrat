@extends('report')
@section('content')
<meta name="format-detection" content="telephone=no">
<div class ="agcacknowledge">
<div class ="pageheader" style="text-align:center;">
            <img style="display: block;  margin-left: auto;  margin-right: auto; height:64px; width:200px;" src="https://polanco.montserratretreat.org/images/mrhlogoblack.png"> <br />
</div>
<br />
<div class ="letter">
<table>
    <tr>
        <td class="board" style="font-size:11pt; line-height:1.3; padding-top:50px;"><div style="font-variant:small-caps"><strong>Board of Trustees</strong></div> <br />
Susie Andrews <br />
<i>President</i> <br /><br />
Mark Vehslage <br />
<i>Secretary Treasurer</i> <br /><br />

Mary Del Olmo <br />
Fr. Holguin <br />
John Luna <br />
Paul Pederson <br />
Richard Rolland <br />
Jeannette Santos <br />
Fr. Thompson <br /><br />

<div style="font-variant:small-caps"><strong>Jesuit Community</strong></div><br />
Fr. Rauschuber, S.J.<br />
Fr. Gonzales, S.J.<br />
Fr. Joseph, S.J.<br />
Fr. Vo, S.J.<br />
        </td>
        <td class="main" style="padding-right: 50px; padding-left:20px; padding-top:20px;">
            <div style="position:absolute; right: 0px; padding-right:60px;">{{date('F d, Y')}}</div><br /><br />
            {{$contact->agc_household_name}} <br />
            {{$contact->address_primary_street}} <br />
            {{$contact->address_primary_city}}, {{$contact->address_primary_state}} {{$contact->address_primary_postal_code}}
            <br />
            <br />
            Dear {{$contact->agc_household_name}},<br /><br />

            @if ($payments->isEmpty())
                <p>It appears that our records do not show any donations made to Montserrat from {{ $start_date }} to {{ $end_date }}.</p>
            @else
                <p>Thank you for your support of Montserrat Jesuits Retreat House. Below is a listing of the donations received.</p>
            <table class="table table-bordered payments" style="font-size:10pt;">
                <caption><strong>Donations from {{ $start_date->format('m-d-Y') }} to {{ $end_date->format('m-d-Y') }}</strong></caption>
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Description</th>
                        <th>Donation Amount</th>
                        <th>Method</th>
                        <th>Retreat</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach($payments as $payment)
                    <tr>

                        <td>{{ $payment->payment_date->format('M d, Y') }}</td>
                        <td>{{ $payment->donation->donation_description ?? 'Unspecified' }} </td>
                        <td>${{ number_format($payment->payment_amount,2) }}</td>
                        <td>{{ $payment->payment_description }} {{ $payment->ccnumber ?? $payment->cknumber}}</td>
                        <td>{{ $payment->donation->retreat->title ?? 'N/A'}}</td>
                    </tr>
                    @endforeach

                </tbody>

            </table>
            <br />
        @endIf

Peace,<br />
{!! $montserrat->signature !!}<br />
Fr. Anthony Rauschuber, S.J.<br />
Director <br />
        </td>
    </tr>
    <tr>
        <td></td>
        <td style="font-size: 10pt; padding-left:20px;"><i><br /><br />Montserrat Jesuit Retreat House is a ministry of the Society of Jesus UCS Province<br />
                No goods or services have been provided to the donor. <br />
                Your donation is deductible to the extent allowed by law.</i></td>
    </tr>

</table>

</div>
<br /><br />

<span class='pagefooter' style="font-size:11pt;">
    <table style="width:100%; margin:auto;">
        <tr>
            <td style="width:33%; margin:auto; text-align:center">PO Box 1390</td>
            <td style="width:33%; margin:auto; text-align:center">600 N. Shady Shores Dr</td>
            <td style="width:33%; margin:auto; text-align:center">Lake Dallas, TX 75065<td>
        </tr>
            <tr>
            <td style="text-align:center">(940) 321-6020</td>
            <td> </td>
            <td style="text-align:center">montserratretreat.org </td>

        </tr>
    </table>
</span>
</div>
@stop
