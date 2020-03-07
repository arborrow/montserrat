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

                <div>FY20 Revenue by Event Type</div>
                <div> {!! $board_summary_revenue_chart->container() !!} </div>
                <hr />
                <div>FY20 Participants by Event Type</div>
                <div> {!! $board_summary_participant_chart->container() !!} </div>
            </div>
        </div>
    </section>
    {!! $board_summary_revenue_chart->script() !!}
    {!! $board_summary_participant_chart->script() !!}

@stop
