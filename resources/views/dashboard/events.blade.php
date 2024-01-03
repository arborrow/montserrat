@extends('template')
@section('content')

    <section class="section-padding">
        <div class="jumbotron text-left">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h1>
                        <span class="grey">Event Dashboard</span>
                    </h1>
                </div>

                <div class="col-lg-3 col-md-4">
                    <select class="custom-select" onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
                        <option value="">Select fiscal year ...</option>
                        @foreach($years as $y)
                            <option value="{{url('dashboard/events/'.$y->year)}}">FY{{$y->year}}</option>
                        @endForeach
                    </select>
                </div>


                <div>FY{{ $year }} Revenue by Event Type</div>

                <div class="container">
                    <canvas id="event_revenue_chart"></canvas>
                </div>

                <div>Total Revenue: ${{ number_format($total_revenue,2) }} </div>
                <hr />

                <div>FY{{ $year }} Participants by Event Type</div>
                
                <div class="container">
                    <canvas id="event_participants_chart"></canvas>
                </div>

                <div>Total Participants: {{ number_format($total_participants,0) }} </div>
                <hr />

                <div>FY{{ $year }} People Nights by Event Type</div>
                
                <div class="container">
                    <canvas id="event_pn_chart"></canvas>
                </div>

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
                        @foreach($event_summary as $category)
                        <tr style='text-align: right'>
                            <td style='text-align: left; font-weight: bold;'><a href="{{ url('dashboard/events/drilldown/'.$category->type_id.'/'.$year) }}">{{ $category->type }}</a></td>
                            <td>${{ number_format($category->total_pledged,2) }}</td>
                            <td>
                                ${{ number_format($category->total_paid,2) }}
                                (
                                @if (array_sum(array_column($event_summary,'total_paid')) > 0)
                                    {{ number_format(((($category->total_paid)/(array_sum(array_column($event_summary,'total_paid'))))*100),0) }}%)
                                @else
                                    N/A
                                @endIf
                            </td>
                            <td>
                                {{ $category->total_participants }}
                                @if (array_sum(array_column($event_summary,'total_participants')) > 0)
                                    ( {{ number_format(((($category->total_participants)/(array_sum(array_column($event_summary,'total_participants'))))*100),0) }}%)
                                @else
                                    N/A
                                @endIf
                            </td>
                            <td>
                                {{ $category->total_nights }}
                            </td>
                            <td>
                                {{ $category->total_pn }}
                                @if (array_sum(array_column($event_summary,'total_pn'))>0)
                                    ( {{ number_format(((($category->total_pn)/(array_sum(array_column($event_summary,'total_pn'))))*100),0) }}%)
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
                            <td>${{ number_format(array_sum(array_column($event_summary,'total_pledged')),2) }}</td>
                            <td>${{ number_format(array_sum(array_column($event_summary,'total_paid')),2) }}</td>
                            <td>{{ number_format(array_sum(array_column($event_summary,'total_participants')),0) }}</td>
                            <td>{{ number_format(array_sum(array_column($event_summary,'total_nights')),0) }}</td>
                            <td>{{ number_format(array_sum(array_column($event_summary,'total_pn')),0) }}</td>
                            <td>
                                @if (array_sum(array_column($event_summary,'total_pn')) > 0)
                                    ${{ number_format((array_sum(array_column($event_summary,'total_paid')))/(array_sum(array_column($event_summary,'total_pn'))),2) }}
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

    <script>
        var revenue_data = @json($revenue_data);
        var participants_data = @json($participants_data);
        var pn_data = @json($people_nights_data);
        const event_revenue_title = @json("Event Revenue");
        const event_participant_title = @json("Event Participants");
        const event_pn_title = @json("Event People Nights");
        const labels = @json($labels);
        const event_colors = @json($event_colors);
        var options = {
                responsive: true,
                legend: {
                    display: true,
                    position: 'bottom',
                },
                title: {
                    display: true,
                    text: event_revenue_title,
                },
            };

        var data = {
            labels: labels,
            datasets: [{
                data: revenue_data,
                backgroundColor: event_colors,
                hoverOffset: 4
            }],
        };
        var part_data = {
            labels: labels,
            datasets: [{
                data: participants_data,
                backgroundColor: event_colors,
                hoverOffset: 4
            }],
        };
        var pn_data = {
            labels: labels,
            datasets: [{
                data: pn_data,
                backgroundColor: event_colors,
                hoverOffset: 4
            }],
        };


        var ctx = document.getElementById('event_revenue_chart').getContext('2d');
        
        var EventRevenueChart = new Chart(ctx, {
            type: 'doughnut',
            data: data, 
            options: options       
        });

        options.title.text = "Event Participants";
        var ctx = document.getElementById('event_participants_chart').getContext('2d');

        var EventParticipantsChart = new Chart(ctx, {
            type: 'doughnut',
            data: part_data, 
            options: options       
        });

        options.title.text = "Event People Nights";
        var ctx = document.getElementById('event_pn_chart').getContext('2d');
        var EventPeopleNightsChart = new Chart(ctx, {
            type: 'doughnut',
            data: pn_data, 
            options: options       
        });
    
    </script>

@stop
