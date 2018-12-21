@extends('template')
@section('content')

    <section class="section-padding">
        <div class="jumbotron text-left">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h1>
                        <span class="grey">AGC Index</span> 
                        <span class="grey">({{$donations->total()}} records)</span> 
                   </h1>
                    <span>{!! $donations->render() !!}</span>
                </div>
                @if ($donations->isEmpty())
                    <p>It is an impoverished new world, there are no AGC donations!</p>
                @else
                <table class="table table-bordered table-striped table-hover"><caption><h2>Annual Giving Donations</h2></caption>
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Donor</th>
                            <th>Description</th>
                            <th>Amount (Paid/Pledged)</th>
                            <th>Thank you</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach($donations as $donation)
                        <tr>

                            <td style="width:10%"><a href="donation/{{ $donation->donation_id}}">{{ date('M d, Y', strtotime($donation->donation_date)) }}</a></td>
                            <td style="width:20%">{!! $donation->contact->contact_link_full_name or 'Unknown contact' !!} </td>
                            <td style="width:10%">{{ $donation->donation_description }} </td>
                            <td style="width:10%; text-align:right;">${{number_format($donation->payments_paid,2)}}/${{ number_format($donation->donation_amount,2) }}</td>
			    <td style="width:10%">
				@if(isset($donation['Thank You']))
					{{$donation['Thank You']}}
				@else
					<a href="donation/{{$donation->donation_id}}/agcacknowledge">Print AGC Acknowledgement</a>
				@endIf
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
