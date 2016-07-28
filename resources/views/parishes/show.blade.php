@extends('template')
@section('content')

    <section class="section-padding">
        <div class="jumbotron text-left">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <span><h2>{!! $parish->organization_name !!} (<a href="../diocese/{{$parish->diocese_id}}">{{ $parish->diocese_name}}</a>)</span>
                    <span class="back"><a href={{ action('ParishesController@index') }}>{!! Html::image('img/parish.png', 'Parish Index',array('title'=>"Parish Index",'class' => 'btn btn-primary')) !!}</a></span></h1>
                    <span class="btn btn-primary">
                        <a href={{ action('TouchpointsController@add',$parish->id) }}>Add Touch point</a>
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
                            <a href="../person/{{ $parish->pastor->contact_b->id}}">{{ $parish->pastor->contact_b->display_name or 'No pastor assigned'}}</a>
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
            <div class='row'>
                <div class='col-md-1'><a href="{{ action('ParishesController@edit', $parish->id) }}" class="btn btn-info">{!! Html::image('img/edit.png', 'Edit',array('title'=>"Edit")) !!}</a></div>
                <div class='col-md-1'>{!! Form::open(['method' => 'DELETE', 'route' => ['parish.destroy', $parish->id]]) !!}
                {!! Form::image('img/delete.png','btnDelete',['class' => 'btn btn-danger','title'=>'Delete']) !!} 
                {!! Form::close() !!}</div><div class="clearfix"> </div>
            </div>
            <hr />
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
                            
                            <td><a href="../person/{{$parishioner->contact_b->id}}">{{ $parishioner->contact_b->display_name }}</a></td>
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
                    <p>It is a brand new world, there are no touch points for this person!</p>
                @else
            <div class="panel-heading">
                <h2><span class="grey">Touch points for {{ $parish->display_name }} </span></h2> 
            <span class="btn btn-primary">
                   <a href={{ action('TouchpointsController@add',$parish->id) }}>Add Touch point</a>
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
                            <td><a href="touchpoint/{{ $touchpoint->id}}">{{ $touchpoint->touched_at }}</a></td>
                            <td><a href="person/{{ $touchpoint->staff->id}}">{{ $touchpoint->staff->display_name }}</a></td>
                            <td>{{ $touchpoint->type }}</td>
                            <td>{{ $touchpoint->notes }}</td>
                        </tr>
                        @endforeach
                        
                    </tbody>
                </table>
            @endif
            
        </div>
            
        </div>
    </section>
@stop