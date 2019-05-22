@extends('template')
@section('content')

<div class="row bg-cover">
    <div class="col-12">
        <h1>
            Donations
            @can('create-donation')
                <span class="create">
                    <a href={{ action('DonationController@create') }}>
                        {!! Html::image('images/create.png', 'Add Donation',array('title'=>"Add Donation",'class' => 'btn btn-light')) !!}
                    </a>
                </span>
            @endCan
            <p class="lead">{{$donations->total()}} records</p>
        </h1>
    </div>
    <div class="col-12 mt-2">
        @if ($donations->isEmpty())
            <div class="text-center">
                <p>It is an impoverished new world, there are no donations!</p>
            </div>
        @else
            <table class="table table-bordered table-striped table-hover table-responsive-md">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Donor</th>
                        <th>Description</th>
                        <th>Amount</th>
                        <th>Terms</th>
                        <th>Retreat</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($donations as $donation)
                    <tr>
                        <td><a href="donation/{{ $donation->donation_id}}">{{ date('M d, Y g:i A', strtotime($donation->donation_date)) }}</a></td>
                        <td>{!! $donation->contact->contact_link_full_name ?? 'Unknown contact' !!} </td>
                        <td>{{ $donation->donation_description }} </td>
                        <td>{{ $donation->donation_amount }}</td>
                        <td>{{ $donation->terms }}</td>
                        <td>{{ $donation->retreat_id}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>
@stop
