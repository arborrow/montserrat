@extends('template')
@section('content')

    <section class="section-padding">
        <div class="jumbotron text-left">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class='row' >
                        <div class="col-md-12 col-sm-12">
                        {!!$organization->avatar_large_link!!}
                        <h1 style="position: absolute; top:5px; left:175px; padding: 5px;">
                            <strong>
                                @can('update-contact')
                                    <a href="{{url('organization/'.$organization->id.'/edit')}}">{{ $organization->organization_name }} </a>({{ $organization->subcontact_type_label }})
                                @else
                                    {{ $organization->organization_name }} ({{ $organization->subcontact_type_label }})
                                @endCan
                            </strong>
                        </h1>
                        </div>
                        {!! Html::link('#notes','Notes',array('class' => 'btn btn-default')) !!}
                        {!! Html::link('#relationships','Relationships',array('class' => 'btn btn-default')) !!}
                        {!! Html::link('#registrations','Registrations',array('class' => 'btn btn-default')) !!}
                        {!! Html::link('#touchpoints','Touchpoints',array('class' => 'btn btn-default')) !!}
                        {!! Html::link('#attachments','Attachments',array('class' => 'btn btn-default')) !!}
                        {!! Html::link('#donations','Donations',array('class' => 'btn btn-default')) !!}
                    </div>
                    
                    <div class="row">
                        
                        <span><a href={{ action('OrganizationController@index') }}>{!! Html::image('img/organization.png', 'Organization Index',array('title'=>"Organization Index",'class' => 'btn btn-default')) !!}</a></span>
                        @can('create-touchpoint')
                        <span class="btn btn-default">
                            <a href={{ action('TouchpointController@add',$organization->id) }}>Add Touchpoint</a>
                        </span>
                        @endCan
                        <span class="btn btn-default">
                            <a href={{ action('RegistrationController@add',$organization->id) }}>Add Registration</a> 
                        </span>                
                    </div>
                </div>
                <div class="row">
                    <div class='col-md-6'>
                    
                        <span><h2>Addresses</h2>
                            @foreach($organization->addresses as $address)
                                @if (!empty($address->street_address))
                                    <strong>{{$address->location->display_name}}:</strong>
                
                                    <address>
                                        {!!$address->google_map!!}  
                                        <br />@if ($address->country_id=1228) @else {{$address->country_id}} @endif 
                                    </address>
                                @endif
                            @endforeach
                        </span>
                    </div>
                </div>
                <div class="clearfix"> </div>
                
                <div class='row'>
                    <div class='col-md-4'>
                        <span><h2>Phone Numbers</h2>
                            @foreach($organization->phones as $phone)
                                @if(!empty($phone->phone))
                                    <strong>{{$phone->location->display_name}} - {{$phone->phone_type}}: </strong>{{$phone->phone}} {{$phone->phone_ext}}<br />
                                @endif
                            @endforeach
                        </span>
                    </div>
                </div>
                <div class="clearfix"> </div>
                
                <div class='row'>
                    <div class='col-md-4'>
                        <span><h2>Electronic Communications</h2>
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
                        </span>
                    </div>
                </div>
                <div class="clearfix"> </div>
                
                <div class='row' id='notes'>
                    <div class='col-md-6'>
                        <h2>Note:</h2> {{ $organization->note_organization_text }}
                        
                    </div>
                </div>
                <div class='row' id='touchpoints'>
                    <div class="col-md-12">
                        @if ($organization->touchpoints->isEmpty())
                            <h2>It is a brand new world, there are no touchpoints for this organization!</h2>
                        @else
                            <table class="table"><caption><h2>Touchpoints for {{ $organization->display_name }} </h2></caption>
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
                                        <td><a href="touchpoint/{{ $touchpoint->id}}">{{ $touchpoint->touched_at }}</a></td>
                                        <td><a href="organization/{{ $touchpoint->staff->id}}">{{ $touchpoint->staff->display_name }}</a></td>
                                        <td>{{ $touchpoint->type }}</td>
                                        <td>{{ $touchpoint->notes }}</td>
                                    </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        @endif
                    </div>
                </div>
                <div class="clearfix"> </div>
            
                <div class='row' id='relationships'>
                    <div class='col-md-8'>
                        <div class='panel-heading'>
                            <h2><strong>Relationships</strong></h2>
                        </div>
                        {!! Form::open(['method' => 'POST', 'route' => ['relationship_type.addme']]) !!}
                        {!! Form::label('relationship_type', 'Add Relationship: ', ['class' => 'col-md-2'])  !!}
                        {!! Form::select('relationship_type', $relationship_types, NULL, ['class' => 'col-md-2']) !!}
                        {!! Form::hidden('contact_id',$organization->id)!!}
                        {!! Form::submit('Create relationship') !!}
                        {!! Form::close() !!}

                                <ul>    
                                    @foreach($organization->a_relationships as $a_relationship)

                                    <li>{!!$organization->contact_link!!} is {{ $a_relationship->relationship_type->label_a_b }} {!! $a_relationship->contact_b->contact_link !!}  </li>
                                    @endforeach

                                    @foreach($organization->b_relationships as $b_relationship)
                                    <li>{!!$organization->contact_link!!} is {{ $b_relationship->relationship_type->label_b_a }} {!! $b_relationship->contact_a->contact_link!!}</li>
                                    @endforeach

                                </ul>
                    </div>
                </div>
                <div class="clearfix"> </div>

                <div class='row' id='registrations'>
                <div class='col-md-8'>
                    <div class='panel-heading'><h2><strong>Retreat Participation for {{ $organization->display_name }}</strong></h2></div>
                            <ul>    
                                @foreach($organization->event_registrations as $registration)
				<li>{!!$registration->event_link!!}  ({{date('F j, Y', strtotime($registration->retreat_start_date))}} - {{date('F j, Y', strtotime($registration->retreat_end_date))}})</li>
                                @endforeach
                            </ul>
                    </div>
            </div>
                <div class="clearfix"> </div>
        
                <div class='row' id='attachments'>
                    <div class='col-md-8'>
                        <div class='panel-heading'>
                            <h2><strong>Attachments for {{ $organization->display_name }} </strong></h2>
                        </div>
                        @if ($files->isEmpty())
                            <p>This user currently has no attachments</p>
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
                                    @foreach($files as $file)
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
                <div class='row' id='donations'>
                    <div class='col-md-8'>
                        <div class='panel-heading'>
                            <h2><strong>Donations for {{ $organization->display_name }} ({{$organization->donations->count() }} donations totaling:  ${{ number_format($organization->donations->sum('donation_amount'),2)}})</strong></h2>
                            @can('create-donation')
                                {!! Html::link(action('DonationController@create',$organization->id),'Create donation',array('class' => 'btn btn-default'))!!}
                            @endCan
                        </div>
                        @if ($organization->donations->isEmpty())
                                <p>No donations for this organization!</p>
                        @else
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Description</th>
                                        <th>Paid / Pledged</th>
                                        <th>Terms</th>
                                        <th>Notes</th>
                                    </tr>
                                </thead>
                                <tbody>

                                @foreach($organization->donations as $donation)
                                    <tr>
                                        <td><a href="../donation/{{$donation->donation_id}}"> {{ $donation->donation_date }} </a></td>
                                        <td> {{ $donation->donation_description }}</td>
                                        <td> ${{number_format($donation->payments->sum('payment_amount'),2)}} / ${{ number_format($donation->donation_amount,2) }} </td>
                                        <td> {{ $donation->terms }}</td>
                                        <td> {{ $donation->Notes }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>
                </div>
                @endCan

                <div class='row'>
                    @can('update-contact')
                        <div class='col-md-1'><a href="{{ action('OrganizationController@edit', $organization->id) }}" class="btn btn-info">{!! Html::image('img/edit.png', 'Edit',array('title'=>"Edit")) !!}</a></div>
                    @endCan
                    @can('delete-contact')
                        <div class='col-md-1'>
                            {!! Form::open(['method' => 'DELETE', 'route' => ['organization.destroy', $organization->id],'onsubmit'=>'return ConfirmDelete()']) !!}
                            {!! Form::image('img/delete.png','btnDelete',['class' => 'btn btn-danger','title'=>'Delete']) !!} 
                            {!! Form::close() !!}
                        </div>
                    @endCan
                    <div class="clearfix"> </div>
                </div>
            </div>
        </div>
    </section>
@stop
