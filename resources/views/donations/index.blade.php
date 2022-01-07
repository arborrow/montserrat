@extends('template')
@section('content')

<div class="row bg-cover">
    <div class="col-lg-12">
        <h1>
            Donations
            @can('create-donation')
                <span class="create">
                    <a href={{ route('donation.create') }}>
                        {!! Html::image('images/create.png', 'Add Donation',array('title'=>"Add Donation",'class' => 'btn btn-light')) !!}</a>
                </span>
            @endCan
            <a href={{ action('DonationController@search') }}>
                {!! Html::image('images/search.png', 'Search donations',array('title'=>"Search donations",'class' => 'btn btn-link')) !!}
            </a>

            <p class="lead">{{$donations->total()}} records</p>
        </h1>
        <div class="row">
            <div class="col-lg-3 col-md-4">
                <select class="custom-select" onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
                    <option value="">Filter by donation description ...</option>
                    <option value="{{url('donation')}}">All donations</option>
                    @foreach($donation_descriptions as $donation_description)
                        <option value="{{url('donation/type/'.$donation_description->donation_id)}}">{{$donation_description->donation_description .'('.$donation_description->count.')'}}</option>
                    @endForeach
                </select>
            </div>
        </div>

    </div>
    <div class="col-lg-12 mt-2">
        @if ($donations->isEmpty())
            <div class="text-center">
                <p>It is an impoverished new world, there are no donations!</p>
            </div>
        @else
            <table class="table table-bordered table-striped table-hover table-responsive-md">
                {{ $donations->links() }}
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Donor</th>
                        <th>Description</th>
                        <th>Amount</th>
                        <th>Terms</th>
                        <th>Event</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($donations as $donation)
                    <tr>
                        <td><a href="{{ URL('donation/'. $donation->donation_id) }}">{{ date('M d, Y g:i A', strtotime($donation->donation_date)) }}</a></td>
                        <td>{!! $donation->contact->contact_link_full_name ?? 'Unknown contact' !!} </td>
                        <td>{{ $donation->donation_description }} </td>
                        <td>{{ '$'.$donation->donation_amount }}</td>
                        <td>{{ $donation->terms }}</td>
                        <td>{!! $donation->retreat_link !!}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>
@stop
