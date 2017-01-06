@extends('template')
@section('content')
<h1>Welcome to Polanco, the Montserrat Jesuit Retreat House Database!</h1>
<p>Polanco is a work in progress and is intended to be an in-house tool for managing information and making all of our lives easier.</p>
                @if ($retreats->isEmpty())
                    <p> Currently, No retreats are in progress</p>
                @else
                @can('show-retreat')
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
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
                            <td><a href="retreat/{{ $retreat->id}}">{{$retreat->idnumber}} - {{ $retreat->title }}</a></td>
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
                            <td><a href="retreat/{{ $retreat->id}}#registrations">{{$retreat->retreatant_count }}</a></td>
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
                @endCan
                @endif
<hr>            
<iframe src="https://calendar.google.com/calendar/embed?wkst=2&amp;bgcolor=%23FFFFFF&amp;src=montserratretreat.org_6rll8gg5fu0tmps7riubl0g0cc%40group.calendar.google.com&amp;color=%23711616&amp;ctz=America%2FChicago" style="border:solid 1px #777" width="800" height="600" frameborder="0" scrolling="no"></iframe>
@stop