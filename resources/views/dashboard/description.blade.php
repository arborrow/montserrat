@extends('template')
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

                <div id="description_chart" style="height:400px">  </div>
            </div>
        </div>
    </section>
    <script src="https://unpkg.com/chart.js@2.9.3/dist/Chart.min.js"></script>
    <!-- Chartisan -->
    <script src="https://unpkg.com/@chartisan/chartjs@^2.1.0/dist/chartisan_chartjs.umd.js"></script>
    <script>

        const chart = new Chartisan({
            el: '#description_chart',
            url: "@chart('donation_description')" + "?category_id={{ $donation_type->id }}",
            hooks: new ChartisanHooks()
              .title('{!! $donation_type->name !!} Donations')
              .responsive()
              .beginAtZero()
              .legend({ position: 'bottom' })
              .datasets(['line', 'line'])
              .colors(["","rgba(22,160,133, 0.3)"])
              .borderColors(["","rgba(22,160,133, 0.6)"])
          });
    </script>
@stop
