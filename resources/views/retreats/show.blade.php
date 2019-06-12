@extends('template')
@section('content')

<div class="row bg-cover">
    <div class="col-12">
        <h1>
            @can('update-retreat')
                Retreat {!!Html::link(url('retreat/'.$retreat->id.'/edit'),$retreat->title.' ('.$retreat->idnumber.')')!!} 
            @else
                Retreat {{$retreat->title.' ('.$retreat->idnumber.')'}} 
            @endCan
        </h1>
    </div>
    <div class="col-12">
        {!! Html::link('#registrations','Registrations',array('class' => 'btn btn-outline-dark')) !!}
        @can('create-touchpoint')
            {!! Html::link(action('TouchpointController@add_retreat',$retreat->id),'Retreat touchpoint',array('class' => 'btn btn-outline-dark'))!!}
        @endCan    
        @can('show-contact')
            {!! Html::link(action('PageController@retreatantinforeport',$retreat->idnumber),'Retreatant information',array('class' => 'btn btn-outline-dark'))!!}
            {!! Html::link(action('PageController@retreatrosterreport',$retreat->idnumber),'Retreatant roster',array('class' => 'btn btn-outline-dark'))!!}
            {!! Html::link(action('PageController@retreatlistingreport',$retreat->idnumber),'Retreatant listing',array('class' => 'btn btn-outline-dark'))!!}
        @endCan
        @can('show-donation')
            {!! Html::link('retreat/'.$retreat->id.'/payments','Retreat donations',array('class' => 'btn btn-outline-dark')) !!}
            {!! Html::link('report/finance/retreatdonations/'.$retreat->idnumber,'Donations report',array('class' => 'btn btn-outline-dark')) !!}
        @endCan
    </div>
    <div class="col-12 mt-3">
        <h2>Details</h2>
        <div class="row">
            <div class="col-12 col-md-6 col-lg-4">
                <span class="font-weight-bold">ID#: </span>{{ $retreat->idnumber}} <br>
                <span class="font-weight-bold">Starts: </span>{{ date('F j, Y g:i A', strtotime($retreat->start_date)) }} <br>
                <span class="font-weight-bold">Ends: </span>{{ date('F j, Y g:i A', strtotime($retreat->end_date)) }} <br>
                <span class="font-weight-bold">Title: </span>{{ $retreat->title}} <br>
                <span class="font-weight-bold">Attending: </span>{{ $retreat->retreatant_count}} <br>
                @if ($retreat->retreatant_waitlist_count > 0)
                    ({!!Html::link(url('retreat/'.$retreat->id.'/waitlist'), $retreat->retreatant_waitlist_count) !!}) <br>
                @endif
            </div>
            <div class="col-12 col-md-6 col-lg-4">
                <span class="font-weight-bold">Description: </span>
                @if (!$retreat->description)
                    N/A
                @else
                    {{ $retreat->description }}
                @endif
                <br>
                <span class="font-weight-bold">Director(s): </span>
                @if ($retreat->retreatmasters->isEmpty())
                    N/A <br>
                @else
                    @foreach($retreat->retreatmasters as $rm)
                        {!!$rm->contact_link_full_name!!}
                    @endforeach
                @endif
                <span class="font-weight-bold">Innkeeper: </span>
                @if ($retreat->innkeeper_id > 0)
                    {!!$retreat->innkeeper->contact_link_full_name!!}
                @else
                    N/A
                @endIf
                <br>
                <span class="font-weight-bold">Assistant: </span>
                @if ($retreat->assistant_id > 0)
                    {!!$retreat->assistant->contact_link_full_name!!}
                @else
                    N/A <br>
                @endIf
                <span class="font-weight-bold">Captain(s): </span>
                @if ($retreat->captains->isEmpty())
                    N/A <br>
                @else
                    <ul>
                        @foreach($retreat->captains as $captain)
                            <li>
                                {!!$captain->contact_link_full_name!!}
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
            <div class="col-12 col-md-6 col-lg-4">
                <span class="font-weight-bold">Type: </span>{{ $retreat->retreat_type}} <br>
                <span class="font-weight-bold">Status: </span>{{ $retreat->is_active == 0 ? 'Cancelled' : 'Active' }} <br>
                <span class="font-weight-bold">Donation: </span>{{ $retreat->amount}} <br>
                <span class="font-weight-bold">Last updated: </span>{{ $retreat->updated_at->format('D F j, Y \a\t g:ia')}}
            </div>
            <div class="col-12">
                <h2>Attachments</h2>
                <div class="row">
                    <div class="col-12 col-lg-4">
                        @can('show-event-contract')
                            {!!$retreat->retreat_contract_link!!}
                        @endCan
                    </div>
                    <div class="col-12 col-lg-4">
                        @can('show-event-schedule')
                            {!!$retreat->retreat_schedule_link!!}
                        @endCan
                    </div>
                    <div class="col-12 col-lg-4">
                        @can('show-event-evaluation')
                            {!!$retreat->retreat_evaluations_link!!}
                        @endCan
                    </div>
                </div>
            </div>
            @if (Storage::has('event/'.$retreat->id.'/group_photo.jpg'))
                <div class="col-12">
                    <h2>Group Photo</h2>
                    <img src="{{url('retreat/'.$retreat->id).'/photo'}}" class="img" style="padding:5px; width:75%">
                </div>
            @endif
        </div>
    </div>
    <div class="col-12">
        <div class="row">
            <div class="col-6 text-right">
                @can('update-retreat')
                    <a href="{{ action('RetreatController@edit', $retreat->id) }}" class="btn btn-info">{!! Html::image('images/edit.png', 'Edit',array('title'=>"Edit")) !!}</a>
                @endCan
            </div>
            <div class="col-6 text-left">
                @can('delete-retreat')
                    {!! Form::open(['method' => 'DELETE', 'route' => ['retreat.destroy', $retreat->id],'onsubmit'=>'return ConfirmDelete()']) !!}
                    {!! Form::image('images/delete.png','btnDelete',['class' => 'btn btn-danger','title'=>'Delete']) !!} 
                    {!! Form::close() !!}
                @endCan
            </div>
        </div>
    </div>
    <div class="col-12 mt-3">
        <div class="row">
            <div class="col-12">
                <h2>Retreatants Registered for {!!Html::link(url('retreat/'.$retreat->id.'/edit'),$retreat->idnumber.' - '.$retreat->title)!!} </h2>
                @can('create-registration')
                    {!! Html::link(action('RegistrationController@register',$retreat->id),'Register a retreatant',array('class' => 'btn btn-outline-dark'))!!}
                @endCan
                @can('show-contact')
                    {!! Html::link($retreat->email_registered_retreatants,'Email registered retreatants',array('class' => 'btn btn-outline-dark'))!!}
                @endCan
                @can('update-registration')
                    {!! Html::link(action('RetreatController@assign_rooms',$retreat->id),'Assign rooms',array('class' => 'btn btn-outline-dark'))!!}
                @endCan
                @can('update-registration')
                    @if ($retreat->end_date < now())
                        {!! Html::link(action('RetreatController@checkout',$retreat->id),'Checkout',array('class' => 'btn btn-outline-dark'))!!}
                    @endIf
                @endCan
            </div>
            <div class="col-12 mt-3">
                @if ($registrations->isEmpty())
                    <div class="text-center">
                        <p>Currently, there are no registrations for this retreat.</p>
                    </div>
                @else
                    <table class="table table-bordered table-striped table-hover table-responsive">
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
                                @foreach($registrations->sortBy('retreatant.sort_name') as $registration)
                                    @if ($registration->status_id == config('polanco.registration_status_id.waitlist'))
                                        <tr class="warning">
                                    @else
                                        <tr>
                                    @endif
                                        <td id='registration-{{$registration->id}}'><a href="{{action('RegistrationController@show', $registration->id)}}">{{ date('F d, Y', strtotime($registration->register_date)) }} </a></td>
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
                                            <span>Health:</span> {!! (!empty($registration->retreatant->note_health->note)) ? "<div class=\"alert alert-danger\">" . $registration->retreatant->note_health->note . "</div>" : null !!}</div><br />
                                            <span>Dietary:</span> {!! (!empty($registration->retreatant->note_dietary->note)) ? "<div class=\"alert alert-info\">" . $registration->retreatant->note_dietary->note . "</div>" : null !!}</div>
                                        </td>
                                        <td>
                                            @can('update-registration')
                                                {!! $registration->registration_status_buttons!!}
                                            @else
                                                {!! $registration->registration_status!!}
                                            @endCan
                                        </td>
                                    </tr>
                                @endforeach
                            @endCan
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
</div>
@stop
