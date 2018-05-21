@extends('template')
@section('content')

    <section class="section-padding">
        <div class="jumbotron text-left">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class='row' style="height: 175px;">
                    <div class="col-md-12 col-sm-12">
                        {!!$parish->avatar_large_link!!}
                        
                    <h1 style="position: absolute; top:5px; left:175px; padding: 5px;">
                        <strong>
                            @can('update-contact')
                                <a href="{{url('parish/'.$parish->id.'/edit')}}">{!! $parish->organization_name !!}</a> (<a href="../diocese/{{$parish->diocese_id}}">{{ $parish->diocese_name}}</a>)
                            @else
                                {{ $parish->organization_name }} (<a href="../diocese/{{$parish->diocese_id}}">{{ $parish->diocese_name}}</a>)
                            @endCan
                        </strong>
                    </h1>
                    </div>
                </div>
                    <span class="back"><a href={{ action('ParishesController@index') }}>{!! Html::image('img/parish.png', 'Parish Index',array('title'=>"Parish Index",'class' => 'btn btn-default')) !!}</a></span></h1>
                    @can('create-touchpoint')
                        <span class="btn btn-default">
                            <a href={{ action('TouchpointController@add',$parish->id) }}>Add Touchpoint</a>
                        </span>
                    @endCan
                    <span class="btn btn-default">
                        <a href={{ action('RegistrationsController@add',$parish->id) }}>Add Registration</a> 
                    </span>                
                </div>
                <div class='row'><div class='col-md-4'>
                <span><h2>Addresses</h2>
                @foreach($parish->addresses as $address)
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
                        @foreach($parish->phones as $phone)
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
                            @foreach($parish->emails as $email)
                            @if(!empty($email->email))
                            <strong>{{$email->location->display_name}} - Email: </strong><a href="mailto:{{$email->email}}">{{$email->email}}</a><br />
                            @endif
                            @endforeach
                            @foreach($parish->websites as $website)
                            @if(!empty($website->url))
                            <strong>{{$website->website_type}} - URL: </strong><a href="{{$website->url}}" target="_blank">{{$website->url}}</a><br />
                            @endif
                            @endforeach
                        </span>
                    </div>
                </div><div class="clearfix"> </div>
                <div class='row'>
                    <div class='col-md-6'><strong>Pastor: </strong>
                        @if (isset($parish->pastor->contact_b))
                            {!! $parish->pastor->contact_b->contact_link_full_name !!}
                        @else
                            No pastor assigned
                        @endIf
                    </div>
                </div><div class="clearfix"> </div>
                
                <div class='row'>
                    <div class='col-md-6'>
                        <span><h2>Notes</h2>
                            @foreach($parish->notes as $note)
                            @if(!empty($note->note))
                            <strong>{{$note->subject}}: </strong>{{$note->note}} (modified: {{$note->modified_date}})<br />
                            @endif
                            @endforeach
                            
                        </span>
                    </div>
                
                    
                </div><div class="clearfix"> </div>
            </div>    
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2><span class="grey">Parishioners of {{$parish->organization_name}}</span></h2> 
                </div>
                @if (!isset($parish->parishioners))
                    <p>No parishioners are currently registered in the database.</p>
                @else
                <table class="table">
                    <thead>
                        <tr>
                            <th>Name</th> 
                            <th>Primary Address</th>
                            <th>Phone(s)</th> 
                            <th>Email(s)</th> 
                       </tr>
                    </thead>
                    <tbody>
                        @foreach($parish->parishioners as $parishioner)
                        <tr>
                            
                            <td><a href="../person/{{$parishioner->contact_b->id}}">
                                    @if($parishioner->contact_b->is_captain) 
                                        {!! Html::image('img/captain.png', 'Captain',array('title'=>"Captain",'class' => 'btn btn-default')) !!}
                                    @endIf
                                    {!! $parishioner->contact_b->contact_link_full_name !!} ({{$parishioner->contact_b->participant_count}})
                                </a>
                            </td>
                            @if(isset($parishioner->contact_b->address_primary))
                                <td>
                                    {!!$parishioner->contact_b->address_primary->google_map!!}
                                    <br />
                                    @if ($parishioner->contact_b->address_primary->country_id=1228) @else {{$parishioner->contact_b->address_primary->country_id}} @endif
                                </td> 
                            @else <td> </td>
                            @endif
                            <td>
                                @foreach($parishioner->contact_b->phones as $phone)
                                @if (!empty($phone->phone))
                                <strong>{{$phone->location->name}}-{{$phone->phone_type}}:</strong><a href="tel:{{$phone->phone}}">{{$phone->phone }}</a><br />
                                @endif
                                @endforeach    
                            </td>
                            <td>
                                @foreach($parishioner->contact_b->emails as $email)
                                @if (!empty($email->email))
                                    @if ($email->is_primary>0)
                                        <strong>
                                    @endif
                                    
                                    {{$email->location->name}}: <a href="mailto:"{{$email->email }}>{{$email->email }}</a><br />
                                    @if ($email->is_primary>0)
                                        </strong>
                                    @endif
                                @endif
                                    
                                @endforeach   
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @endif
            </div>
            
            <div class="panel panel-default">
               
            @if ($parish->touchpoints->isEmpty())
                        <div class='panel-heading'>
                            <h2><strong>Touchpoints</strong></h2>
                        </div>
                                <p>It is a brand new world, there are no touchpoints for this contact!</p>
                @else
            <div class="panel-heading">
                <h2><span class="grey">Touchpoints for {{ $parish->display_name }} </span></h2> 
            <span class="btn btn-default">
                   <a href={{ action('TouchpointController@add',$parish->id) }}>Add Touchpoint</a>
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
                        @foreach($parish->touchpoints as $touchpoint)
                        <tr>
                            <td><a href="{{url('touchpoint/'.$touchpoint->id)}}">{{ $touchpoint->touched_at }}</a></td>
                            <td><a href="{{url('person/'.$touchpoint->staff->id)}}">{{ $touchpoint->staff->display_name }}</a></td>
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
                        {!! Form::hidden('contact_id',$parish->id)!!}
                        {!! Form::submit('Create relationship') !!}
                        {!! Form::close() !!}

                                <ul>    
                                    @foreach($parish->a_relationships as $a_relationship)

                                    <li>{!!$parish->contact_link!!} is {{ $a_relationship->relationship_type->label_a_b }} {!! $a_relationship->contact_b->contact_link !!}  </li>
                                    @endforeach

                                    @foreach($parish->b_relationships as $b_relationship)
                                    <li>{!!$parish->contact_link!!} is {{ $b_relationship->relationship_type->label_b_a }} {!! $b_relationship->contact_a->contact_link!!}</li>
                                    @endforeach

                                </ul>
                    </div>
                </div>
                <div class="clearfix"> </div>

                <div class='row'>
                <div class='col-md-8'>
                    <div class='panel-heading'><h2><strong>Retreat Participation for {{ $parish->display_name }}</strong></h2></div>
                            <ul>    
                                @foreach($parish->event_registrations as $registration)
                                <li>{!!$registration->event_link!!} ({{date('F j, Y', strtotime($registration->event->start_date))}} - {{date('F j, Y', strtotime($registration->event->end_date))}}) </li>
                                @endforeach
                            </ul>
                    </div>
            </div>
            <div class="clearfix"> </div>
        
        <div class='row'>
            <div class='col-md-8'>
                <div class='panel-heading'>
                    <h2><strong>Attachments for {{ $parish->display_name }} </strong></h2>
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
                                    <td><a href="{{url('contact/'.$parish->id.'/attachment/'.$file->uri)}}">{{ $file->uri }}</a></td>
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
                    <div class='col-md-1'>
                        <a href="{{ action('ParishesController@edit', $parish->id) }}" class="btn btn-info">{!! Html::image('img/edit.png', 'Edit',array('title'=>"Edit")) !!}</a>
                    </div>
                @endCan
                @can('delete-contact')
                    <div class='col-md-1'>
                        {!! Form::open(['method' => 'DELETE', 'route' => ['parish.destroy', $parish->id],'onsubmit'=>'return ConfirmDelete()']) !!}
                        {!! Form::image('img/delete.png','btnDelete',['class' => 'btn btn-danger','title'=>'Delete']) !!} 
                        {!! Form::close() !!}
                    </div>
                @endCan
                <div class="clearfix"> </div>
            </div>
        </div>
    </section>
@stop