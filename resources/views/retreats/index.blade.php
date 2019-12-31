@extends('template')
@section('content')

<div class="row bg-cover" id="upcoming">
    <div class="col-12">
        <h2>
            Upcoming {{ $defaults['type'] }}
            @can('create-retreat')
                <span class="options">
                    <a href={{ action('RetreatController@create') }}>
                        {!! Html::image('images/create.png', 'Create a Retreat',array('title'=>"Create Retreat",'class' => 'btn btn-light')) !!}
                    </a>
                    <a href="#previous">
                        <i class="fas fa-history" title="Previous Retreats"></i>
                    </a>
                </span>
            @endCan
        </h2>
        <p class="lead">{{$retreats->count()}} records</p>
        <div class="row">
            <div class="col-md-4 col-12">
                <select class="custom-select" onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
                    <option value="">Filter by retreat type...</option>
                    <option value="{{url('retreat')}}">All retreats</option>
                    @foreach($event_types as $event_type=>$value)
                        <option value="{{url('retreat/type/'.$value)}}">{{$event_type}}</option>
                    @endForeach
                </select>
            </div>
        </div>
    </div>
    <div class="col-12">
        @if ($retreats->isEmpty())
        <p> Currently, there are no upcoming {{$defaults['type']}}!</p>
    @else
    <table class="table table-bordered table-striped table-hover">
        <thead>
            <tr>
                <th>ID#</th>
                <th>Title</th>
                <th>Starts - Ends</th>
                <th>Director(s)</th>
                <th>Innkeeper</th>
                <th>Assistant</th>
                <th># Attending</th>
                <th>Attachments</th>
            </tr>
        </thead>
        <tbody>
            @foreach($retreats as $retreat)
            @if ($retreat->is_active == 0)
                <tr style="text-decoration:line-through">
            @else
                <tr>
            @endIf
                <td><a href="{{url('retreat/'.$retreat->id)}}">{{ $retreat->idnumber}}</a></td>
                <td>{{ $retreat->title }}</td>
                <td>{{ date('M j, Y', strtotime($retreat->start_date)) }} - {{ date('M j, Y', strtotime($retreat->end_date)) }}</td>
                <td>
                    @if ($retreat->retreatmasters->isEmpty())
                    N/A
                    @else
                        @foreach($retreat->retreatmasters as $rm)
                            {!!$rm->contact_link_full_name!!}<br />
                        @endforeach
                    @endif
                </td>
                <td>
                    @if ($retreat->innkeeper_id > 0 && !empty($retreat->innkeeper))
                        {!!$retreat->innkeeper->contact_link_full_name!!}
                    @else
                        N/A
                    @endIf
                </td>
                <td>
                    @if ($retreat->assistant_id > 0 && !empty($retreat->assistant))
                        {!!$retreat->assistant->contact_link_full_name!!}
                    @else
                        N/A
                    @endIf
                </td>
                <td><a href="{{url('retreat/'.$retreat->id.'#registrations')}}">{{ $retreat->retreatant_count}}</a></td>
                <td>
                    @can('show-event-contract')
                        {!!$retreat->retreat_contract_link!!}
                    @endCan
                    @can('show-event-schedule')
                        {!!$retreat->retreat_schedule_link!!}
                    @endCan
                    @can('show-event-evaluation')
                        {!!$retreat->retreat_evaluations_link!!}
                    @endCan
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif
    </div>
</div>

<hr>

<div class="row bg-cover" id="previous">
    <div class="col-12">
        <h2>
            Previous {{ $defaults['type'] }}
            <span class="options">
                <a href="#upcoming">
                    <i class="fas fa-chevron-circle-up"></i>
                </a>
            </span>
        </h2>
        <p class="lead">{{$oldretreats->total()}} records</p>
    </div>
    <div class="col-12">
        @if ($oldretreats->isEmpty())
            <p> Currently, there are no previous {{$defaults['type']}}!</p>
        @else
        <table class="table">
            <thead>
                <tr>
                    <th>ID#</th>
                    <th>Title</th>
                    <th>Starts - Ends</th>
                    <th>Director(s)</th>
                    <th>Innkeeper</th>
                    <th>Assistant</th>
                    <th># Attended</th>
                    <th>Attachments</th>
                </tr>
            </thead>
            <tbody>
                @foreach($oldretreats as $oldretreat)
                @if ($oldretreat->is_active == 0)
                    <tr style="text-decoration:line-through">
                @else
                    <tr>
                @endIf
                    <td><a href="{{url('retreat/'.$oldretreat->id)}}">{{ $oldretreat->idnumber}}</a></td>
                    <td>{{ $oldretreat->title }}</td>
                    <td>{{ date('M j, Y', strtotime($oldretreat->start_date)) }} - {{ date('M j, Y', strtotime($oldretreat->end_date)) }}</td>
                    <td>
                    @if ($oldretreat->retreatmasters->isEmpty())
                        N/A
                    @else
                        @foreach($oldretreat->retreatmasters as $rm)
                            @if (!empty($rm->display_name))
                                {!!$rm->contact_link_full_name!!}
                            @else
                                N/A
                            @endIf
                        @endforeach
                    @endif
                    </td>

                    <td>
                        @if (!empty($oldretreat->innkeeper->display_name))
                            {!!$oldretreat->innkeeper->contact_link_full_name!!}
                        @else
                            N/A
                        @endIf
                    </td>
                    <td>
                        @if (!empty($oldretreat->assistant->display_name))
                            {!!$oldretreat->assistant->contact_link_full_name!!}
                        @else
                            N/A
                        @endIf
                    </td>
                    <td><a href="{{url('retreat/'.$oldretreat->id.'#registrations')}}">{{ $oldretreat->retreatant_count}}</a></td>
                    <td>
                        @can('show-event-contract')
                            {!!$oldretreat->retreat_contract_link!!}
                        @endCan
                        @can('show-event-schedule')
                            {!!$oldretreat->retreat_schedule_link!!}
                        @endCan
                        @can('show-event-evaluation')
                            {!!$oldretreat->retreat_evaluations_link!!}
                        @endCan
                    </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {!! $oldretreats->render() !!}
        @endif
    </div>
</div>
@stop
