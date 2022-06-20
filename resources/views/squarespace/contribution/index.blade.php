@extends('template')
@section('content')

    <section class="section-padding">
        <div class="jumbotron text-left">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h1>
                        <span class="grey">Index of Squarespace Contributions (Unprocessed)</span>
                    </h1>
                    <span>{{ $ss_contributions->links() }}</span>

                </div>

                <table class="table table-bordered table-striped table-hover"><caption><h2>Contributions (Unprocessed) ({{$ss_contributions->total()}})</h2></caption>
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

                        @foreach ($ss_contributions as $ss_contribution)
                        <tr>
                            <td>
                                <a href="{{ URL('squarespace/contribution/' . $ss_contribution->id .'/edit') }} ">{{ $ss_contribution->created_at }}</a>
                            </td>
                            <td>{{ ucwords(strtolower($ss_contribution->name)) }}</td>
                            <td>{{ strtolower($ss_contribution->email) }}</td>
                            <td>{{ trim($ss_contribution->fund .' '. $ss_contribution->retreat_description . ' ' . $ss_contribution->offering_type) }}</td>
                            <td>${{ $ss_contribution->amount }}</td>
                            <td>{{ strtolower($ss_contribution->comments) }}</td>
                        </tr>
                        @endforeach

                    </tbody>
                </table>

                <hr />

                <div class="panel-heading">
                    <h1>
                        <span class="grey">Index of Squarespace Processed Contributions</span>
                    </h1>
                    <span>{{ $processed_ss_contributions->links() }}</span>

                </div>

                <table class="table table-bordered table-striped table-hover"><caption><h2>Processed Contributions ({{$processed_ss_contributions->total()}})</h2></caption>
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

                        @foreach ($processed_ss_contributions as $processed_contribution)
                        <tr>
                            <td>
                                <a href="{{ URL('squarespace/contribution/' . $processed_contribution->id . '/edit') }} ">{{ $processed_contribution->created_at }}</a>
                            </td>
                            <td>{{ ucwords(strtolower($processed_contribution->name)) }}</td>
                            <td>{{ strtolower($processed_contribution->email) }}</td>
                            <td>{{ trim($processed_contribution->fund .' '. $processed_contribution->retreat_description . ' ' . $processed_contribution->offering_type) }}</td>
                            <td>${{ $processed_contribution->amount }}</td>
                            <td>{{ strtolower($processed_contribution->comments) }}</td>
                        </tr>
                        @endforeach

                    </tbody>

                </table>


            </div>
        </div>
    </section>
@stop
