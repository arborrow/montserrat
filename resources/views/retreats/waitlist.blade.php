@extends('template')
@section('content')

<section class="section-padding">
    <div class="jumbotron text-left">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h2>
                    @can('update-retreat')
                        Retreat {!!Html::link(url('retreat/'.$retreat->id.'/edit'),$retreat->idnumber.' - '.$retreat->title.' Waitlist')!!} 
                    @else
                        Retreat {{$retreat->idnumber.' - '.$retreat->title}} Waitlist
                    @endCan
                </h2>
                {!! Html::link('#registrations','Waitlist Registrations',array('class' => 'btn btn-primary')) !!}
                {!! Html::link(url('retreat'),'Retreat index',array('class' => 'btn btn-primary')) !!}
            
            </div>
            <div class='row'>
                <div class='col-md-2'><strong>ID#: </strong>{{ $retreat->idnumber}}</div>
            </div><div class="clearfix"> </div>
            <div class='row'>
                <div class='col-md-3'><strong>Starts: </strong>{{ date('F j, Y g:i A', strtotime($retreat->start_date)) }}</div>
                <div class='col-md-3'><strong>Ends: </strong>{{ date('F j, Y g:i A', strtotime($retreat->end_date)) }}</div>
            </div><div class="clearfix"> </div>
            <div class='row'>
                <div class='col-md-3'><strong>Title: </strong>{{ $retreat->title}}</div>
                <div class='col-md-3'><strong>Attending: </strong>{{ $retreat->retreatant_count}}
                @if ($retreat->retreatant_waitlist_count > 0)
                    ({{ $retreat->retreatant_waitlist_count }})
                @endif
                </div>
            </div><div class="clearfix"> </div>
            <div class='row'>
                <div class='col-md-6'><strong>Description: </strong>{{ $retreat->description}}</div>
            </div><div class="clearfix"> </div>
            <div class='row'>
                <div class='col-md-3'><strong>Director(s): </strong>
                    @if ($retreat->retreatmasters->isEmpty())
                        N/A
                    @else
                        @foreach($retreat->retreatmasters as $rm)
                            {!!$rm->contact_link_full_name!!}
                        @endforeach
                    @endif
                </div>
    
                <div class='col-md-3'><strong>Innkeeper: </strong>
                    @if ($retreat->innkeeper_id > 0)
                        {!!$retreat->innkeeper->contact_link_full_name!!}
                    @else
                        N/A
                    @endIf
                </div>
                <div class='col-md-3'><strong>Assistant: </strong>
                    @if ($retreat->assistant_id > 0)
                        {!!$retreat->assistant->contact_link_full_name!!}
                    @else
                        N/A
                    @endIf
                </div>

            </div><div class="clearfix"> </div>
            <div class='row'>
                <div class='col-md-6'><strong>Captain(s): </strong>
                    @if ($retreat->captains->isEmpty())
                        N/A
                    @else
                    <ul>
                        @foreach($retreat->captains as $captain)
                        <li>    {!!$captain->contact_link_full_name!!} </li>
                        @endforeach
                    </ul>
                    @endif
                </div>
            </div>
            <div class='row'>
                <div class='col-md-3'><strong>Type: </strong>{{ $retreat->retreat_type}}</div>
                <div class='col-md-3'><strong>Status: </strong>{{ $retreat->is_active == 0 ? 'Cancelled' : 'Active' }}</div>
