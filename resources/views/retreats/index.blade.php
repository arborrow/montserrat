@extends('template')
@section('content')

    <section class="section-padding">
        <div class="jumbotron text-left">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h1>
                        <span class="grey" id="upcoming_retreats">Upcoming retreats ({{$retreats->count()}}) </span> 
                        <span class="previous">{!! Html::link('#previous_retreats','Previous retreats',array('class' => 'btn btn-primary'))!!}</span>
                        @can('create-retreat')
                            <span class="create">
                                <a href={{ action('RetreatsController@create') }}>{!! Html::image('img/create.png', 'Create a Retreat',array('title'=>"Create Retreat",'class' => 'btn btn-primary')) !!}</a>
                            </span>
                        @endCan
                    </h1>

                </div>
                @if ($retreats->isEmpty())
                    <p> Currently, there are no upcoming retreats!</p>
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
                            <!--<th>Silent</th>
                            <th>Edit</th>
                            <th>Delete</th> -->
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($retreats as $retreat)
                        <tr>
                            <td><a href="retreat/{{ $retreat->id}}">{{ $retreat->idnumber}}</a></td>
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
                                @if ($retreat->innkeeper_id > 0)
                                    {!!$retreat->innkeeper->contact_link_full_name!!}
                                @else
                                    N/A
                                @endIf
                            </td>
                            <td>
                                @if ($retreat->assistant_id > 0)
                                    {!!$retreat->assistant->contact_link_full_name!!}
                                @else
                                    N/A
                                @endIf
                            </td>
                            <td>{{$retreat->retreatant_count }}</td>
                            <td> {!!$retreat->retreat_contract_link!!} {!!$retreat->retreat_schedule_link!!} {!!$retreat->retreat_evaluations_link!!}</td>
                            <!--<td>{{ $retreat->silent ? 'Yes' : 'No'}}</td>
                            <td><a href="{{ action('RetreatsController@edit', $retreat->id) }}" class="btn btn-info">{!! Html::image('img/edit.png', 'Edit',array('title'=>"Edit")) !!}</a></td>
<td>{!! Form::open(['method' => 'DELETE', 'route' => ['retreat.destroy', $retreat->id],'onsubmit'=>'return ConfirmDelete()']) !!}
 {!! Form::image('img/delete.png','btnDelete',['class' => 'btn btn-danger','title'=>'Delete']) !!} 
{!! Form::close() !!}
</td>-->
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @endif
<hr>            <div class="panel-heading">
                    <h1>
                    <span class="grey" id="previous_retreats">Previous retreats ({{$oldretreats->total()}})</span> 
                    <span class="grey">{!! Html::link('#upcoming_retreats','Upcoming retreats',array('class' => 'btn btn-primary'))!!}</span>
                    </h1>
                </div>
                
                @if ($oldretreats->isEmpty())
                    <p> Currently, there are no previous retreats!</p>
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
                            <!--<th>Silent</th>
                            <th>Edit</th>
                            <th>Delete</th> -->
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($oldretreats as $oldretreat)
                        <tr>
                            <td><a href="retreat/{{ $oldretreat->id}}">{{ $oldretreat->idnumber}}</a></td>
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
                            <td>{{ $oldretreat->retreatant_count}}</td>
                            <td> {!!$oldretreat->retreat_contract_link!!} {!!$oldretreat->retreat_schedule_link!!} {!!$oldretreat->retreat_evaluations_link!!}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {!! $oldretreats->render() !!}  
                @endif
            </div>
        </div>
    </section>
@stop