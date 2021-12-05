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
        @can('show-donation')
            {!! Html::link('retreat/'.$retreat->id.'/payments','Retreat donations',array('class' => 'btn btn-outline-dark')) !!}
            {!! Html::link('report/finance/retreatdonations/'.$retreat->idnumber,'Donations report',array('class' => 'btn btn-outline-dark')) !!}
        @endCan
        @can('show-registration')
            <select class="custom-select col-3" onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
                <option value="">Print ...</option>
                <option value="{{url('retreat/'.$retreat->id.'/namebadges/all')}}">Namebadges</option>
                <option value="{{url('report/retreatroster/'.$retreat->idnumber)}}">Retreat roster</option>
                <option value="{{url('report/retreatlisting/'.$retreat->idnumber)}}">Retreat listing</option>
                <option value="{{url('report/retreatantinfo/'.$retreat->idnumber)}}">Retreatant info sheets</option>
                <option value="{{url('retreat/'.$retreat->id.'/roomlist')}}">Room list</option>
                <option value="{{url('retreat/'.$retreat->id.'/tableplacards')}}">Table placards</option>
                <option value="{{url('report/retreatregistrations/'.$retreat->idnumber)}}">Retreat registrations</option>
            </select>
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
                <span class="font-weight-bold">Participants: </span>{{ $retreat->participant_count}} <br>
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
                @foreach($retreat->retreatmasters as $retreatmaster)
                    {!!$retreatmaster->contact_link_full_name!!}
                    @endforeach
                    @endif
                    <span class="font-weight-bold">Innkeeper: </span>
                    @if ($retreat->innkeepers->isEmpty())
                    N/A <br>
                    @else
                    @foreach($retreat->innkeepers as $innkeeper)
                        {!!$innkeeper->contact_link_full_name!!}
                        @endforeach
                        @endif
                        <br>
                        <span class="font-weight-bold">Assistant: </span>
                        @if ($retreat->assistants->isEmpty())
                        N/A <br>
                        @else
                        @foreach($retreat->assistants as $assistant)
                            {!!$assistant->contact_link_full_name!!}
                            @endforeach
                            @endif
                            <span class="font-weight-bold">Ambassador(s): </span>
                            @if ($retreat->ambassadors->isEmpty())
                            N/A <br>
                            @else
                            <ul>
                                @foreach($retreat->ambassadors as $ambassador)
                                    <li>
                                        {!!$ambassador->contact_link_full_name!!}
                                    </li>
                                    @endforeach
                            </ul>
                            @endif
            </div>
            <div class="col-12 col-md-6 col-lg-4">
                <span class="font-weight-bold">Type: </span>{{ $retreat->retreat_type}} <br>
                <span class="font-weight-bold">Status: </span>{{ $retreat->is_active == 0 ? 'Canceled' : 'Active' }} <br>
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

                    @can('show-event-attachment')
                    @if ($attachments->isEmpty())
                    <p>There are no additional attachments for this retreat.</p>
                    @else
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Uploaded date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($attachments->sortByDesc('upload_date') as $file)
                                <tr>
                                    <td><a href="{{url('retreat/'.$retreat->id.'/attachment/'.$file->uri)}}">{{ $file->uri }}</a></td>
                                    <td><a href="{{url('attachment/'.$file->id)}}">{{$file->description}}</a></td>
                                    <td>{{ $file->upload_date}}</td>
                                </tr>
                                @endforeach
                        </tbody>
                    </table>
                    @endif
                    @endCan
                </div>
            </div>
            @can('show-event-group-photo')
            @if (Storage::has('event/'.$retreat->id.'/group_photo.jpg'))
            <div class="col-12">
                <h2>Group Photo</h2>
                <img src="{{url('retreat/'.$retreat->id).'/photo'}}" class="img" style="padding:5px; width:75%">
            </div>
            @endif
            @endCan
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
        <div class="row" id='registrations'>
            <div class="col-12">
                <h2>
                    {{$registrations->total()}} Registrations
                    {{($status ? '('.ucfirst($status).')' : NULL) }} for
                    @can('update-retreat')
                    {!!Html::link(url('retreat/'.$retreat->id.'/edit'),$retreat->title.' ('.$retreat->idnumber.')')!!}
                    @else
                    {{$retreat->title.' ('.$retreat->idnumber.')'}}
                    @endCan
                </h2>
                @can('create-registration')
                    {!! Html::link(action('RegistrationController@register',$retreat->id),'Register a retreatant',array('class' => 'btn btn-outline-dark'))!!}
                @endCan
                @can('show-contact')
                    {!! Html::link($retreat->email_registered_retreatants,'Email registered retreatants',array('class' => 'btn btn-outline-dark'))!!}
                @endCan
                @can('update-registration')
                    {!! Html::link(action('RetreatController@assign_rooms',$retreat->id),'Assign rooms',array('class' => 'btn btn-outline-dark'))!!}
                    @if (($retreat->start_date <= now()) && ($retreat->end_date >= now()))
                        {!! Html::link(action('RetreatController@checkin',$retreat->id),'Checkin',array('class' => 'btn btn-outline-dark'))!!}
                    @endIf

                    @if ($retreat->end_date < now())
                        {!! Html::link(action('RetreatController@checkout',$retreat->id),'Checkout',array('class' => 'btn btn-outline-dark'))!!}
                    @endIf
                @endCan
                <select class="custom-select col-3" onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
                    <option value="">Filter registrations by status ...</option>
                    <option value="{{url('retreat/'.$retreat->id)}}">All</option>
                    <option value="{{url('retreat/'.$retreat->id.'/status/active')}}">Active</option>
                    <option value="{{url('retreat/'.$retreat->id.'/status/arrived')}}">Arrived</option>
                    <option value="{{url('retreat/'.$retreat->id.'/status/canceled')}}">Canceled</option>
                    <option value="{{url('retreat/'.$retreat->id.'/status/confirmed')}}">Confirmed</option>
                    <option value="{{url('retreat/'.$retreat->id.'/status/dawdler')}}">Dawdler</option>
                    <option value="{{url('retreat/'.$retreat->id.'/status/departed')}}">Departed</option>
                    <option value="{{url('retreat/'.$retreat->id.'/status/retreatants')}}">Retreatants</option>
                    <option value="{{url('retreat/'.$retreat->id.'/status/unconfirmed')}}">Unconfirmed</option>
                    </select>
            </div>
            <div class="col-12 mt-3">
                @if ($registrations->isEmpty())
                <div class="text-center">
                    <p>Currently, there are no registrations for this retreat.</p>
                </div>
                @else
                    @can('show-registration')
                        {{ $registrations->links() }}
                        <table class="table table-bordered table-striped table-hover table-responsive">
                            <thead>
                                <tr>
                                    <th>Date Registered</th>
                                    <th>Picture</th>
                                    <th>Name</th>
                                    <th>Status</th>
                                    <th>Room</th>
                                    <th>Email</th>
                                    <th>Mobile</th>
                                    <th>Notes</th>
                                    <th>Parish</th>
                                </tr>
                            </thead>
                            <tbody>
                                    @foreach($registrations as $registration)
                                        @if ($registration->status_id == config('polanco.registration_status_id.waitlist'))
                                            <tr class="warning">
                                        @else
                                            <tr>
                                        @endif
                                        <td id='registration-{{$registration->id}}'><a href="{{action('RegistrationController@show', $registration->id)}}">{{ date('F d, Y', strtotime($registration->register_date)) }} </a>
                                            {{$registration->participant_role_name}} [{{ $loop->index +1 }}]
                                        </td>
                                        <td> {!!$registration->retreatant->avatar_small_link!!} </td>
                                        <td>{!!$registration->retreatant->contact_link_full_name!!} ({{$registration->retreatant_events_count}})</td>
                                        <td>
                                            @can('update-registration')
                                                {!! $registration->registration_status_buttons!!}
                                            @else
                                                {!! $registration->registration_status!!}
                                            @endCan
                                        </td>
                                        <td>
                                            @if (empty($registration->room->name))
                                                N/A
                                            @else
                                                <a href="{{action('RoomController@show', $registration->room->id)}}">{{ $registration->room->name}}</a>
                                            @endif
                                        </td>
                                        <td><a href="mailto:{{ $registration->retreatant->email_primary_text }}?subject={{ rawurlencode($retreat->title . ": Followup") }}">{{ $registration->retreatant->email_primary_text }}</a></td>
                                        <td>
                                            {!!$registration->retreatant->phone_home_mobile_number!!}
                                        </td>
                                        <td>
                                            {{ $registration->notes }} <br />
                                            <span>
                                                Health:
                                            </span>
                                            {!! (!empty($registration->retreatant->note_health->note)) ? "<div class=\"alert alert-danger alert-important\">" . $registration->retreatant->note_health->note . "</div>" : null !!}
                                            <br />
                                            <span>
                                                Dietary:
                                            </span>
                                            {!! (!empty($registration->retreatant->note_dietary->note)) ? "<div class=\"alert alert-info alert-important\">" . $registration->retreatant->note_dietary->note . "</div>" : null !!}
                                        </td>
                                        <td>
                                            @if (empty($registration->retreatant->parish_name))
                                            N/A
                                            @else
                                            {!! $registration->retreatant->parish_link!!}
                                            @endif
                                        </td>
                                        </tr>
                                    @endforeach

                            </tbody>
                        </table>
                    {{ $registrations->links() }}
                    @endCan
                @endif
            </div>
        </div>
    </div>
</div>
@stop
