@extends('template')
@section('content')

<div class="row bg-cover">
    <div class="col-12">
        <h1>AGC FY {{$total['year']}} Index - ({{$donations->total()}} donations)</h1>
        <p class="lead">${{number_format($total['paid'],2)}} of ${{number_format($total['pledged'],2)}} ({{number_format($total['percent'],0)}}%)</p>
        {!! $donations->render() !!}
    </div>
    <div class="col-12">
        @if ($donations->isEmpty())
            <div class="text-center">
                <p>It is an impoverished new world, there are no AGC donations!</p>
            </div>
        @else
            <table class="table table-bordered table-striped table-hover table-responsive">
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
                            <td><a href='{{url("donation/".$donation->donation_id)}}'"> {{ date('M d, Y', strtotime($donation->donation_date)) }} </a></td>
                            <td>{!! $donation->contact->contact_link_full_name ?? 'Unknown contact' !!} ({{$donation->contact->agc_household_name}}) </td>
                            <td>{{ $donation->donation_description }} </td>
                            <td>${{number_format($donation->payments_paid,2)}}/${{ number_format($donation->donation_amount,2) }}</td>
                            <td>
                                @if(isset($donation['Thank You']))
                                    <a href='{{url("donation/".$donation->donation_id."/agcacknowledge") }}'>{{$donation['Thank You']}}</a>
                                @else
                                    @if ($donation->percent_paid == 100)
                                        <a href='{{ url("donation/".$donation->donation_id."/agcacknowledge") }}'><img src='{{ url("images/letter.png") }}' alt="Print acknowledgement" title="Print acknowledgement"></a>
                                    @else
                                        Awaiting full payment
                                    @endIf
                                @endIf
                                <a href='{{ url("person/".$donation->contact_id."/envelope10") }}'><img src='{{ url("images/envelope.png") }}' alt="Print envelope" title="Print envelope"></a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {!! $donations->render() !!}
        @endif
    </div>
</div>
@stop
