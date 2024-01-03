@extends('template')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.js" integrity="sha512-d6nObkPJgV791iTGuBoVC9Aa2iecqzJRE0Jiqvk85BhLHAPhWqkuBiQb1xz2jvuHNqHLYoN3ymPfpiB1o+Zgpw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

@section('content')

    <section class="section-padding">
        <div class="jumbotron text-left">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h1>
                        <span class="grey">Donation Description Dashboard</span>
                    </h1>
                </div>
                    <div class="row">
                        <div class="col-lg-3 col-md-4">
                            <select class="custom-select" onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
                                <option value="">Filter by Donation Description ...</option>
                                @foreach($descriptions as $key=>$description)
                                    <option value="{{url('dashboard/description/'.$description)}}">{{ $key }}</option>
                                @endForeach
                            </select>
                        </div>
                    </div>
                <div class="container">
                    <canvas id="DonationDescriptionChart"></canvas>
                </div>
            </div>
        </div>
    </section>

    <script>

        var data = @json($data);
        var title = @json($donation_type->name . " Donations");

        var ctx = document.getElementById('DonationDescriptionChart').getContext('2d');

        var myChart = new Chart(ctx, {
            type: 'line',
            options: {
                plugins: {
                    title: {
                        display: true,
                        text: title
                    },
                    legend: {
                        position: 'bottom',
                    },

                },
                fill: true,
                scales: {
                    y: {
                       beginAtZero: true
                    }
                },
            },
            data: {
                labels: data.labels,
                datasets: [{
                    label: 'Donations',
                    data: data.dataset1,
                    backgroundColor: 'rgba(22, 160, 133, 0.3)',
                    borderColor: 'rgba(22,160,133,0.7)',

                    borderWidth: 2,
                    tension: 0.33, // Set tension for a smoother curve                
                }, 
                {
                    label: 'Average',
                    data: data.dataset2,
                    backgroundColor: 'rgba(110, 115, 111, 0.2)',
                    borderColor: 'rgba(110, 115, 111, 1.0)',
                    borderWidth: 2,
                    tension: 0.5,
                }]
            },
        });

    </script>

@stop
