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


                <div id="agc_donor" style="height:400px"> </div>

                <hr />
                <div id="agc_amount" style="height:400px"> </div>
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
    <script src="https://unpkg.com/chart.js@2.9.3/dist/Chart.min.js"></script>
    <script src="https://unpkg.com/@chartisan/chartjs@^2.0.6/dist/chartisan_chartjs.umd.js"></script>
    <script>

        const chart = new Chartisan({
            el: '#agc_donor',
            url: "@chart('agc_donor')" + "?number_of_years={{ $number_of_years }}",
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
              url: "@chart('agc_amount')" + "?number_of_years={{ $number_of_years }}",
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