<!--                <div class='col-md-3'><strong>Silent: </strong>{{ $retreat->silent}}</div> -->
                <div class='col-md-3'><strong>Donation: </strong>{{ $retreat->amount}}</div>
            </div><div class="clearfix"> </div>
            <div class='row'>
            </div><div class="clearfix"> </div>
            <div class='row'>
                <div class='col-md-2'><strong>Last updated: </strong>{{ $retreat->updated_at->format('D F j, Y \a\t g:ia')}}</div>
            </div><div class="clearfix"> </div>
            <div class='row'>
                <div class="col-md-1">
                    <strong>Attachments: </strong>
                </div>
                <div class="col-md-2">
                    @can('show-event-contract')
                        {!!$retreat->retreat_contract_link!!}
                    @endCan
                    @can('show-event-schedule')
                        {!!$retreat->retreat_schedule_link!!}
                    @endCan
                    @can('show-event-evaluation')
                        {!!$retreat->retreat_evaluations_link!!}
                    @endCan
                </div>
                    
            </div>
            <div class="clearfix"> </div>
            @can('show-event-group-photo')
                <div class='row'>

                    @if (Storage::has('event/'.$retreat->id.'/group_photo.jpg'))
                        <div class='col-md-1'>
                            <strong>Group photo:</strong> 
                        </div>
                        <div class='col-md-8'>
                            <img src="{{url('retreat/'.$retreat->id).'/photo'}}" class="img" style="padding:5px; width:75%">
                        </div>
                    @endif

                </div>
            @endCan
            <div class="clearfix"> </div>
                
        </div>
            <div class='row'>
                @can('update-retreat')
                    <div class='col-md-1'>
                        <a href="{{ action('RetreatController@edit', $retreat->id) }}" class="btn btn-info">{!! Html::image('/images/edit.png', 'Edit',array('title'=>"Edit")) !!}</a>
                    </div>
                @endCan
                @can('delete-retreat')
                    <div class='col-md-1'>{!! Form::open(['method' => 'DELETE', 'route' => ['retreat.destroy', $retreat->id],'onsubmit'=>'return ConfirmDelete()']) !!}
                        {!! Form::image('/images/delete.png','btnDelete',['class' => 'btn btn-danger','title'=>'Delete']) !!} 
                        {!! Form::close() !!}
                    </div>
                @endCan
                <div class="clearfix"> </div>
            </div><br />
        <div class="panel panel-default">  
        <div class="panel-heading" id='registrations'>
            <h2>Waitlist for {!!Html::link(url('retreat/'.$retreat->id),$retreat->idnumber.' - '.$retreat->title)!!} </h2>
            
            @can('show-contact')
                {!! Html::link($retreat->email_waitlist_retreatants,'Email retreatants on waitlist',array('class' => 'btn btn-outline-dark'))!!}
            @endCan
            @can('create-touchpoint')
                {!! Html::link(action('TouchpointController@add_retreat_waitlist',$retreat->id),'Waitlist touchpoint',array('class' => 'btn btn-outline-dark'))!!}
            @endCan    
        </div>
            @if ($registrations->isEmpty())
                <p> Currently, there is no waitlist for this retreat.</p>
            @else
            <table class="table">
                <thead>
                    <tr>
                        <th>Date Registered</th>
                        <th>Picture</th>
                        <th>Name</th>
                        <th>Room</th>
                        <th>Email</th>
                        <th>Mobile Phone</th>
                        <th>Parish</th>
                        <th>Notes</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                @can('show-registration')    
                    @foreach($registrations->sortBy('register_date') as $registration)
                        <tr>
                            <td id='registration-{{$registration->id}}'><a href="{{action('RegistrationController@show', $registration->id)}}">{{ date('F d, Y', strtotime($registration->register_date)) }}</a></td>
                            <td> {!!$registration->retreatant->avatar_small_link!!} </td>
                            <td>{!!$registration->retreatant->contact_link_full_name!!} ({{$registration->retreatant->participant_count}})</td>
                            <td>
                                @if (empty($registration->room->name))
                                    N/A
                                @else
                                <a href="{{action('RoomController@show', $registration->room->id)}}">{{ $registration->room->name}}</a>
                                @endif
                            </td>
                            <td>{{ $registration->retreatant->email_primary_text }}</td>
                            <td>
                                {!!$registration->retreatant->phone_home_mobile_number!!}
                            </td>
                            <td>
                                @if (empty($registration->retreatant->parish_name))
                                    N/A
                                @else
                                {!! $registration->retreatant->parish_link!!}
                                @endif
                            </td>
                            <td> {{ $registration->notes }} <br />
                                <strong>Health:</strong> {!! (!empty($registration->retreatant->note_health->note)) ? "<div class=\"alert alert-danger\">" . $registration->retreatant->note_health->note . "</div>" : null !!}</div><br />
                                <strong>Dietary:</strong> {!! (!empty($registration->retreatant->note_dietary->note)) ? "<div class=\"alert alert-info\">" . $registration->retreatant->note_dietary->note . "</div>" : null !!}</div>
                            </td>
                            <td>
                                @can('update-registration')
                                <span class="btn btn-danger">
                                    {!!Html::link(url('registration/'.$registration->id.'/offwaitlist'),'Register')!!}
                                </span>
                                @else
                                    {{ $registration->status_name }}
                                @endCan
                            </td>
                        </tr>
                        @endforeach
                    @endCan
            </tbody>
</table>@endif
        </div>
    </div>        </div>

</section>
@stop
