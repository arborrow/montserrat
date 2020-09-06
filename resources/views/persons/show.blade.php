@extends('template')
@section('content')

<div class="row bg-cover">
    <div class="col-12">
        <div class="row text-center">
            <div class="col-12">
                {!!$person->avatar_large_link!!}
            </div>
            <div class="col-12">
                @can('update-contact')
                    <h1><span class="font-weight-bold"><a href="{{url('person/'.$person->id.'/edit')}}">{{ $person->full_name }}</a></span></h1>
                @else
                    <h1><span class="font-weight-bold">{{ $person->full_name }}</span></h1>
                @endCan
            </div>
            <div class="col-12">
                {!! Html::link('#contact_info','Contact',array('class' => 'btn btn-outline-dark')) !!}
                {!! Html::link('#demographics','Demographics',array('class' => 'btn btn-outline-dark')) !!}
                {!! Html::link('#groups','Groups',array('class' => 'btn btn-outline-dark')) !!}
                {!! Html::link('#notes','Notes',array('class' => 'btn btn-outline-dark')) !!}
                @can('show-relationship'){!! Html::link('#relationships','Relationships',array('class' => 'btn btn-outline-dark')) !!} @endCan
                @can('show-registration'){!! Html::link('#registrations','Registrations',array('class' => 'btn btn-outline-dark')) !!} @endCan
                @can('show-touchpoint'){!! Html::link('#touchpoints','Touchpoints',array('class' => 'btn btn-outline-dark')) !!} @endCan
                @can('show-attachment'){!! Html::link('#attachments','Attachments',array('class' => 'btn btn-outline-dark')) !!} @endCan
                @can('show-donation') {!! Html::link('#donations','Donations',array('class' => 'btn btn-outline-dark')) !!} @endCan
            </div>
            <div class="col-12 mt-2">
                @can('show-group')
                @if ($person->is_board_member) <span><a href={{ action('PersonController@boardmembers') }}>{!! Html::image('images/board.png', 'Board Members Group',array('title'=>"Board Members Group",'class' => 'btn btn-outline-dark')) !!}</a></span> @endIf
                @if ($person->is_ambassador) <span><a href={{ action('PersonController@ambassadors') }}>{!! Html::image('images/ambassador.png', 'Ambassador Group',array('title'=>"Ambassadors Group",'class' => 'btn btn-outline-dark')) !!}</a></span> @endIf
                @if ($person->is_staff) <span><a href={{ action('PersonController@staff') }}>{!! Html::image('images/employee.png', 'Staff Group',array('title'=>"Employees Group",'class' => 'btn btn-outline-dark')) !!}</a></span> @endIf
                @if ($person->is_steward) <span><a href={{ action('PersonController@stewards') }}>{!! Html::image('images/steward.png', 'Steward Group',array('title'=>"Stewards Group",'class' => 'btn btn-outline-dark')) !!}</a></span> @endIf
                @if ($person->is_volunteer) <span><a href={{ action('PersonController@volunteers') }}>{!! Html::image('images/volunteer.png', 'Volunteers Group',array('title'=>"Volunteers Group",'class' => 'btn btn-outline-dark')) !!}</a></span> @endIf
                @if ($person->is_retreat_director) <span><a href={{ action('PersonController@directors') }}>{!! Html::image('images/director.png', 'Retreat Directors Group',array('title'=>"Directors Group",'class' => 'btn btn-outline-dark')) !!}</a></span> @endIf
                @if ($person->is_retreat_innkeeper) <span><a href={{ action('PersonController@innkeepers') }}>{!! Html::image('images/innkeeper.png', 'Retreat Innkeepers Group',array('title'=>"Innkeepers Group",'class' => 'btn btn-outline-dark')) !!}</a></span> @endIf
                @if ($person->is_retreat_assistant) <span><a href={{ action('PersonController@assistants') }}>{!! Html::image('images/assistant.png', 'Retreat Assistants Group',array('title'=>"Assistants Group",'class' => 'btn btn-outline-dark')) !!}</a></span> @endIf
                @if ($person->is_bishop) <span><a href={{ action('PersonController@bishops') }}>{!! Html::image('images/bishop.png', 'Bishops Group',array('title'=>"Bishop Group",'class' => 'btn btn-outline-dark')) !!}</a></span> @endIf
                @if ($person->is_pastor) <span><a href={{ action('PersonController@pastors') }}>{!! Html::image('images/pastor.png', 'Pastors Group',array('title'=>"Pastors Group",'class' => 'btn btn-outline-dark')) !!}</a></span> @endIf
                @if ($person->is_priest) <span><a href={{ action('PersonController@priests') }}>{!! Html::image('images/priest.png', 'Priests Group',array('title'=>"Priests Group",'class' => 'btn btn-outline-dark')) !!}</a></span> @endIf
                @if ($person->is_deacon) <span><a href={{ action('PersonController@deacons') }}>{!! Html::image('images/deacon.png', 'Deacons Group',array('title'=>"Deacons Group",'class' => 'btn btn-outline-dark')) !!}</a></span> @endIf
                @if ($person->is_provincial) <span><a href={{ action('PersonController@provincials') }}>{!! Html::image('images/provincial.png', 'Provincials Group',array('title'=>"Provincials Group",'class' => 'btn btn-outline-dark')) !!}</a></span> @endIf
                @if ($person->is_superior) <span><a href={{ action('PersonController@superiors') }}>{!! Html::image('images/superior.png', 'Superiors Group',array('title'=>"Superiors Group",'class' => 'btn btn-outline-dark')) !!}</a></span> @endIf
                @if ($person->is_jesuit) <span><a href={{ action('PersonController@jesuits') }}>{!! Html::image('images/jesuit.png', 'Jesuits Group',array('title'=>"Jesuits Group",'class' => 'btn btn-outline-dark')) !!}</a></span> @endIf
                @endCan
            </div>
            <div class="col-12 mt-2">
                @can('create-touchpoint')
                <span class="btn btn-outline-dark">
                    <a href={{ action('TouchpointController@add',$person->id) }}>Add Touchpoint</a>
                </span>
                @endCan
                @can('create-registration')
                <span class="btn btn-outline-dark">
                    <a href={{ action('RegistrationController@add',$person->id) }}>Add Registration</a>
                </span>
                @endCan
                 <span class="btn btn-outline-dark">
                    <a href={{ action('PageController@contact_info_report',$person->id) }}>Contact Info Report</a>
                </span>
                <span class="btn btn-outline-dark">
                    <a href={{ URL('person/'.$person->id.'/envelope?size=10&logo=0') }}><img src={{URL::asset('images/envelope.png')}} title="Print envelope" alt="Print envelope"></a>
                </span>
                <span class="btn btn-outline-dark">
                    <a href={{ URL('person/'.$person->id.'/envelope?size=9x6&logo=1') }}><img src={{URL::asset('images/envelope9x6.png')}} title="Print 9x6 envelope" alt="Print 9x6 envelope"></a>
                </span>
            </div>
        </div>
    </div>
    <div class="col-12 mt-5">
        <div class="row">
            <div class="col-12 col-lg-6" id="basic_info">
                <h2>Basic Information</h2>
                <p>
                    <span class="font-weight-bold">Title: </span>{{ (!empty($person->prefix_name)) ? $person->prefix_name : null }}
                    <br><span class="font-weight-bold">First Name: </span>{{ (!empty($person->first_name)) ? $person->first_name : null }}
                    <br><span class="font-weight-bold">Middle Name: </span>{{ (!empty($person->middle_name)) ? $person->middle_name : null}}
                    <br><span class="font-weight-bold">Last Name: </span>{{ (!empty($person->last_name)) ? $person->last_name : null}}
                    <br><span class="font-weight-bold">Suffix: </span>{{$person->suffix_name}}
                    <br><span class="font-weight-bold">Nick name:</span> {{ (!empty($person->nick_name)) ? $person->nick_name : null }}
                    <br><span class="font-weight-bold">Display name: </span>{{ (!empty($person->display_name)) ? $person->display_name : null }}
                    <br><span class="font-weight-bold">Sort name: </span>{{ (!empty($person->sort_name)) ? $person->sort_name : null }}
                    <br><span class="font-weight-bold">AGC Household name: </span>{{ (!empty($person->agc_household_name)) ? $person->agc_household_name : null }}
                    <br><span class="font-weight-bold">Contact type: </span>{{ $person->contact_type_label }}
                    <br><span class="font-weight-bold">Subcontact type: </span>{{ $person->subcontact_type_label }}
                </p>
            </div>
            <div class="col-12 col-lg-6 alert alert-danger alert-important" id="safety_info">
                <h2>Emergency Contact Information</h2>
                <p>
                    <span class="font-weight-bold">Name: </span>{{ !empty($person->emergency_contact->name) ? $person->emergency_contact->name : 'N/A' }}
                    <br><span class="font-weight-bold">Relationship: </span>{{ !empty($person->emergency_contact->relationship) ? $person->emergency_contact->relationship : 'N/A' }}
                    <br><span class="font-weight-bold">Phone:</span> {{ !empty($person->emergency_contact->phone) ? $person->emergency_contact->phone : 'N/A' }}
                    <br><span class="font-weight-bold">Alt phone:</span> {{ !empty($person->emergency_contact->phone_alternate) ? $person->emergency_contact->phone_alternate: 'N/A' }}
                </p>
                <h2>Health and Dietary Information</h2>
                <p>
                    <span class="font-weight-bold">Health notes: </span>{{$person->note_health}}
                    <br><span class="font-weight-bold">Dietary notes: </span>{{$person->note_dietary}}
                </p>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-lg-6" id="contact_info">
                <h2>Contact Information</h2>
                <div class="row">
                    <strong>Preferred communication method: </strong> {{ config('polanco.preferred_communication_method.'.$person->preferred_communication_method) }}
                </div>
                <div class="row">
                    @if($person->do_not_phone)
                        <div class="alert alert-warning col-12 col-lg-3 m-2" role="alert">
                            <span class="font-weight-bold">Do Not Call</span>
                        </div>
                    @endIf
                    @if($person->do_not_sms)
                        <div class="alert alert-warning col-12 col-lg-3 m-2" role="alert">
                            <span class="font-weight-bold">Do Not Text</span>
                        </div>
                    @endIf
                    @if($person->do_not_mail)
                        <div class="alert alert-warning col-12 col-lg-3 m-2" role="alert">
                            <span class="font-weight-bold">Do Not Mail</span>
                        </div>
                    @endIf
                    @if($person->do_not_email)
                        <div class="alert alert-warning col-12 col-lg-3 m-2" role="alert">
                            <span class="font-weight-bold">Do Not Email</span>
                        </div>
                    @endIf
                </div>
                <div><h3>Address(es)</h3>
                @foreach($person->addresses as $address)
                    @if (!empty($address->street_address))
                        <span class="font-weight-bold">{{$address->location->display_name}}:</span>
                        <address class="d-inline">{!!$address->google_map!!}</address>
                        @can('delete-address')
                            {!! Form::open(['method' => 'DELETE', 'route' => ['address.destroy', $address->id],'onsubmit'=>'return ConfirmDelete()', 'class' => 'd-inline']) !!}
                                <button type="submit" class="btn btn-outline-dark btn-sm"><i class="fas fa-trash"></i></button>
                            {!! Form::close() !!}
                        @endCan
                        <br>
                    @endif
                @endforeach
            </div>
                <div><h3>Phone(s)</h3>
                    @foreach($person->phones as $phone)
                        @if(!empty($phone->phone))
                            <span class="font-weight-bold">{{$phone->location->display_name}} - {{$phone->phone_type}}: </span>
                            <a href="tel:{{$phone->phone}}{{$phone->phone_extension}}">{{$phone->phone}}{{$phone->phone_extension}}</a>
                            <br>
                        @endif
                    @endforeach
                </div>
                <div><h3>Email(s)</h3>
                    @foreach($person->emails as $email)
                        @if(!empty($email->email))
                            <span class="font-weight-bold">{{$email->location->display_name}} - Email: </span><a href="mailto:{{$email->email}}">{{$email->email}}</a>
                            <br>
                        @endif
                    @endforeach
                </div>
                <div><h3>Website(s)</h3>
                @foreach($person->websites as $website)
                    @if(!empty($website->url))
                        <span class="font-weight-bold">{{$website->website_type}} - URL: </span><a href="{{$website->url}}" target="_blank">{{$website->url}}</a>
                        <br>
                    @endif
                @endforeach
                </div>
            </div>
            <div class="col-12 col-lg-6" id="demographics">
                <h2>Demographics</h2>
                <p>
                    <span class="font-weight-bold">Gender: </span>{{ !empty($person->gender_name) ? $person->gender_name : 'N/A' }}
                    <br><span class="font-weight-bold">Birth Date: </span> {{ !empty($person->birth_date) ? $person->birth_date : 'N/A' }}
                    <br><span class="font-weight-bold">Religion: </span> {{ !empty($person->religion_id) ? $person->religion_name : 'N/A' }}
                    <br><span class="font-weight-bold">Occupation: </span> {{ !empty($person->occupation_id) ? $person->occupation_name : 'N/A' }}
                    <br><span class="font-weight-bold">Ethnicity: </span> {{ !empty($person->ethnicity_id) ? $person->ethnicity_name : 'N/A' }}
                    <br><span class="font-weight-bold">Parish: </span> {!! !empty($person->parish_link) ? $person->parish_link : 'N/A' !!}
                    <br><span class="font-weight-bold">Preferred Language: </span> {{ !empty($person->preferred_language) ? $person->preferred_language_label : 'N/A' }}
                    <br><span class="font-weight-bold">Languages: </span>
                    @if(!empty(array_filter((array)$person->languages)))
                        <ul>
                            @foreach($person->languages as $language)
                                <li>{{$language->label}}</li>
                            @endforeach
                        </ul>
                    @else
                        N/A
                    @endif
                </p>
            </div>
            <div class="col-12 col-lg-6" id="other_info">
                <h2>Other</h2>
                <p>
                    <span class="font-weight-bold">Referral sources: </span>
                    @if(!empty(array_filter((array)$person->referrals)))
                    <ul>
                        @foreach($person->referrals as $referral)
                            <li>{{$referral->name}}</li>
                        @endforeach
                    </ul>
                    @else
                        N/A
                    @endif
                    <br>
                    <span class="font-weight-bold">Deceased: </span>
                    @if ($person->is_deceased)
                        Yes
                    @else
                        No
                    @endIf
                    <br>
                    <span class="font-weight-bold">Deceased Date: </span>
                    @if (!empty($person->deceased_date))
                        {{date('F d, Y', strtotime($person->deceased_date))}}
                    @else
                        N/A
                    @endif
                </p>
            </div>
            @can('show-group')
            <div class="col-12 col-lg-6" id="groups">
                <h2>Groups</h2>
                @if(!empty(array_filter((array)$person->groups)))
                    <ul>
                    @foreach($person->groups as $group)
                        <li><a href="../group/{{ $group->group_id}}">{{ $group->group->name }}</a></li>
                    @endforeach
                    </ul>
                @else
                    This person does not belong to any groups.
                @endif
            </div>
            @endCan
            <div class="col-12 col-lg-6" id="notes">
                <h2>Notes</h2>
                <p><span class="font-weight-bold">General: </span> {!! $person->note_contact ? $person->note_contact : 'N/A' !!}
                <br><span class="font-weight-bold">Room Preference: </span> {!! $person->note_room_preference ? $person->note_room_preference : 'N/A' !!}</p>
            </div>

            @can('show-relationship')
            <div class="col-12 col-lg-6" id="relationships">
                <h2>Relationships ({{ $person->a_relationships->count() + $person->b_relationships->count() }})</h2>
                @can('create-relationship')
                {!! Form::open(['method' => 'POST', 'route' => ['relationship_type.addme']]) !!}
                    <div class="form-group">
                        <div class="row">
                            <div class="col-12">
                                {!! Form::label('relationship_type', 'Add Relationship: ')  !!}
                            </div>
                            <div class="col-6">
                                {!! Form::select('relationship_type', $relationship_types, NULL, ['class' => 'form-control']) !!}
                                {!! Form::hidden('contact_id',$person->id)!!}
                            </div>
                            <div class="col-6">
                                {!! Form::submit('Create relationship', ['class' => 'btn btn-primary']) !!}
                            </div>
                        </div>
                    </div>
                {!! Form::close() !!}
                @endCan
                <ul>
                    @foreach($person->a_relationships as $a_relationship)
                    <li>
                        @can('delete-relationship')
                            {!! Form::open(['method' => 'DELETE', 'route' => ['relationship.destroy', $a_relationship->id],'onsubmit'=>'return ConfirmDelete()']) !!}
                                {!!$person->contact_link_full_name!!} is {{ $a_relationship->relationship_type->label_a_b }} {!! $a_relationship->contact_b->contact_link_full_name !!}
                                <button type="submit" class="btn btn-outline-dark btn-sm"><i class="fas fa-trash"></i></button>
                            {!! Form::close() !!}
                        @else
                            {!!$person->contact_link_full_name!!} is {{ $a_relationship->relationship_type->label_a_b }} {!! $a_relationship->contact_b->contact_link_full_name !!}
                        @endCan
                    </li>
                    @endforeach

                    @foreach($person->b_relationships as $b_relationship)
                    <li>
                        @can('delete-relationship')
                            {!! Form::open(['method' => 'DELETE', 'route' => ['relationship.destroy', $b_relationship->id],'onsubmit'=>'return ConfirmDelete()']) !!}
                                {!!$person->contact_link_full_name!!} is {{ $b_relationship->relationship_type->label_b_a }} {!! $b_relationship->contact_a->contact_link_full_name!!}
                                <button type="submit" class="btn btn-outline-dark btn-sm"><i class="fas fa-trash"></i></button>
                            {!! Form::close() !!}
                        @else
                            {!!$person->contact_link_full_name!!} is {{ $b_relationship->relationship_type->label_b_a }} {!! $b_relationship->contact_a->contact_link_full_name!!}
                        @endCan
                    </li>
                    @endforeach
                </ul>
            </div>
            @endCan
            @can('show-registration')
            <div class="col-12 mt-3" id="registrations">
                <h2>Retreat Participation ({{$registrations->count()}})</h2>
                @foreach($registrations as $registration)
                    <div class="p-3 mb-2 alert rounded {{ $registration->canceled_at ? 'alert-warning' : 'alert-success'}}">
                        {!!$registration->event_link!!} ({{date('F j, Y', strtotime($registration->retreat_start_date))}} - {{date('F j, Y', strtotime($registration->retreat_end_date))}}) - <u>{{$registration->participant_role_name}}</u> ({{$registration->participant_status}})
                        <a href="{{ url('registration/'.$registration->id) }}">
                            View Registration
                        </a>
                        [{{ $registration->source ? $registration->source : 'N/A' }}]
                    </div>
                @endforeach
            </div>
            @endCan
            @can('show-touchpoint')
            <div class="col-12 mt-3" id="touchpoints">
                <h2>Touchpoints ({{ $person->touchpoints->count() }})</h2>
                @can('create-touchpoint')
                <button class="btn btn-outline-dark"><a href={{ action('TouchpointController@add',$person->id) }}>Add Touchpoint</a></button>
                @endCan
                @if ($touchpoints->isEmpty())
                    <p>There are no touchpoints for this person.</p>
                @else
                    <table class="table table-striped table-responsive-lg">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Contacted by</th>
                                <th>Type of contact</th>
                                <th>Notes</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($touchpoints as $touchpoint)
                            <tr>
                                <td><a href="{{url('touchpoint/'.$touchpoint->id)}}">{{ $touchpoint->touched_at }}</a></td>
                                <td>{!! $touchpoint->staff->contact_link_full_name ?? 'Unknown staff member' !!}</td>
                                <td>{{ $touchpoint->type }}</td>
                                <td>{{ $touchpoint->notes }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
            @endCan
            @can('show-attachment')
            <div class="col-12 mt-3" id="attachments">
                <h2>Attachments ({{ $files->count() }})</h2>
                @if ($files->isEmpty())
                    <p>There are no attachments for this person.</p>
                @else
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Uploaded date</th>
                                <th>MIME type</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($files->sortByDesc('upload_date') as $file)
                            <tr>
                                <td><a href="{{url('contact/'.$person->id.'/attachment/'.$file->uri)}}">{{ $file->uri }}</a></td>
                                <td>{{$file->description}}</td>
                                <td>{{ $file->upload_date}}</td>
                                <td>{{ $file->mime_type }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
            @endCan
            @can('show-donation')
            <div class="col-12 mt-3" id="donations">
                <h2>
                    {{$person->donations->count() }}  Donation(s) for {{ $person->display_name }}
                        - ${{$person->donations->sum('payments_paid')}} paid of
                    ${{$person->donations->sum('donation_amount') }} pledged
                    @if ($person->donations->sum('donation_amount') > 0)
                    [{{($person->donations->sum('payments_paid') / $person->donations->sum('donation_amount'))*100}}%]
                    @endif
                </h2>
                @can('create-donation')
                    {!! Html::link(action('DonationController@create',$person->id),'Create donation',array('class' => 'btn btn-outline-dark'))!!}
                @endCan
                @if ($person->donations->isEmpty())
                    <p>No donations for this person!</p>
                @else
                    <table class="table table-striped table-responsive-lg">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Description</th>
                                <th>Paid/Pledged [%]</th>
                                <th>Terms</th>
                                <th>Notes</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($person->donations->sortByDesc('donation_date') as $donation)
                            <tr>
                                <td><a href="../donation/{{$donation->donation_id}}"> {{ $donation->donation_date_formatted}} </a></td>
                                <td> {{ $donation->donation_description.': #'.optional($donation->retreat)->idnumber }}</td>

                                @if ($donation->donation_amount > $donation->payments->sum('payment_amount'))
                                  <td class="alert alert-warning" style="padding:0px;">
                                @endIf
                                @if ($donation->donation_amount < $donation->payments->sum('payment_amount'))
                                  <td class="alert alert-danger" style="padding:0px;">
                                @endIf
                                @if ($donation->donation_amount == $donation->payments->sum('payment_amount'))
                                  <td>
                                @endIf

                                ${{number_format($donation->payments->sum('payment_amount'),2)}}
                                    / ${{number_format($donation->donation_amount,2) }}
                                    [{{$donation->percent_paid}}%]
                                </td>

                                <td> {{ $donation->terms }}</td>
                                <td> {{ $donation->Notes }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
            @endCan
        </div>
        <div class="row" id="commands">
            @can('update-contact')
            <div class='col-6 text-right'>
                <a href="{{ action('PersonController@edit', $person->id) }}" class="btn btn-info">{!! Html::image('images/edit.png', 'Edit',array('title'=>"Edit")) !!}</a>
            </div>
            @endCan
            @can('delete-contact')
            <div class='col-6'>
                {!! Form::open(['method' => 'DELETE', 'route' => ['person.destroy', $person->id],'onsubmit'=>'return ConfirmDelete()']) !!}
                {!! Form::image('images/delete.png','btnDelete',['class' => 'btn btn-danger','title'=>'Delete']) !!}
                {!! Form::close() !!}
            </div>
            @endCan
        </div>
    </div>
</div>
@stop
