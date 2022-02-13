@extends('template')
@section('content')

<div class="row bg-cover" id="upcoming">
    <div class="col-lg-12">
        <h2>
            Upcoming {{ $defaults['type'] }} ({{$retreats->total()}})
            <span class="options">
                @can('create-retreat')
                    <a href={{ action([\App\Http\Controllers\RetreatController::class, 'create']) }}>
                        {!! Html::image('images/create.png', 'Create a Retreat',array('title'=>"Create Retreat",'class' => 'btn btn-light')) !!}
                    </a>
                @endCan
                <a href="#previous">
                    <i class="fas fa-history" title="Previous Retreats"></i>
                </a>
                <a href={{ action([\App\Http\Controllers\RetreatController::class, 'search']) }}>
                    {!! Html::image('images/search.png', 'Search retreats',array('title'=>"Search retreats",'class' => 'btn btn-link')) !!}
                </a>
            </span>
        </h2>

        <div class="row">
            <div class="col-lg-3 col-md-4">
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
    <div class="col-lg-12">
        @if ($retreats->isEmpty())
        <p> Currently, there are no upcoming {{$defaults['type']}}!</p>
    @else
    <table class="table table-bordered table-striped table-hover">
        <thead>
            <tr>
                <th>ID#</th>
                <th>Title</th>
                <th>Starts - Ends</th>
                <th>Roles</th>
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
                    Director: N/A <br />
                    @else
                        Director(s):
                        @foreach($retreat->retreatmasters as $retreatmaster)
                            {!!$retreatmaster->contact_link_full_name!!}<br />
                        @endforeach
                    @endif
                  @if ($retreat->innkeepers->isEmpty())
                  @else
                      Innkeeper(s):
                      @foreach($retreat->innkeepers as $innkeeper)
                          {!!$innkeeper->contact_link_full_name!!}<br />
                      @endforeach
                  @endif
                  @if ($retreat->assistants->isEmpty())
                  @else
                      Assistant(s):
                      @foreach($retreat->assistants as $assistant)
                          {!!$assistant->contact_link_full_name!!}<br />
                      @endforeach
                  @endif
                  @if ($retreat->ambassadors->isEmpty())
                  @else
                      Ambassador(s):
                      @foreach($retreat->ambassadors as $ambassador)
                          {!!$ambassador->contact_link_full_name!!}<br />
                      @endforeach
                  @endif

                </td>
                <td><a href="{{url('retreat/'.$retreat->id.'#registrations')}}"> {{ $retreat->participant_count }}</a></td>
                <td>
                    @if ($results['show-event-contract'])
                        {!!$retreat->retreat_contract_link!!}
                    @endIf
                    @if ($results['show-event-schedule'])
                        {!!$retreat->retreat_schedule_link!!}
                    @endIf
                    @if($results['show-event-evaluation'])
                        {!!$retreat->retreat_evaluations_link!!}
                    @endIf
                </td>
            </tr>
            @endforeach
            {{ $retreats->links() }}
        </tbody>
    </table>
    @endif
    </div>
</div>

<hr>

<div class="row bg-cover" id="previous">
    <div class="col-lg-12">
        <h2>
            Previous {{ $defaults['type'] }} ({{$oldretreats->total()}})
            <span class="options">
                <a href="#upcoming">
                    <i class="fas fa-chevron-circle-up"></i>
                </a>
            </span>
        </h2>
    </div>
    <div class="col-lg-12">
        @if ($oldretreats->isEmpty())
            <p> Currently, there are no previous {{$defaults['type']}}!</p>
        @else
        <table class="table">
            <thead>
                <tr>
                    <th>ID#</th>
                    <th>Title</th>
                    <th>Starts - Ends</th>
                    <th>Roles</th>
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
                        Director: N/A <br />
                        @else
                            Director(s):
                            @foreach($oldretreat->retreatmasters as $retreatmaster)
                                {!!$retreatmaster->contact_link_full_name!!}<br />
                            @endforeach
                        @endif
                      @if ($oldretreat->innkeepers->isEmpty())
                      @else
                          Innkeeper(s):
                          @foreach($oldretreat->innkeepers as $innkeeper)
                              {!!$innkeeper->contact_link_full_name!!}<br />
                          @endforeach
                      @endif
                      @if ($oldretreat->assistants->isEmpty())
                      @else
                          Assistant(s):
                          @foreach($oldretreat->assistants as $assistant)
                              {!!$assistant->contact_link_full_name!!}<br />
                          @endforeach
                      @endif
                      @if ($oldretreat->ambassadors->isEmpty())
                      @else
                          Ambassador(s):
                          @foreach($oldretreat->ambassadors as $ambassador)
                              {!!$ambassador->contact_link_full_name!!}<br />
                          @endforeach
                      @endif
                    </td>
                    <td><a href="{{url('retreat/'.$oldretreat->id.'#registrations')}}">{{ $oldretreat->participant_count}}</a></td>
                    <td>
                        @if($results['show-event-contract'])
                            {!!$oldretreat->retreat_contract_link!!}
                        @endIf
                        @if($results['show-event-schedule'])
                            {!!$oldretreat->retreat_schedule_link!!}
                        @endIf
                        @if($results['show-event-evaluation'])
                            {!!$oldretreat->retreat_evaluations_link!!}
                        @endIf
                    </td>
                    </tr>
                @endforeach
                {{ $oldretreats->links() }}
            </tbody>
        </table>
        @endif
    </div>
</div>
@stop
