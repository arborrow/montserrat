@extends('template')
@section('content')

<section class="section-padding">
    <div class="jumbotron text-left">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h1>
                    <span class="grey">{{$donations->total()}} results found</span>
                    <span class="search"><a href={{ action('DonationController@search') }}>{!! Html::image('images/search.png', 'New search',array('title'=>"New search",'class' => 'btn btn-link')) !!}</a></span></h1>
            </div>
            @if ($donations->isEmpty())
            <p>Oops, no known donations with the given search criteria</p>
            @else
            <table class="table table-striped table-bordered table-hover">
                <caption>
                    <h2>Donations</h2>
                </caption>
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Donor</th>
                        <th>Description</th>
                        <th>Amount</th>
                        <th>Event</th>
                        <th>Notes</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($donations as $donation)
                    <tr>
                        <td><a href="{{ URL('donation/'. $donation->donation_id) }}">{{ date('M d, Y g:i A', strtotime($donation->donation_date)) }}</a></td>
                        <td>{!! $donation->contact->contact_link_full_name ?? 'Unknown contact' !!} </td>
                        <td>{{ $donation->donation_description }} </td>
                        <td>{{ '$'.$donation->donation_amount }}</td>
                        <td>{!! $donation->retreat_link !!}</td>
                        <td>{{ $donation->Notes }}</td>
                    </tr>
                    @endforeach
                    {!! $donations->render() !!}
                </tbody>
            </table>
            @endif
        </div>
    </div>
</section>
@stop
