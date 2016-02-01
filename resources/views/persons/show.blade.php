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
                @if ($person->is_director) <span class="back"><a href={{ action('PersonsController@directors') }}>{!! Html::image('img/director.png', 'Directors Index',array('title'=>"Directors Index",'class' => 'btn btn-primary')) !!}</a></span> @endIf
                @if ($person->is_donor) <span class="back"><a href={{ action('PersonsController@donors') }}>{!! Html::image('img/donor.png', 'Donor Index',array('title'=>"Donor Index",'class' => 'btn btn-primary')) !!}</a></span> @endIf
                @if ($person->is_innkeeper) <span class="back"><a href={{ action('PersonsController@innkeepers') }}>{!! Html::image('img/innkeeper.png', 'Innkeepers Index',array('title'=>"Innkeepers Index",'class' => 'btn btn-primary')) !!}</a></span> @endIf
                @if ($person->is_pastor) <span class="back"><a href={{ action('PersonsController@pastors') }}>{!! Html::image('img/pastor.png', 'Pastors Index',array('title'=>"Pastors Index",'class' => 'btn btn-primary')) !!}</a></span> @endIf
                @if ($person->is_retreatant) <span class="back"><a href={{ action('PersonsController@retreatants') }}>{!! Html::image('img/retreatant.png', 'Retreatants Index',array('title'=>"Retreatants Index",'class' => 'btn btn-primary')) !!}</a></span> @endIf
                @if ($person->is_staff) <span class="back"><a href={{ action('PersonsController@employees') }}>{!! Html::image('img/employee.png', 'Employees Index',array('title'=>"Employees Index",'class' => 'btn btn-primary')) !!}</a></span> @endIf
                @if ($person->is_volunteer) <span class="back"><a href={{ action('PersonsController@volunteers') }}>{!! Html::image('img/volunteer.png', 'Volunteers Index',array('title'=>"Volunteers Index",'class' => 'btn btn-primary')) !!}</a></span> @endIf
                </span>                

            </div>
            <div class='row'><div class='col-md-4'><span><h2>Address</h2>
                <address>
                    <a href="http://maps.google.com/?q={{$person->address1}} {{ $person->address2}} {{ $person->city}} {{ $person->state}} {{ $person->zip}}" target="_blank">
                                
                    {{ $person->address1}}
                        @if (!empty($person->address2))
                            <br />{{$person->address2}}
                        @endif   
                        <br />{{$person->city}} {{$person->state}} {{ $person->zip}}</a> 
                <br />@if ($person->country='USA') @else {{$person->country}} @endif </address>
            </span></div>
             <div class='col-md-4' style="background-color: lightcoral;"><span class="info">
                     <h2><strong>Emergency Contact Information</strong></h2>
                    <strong>Name: </strong>{{ isset($person->emergencycontactname) ? $person->emergencycontactname : 'N/A' }}
                    <br /><strong>Phone:</strong> {{ isset($person->emergencycontactphone) ? $person->emergencycontactphone : 'N/A' }}
                    <br /><strong>Alt phone:</strong> {{ isset($person->emergencycontactphone2) ? $person->emergencycontactphone2: 'N/A' }}
                </span></div>               
            </div><div class="clearfix"> </div>

            <div class='row'>
                <div class='col-md-4'><span><h2>Phone Numbers</h2><strong>Home phone: </strong>{{$person->homephone}}
                <br /><strong>Work phone: </strong>{{$person->workphone}}   
                <br /><strong>Mobile phone: </strong>{{$person->mobilephone}}     
                <br /><strong>Fax: </strong>{{$person->faxphone}}
                </span></div>
                <div class='col-md-4'><span><h2>Electronic Communications</h2>
                        <strong>Email: </strong><a href="mailto:{{$person->email}}">{{$person->email}}</a>
                        <br /><strong>URL: </strong><a href="{{$person->url}}" target="_blank">{{$person->url}}</a>   
                </span></div></div><div class="clearfix"> </div>

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
                        </div>
                        <div class="form-group">
                            {!! Form::label('is_pastor', 'Pastor of Parish:', ['class' => 'col-md-2'])  !!}
                            {!! Form::checkbox('is_pastor', 1, $person->is_pastor,['class' => 'col-md-1']) !!}
                            {!! Form::label('is_bishop', 'Bishop:', ['class' => 'col-md-2'])  !!}
                            {!! Form::checkbox('is_bishop', 1, $person->is_bishop,['class' => 'col-md-1']) !!}
                        </div>    
                    </span>
                </div>
                <div class="clearfix"> </div>
            </div>
                   
            
            
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