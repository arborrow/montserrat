@extends('template')
@section('content')

    <section class="section-padding">
        <div class="jumbotron text-left">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h1>
                        <span class="grey">Board Dashboard</span>
                    </h1>
                </div>

                <div class="col-lg-3 col-md-4">
                    <select class="custom-select" onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
                        <option value="">Select fiscal year ...</option>
                        @foreach($years as $y)
                            <option value="{{url('dashboard/board/'.$y->year)}}">FY{{$y->year}}</option>
                        @endForeach
                    </select>
                </div>


                <div>FY{{ $year }} Revenue by Event Type</div>
                <div> {!! $board_summary_revenue_chart->container() !!} </div>

                <div>Total Revenue: ${{ number_format($total_revenue,2) }} </div>
                <hr />
                <div>FY{{ $year }} Participants by Event Type</div>
                <div> {!! $board_summary_participant_chart->container() !!} </div>
                <div>Total Participants: {{ number_format($total_participants,0) }} </div>
                <hr />
                <div>FY{{ $year }} People Nights by Event Type</div>
                <div> {!! $board_summary_peoplenight_chart->container() !!} </div>
                <div>Total People Nights: {{ number_format($total_peoplenights,0) }} </div>
                <hr />
                <div>FY{{ $year }} Summary</div>
                <div>
                    <table class="table table-bordered table-striped table-hover table-responsive-md">
                        <thead style='text-align:center'>
                            <th>Type</th>
                            <th>Pledged</th>
                            <th>Paid</th>
                            <th>Participants</th>
                            <th>Nights</th>
                            <th>People Nights</th>
                            <th>Avg.$/Person/Night</th>
                        </thead>
                        @foreach($board_summary as $category)
                        <tr style='text-align: right'>
                            <td style='text-align: left; font-weight: bold;'><a href="{{ url('dashboard/board/drilldown/'.$category->type_id.'/'.$year) }}">{{ $category->type }}</a></td>
                            <td>${{ number_format($category->total_pledged,2) }}</td>
                            <td>
                                ${{ number_format($category->total_paid,2) }}
                                (
                                @if (array_sum(array_column($board_summary,'total_paid')) > 0)
                                    {{ number_format(((($category->total_paid)/(array_sum(array_column($board_summary,'total_paid'))))*100),0) }}%)
                                @else
                                    N/A
                                @endIf
                            </td>
                            <td>
                                {{ $category->total_participants }}
                                @if (array_sum(array_column($board_summary,'total_participants')) > 0)
                                    ( {{ number_format(((($category->total_participants)/(array_sum(array_column($board_summary,'total_participants'))))*100),0) }}%)
                                @else
                                    N/A
                                @endIf
                            </td>
                            <td>
                                {{ $category->total_nights }}
                            </td>
                            <td>
                                {{ $category->total_pn }}
                                @if (array_sum(array_column($board_summary,'total_pn'))>0)
                                    ( {{ number_format(((($category->total_pn)/(array_sum(array_column($board_summary,'total_pn'))))*100),0) }}%)
                                @else
                                   n/a
                                @endIf
                            </td>
                            <td>
                              @if ($category->total_pn > 0)
                                  ${{ ($category->total_pn>0) ? (number_format(($category->total_paid/$category->total_pn),2)) : '0.00' }}
                              @else
                                  n/a
                              @endIf
                            </td>
                        </tr>
                        @endforeach
                        <tr style='text-align: right; font-weight: bold;'>
                            <td style='text-align: left;'>Total</td>
                            <td>${{ number_format(array_sum(array_column($board_summary,'total_pledged')),2) }}</td>
                            <td>${{ number_format(array_sum(array_column($board_summary,'total_paid')),2) }}</td>
                            <td>{{ number_format(array_sum(array_column($board_summary,'total_participants')),0) }}</td>
                            <td>{{ number_format(array_sum(array_column($board_summary,'total_nights')),0) }}</td>
                            <td>{{ number_format(array_sum(array_column($board_summary,'total_pn')),0) }}</td>
                            <td>
                                @if (array_sum(array_column($board_summary,'total_pn')) > 0)
                                    ${{ number_format((array_sum(array_column($board_summary,'total_paid')))/(array_sum(array_column($board_summary,'total_pn'))),2) }}
                                @else
                                    n/a
                                @endIf
                            </td>

                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </section>
    {!! $board_summary_revenue_chart->script() !!}
    {!! $board_summary_participant_chart->script() !!}
    {!! $board_summary_peoplenight_chart->script() !!}

@stop
