@extends('template')
@section('content')

<section class="section-padding">
    <div class="jumbotron text-left">
        <div class="panel panel-default">
            <div class="panel-heading">
                <span><h2>{{ isset($person->title) ? $person->title : null }} 
                {{ isset($person->firstname) ? $person->firstname : null }} 
                {{ isset($person->middlename) ? $person->middlename : null}} 
                {{ $person->lastname}}{{isset($person->suffix) ? ', '.$person->suffix : null }}
                {{ (!empty($person->nickname)) ? "(&quot;$person->nickname&quot;)" : null }}   </span>
                <span class="back">
                @if ($person->is_assistant) <span class="back"><a href={{ action('PersonsController@assistants') }}>{!! Html::image('img/assistant.png', 'Assistants Index',array('title'=>"Assistants Index",'class' => 'btn btn-primary')) !!}</a></span> @endIf
                @if ($person->is_bishop) <span class="back"><a href={{ action('PersonsController@bishops') }}>{!! Html::image('img/bishop.png', 'Bishop Index',array('title'=>"Bishop Index",'class' => 'btn btn-primary')) !!}</a></span> @endIf
                @if ($person->is_board) <span class="back"><a href={{ action('PersonsController@boardmembers') }}>{!! Html::image('img/board.png', 'Board Members Index',array('title'=>"Board Members Index",'class' => 'btn btn-primary')) !!}</a></span> @endIf
                @if ($person->is_captain) <span class="back"><a href={{ action('PersonsController@captains') }}>{!! Html::image('img/captain.png', 'Captains Index',array('title'=>"Captains Index",'class' => 'btn btn-primary')) !!}</a></span> @endIf
                @if ($person->is_catholic) <span class="back"><a href={{ action('PersonsController@catholics') }}>{!! Html::image('img/catholic.png', 'Catholics Index',array('title'=>"Catholics Index",'class' => 'btn btn-primary')) !!}</a></span> @endIf
                @if ($person->is_deceased) <span class="back"><a href={{ action('PersonsController@deceased') }}>{!! Html::image('img/deceased.png', 'Deceased Index',array('title'=>"Deceased Index",'class' => 'btn btn-primary')) !!}</a></span> @endIf
                @if ($person->is_director) <span class="back"><a href={{ action('PersonsController@directors') }}>{!! Html::image('img/director.png', 'Directors Index',array('title'=>"Directors Index",'class' => 'btn btn-primary')) !!}</a></span> @endIf
                @if ($person->is_donor) <span class="back"><a href={{ action('PersonsController@donors') }}>{!! Html::image('img/donor.png', 'Donor Index',array('title'=>"Donor Index",'class' => 'btn btn-primary')) !!}</a></span> @endIf
                @if ($person->is_formerboard) <span class="back"><a href={{ action('PersonsController@formerboard') }}>{!! Html::image('img/formerboard.png', 'Former Board Index',array('title'=>"Former Board Index",'class' => 'btn btn-primary')) !!}</a></span> @endIf
                @if ($person->is_innkeeper) <span class="back"><a href={{ action('PersonsController@innkeepers') }}>{!! Html::image('img/innkeeper.png', 'Innkeepers Index',array('title'=>"Innkeepers Index",'class' => 'btn btn-primary')) !!}</a></span> @endIf
                @if ($person->is_jesuit) <span class="back"><a href={{ action('PersonsController@jesuits') }}>{!! Html::image('img/jesuit.png', 'Jesuits Index',array('title'=>"Jesuits Index",'class' => 'btn btn-primary')) !!}</a></span> @endIf
                @if ($person->is_pastor) <span class="back"><a href={{ action('PersonsController@pastors') }}>{!! Html::image('img/pastor.png', 'Pastors Index',array('title'=>"Pastors Index",'class' => 'btn btn-primary')) !!}</a></span> @endIf
                @if ($person->is_retreatant) <span class="back"><a href={{ action('PersonsController@retreatants') }}>{!! Html::image('img/retreatant.png', 'Retreatants Index',array('title'=>"Retreatants Index",'class' => 'btn btn-primary')) !!}</a></span> @endIf
                @if ($person->is_staff) <span class="back"><a href={{ action('PersonsController@employees') }}>{!! Html::image('img/employee.png', 'Employees Index',array('title'=>"Employees Index",'class' => 'btn btn-primary')) !!}</a></span> @endIf
                @if ($person->is_volunteer) <span class="back"><a href={{ action('PersonsController@volunteers') }}>{!! Html::image('img/volunteer.png', 'Volunteers Index',array('title'=>"Volunteers Index",'class' => 'btn btn-primary')) !!}</a></span> @endIf
               <span class="btn btn-primary"><a href={{ action('TouchpointsController@add',$person->id) }}>Add Touch point</a></span> 
               </span>                

            </div>
            <div class='row'><div class='col-md-4'><span><h2>Addresses</h2>
                @foreach($person->addresses as $address)
                <strong>{{$address->location->display_name}}:</strong>
                
                <address>
                    <a href="http://maps.google.com/?q={{$address->street_address}} {{ $address->city}} {{ $address->state->abbreviation}} {{ $address->postal_code}}" target="_blank">
                                
                    {{ $address->street_address}}
                        @if (!empty($address_supplemental_address_1))
                            <br />{{$address_supplemental_address_1}}
                        @endif   
                        <br />{{$address->city}}, {{ $address->state->abbreviation}} {{ $address->postal_code}}</a> 
                <br />@if ($address->country_id=1228) @else {{$address->country_id}} @endif 
                </address>
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
                            <strong>{{$phone->location->display_name}} - {{$phone->phone_type}}: </strong>{{$phone->phone}} {{$phone->phone_ext}}<br />
                        @endforeach
                    </span>
                </div>
                
                <div class='col-md-4'>
                    <span><h2>Electronic Communications</h2>
                        @foreach($person->emails as $email)
                        <strong>{{$email->location->display_name}} - Email: </strong><a href="mailto:{{$email->email}}">{{$email->email}}</a><br />
                        @endforeach
                        @foreach($person->websites as $website)
                        <strong>{{$website->website_type}} - URL: </strong><a href="{{$website->url}}" target="_blank">{{$website->url}}</a><br />
                        @endforeach
                    </span>
                </div>
            </div><div class="clearfix"> </div>

            <div class='row'><span>
                <div class='col-md-8'<span><h2>Demographics:</h2>
                <strong>Gender: </strong>{{$person->gender}}  
                <br /><strong>DOB: </strong> 
                @if (isset($person->dob))
                    {{date('F d, Y', strtotime($person->dob))}}
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
                        <strong>Room Preference: </strong>{{$person->roompreference}}
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
                            {!! Form::label('is_donor', 'Donor:', ['class' => 'col-md-2'])  !!}
                            {!! Form::checkbox('is_donor', 1, $person->is_donor, ['class' => 'col-md-1']) !!}
                            {!! Form::label('is_retreatant', 'Retreatant:', ['class' => 'col-md-2'])  !!}
                            {!! Form::checkbox('is_retreatant', 1, $person->is_retreatant,['class' => 'col-md-1']) !!}
                            {!! Form::label('is_catholic', 'Catholic:', ['class' => 'col-md-2'])  !!}
                            {!! Form::checkbox('is_catholic', 1, $person->is_catholic,['class' => 'col-md-1']) !!}
                            {!! Form::label('is_deceased', 'Deceased:', ['class' => 'col-md-2'])  !!}
                            {!! Form::checkbox('is_deceased', 1, $person->is_deceased,['class' => 'col-md-1']) !!}

                        </div>
                        <div class="form-group">
                            {!! Form::label('is_director', 'Retreat Director:', ['class' => 'col-md-2'])  !!}
                            {!! Form::checkbox('is_director', 1, $person->is_director,['class' => 'col-md-1']) !!}
                            {!! Form::label('is_innkeeper', 'Retreat Innkeeper:', ['class' => 'col-md-2'])  !!}
                            {!! Form::checkbox('is_innkeeper', 1, $person->is_innkeeper,['class' => 'col-md-1']) !!}
                             {!! Form::label('is_assistant', 'Retreat Assistant:', ['class' => 'col-md-2'])  !!}
                            {!! Form::checkbox('is_assistant', 1, $person->is_assistant,['class' => 'col-md-1']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('is_captain', 'Captain:', ['class' => 'col-md-2'])  !!}
                            {!! Form::checkbox('is_captain', 1, $person->is_captain,['class' => 'col-md-1']) !!}
                            {!! Form::label('is_volunteer', 'Volunteer:', ['class' => 'col-md-2'])  !!}
                            {!! Form::checkbox('is_volunteer', 1, $person->is_volunteer,['class' => 'col-md-1']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('is_staff', 'Staff:', ['class' => 'col-md-2'])  !!}
                            {!! Form::checkbox('is_staff', 1, $person->is_staff,['class' => 'col-md-1']) !!}
                            {!! Form::label('is_board', 'Board Member:', ['class' => 'col-md-2'])  !!}
                            {!! Form::checkbox('is_board', 1, $person->is_board,['class' => 'col-md-1']) !!}
                            {!! Form::label('is_formerboard', 'Former Board:', ['class' => 'col-md-2'])  !!}
                            {!! Form::checkbox('is_formerboard', 1, $person->is_formerboard,['class' => 'col-md-1']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('is_jesuit', 'Jesuit:', ['class' => 'col-md-2'])  !!}
                            {!! Form::checkbox('is_jesuit', 1, $person->is_jesuit,['class' => 'col-md-1']) !!}
                            {!! Form::label('is_pastor', 'Pastor of Parish:', ['class' => 'col-md-2'])  !!}
                            {!! Form::checkbox('is_pastor', 1, $person->is_pastor,['class' => 'col-md-1']) !!}
                            {!! Form::label('is_bishop', 'Bishop:', ['class' => 'col-md-2'])  !!}
                            {!! Form::checkbox('is_bishop', 1, $person->is_bishop,['class' => 'col-md-1']) !!}
                        </div>    
                    </span>
                </div>
                <div class="clearfix"> </div>
            </div>
                   <hr />
             @if ($person->touchpoints->isEmpty())
                    <p>It is a brand new world, there are no touch points for this person!</p>
                @else
                <table class="table"><caption><h2>Touch points for {{ $person->firstname }} {{ $person->lastname }} </h2></caption>
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