@extends('template')
@section('content')

<div class="row bg-cover">
    <div class="col-12">
        <h1>
            Overpaid Donations
            <p class="lead">{{$overpaid->count()}} Overpaid records</p>
        </h1>
    </div>
    <div class="col-12 mt-2">
        @if ($overpaid->isEmpty())
            <div class="text-center">
                <p>The world is perfectly balanced, there are no overpaid donations!</p>
            </div>
        @else
            <table class="table table-bordered table-striped table-hover table-responsive-md">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Donation</th>
                        <th>Date</th>
                        <th>Paid</th>
                        <th>Pledged</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($overpaid as $donation)
                    <tr>
                        <td>{{ $donation->sort_name }}</td>
                        <td><a href="{{URL('donation/'.$donation->donation_id)}}">{{ $donation->donation_id}}</a></td>
                        <td>{{ date('M d, Y g:i A', strtotime($donation->donation_date)) }}</td>
                        <td>{{ $donation->paid }} </td>
                        <td>{{ $donation->pledged }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>
@stop
