@extends('pdf.pdf_report')
@section('content')
<meta name="format-detection" content="telephone=no">
<div class ="acknowledgment">

    <table>
    <tr>
        @include('pdf._boardmembers')
        <td class="main" style="width: 65%; padding-right: 50px; padding-left:20px; padding-top:20px; font-size:11pt; font-family:montserrat;">
            <div style="position:absolute; right: 0px; padding-right:60px;">
                {{date('F d, Y')}}
            </div><br /><br /><br /><br />
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
            <table class="payments" style="width: 100%; font-size:10pt; font-family:montserrat; border: solid 0.5pt; border-collapse: collapse;
">
                <caption>
                    <strong>Donations from {{ $start_date->format('m-d-Y') }} to {{ $end_date->format('m-d-Y') }}</strong>
                </caption>
                <thead>
                    <tr>
                        <th style="border: solid 0.5pt; padding:5px;">Date</th>
                        <th style="border: solid 0.5pt; padding:5px;">Description</th>
                        <th style="border: solid 0.5pt; padding:5px;">Donation Amount</th>
                        <th style="border: solid 0.5pt; padding:5px;">Method</th>
                        <th style="border: solid 0.5pt; padding:5px;">Retreat</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach($payments as $payment)
                    <tr>

                        <td style="border: solid 0.5pt; padding:5px;">{{ $payment->payment_date->format('M d, Y') }}</td>
                        <td style="border: solid 0.5pt; padding:5px;">{{ $payment->donation->donation_description ?? 'Unspecified' }} </td>
                        <td style="border: solid 0.5pt; padding:5px; text-align: right;">${{ number_format($payment->payment_amount,2) }}</td>
                        <td style="border: solid 0.5pt; padding:5px;">{{ $payment->payment_description }} {{ $payment->ccnumber ?? $payment->cknumber}}</td>
                        <td style="border: solid 0.5pt; padding:5px;">{{ $payment->donation->retreat->title ?? 'N/A'}}</td>
                    </tr>
                    @endforeach

                </tbody>

            </table>
            <br />
            @endIf

            Peace,<br />
            <div class="signature">
            {!! $montserrat->signature !!}
            </div>
            Fr. Anthony Rauschuber, S.J.<br />
            Director <br />
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td style="font-size: 10pt; font-family: montserrat; padding-left:20px;">
                        <br /><br />
                        Montserrat Jesuit Retreat House is a ministry of the Society of Jesus UCS Province. No goods or services have been provided to the donor. Your donation is deductible to the extent allowed by law.
                    </td>
                </tr>

    </table>
</div>
@stop
