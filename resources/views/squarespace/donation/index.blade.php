@extends('template')
@section('content')

    <section class="section-padding">
        <div class="jumbotron text-left">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h1>
                        <span class="grey">SquareSpace Donations (Unprocessed)</span>
                    </h1>
                    <span>{{ $donations->links() }}</span>

                </div>

                <table class="table table-bordered table-striped table-hover"><caption><h2>Donations (Unprocessed) ({{$donations->total()}})</h2></caption>
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Fund/Retreat</th>
                            <th>Amount</th>
                            <th>Comments</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($donations as $donation)
                        <tr>
                            <td>
                                <a href="{{ URL('squarespace/donation/' . $donation->id .'/edit') }} ">{{ $donation->created_at }}</a>
                            </td>
                            <td>{{ ucwords(strtolower($donation->name)) }}</td>
                            <td>{{ strtolower($donation->email) }}</td>
                            <td>{{ trim($donation->fund .' '. $donation->retreat_description . ' ' . $donation->offering_type) }}</td>
                            <td>${{ $donation->amount }}</td>
                            <td>{{ strtolower($donation->comments) }}</td>
                        </tr>
                        @endforeach

                    </tbody>
                </table>

                <hr />

                <div class="panel-heading">
                    <h1>
                        <span class="grey">SquareSpace Processed Donations</span>
                    </h1>
                    <span>{{ $processed_donations->links() }}</span>

                </div>

                <table class="table table-bordered table-striped table-hover"><caption><h2>Processed Donations ({{$processed_donations->total()}})</h2></caption>
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Fund/Retreat</th>
                            <th>Amount</th>
                            <th>Comments</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($processed_donations as $processed_donation)
                        <tr>
                            <td>
                                <a href="{{ URL('squarespace/donation/' . $processed_donation->id . '/edit') }} ">{{ $processed_donation->created_at }}</a>
                            </td>
                            <td>{{ ucwords(strtolower($processed_donation->name)) }}</td>
                            <td>{{ strtolower($processed_donation->email) }}</td>
                            <td>{{ trim($processed_donation->fund .' '. $processed_donation->retreat_description . ' ' . $processed_donation->offering_type) }}</td>
                            <td>${{ $processed_donation->amount }}</td>
                            <td>{{ strtolower($processed_donation->comments) }}</td>
                        </tr>
                        @endforeach

                    </tbody>

                </table>


            </div>
        </div>
    </section>
@stop
