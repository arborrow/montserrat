@extends('template')
@section('content')

<section class="section-padding">
    <div class="jumbotron text-left">
        <div class="panel panel-default">
            <div class="panel-heading">
                <span><h2>{{ isset($contact->title) ? $contact->title : null }} 
                {{ isset($contact->first_name) ? $contact->first_name : null }} 
                {{ isset($contact->middle_name) ? $contact->middle_name : null}} 
                {{ $contact->last_name}}{{isset($contact->suffix) ? ', '.$contact->suffix : null }}
                {{ (!empty($contact->nick_name)) ? "(&quot;$contact->nick_name&quot;)" : null }}   </span>
                <span class="back">
               <span class="btn btn-primary"><a href={{ action('TouchpointsController@add',$contact->id) }}>Add Touch point</a></span> 
               </span>                

            </div>
            <div class='row'><div class='col-md-4'><span><h2>Addresses</h2>
                @foreach($contact->addresses as $address)
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
                    <strong>Name: </strong>{{ isset($contact->emergencycontactname) ? $contact->emergencycontactname : 'N/A' }}
                    <br /><strong>Phone:</strong> {{ isset($contact->emergencycontactphone) ? $contact->emergencycontactphone : 'N/A' }}
                    <br /><strong>Alt phone:</strong> {{ isset($contact->emergencycontactphone2) ? $contact->emergencycontactphone2: 'N/A' }}
                </span></div>               
            </div><div class="clearfix"> </div>

            <div class='row'>
                <div class='col-md-4'>
                    <span><h2>Phone Numbers</h2>
                        @foreach($contact->phones as $phone)
                        @if(!empty($phone->phone))
                            <strong>{{$phone->location->display_name}} - {{$phone->phone_type}}: </strong>{{$phone->phone}} {{$phone->phone_ext}}<br />
                        @endif
                            @endforeach
                    </span>
                </div>
                
                <div class='col-md-4'>
                    <span><h2>Electronic Communications</h2>
                        @foreach($contact->emails as $email)
                        @if(!empty($email->email))
                        <strong>{{$email->location->display_name}} - Email: </strong><a href="mailto:{{$email->email}}">{{$email->email}}</a><br />
                        @endif
                        @endforeach
                        @foreach($contact->websites as $website)
                        @if(!empty($website->url))
                        <strong>{{$website->website_type}} - URL: </strong><a href="{{$website->url}}" target="_blank">{{$website->url}}</a><br />
                        @endif
                        @endforeach
                    </span>
                </div>
            </div><div class="clearfix"> </div>

            <div class='row'><span>
                <div class='col-md-8'<span><h2>Demographics:</h2>
                <strong>Gender: </strong>{{$contact->gender}}  
                <br /><strong>DOB: </strong> 
                @if (isset($contact->birth_date))
                    {{date('F d, Y', strtotime($contact->birth_date))}}
                @else 
                    N/A
                @endif
                <br /><strong>Ethnicity: </strong>{{$contact->ethnicity}}   
                <br /><strong>Parish: </strong>
                @if (isset($contact->parish->id)) <a href="../parish/{{$contact->parish->id}}">{{$contact->parish->name}}</a> @endIf     
                <br /><strong>Languages: </strong>{{$contact->languages}}</div></span> 
            </div><div class="clearfix"> </div>

            <div class='row'>

                <div class='col-md-4'>
                    <span><h2>Notes</h2>
                        <strong>Notes: </strong>{{$contact->notes}}<br />
                        <strong>Room Preference: </strong>{{$contact->roompreference}}<br />
                        <strong>Display name: </strong>{{$contact->display_name}}<br />
                        <strong>Sort name: </strong>{{$contact->sort_name}}
                    </span>
                </div>
                <div class='col-md-4' style="background-color: lightcoral;">
                    <span><h2><strong>Medical</strong></h2>
                        <strong>Medical notes: </strong>{{$contact->medical}}<br />
                        <strong>Dietary notes: </strong>{{$contact->dietary}}   
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
             @if ($contact->touchpoints->isEmpty())
                    <p>It is a brand new world, there are no touch points for this person!</p>
                @else
                <table class="table"><caption><h2>Touch points for {{ $contact->firstname }} {{ $contact->lastname }} </h2></caption>
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Contacted by</th>
                            <th>Type of contact</th>
                            <th>Notes</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($contact->touchpoints as $touchpoint)
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
            <div class='col-md-1'><a href="{{ action('PersonsController@edit', $contact->id) }}" class="btn btn-info">{!! Html::image('img/edit.png', 'Edit',array('title'=>"Edit")) !!}</a></div>
            <div class='col-md-1'>{!! Form::open(['method' => 'DELETE', 'route' => ['person.destroy', $contact->id]]) !!}
            {!! Form::image('img/delete.png','btnDelete',['class' => 'btn btn-danger','title'=>'Delete']) !!} 
            {!! Form::close() !!}</div><div class="clearfix"> </div>
        </div>
    </div>
</section>
@stop