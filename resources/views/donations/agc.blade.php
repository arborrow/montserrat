@extends('template')
@section('content')

    <section class="section-padding">
        <div class="jumbotron text-left">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h1>
                        <span class="grey">AGC FY {{$total['year']}} Index - ({{$donations->total()}} donations)<br />
                            ${{number_format($total['paid'],2)}} of ${{number_format($total['pledged'],2)}} ({{number_format($total['percent'],0)}}%)</span>
                        </h1>
                        <span>{!! $donations->render() !!}</span>
                    </div>
                    @if ($donations->isEmpty())
                        <p>It is an impoverished new world, there are no AGC donations!</p>
                    @else
                        <table class="table table-bordered table-striped table-hover"><caption><h2>FY19 Annual Giving Donations</h2></caption>
                            <thead>
                                <tr>
                                    <th>Donation Date</th>
                                    <th>Donor (Household name)</th>
                                    <th>Description</th>
                                    <th>Amount (Paid/Pledged)</th>
                                    <th>Thank you</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach($donations as $donation)
                                    <tr>

                                        <td style="width:10%"><a href="/donation/{{ $donation->donation_id}}">{{ date('M d, Y', strtotime($donation->donation_date)) }}</a></td>
                                        <td style="width:20%">{!! $donation->contact->contact_link_full_name ?? 'Unknown contact' !!} ({{$donation->contact->agc_household_name}}) </td>
                                        <td style="width:10%">{{ $donation->donation_description }} </td>
                                        <td style="width:10%; text-align:right;">${{number_format($donation->payments_paid,2)}}/${{ number_format($donation->donation_amount,2) }}</td>
                                        <td style="width:10%">
                                            @if(isset($donation['Thank You']))
                                                <a href="/donation/{{$donation->donation_id}}/agcacknowledge">{{$donation['Thank You']}}</a>
                                            @else
                                                @if ($donation->percent_paid == 100)
                                                    <a href="/donation/{{$donation->donation_id}}/agcacknowledge"><img src="/img/letter.png" alt="Print acknowledgement" title="Print acknowledgement"></a>
                                                @else
                                                    Awaiting full payment
                                                @endIf
                                            @endIf
                                            <a href="/person/{{$donation->contact_id}}/envelope10"><img src="/img/envelope.png" alt="Print envelope" title="Print envelope"></a>

                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>

                        </table>
                        {!! $donations->render() !!}
                    @endif
                </div>
            </div>
        </section>
    @stop
