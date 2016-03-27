@extends('template')
@section('content')

    <section class="section-padding">
        <div class="jumbotron text-left">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <span><h2>{!! $parish->organization_name !!} (<a href="../diocese/{{$parish->diocese->contact_a->id}}">{{ $parish->diocese->contact_a->organization_name}}</a>)</span>
                    <span class="back"><a href={{ action('ParishesController@index') }}>{!! Html::image('img/parish.png', 'Parish Index',array('title'=>"Parish Index",'class' => 'btn btn-primary')) !!}</a></span></h1>
                </div>
                <div class='row'><div class='col-md-4'>
                <span><h2>Addresses</h2>
                @foreach($parish->addresses as $address)
                @if (!empty($address->street_address))
                <strong>{{$address->location->display_name}}:</strong>
                
                <address>
                    <a href="http://maps.google.com/?q=
                       {{isset($address->street_address) ? $address->street_address : '' }} 
                       {{isset($address->city) ? $address->city : ''}} 
                       {{isset($address->state->abbreviation) ? $address->state->abbreviation : ''}} 
                       {{isset($address->postal_code) ? $address->postal_code : ''}}" target="_blank">
                                
                    {{isset($address->street_address) ? $address->street_address : ''}}
                        @if (!empty($address->supplemental_address_1))
                            <br />{{$address->supplemental_address_1}}
                        @endif   
                        <br />
                        {{isset($address->city) ? $address->city : ''}}, 
                        {{isset($address->state->abbreviation) ? $address->state->abbreviation : ''}} 
                        {{isset($address->postal_code) ? $address->postal_code : ''}}</a> 
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
                    <h2><span class="grey">Parishioner Index</span></h2> 
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
                            @if(isset($parishioner->contact_b->primary_address))
                                <td>
                                    <a href="http://maps.google.com/?q=
                                    {{isset($parishioner->contact_b->primary_address->street_address) ? $parishioner->contact_b->primary_address->street_address : '' }} 
                                    {{isset($parishioner->contact_b->primary_address->city) ? $parishioner->contact_b->primary_address->city : ''}} 
                                    {{isset($parishioner->contact_b->primary_address->state->abbreviation) ? $parishioner->contact_b->primary_address->state->abbreviation : ''}} 
                                    {{isset($parishioner->contact_b->primary_address->postal_code) ? $parishioner->contact_b->primary_address->postal_code : ''}}" target="_blank">

                                    {{isset($parishioner->contact_b->primary_address->street_address) ? $parishioner->contact_b->primary_address->street_address : ''}}
                                    @if (!empty($parishioner->contact_b->primary_address->supplemental_address_1))
                                        <br />{{ $parishioner->contact_b->primary_address->supplemental_address_1 }}
                                    @endif   
                                    <br />
                                    {{isset($parishioner->contact_b->primary_address->city) ? $parishioner->contact_b->primary_address->city : ''}}, 
                                    {{isset($parishioner->contact_b->primary_address->state->abbreviation) ? $parishioner->contact_b->primary_address->state->abbreviation : ''}} 
                                    {{isset($parishioner->contact_b->primary_address->postal_code) ? $parishioner->contact_b->primary_address->postal_code : ''}}</a> 
                                    <br />
                                    @if ($parishioner->contact_b->primary_address->country_id=1228) @else {{$parishioner->contact_b->primary_address->country_id}} @endif
                                </td> 
                            @else <td> </td>
                            @endif
                            <td>
                                @foreach($parishioner->contact_b->phones as $phone)
                                <strong>{{$phone->location->name}}-{{$phone->phone_type}}:</strong><a href="tel:{{$phone->phone}}">{{$phone->phone }}</a><br />
                                @endforeach    
                            </td>
                            <td>
                                @foreach($parishioner->contact_b->emails as $email)
                                <a href="mailto:"{{$email->email }}>{{$email->email }}</a><br />
                                @endforeach   
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @endif
            </div>
        </div>
    </section>
@stop