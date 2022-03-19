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
                                @foreach($descriptions as $description)
                                    <option value="{{url('dashboard/description/'.$description)}}">{{ $description }}</option>
                                @endForeach
                            </select>
                        </div>
                    </div>

                <div id="description_chart" style="height:300px">  </div>
            </div>
        </div>
    </section>
    <script src="https://unpkg.com/chart.js@2.9.3/dist/Chart.min.js"></script>
    <!-- Chartisan -->
    <script src="https://unpkg.com/@chartisan/chartjs@^2.1.0/dist/chartisan_chartjs.umd.js"></script>
    <script>

        const chart = new Chartisan({
            el: '#description_chart',
            url: "@chart('donation_description')",
          });
    </script>
@stop
