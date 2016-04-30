@extends('template')
@section('content')

<section class="section-padding">
    <div class="jumbotron text-left">
        <div class="panel panel-default">
            <div class="panel-heading">
                <span class="back">
                    <span><h2><strong>
                        {{ (!empty($person->prefix_id)) ? $person->prefix->name : null }} 
                        {{ (!empty($person->first_name)) ? $person->first_name : null }} 
                        {{ (!empty($person->middle_name)) ? $person->middle_name : null}} 
                        {{ (!empty($person->last_name)) ? $person->last_name : null}}
                        {{ (!empty($person->suffix_id)) ? ', '.$person->suffix->name : null }}
                        {{ (!empty($person->nick_name)) ? "(&quot;$person->nick_name&quot;)" : null }}   
                        </strong></h2>
                    </span>

               <span class="btn btn-primary"><a href={{ action('TouchpointsController@add',$person->id) }}>Add Touch point</a></span> 
               </span>                

            </div>
            <div class='row'>
                <div class='col-md-4'><span><h2><strong>Names</strong></h2>
                    <div>
                        <span>
                            <strong>Title: </strong>{{ (!empty($person->prefix_id)) ? $person->prefix->name : null }} <br />
                            <strong>First Name: </strong>{{ (!empty($person->first_name)) ? $person->first_name : null }} <br /> 
                            <strong>Middle Name: </strong>{{ (!empty($person->middle_name)) ? $person->middle_name : null}} <br />
                            <strong>Last Name: </strong>{{ (!empty($person->last_name)) ? $person->last_name : null}} <br />
                            <strong>Suffix: </strong>{{(!empty($person->suffix_id)) ? $person->suffix->name : null }} <br />
                        </span>
                        <strong>Nick name:</strong> {{ (!empty($person->nick_name)) ? $person->nick_name : null }} <br />
                        <strong>Display name: </strong>{{ (!empty($person->display_name)) ? $person->display_name : null }}   <br />
                        <strong>Sort name: </strong>{{ (!empty($person->sort_name)) ? $person->sort_name : null }}   
                    </div>
                </div>
                <div class='col-md-4' style="background-color: lightcoral;">
                    <span class="info">
                        <h2><strong>Emergency Contact Information</strong></h2>
                        <strong>Name: </strong>{{ isset($person->emergency_contact->name) ? $person->emergency_contact->name : 'N/A' }}
                        <br /><strong>Relationship: </strong>{{ isset($person->emergency_contact->relationship) ? $person->emergency_contact->relationship : 'N/A' }}
                        <br /><strong>Phone:</strong> {{ isset($person->emergency_contact->phone) ? $person->emergency_contact->phone : 'N/A' }}
                        <br /><strong>Alt phone:</strong> {{ isset($person->emergency_contact->phone_alternate) ? $person->emergency_contact->phone_alternate: 'N/A' }}
                    </span>
                    <span><h2><strong>Health and Dietary Information</strong></h2>
                        <strong>Health notes: </strong>{{$person->note_health}}<br />
                        <strong>Dietary notes: </strong>{{$person->note_dietary}}   
                    </span>
            
                </div>               
            </div><div class="clearfix"> </div>

            <div class='row'><div class='col-md-4'><span><h2><strong>Addresses</strong></h2>
                @foreach($person->addresses as $address)
                @if (!empty($address->street_address))
                <strong>{{$address->location->display_name}}:</strong>
                
                <address>
                    <a href="http://maps.google.com/?q=
                       {{isset($address->street_address) ? $address->street_address : '' }} 
                       {{isset($address->city) ? $address->city : ''}} 
                       {{isset($address->state->abbreviation) ? $address->state->abbreviation : ''}} 
                       {{isset($address->postal_code) ? $address->postal_code : ''}}" target="_blank">
                                
                    {{isset($address->street_address) ? $address->street_address : ''}}
                        @if (!empty($address_supplemental_address_1))
                            <br />{{$address_supplemental_address_1}}
                        @endif   
                        <br />
                        {{isset($address->city) ? $address->city : ''}}, 
                        {{isset($address->state->abbreviation) ? $address->state->abbreviation : ''}} 
                        {{isset($address->postal_code) ? $address->postal_code : ''}}</a> 
                <br />@if ($address->country_id=1228) @else {{$address->country_id}} @endif 
                </address>
                @endif
                @endforeach
                    </span></div></div>
            
            <div class='row'>
                <div class='col-md-4'>
                    <span><h2><strong>Phone Numbers</strong></h2>
                        @foreach($person->phones as $phone)
                        @if(!empty($phone->phone))
                            <strong>{{$phone->location->display_name}} - {{$phone->phone_type}}: </strong>{{$phone->phone}} {{$phone->phone_ext}}<br />
                        @endif
                            @endforeach
                    </span>
                </div>
                
                <div class='col-md-4'>
                    <span><h2><strong>Electronic Communications</strong></h2>
                        @foreach($person->emails as $email)
                        @if(!empty($email->email))
                        <strong>{{$email->location->display_name}} - Email: </strong><a href="mailto:{{$email->email}}">{{$email->email}}</a><br />
                        @endif
                        @endforeach
                        @foreach($person->websites as $website)
                        @if(!empty($website->url))
                        <strong>{{$website->website_type}} - URL: </strong><a href="{{$website->url}}" target="_blank">{{$website->url}}</a><br />
                        @endif
                        @endforeach
                    </span>
                </div>
            </div><div class="clearfix"> </div>

            <div class='row'><span>
                <div class='col-md-8'<span><h2><strong>Demographics:</strong></h2>
                    <strong>Gender: </strong>{{ !empty($person->gender_id) ? $person->gender->name: 'N/A' }}  
                    <br /><strong>Birth Date: </strong> 
                    @if (isset($person->birth_date))
                        {{date('F d, Y', strtotime($person->birth_date))}}
                    @else 
                        N/A
                    @endif
                    <br /><strong>Ethnicity: </strong>{{ !empty($person->ethnicity_id) ? $person->ethnicity->ethnicity: 'N/A' }}    
                    <br /><strong>Parish: </strong>
                    @if (isset($person->parish_id)) <a href="../parish/{{$person->parish_id}}">{{$person->parish_name}}</a> @endIf     
                    <br /><strong>Languages: </strong>
                        <ul>
                            @foreach($person->languages as $language)
                                <li>{{$language->label}}</li> 
                            @endforeach
                        </ul>
                    <strong>Preferred Language: </strong>
                        {{ isset($person->preferred_language) ? $person->preferred_language_label: 'N/A' }}
                        
                </div></span> 
            </div><div class="clearfix"> </div>

            <div class='row'>

                <div class='col-md-4'>
                    <span><h2><strong>Notes</strong></h2>
                        <strong>General Note: </strong>{{$person->note_contact}}<br />
                        <strong>Room Preference: </strong>{{$person->note_room_preference}}<br />
                    </span>
                </div>
                
            </div><div class="clearfix"> </div>  
            <div class='row'>

                <div class='col-md-8'>
                    <span>
                        <h2><strong>Groups and Relationships</strong></h2>
                        <div class="form-group">Groups
                            <ul>    @foreach($person->groups as $group)
                        
                            <li><a href="../group/{{ $group->group_id}}">{{ $group->group->name }}</a></li>
                        
                        @endforeach
                        </ul>
                        </div>
                        <div class="form-group">Relationships
                            <ul>    
                                @foreach($person->a_relationships as $a_relationship)
                                    <li>{{$person->display_name}} is {{  $a_relationship->relationship_type->label_a_b }} {{$a_relationship->contact_b->display_name}}</li>
                                @endforeach
                   
                                @foreach($person->b_relationships as $b_relationship)
                                    <li>{{$person->display_name}} is {{  $b_relationship->relationship_type->label_b_a }} {{$b_relationship->contact_a->display_name}}</li>
                                @endforeach
                        
                            </ul>
                        </div>
                        </ul>
                        </div>
                    </span>
                </div>
                <div class="clearfix"> </div>
            </div>
                   <hr />
             @if ($person->touchpoints->isEmpty())
                    <p>It is a brand new world, there are no touch points for this person!</p>
                @else
                <table class="table"><caption><h2>Touch points for {{ $person->display_name }} </h2></caption>
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Contacted by</th>
                            <th>Type of contact</th>
                            <th>Notes</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($person->touchpoints as $touchpoint)
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
        <div class='row'>
            <div class='col-md-1'><a href="{{ action('PersonsController@edit', $person->id) }}" class="btn btn-info">{!! Html::image('img/edit.png', 'Edit',array('title'=>"Edit")) !!}</a></div>
            <div class='col-md-1'>{!! Form::open(['method' => 'DELETE', 'route' => ['person.destroy', $person->id]]) !!}
            {!! Form::image('img/delete.png','btnDelete',['class' => 'btn btn-danger','title'=>'Delete']) !!} 
            {!! Form::close() !!}</div><div class="clearfix"> </div>
        </div>
    </div>
</section>
@stop