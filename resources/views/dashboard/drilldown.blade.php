@extends('template')
@section('content')

    <section class="section-padding">
        <div class="jumbotron text-left">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h1>
                        <span class="grey">Board Dashboard Drilldown: {{ $event_type->name }} FY{{ $year }}</span>
                    </h1>
                </div>

                <div class="col-12">
                    @if ($retreats->isEmpty())
                    <p>There are no retreats in this category</p>
                @else
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th>ID#</th>
                            <th>Title</th>
                            <th>Starts - Ends (Nights)</th>
                            <th>Paid/Pledged (%)</th>
                            <th>Participants</th>
                            <th>$/Person/Night</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($retreats as $retreat)
                        @if ($retreat->is_active == 0)
                            <tr style="text-decoration:line-through">
                        @else
                            <tr>
                        @endIf
                            <td><a href="{{url('retreat/'.$retreat->id)}}">{{ $retreat->idnumber}}</a></td>
                            <td>{{ $retreat->title }}</td>
                            <td>{{ date('M j, Y', strtotime($retreat->start_date)) }} - {{ date('M j, Y', strtotime($retreat->end_date)) }} ({{ $retreat->nights }})</td>
                            <td>
                                @can('show-donation')
                                    <a href="{{ url('report/finance/retreatdonations/'.$retreat->idnumber) }}">${{ number_format($retreat->payments_paid_sum,2) }}/${{ number_format($retreat->donations_pledged_sum,2) }}</a> ({{ $retreat->percent_paid }}%)
                                @else
                                    ${{ number_format($retreat->payments_paid_sum,2) }}/${{ number_format($retreat->donations_pledged_sum,2) }} ({{ $retreat->percent_paid }}%)
                                @endCan
                            </td>
                            <td>{{ $retreat->participant_count }}</td>
                            <td>${{ number_format($retreat->average_paid_per_night,2) }}</td>
                        </tr>
                        @endforeach
                        <tr>
                            <td style="font-weight:bold">Totals</td>
                            <td></td>
                            <td></td>
                            <td style="font-weight:bold">${{ number_format($retreats->sum('payments_paid_sum'),2) }} / ${{ number_format($retreats->sum('donations_pledged_sum'),2) }}</td>
                            <td style="font-weight:bold">{{ $retreats->sum('participant_count') }}</td>
                            <td style="font-weight:bold">${{ number_format($retreats->average('average_paid_per_night'),2) }}</td>
                        </tr>
                    </tbody>
                </table>
                @endif
                </div>


            </div>
        </div>
    </section>

@stop
