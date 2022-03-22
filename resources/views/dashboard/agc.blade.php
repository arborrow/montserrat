@extends('template')
@section('content')

    <section class="section-padding">
        <div class="jumbotron text-left">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h1>
                        <span class="grey">AGC Dashboard</span>
                    </h1>
                </div>
                <div id="agc_donor" style="height:400px"> </div>
                <hr />
                <div id="agc_amount" style="height:400px"> </div>
            </div>
        </div>
    </section>
    <script src="https://unpkg.com/chart.js@2.9.3/dist/Chart.min.js"></script>
    <script src="https://unpkg.com/@chartisan/chartjs@^2.0.6/dist/chartisan_chartjs.umd.js"></script>
    <script>

        const chart = new Chartisan({
            el: '#agc_donor',
            url: "@chart('agc_donor')",
            hooks: new ChartisanHooks()
              .title('AGC Donors per Fiscal Year')
              .responsive()
              .beginAtZero()
              .legend({ position: 'bottom' })
              .datasets(['line', 'line'])
              .colors(["","rgba(22,160,133, 0.3)","rgba(51,105,232, 0.3)","rgba(255, 205, 86, 0.3)","rgba(255, 99, 132, 0.3)","rgba(244,67,54, 0.3)"])
              .borderColors(["","rgba(22,160,133, 0.6)","rgba(51,105,232, 0.6)","rgba(255, 205, 86, 0.6)","rgba(255, 99, 132, 0.6)","rgba(244,67,54, 0.6)"])
          });

          const amount_chart = new Chartisan({
              el: '#agc_amount',
              url: "@chart('agc_amount')",
              hooks: new ChartisanHooks()
                .title('AGC Donations per Fiscal Year')
                .responsive()
                .beginAtZero()
                .legend({ position: 'bottom' })
                .datasets(['line', 'line'])
                .colors(["","rgba(22,160,133, 0.3)","rgba(51,105,232, 0.3)","rgba(255, 205, 86, 0.3)","rgba(255, 99, 132, 0.3)","rgba(244,67,54, 0.3)"])
                .borderColors(["","rgba(22,160,133, 0.6)","rgba(51,105,232, 0.6)","rgba(255, 205, 86, 0.6)","rgba(255, 99, 132, 0.6)","rgba(244,67,54, 0.6)"])
            });

    </script>

@stop
