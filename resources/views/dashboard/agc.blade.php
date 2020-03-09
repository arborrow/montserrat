@extends('template')
@section('content')

    <section class="section-padding">
        <div class="jumbotron text-left">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h1>
                        <span class="grey">Dashboard</span>
                    </h1>
                </div>
                <div> {!! $agc_donor_chart->container() !!} </div>
                <hr />
                <div> {!! $agc_amount->container() !!} </div>

            </div>
        </div>
    </section>
    {!! $agc_donor_chart->script() !!}
    {!! $agc_amount->script() !!}

@stop
