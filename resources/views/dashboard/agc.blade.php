@extends('template')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.js" integrity="sha512-d6nObkPJgV791iTGuBoVC9Aa2iecqzJRE0Jiqvk85BhLHAPhWqkuBiQb1xz2jvuHNqHLYoN3ymPfpiB1o+Zgpw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
@section('content')

    <section class="section-padding">
        <div class="jumbotron text-left">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h1>
                        <span class="grey">AGC Dashboard</span>
                    </h1>
                </div>

                <div class="col-lg-3 col-md-4">
                  <!-- hardcoded options in drop down box but can manually adjust in URL -->
                    <select class="custom-select" onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
                        <option value="">How many years back ...</option>
                        <option value="{{url('dashboard/agc/5')}}">5</option>
                        <option value="{{url('dashboard/agc/10')}}">10</option>
                        <option value="{{url('dashboard/agc/15')}}">15</option>
                        <option value="{{url('dashboard/agc/20')}}">20</option>
                        <option value="{{url('dashboard/agc/25')}}">25</option>
                    </select>
                </div>

                <div class="container">
                    <canvas id="AGCAmountsChart"></canvas>
                </div>

                <div class="container">
                    <canvas id="AGCDonorsChart"></canvas>
                </div>

                <hr />

                <div>
                    <table class="table table-bordered table-striped table-hover table-responsive-md">
                      <caption>AGC Summary</caption>
                        <thead style='text-align:center'>
                            <th>FY</th>
                            @foreach($agc_descriptions as $description)
                                <th>{{ $description->name }}</th>
                            @endforeach
                            <th>Total</th>
                        </thead>
                        @foreach($donors as $year=>$results)
                        <tr style='text-align: right'>
                            <td style='text-align: left'>{{ $year }}</td>
                            @foreach($agc_descriptions as $description)
                                <td><a href="{{url('dashboard/agc_donations?fiscal_year='.$year.'&donation_type_id='.$description->id)}}">{{ ($results['sum_'.$description->name] > 0) ? '$'.number_format($results['sum_'.$description->name],2) : '$0.00'}}</a> ({{($results['count_'.$description->name] > 0) ? $results['count_'.$description->name] : 0 }})</td>
                            @endforeach
                            <td><a href="{{ url('dashboard/agc_donations?fiscal_year='.$year.'&donation_type_id=0') }}">{{ ($results['sum'] > 0) ? '$'.number_format($results['sum'],2) : '$0.00' }}</a> ({{ $results['count'] }})</td>

                        @endforeach
                    </table>
                </div>


            </div>
        </div>
    </section>

    <script>
        var data = @json($data);
        var title = @json("Number of AGC Donors per Fiscal Year");
        var donors = @json($donors);

        var ctx = document.getElementById('AGCDonorsChart').getContext('2d');

        var myChart = new Chart(ctx, {
            type: 'line',
            options: {
                scales: {
                    y: {
                    beginAtZero: true
                    }
                },
                fill: true,
                plugins: {
                    title: {
                        display: true,
                        text: title,
                    },
                    legend: {
                        position: 'bottom',
                    },
                },
            }, 
            data: {
                labels: data.labels,
                datasets: [
                {
                    label: 'AGC - General',
                    data: data["AGC - General Donors"],
                    backgroundColor: 'rgba(51,105,232, 0.3)',
                    borderColor: 'rgba(51,105,232,0.7)',
                    borderWidth: 2,
                    tension: 0.5,
                },
                {
                    label: 'AGC - Endowment',
                    data: data["AGC - Endowment Donors"],
                    backgroundColor: 'rgba(255, 205, 86, 0.3)',
                    borderColor: 'rgba(255, 205, 86,0.7)',
                    borderWidth: 2,
                    tension: 0.5,
                },
                {
                    label: 'AGC - Scholarships',
                    data: data["AGC - Scholarships Donors"],
                    backgroundColor: 'rgba(255, 99, 132, 0.3)',
                    borderColor: 'rgba(255, 99, 132,0.7)',
                    borderWidth: 2,
                    tension: 0.5,
                },                
                {
                    label: 'AGC - Buildings & Maintenance',
                    data: data["AGC - Buildings & Maintenance Donors"],
                    backgroundColor: 'rgba(128, 0, 0, 0.3)',
                    borderColor: 'rgba(128, 0, 0, 0.7)',
                    borderWidth: 2,
                    tension: 0.5,
                },                
                {
                    label: 'Total Number of AGC Donors',
                    data: data.donor_count,
                    backgroundColor: 'rgba(22,160,133, 0.3)',
                    borderColor: 'rgba(22,160,133, 1.0)',
                    borderWidth: 2,
                    tension: 0.5,
                },
                {
                    label: 'Average Number of AGC Donors',
                    data: data.donor_count_average,
                    backgroundColor: 'rgba(110, 115, 111, 0.2)',
                    borderColor: 'rgba(110, 115, 111, 1.0)',
                    borderWidth: 2,
                    tension: 0.5,                
                },
            ]
            },
        });

    </script>

    <script>
        var data = @json($data);
        var title = @json("AGC Donations per Fiscal Year");
        var donors = @json($donors);

        var ctx = document.getElementById('AGCAmountsChart').getContext('2d');

        var myChart = new Chart(ctx, {
            type: 'line',
            options: {
                scales: {
                    y: {
                       beginAtZero: true
                    }
                },
                fill: true,
                plugins: {
                    title: {
                        display: true,
                        text: title,
                    },
                    legend: {
                        position: 'bottom',
                    },
                },
            }, 
            data: {
                labels: data.labels,
                datasets: [
                {
                    label: 'AGC - General',
                    data: data["AGC - General"],
                    backgroundColor: 'rgba(51,105,232, 0.3)',
                    borderColor: 'rgba(51,105,232,0.7)',
                    borderWidth: 2,
                    tension: 0.5,
                },
                {
                    label: 'AGC - Endowment',
                    data: data["AGC - Endowment"],
                    backgroundColor: 'rgba(255, 205, 86, 0.3)',
                    borderColor: 'rgba(255, 205, 86,0.7)',
                    borderWidth: 2,
                    tension: 0.5,
                },
                {
                    label: 'AGC - Scholarships',
                    data: data["AGC - Scholarships"],
                    backgroundColor: 'rgba(255, 99, 132, 0.3)',
                    borderColor: 'rgba(255, 99, 132,0.7)',
                    borderWidth: 2,
                    tension: 0.5,
                },                
                {
                    label: 'AGC - Buildings & Maintenance',
                    data: data["AGC - Buildings & Maintenance"],
                    backgroundColor: 'rgba(128, 0, 0, 0.3)',
                    borderColor: 'rgba(128, 0, 0, 0.7)',
                    borderWidth: 2,
                    tension: 0.5,
                },                
                {
                    label: 'Total AGC Donations',
                    data: data.sums,
                    backgroundColor: 'rgba(22,160,133, 0.3)',
                    borderColor: 'rgba(22,160,133, 1.0)',
                    borderWidth: 2,
                    tension: 0.5,
                },
                {
                    label: 'Average AGC Donations',
                    data: data.avgs,
                    backgroundColor: 'rgba(110, 115, 111, 0.2)',
                    borderColor: 'rgba(110, 115, 111, 1.0)',
                    borderWidth: 2,
                    tension: 0.5,                
                },
            ]
            },
        });

    </script>

    

@stop
