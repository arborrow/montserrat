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

                <div class="col-md-4 col-12">
                    <select class="custom-select" onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
                        <option value="">Select fiscal year ...</option>
                            <option value="{{url('dashboard/board/2020')}}">FY20</option>
                            <option value="{{url('dashboard/board/2019')}}">FY19</option>
                            <option value="{{url('dashboard/board/2018')}}">FY18</option>
                            <option value="{{url('dashboard/board/2017')}}">FY17</option>
                            <option value="{{url('dashboard/board/2016')}}">FY16</option>
                            <option value="{{url('dashboard/board/2015')}}">FY15</option>

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
                            <td style='text-align: left; font-weight: bold;'>{{ $category->type }}</td>
                            <td>${{ number_format($category->total_pledged,2) }}</td>
                            <td>
                                ${{ number_format($category->total_paid,2) }}
                                ( {{ number_format(((($category->total_paid)/(array_sum(array_column($board_summary,'total_paid'))))*100),0) }}%)
                            </td>
                            <td>
                                {{ $category->total_participants }}
                                ( {{ number_format(((($category->total_participants)/(array_sum(array_column($board_summary,'total_participants'))))*100),0) }}%)

                            </td>
                            <td>
                                {{ $category->total_nights }}
                            </td>
                            <td>
                                {{ $category->total_pn }}
                                ( {{ number_format(((($category->total_pn)/(array_sum(array_column($board_summary,'total_pn'))))*100),0) }}%)

                            </td>
                            <td>
                                ${{ ($category->total_pn>0) ? (number_format(($category->total_paid/$category->total_pn),2)) : '0.00' }}
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
                            <td>${{ number_format((array_sum(array_column($board_summary,'total_paid')))/(array_sum(array_column($board_summary,'total_pn'))),2) }}</td>
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
