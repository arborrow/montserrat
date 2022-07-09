@extends('template')
@section('content')

<div class="row bg-cover">
    <div class="col-lg-12">
        <h1>
            Mergeable Donations
            <p class="lead">{{$mergeable->count()}} Mergeable donations</p>
        </h1>
    </div>
    <div class="col-lg-12 mt-2">
        @if ($mergeable->isEmpty())
            <div class="text-center">
                <p>Congratulations, you have achieved temporal bliss. Currently, there are no mergeable donations!</p>
            </div>
        @else
            <table class="table table-bordered table-striped table-hover table-responsive-md">
                {{ $mergeable->links() }}
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Donation Date</th>
                        <th>Event Idnumber</th>
                        <th>Event Title</th>
                        <th>Donation Description</th>
                        <th>First Donation ID</th>
                        <th>Last Donation ID</th>
                        <th>Mergeable Count</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($mergeable as $donation)
                    <tr>
                        <td>{{ $donation->sort_name }}</td>
                        <td>{{ $donation->donation_date }}</td>
                        <td>{{ $donation->idnumber }} </td>
                        <td>{{ $donation->event_title}}</td>
                        <td>{{ $donation->donation_description }} </td>
                        <td><a href="{{URL('donation/'.$donation->min_donation_id)}}">{{ $donation->min_donation_id}}</a></td>
                        <td><a href="{{URL('donation/'.$donation->max_donation_id)}}">{{ $donation->max_donation_id}}</a></td>
                        <td>{{ $donation->donation_count }} </td>
                        <td>
                            {!! Html::link(action([\App\Http\Controllers\DonationController::class, 'merge'], [$donation->min_donation_id, $donation->max_donation_id]),'Merge Donations',array('class' => 'btn btn-secondary'))!!}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>
@stop
