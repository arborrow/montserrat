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
                {!! $chart->container() !!}
            </div>
        </div>
    </section>
    {!! $chart->script() !!}

@stop
