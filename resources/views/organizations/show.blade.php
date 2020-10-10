@extends('template')
@section('content')

<div class="row bg-cover">
    <div class="col-12 text-center">
        {!!$organization->avatar_large_link!!}
        <h1>
            @can('update-contact')
                <a href="{{url('organization/'.$organization->id.'/edit')}}">{{ $organization->organization_name }} </a>({{ $organization->subcontact_type_label }})
            @else
                {{ $organization->organization_name }} ({{ $organization->subcontact_type_label }})
            @endCan
        </h1>
        <div class="row">
            <div class="col-12">
                {!! Html::link('#notes','Notes',array('class' => 'btn btn-outline-dark')) !!}
                {!! Html::link('#relationships','Relationships',array('class' => 'btn btn-outline-dark')) !!}
                {!! Html::link('#touchpoints','Touchpoints',array('class' => 'btn btn-outline-dark')) !!}
                {!! Html::link('#registrations','Registrations',array('class' => 'btn btn-outline-dark')) !!}
                {!! Html::link('#attachments','Attachments',array('class' => 'btn btn-outline-dark')) !!}
                {!! Html::link('#donations','Donations',array('class' => 'btn btn-outline-dark')) !!}
            </div>
            <div class="col-12 mt-3">
                <span><a href={{ action('OrganizationController@index') }}>{!! Html::image('images/organization.png', 'Organization Index',array('title'=>"Organization Index",'class' => 'btn btn-outline-dark')) !!}</a></span>
                @can('create-touchpoint')
                <span class="btn btn-outline-dark">
                    <a href={{ action('TouchpointController@add',$organization->id) }}>Add Touchpoint</a>
                </span>
                @endCan
                <span class="btn btn-outline-dark">
                    <a href={{ action('RegistrationController@add',$organization->id) }}>Add Registration</a>
                </span>
            </div>
        </div>
    </div>
    <div class="col-12 mt-3">
        <div class="row">
            <div class="col-12 col-lg-6">
                <h2>Addresses</h2>
                @foreach($organization->addresses as $address)
                    @if (!empty($address->street_address))
                        <strong>{{$address->location->display_name}}:</strong>

                        <address>
                            {!!$address->google_map!!}
                            <br />@if ($address->country_id == config('polanco.country_id_usa')) @else {{$address->country_id}} @endif
                        </address>
                    @endif
                @endforeach
            </div>
            <div class="col-12 col-lg-6">
                <h2>Phone Numbers</h2>
                @foreach($organization->phones as $phone)
                    @if(!empty($phone->phone))
                        <strong>{{$phone->location->display_name}} - {{$phone->phone_type}}: </strong>{{$phone->phone}} {{$phone->phone_ext}}<br />
                    @endif
                @endforeach
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-lg-6">
                <h2>Electronic Communications</h2>
                @foreach($organization->emails as $email)
                    @if(!empty($email->email))
                    <strong>{{$email->location->display_name}} - Email: </strong><a href="mailto:{{$email->email}}">{{$email->email}}</a><br />
                    @endif
                @endforeach
                @foreach($organization->websites as $website)
                    @if(!empty($website->url))
                    <strong>{{$website->website_type}} - URL: </strong><a href="{{$website->url}}" target="_blank">{{$website->url}}</a><br />
                    @endif
                @endforeach
            </div>
            <div class="col-12 col-lg-6" id="notes">
                <h2>Note</h2>
                {{ $organization->note_organization_text }}
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-lg-6" id="relationships">
                <h2>Relationships ({{ $organization->a_relationships->count() + $organization->b_relationships->count() }})</h2>
                {!! Form::open(['method' => 'POST', 'route' => ['relationship_type.addme']]) !!}
                <div class="form-group">
                    <div class="row">
                        <div class="col-12">
                            {!! Form::label('relationship_type', 'Add Relationship: ')  !!}
                        </div>
                        <div class="col-6">
                            {!! Form::select('relationship_type', $relationship_types, NULL, ['class' => 'form-control']) !!}
                            {!! Form::hidden('contact_id',$organization->id)!!}
                        </div>
                        <div class="col-6">
                            {!! Form::submit('Create relationship', ['class' => 'btn btn-primary']) !!}
                        </div>
                    </div>
                </div>
                {!! Form::close() !!}
                <ul>
                    @foreach($organization->a_relationships as $a_relationship)
                      <li>
                        @can('delete-relationship')
                          {!! Form::open(['method' => 'DELETE', 'route' => ['relationship.destroy', $a_relationship->id],'onsubmit'=>'return ConfirmDelete()']) !!}
                            {!!$organization->contact_link!!} is {{ $a_relationship->relationship_type->label_a_b }} {!! $a_relationship->contact_b->contact_link !!}
                            <button type="submit" class="btn btn-outline-dark btn-sm"><i class="fas fa-trash"></i></button>
                          {!! Form::close() !!}
                        @else
                          {!!$organization->contact_link!!} is {{ $a_relationship->relationship_type->label_a_b }} {!! $a_relationship->contact_b->contact_link !!}
                        @endCan
                      </li>
                    @endforeach
                    @foreach($organization->b_relationships as $b_relationship)
                      <li>
                        @can('delete-relationship')
                          {!! Form::open(['method' => 'DELETE', 'route' => ['relationship.destroy', $b_relationship->id],'onsubmit'=>'return ConfirmDelete()']) !!}
                            {!!$organization->contact_link!!} is {{ $b_relationship->relationship_type->label_b_a }} {!! $b_relationship->contact_a->contact_link !!}
                            <button type="submit" class="btn btn-outline-dark btn-sm"><i class="fas fa-trash"></i></button>
                          {!! Form::close() !!}
                        @else
                          {!!$organization->contact_link!!} is {{ $b_relationship->relationship_type->label_b_a }} {!! $b_relationship->contact_a->contact_link !!}
                        @endcan
                      </li>
                    @endforeach
                </ul>
            </div>
        </div>
        <div class="row">
            <div class="col-12" id="touchpoints">
                <h2>Touchpoints for {{ $organization->display_name }} ({{ $organization->touchpoints->count() }})</h2>
                @if ($organization->touchpoints->isEmpty())
                    <div class="text-center">
                        <p>It is a brand new world, there are no touchpoints for this organization!</p>
                    </div>
                @else
                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Contacted by</th>
                                <th>Type of contact</th>
                                <th>Notes</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($organization->touchpoints as $touchpoint)
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
        </div>
        <div class="row">
            <div class="col-12" id="registrations">
                <h2>Retreat Participation for {{ $organization->display_name }} ({{ $organization->event_registrations->count() }})</h2>
                <ul>
                    @foreach($organization->event_registrations as $registration)
                        <li>{!!$registration->event_link!!}  ({{date('F j, Y', strtotime($registration->retreat_start_date))}} - {{date('F j, Y', strtotime($registration->retreat_end_date))}})</li>
                    @endforeach
                </ul>
            </div>
        </div>
        <div class="row">
            <div class="col-12" id="attachments">
                <h2>Attachments for {{ $organization->display_name }}</h2>
                @if ($files->isEmpty())
                    <div class="text-center">
                        <p>This organization currently has no attachments</p>
                    </div>
                @else
                    <table class="table table-striped table-bordered table-hover">
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
                                <td><a href="{{url('contact/'.$organization->id.'/attachment/'.$file->uri)}}">{{ $file->uri }}</a></td>
                                <td>{{$file->description}}</td>
                                <td>{{ $file->upload_date}}</td>
                                <td>{{ $file->mime_type }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
        @can('show-donation')
            <div class="row">
                <div class="col-12" id="donations">
                    <h2>Donations for {{ $organization->display_name }} ({{$organization->donations->count() }} donations totaling:  ${{ number_format($organization->donations->sum('donation_amount'),2)}})</h2>
                    @can('create-donation')
                        {!! Html::link(route('donation.add',$organization->id),'Create donation',array('class' => 'btn btn-outline-dark'))!!}
                    @endCan
                    @if ($organization->donations->isEmpty())
                        <div class="text-center">
                            <p>No donations for this organization!</p>
                        </div>
                    @else
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Description</th>
                                    <th>Paid / Pledged (%)</th>
                                    <th>Terms</th>
                                    <th>Notes</th>
                                </tr>
                            </thead>
                            <tbody>

                            @foreach($organization->donations->sortByDesc('donation_date') as $donation)
                                <tr>
                                    <td><a href="../donation/{{$donation->donation_id}}"> {{ $donation->donation_date }} </a></td>
                                    <td> {{ $donation->donation_description.': #'.optional($donation->retreat)->idnumber }}</td>

                                    @if ($donation->donation_amount > $donation->payments->sum('payment_amount'))
                                      <td class="alert alert-warning alert-important" style="padding:0px;">
                                    @endIf
                                    @if ($donation->donation_amount < $donation->payments->sum('payment_amount'))
                                      <td class="alert alert-danger alert-important" style="padding:0px;">
                                    @endIf
                                    @if ($donation->donation_amount == $donation->payments->sum('payment_amount'))
                                      <td>
                                    @endIf

                                    ${{number_format($donation->payments->sum('payment_amount'),2)}}
                                    /
                                    ${{ number_format($donation->donation_amount,2) }}

                                        [{{ $donation->percent_paid }}%]
                                    </td>

                                    <td>  /  </td>

                                    <td> {{ $donation->terms }}</td>
                                    <td> {{ $donation->Notes }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        @endcan
        <div class="row">
            <div class="col-6 text-right">
                @can('update-contact')
                    <a href="{{ action('OrganizationController@edit', $organization->id) }}" class="btn btn-info">{!! Html::image('images/edit.png', 'Edit',array('title'=>"Edit")) !!}</a>
                @endCan
            </div>
            <div class="col-6 text-left">
                @can('delete-contact')
                    {!! Form::open(['method' => 'DELETE', 'route' => ['organization.destroy', $organization->id],'onsubmit'=>'return ConfirmDelete()']) !!}
                    {!! Form::image('images/delete.png','btnDelete',['class' => 'btn btn-danger','title'=>'Delete']) !!}
                    {!! Form::close() !!}
                @endCan
            </div>
        </div>
    </div>
</div>
@stop
