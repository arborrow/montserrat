@extends('template')
@section('content')

<section class="section-padding">
    <div class="jumbotron text-left">
        <div class="panel panel-default">
            <div class="panel-heading">
                <span><h2>{{ isset($person->prefix_id) ? $person->prefix->name : null }} 
                {{ isset($person->first_name) ? $person->first_name : null }} 
                {{ isset($person->middle_name) ? $person->middle_name : null}} 
                {{ $person->last_name}}{{isset($person->suffix_id) ? ', '.$person->suffix->name : null }}
                {{ (!empty($person->nick_name)) ? "(&quot;$person->nick_name&quot;)" : null }}   </span>
                <span class="back">
               <span class="btn btn-primary"><a href={{ action('TouchpointsController@add',$person->id) }}>Add Touch point</a></span> 
               </span>                

            </div>
            <div class='row'><div class='col-md-4'><span><h2>Addresses</h2>
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
            </span></div>
             <div class='col-md-4' style="background-color: lightcoral;"><span class="info">
                     <h2><strong>Emergency Contact Information</strong></h2>
                    <strong>Name: </strong>{{ isset($person->emergencycontactname) ? $person->emergencycontactname : 'N/A' }}
                    <br /><strong>Phone:</strong> {{ isset($person->emergencycontactphone) ? $person->emergencycontactphone : 'N/A' }}
                    <br /><strong>Alt phone:</strong> {{ isset($person->emergencycontactphone2) ? $person->emergencycontactphone2: 'N/A' }}
                </span></div>               
            </div><div class="clearfix"> </div>

            <div class='row'>
                <div class='col-md-4'>
                    <span><h2>Phone Numbers</h2>
                        @foreach($person->phones as $phone)
                        @if(!empty($phone->phone))
                            <strong>{{$phone->location->display_name}} - {{$phone->phone_type}}: </strong>{{$phone->phone}} {{$phone->phone_ext}}<br />
                        @endif
                            @endforeach
                    </span>
                </div>
                
                <div class='col-md-4'>
                    <span><h2>Electronic Communications</h2>
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
                <div class='col-md-8'<span><h2>Demographics:</h2>
                <strong>Gender: </strong>{{$person->gender}}  
                <br /><strong>DOB: </strong> 
                @if (isset($person->birth_date))
                    {{date('F d, Y', strtotime($person->birth_date))}}
                @else 
                    N/A
                @endif
                <br /><strong>Ethnicity: </strong>{{$person->ethnicity}}   
                <br /><strong>Parish: </strong>
                @if (isset($person->parish->id)) <a href="../parish/{{$person->parish->id}}">{{$person->parish->name}}</a> @endIf     
                <br /><strong>Languages: </strong>{{$person->languages}}</div></span> 
            </div><div class="clearfix"> </div>

            <div class='row'>

                <div class='col-md-4'>
                    <span><h2>Notes</h2>
                        <strong>Notes: </strong>{{$person->notes}}<br />
                        <strong>Room Preference: </strong>{{$person->roompreference}}<br />
                        <strong>Display name: </strong>{{$person->display_name}}<br />
                        <strong>Sort name: </strong>{{$person->sort_name}}
                    </span>
                </div>
                <div class='col-md-4' style="background-color: lightcoral;">
                    <span><h2><strong>Medical</strong></h2>
                        <strong>Medical notes: </strong>{{$person->medical}}<br />
                        <strong>Dietary notes: </strong>{{$person->dietary}}   
                    </span>
                </div>
            
            </div><div class="clearfix"> </div>  
            <div class='row'>

                <div class='col-md-8'>
                    <span>
                        <h2>Roles</h2>
                        <div class="form-group">
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
                            <td><a href="person/{{ $touchpoint->staff->id}}">{{ $touchpoint->staff->lastname }}, {{ $touchpoint->staff->firstname }}</a></td>
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