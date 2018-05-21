@extends('template')
@section('content')

    <section class="section-padding">
        <div class="jumbotron text-left">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="col-md-12 col-sm-12">
                        {!!$diocese->avatar_large_link!!}
                        
                    <h1 style="position: absolute; top:5px; left:175px; padding: 5px;">
                        <strong>
                            @can('update-contact')
                                <a href="{{url('diocese/'.$diocese->id.'/edit')}}">{{ $diocese->organization_name }}</a> 
                            @else
                                {{ $diocese->organization_name }}
                            @endCan
                        </strong></h1>
                    </div>
                    
                    <span><a href={{ action('DioceseController@index') }}>{!! Html::image('img/diocese.png', 'Diocese Index',array('title'=>"Diocese Index",'class' => 'btn btn-default')) !!}</a></span>
                    <span class="btn btn-default">
                        <a href={{ action('TouchpointController@add',$diocese->id) }}>Add Touchpoint</a>
                    </span>
                    <span class="btn btn-default">
                    <a href={{ action('RegistrationController@add',$diocese->id) }}>Add Registration</a> 
                </span>                

                </div>
                <div class="row">
                    <div class='col-md-6'>
                    <strong>Bishop(s)</strong><br />
                    @if (empty($diocese->bishops))
                        No Bishop(s) assigned 
                    @else
                        @foreach($diocese->bishops as $bishop)
                            <a href="../person/{{$bishop->contact_id_b}}">{{ $bishop->contact_b->full_name}}</a>
                        @endforeach
                    @endif
                    </div>
                </div><div class="clearfix"> </div>
                <div class="row">
                <div class='col-md-6'>
                    
                <span><h2>Addresses</h2>
                @foreach($diocese->addresses as $address)
                @if (!empty($address->street_address))
                <strong>{{$address->location->display_name}}:</strong>
                
                <address>
                    {!!$address->google_map!!}  
                <br />@if ($address->country_id=1228) @else {{$address->country_id}} @endif 
                </address>
                @endif
                @endforeach
                </span></div></div><div class="clearfix"> </div>
                <div class='row'>
                    
                    <div class='col-md-4'>
                    <span><h2>Phone Numbers</h2>
                        @foreach($diocese->phones as $phone)
                        @if(!empty($phone->phone))
                            <strong>{{$phone->location->display_name}} - {{$phone->phone_type}}: </strong>{{$phone->phone}} {{$phone->phone_ext}}<br />
                        @endif
                            @endforeach
                    </span>
                </div>
                
                </div><div class="clearfix"> </div>
                
                <div class='row'>
                    <div class='col-md-4'>
                        <span><h2>Electronic Communications</h2>
                            @foreach($diocese->emails as $email)
                            @if(!empty($email->email))
                            <strong>{{$email->location->display_name}} - Email: </strong><a href="mailto:{{$email->email}}">{{$email->email}}</a><br />
                            @endif
                            @endforeach
                            @foreach($diocese->websites as $website)
                            @if(!empty($website->url))
                            <strong>{{$website->website_type}} - URL: </strong><a href="{{$website->url}}" target="_blank">{{$website->url}}</a><br />
                            @endif
                            @endforeach
                        </span>
                    </div>
                </div><div class="clearfix"> </div>
                
                <div class='row'>
                    <div class='col-md-6'>
                        <span><h2>Notes</h2>
                            @foreach($diocese->notes as $note)
                            @if(!empty($note->note))
                            <strong>{{$note->subject}}: </strong>{{$note->note}} (modified: {{$note->modified_date}})<br />
                            @endif
                            @endforeach
                            
                        </span>
                    </div>
                
                    
                </div>
                <div class="clearfix"> </div>
                @if ($diocese->touchpoints->isEmpty())
                        <div class='panel-heading'>
                            <h2><strong>Touchpoints</strong></h2>
                        </div>
                                <p>It is a brand new world, there are no touchpoints for this contact!</p>
                @else
            <div class="panel-heading">
                <h2><span class="grey">Touchpoints for {{ $diocese->display_name }} </span></h2> 
            <span class="btn btn-default">
                   <a href={{ action('TouchpointController@add',$diocese->id) }}>Add Touchpoint</a>
                </span>
            
            </div>
                
                <table class="table">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Contacted by</th>
                            <th>Type of contact</th>
                            <th>Notes</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($diocese->touchpoints as $touchpoint)
                        <tr>
                            <td><a href="touchpoint/{{ $touchpoint->id}}">{{ $touchpoint->touched_at }}</a></td>
                            <td><a href="person/{{ $touchpoint->staff->id}}">{{ $touchpoint->staff->display_name }}</a></td>
                            <td>{{ $touchpoint->type }}</td>
                            <td>{{ $touchpoint->notes }}</td>
                        </tr>
                        @endforeach
                        
                    </tbody>
                </table>
            @endif
            
                <div class='row'>
                    <div class='col-md-8'>
                        <div class='panel-heading'>
                            <h2><strong>Relationships</strong></h2>
                        </div>
                        {!! Form::open(['method' => 'POST', 'route' => ['relationship_type.addme']]) !!}
                        {!! Form::label('relationship_type', 'Add Relationship: ', ['class' => 'col-md-2'])  !!}
                        {!! Form::select('relationship_type', $relationship_types, NULL, ['class' => 'col-md-2']) !!}
                        {!! Form::hidden('contact_id',$diocese->id)!!}
                        {!! Form::submit('Create relationship') !!}
                        {!! Form::close() !!}

                                <ul>    
                                    @foreach($diocese->a_relationships as $a_relationship)
                                        <li>
                                            {!! Form::open(['method' => 'DELETE', 'route' => ['relationship.destroy', $a_relationship->id],'onsubmit'=>'return ConfirmDelete()']) !!}
                                            {!!$diocese->contact_link!!} {{ $a_relationship->relationship_type->label_a_b }} {!! $a_relationship->contact_b->contact_link !!} 
                                            {!! Form::image('img/delete.png','btnDelete',['title'=>'Delete Relationship '.$a_relationship->id, 'style'=>'padding-left: 50px;']) !!} 
                                            {!! Form::close() !!}
                                        </li>
                                    @endforeach

                                    @foreach($diocese->b_relationships as $b_relationship)
                                        <li>
                                            {!! Form::open(['method' => 'DELETE', 'route' => ['relationship.destroy', $b_relationship->id],'onsubmit'=>'return ConfirmDelete()']) !!}
                                            {!!$diocese->contact_link!!} is {{ $b_relationship->relationship_type->label_a_b }} {!! $b_relationship->contact_b->contact_link !!} 
                                            {!! Form::image('img/delete.png','btnDelete',['title'=>'Delete Relationship '.$b_relationship->id, 'style'=>'padding-left: 50px;']) !!} 
                                            {!! Form::close() !!}
                                        </li>
                                    @endforeach

                                </ul>
                    </div>
                </div>
                <div class="clearfix"> </div>

                <div class='row'>
                <div class='col-md-8'>
                    <div class='panel-heading'><h2><strong>Retreat Participation for {{ $diocese->display_name }}</strong></h2></div>
                            <ul>    
                                @foreach($diocese->event_registrations as $registration)
                                <li>{!!$registration->event_link!!} ({{date('F j, Y', strtotime($registration->event->start_date))}} - {{date('F j, Y', strtotime($registration->event->end_date))}}) </li>
                                @endforeach
                            </ul>
                    </div>
            </div>
            <div class="clearfix"> </div>
        
        <div class='row'>
            <div class='col-md-8'>
                <div class='panel-heading'>
                    <h2><strong>Attachments for {{ $diocese->display_name }} </strong></h2>
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
                                    <td><a href="{{url('contact/'.$diocese->id.'/attachment/'.$file->uri)}}">{{ $file->uri }}</a></td>
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
            
            </div>            
                <div class='row'>
                    @can('update-contact')
                        <div class='col-md-1'><a href="{{ action('DioceseController@edit', $diocese->id) }}" class="btn btn-info">{!! Html::image('img/edit.png', 'Edit',array('title'=>"Edit")) !!}</a></div>
                    @endCan
                    @can('delete-contact')
                        <div class='col-md-1'>
                            {!! Form::open(['method' => 'DELETE', 'route' => ['diocese.destroy', $diocese->id],'onsubmit'=>'return ConfirmDelete()']) !!}
                            {!! Form::image('img/delete.png','btnDelete',['class' => 'btn btn-danger','title'=>'Delete']) !!} 
                            {!! Form::close() !!}
                        </div>
                    @endCan
                <div class="clearfix"> </div>
                </div>
        </div>
    </section>
@stop