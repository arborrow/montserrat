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
                {{ isset($person->nickname) ? "(&quot;$person->nickname&quot;)" : null }}   </span>
                <span class="back"><a href={{ action('PersonsController@index') }}>{!! Html::image('img/person.png', 'Person Index',array('title'=>"Person Index",'class' => 'btn btn-primary')) !!}</a></span></h1>
            </div>
            <div class='row'><div class='col-md-4'><span><h2>Address</h2>
                <address>{{ $person->address1}}
                @if (isset($person->address2))
                <br />{{$person->address2}}
                @endif   
                <br />{{$person->city}} {{$person->state}} {{ $person->zip}} 
                <br />@if ($person->country='USA') @else {{$person->country}} @endif </address>
            </span></div>
             <div class='col-md-4'><span class="info">
                    <h2>Emergency Contact Information</h2>
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
                <strong>Email: </strong>{{$person->email}}
                <br /><strong>URL: </strong>{{$person->url}}   
                </span></div></div><div class="clearfix"> </div>

            <div class='row'><span>
                <div class='col-md-8'<span><h2>Demographics:</h2>
                <strong>Gender: </strong>{{$person->gender}}  
                <br /><strong>Ethnicity: </strong>{{$person->ethnicity}}   
                <br /><strong>Parish: </strong>
                @if (isset($person->parish->id)) <a href="../parish/{{$person->parish->id}}">{{$person->parish->name}}</a> @endIf     
                <br /><strong>Languages: </strong>{{$person->languages}}</div></span> 
            </div><div class="clearfix"> </div>

            <div class='row'>

                <div class='col-md-4'><span><h2>Medical</h2>
                <strong>Medical notes: </strong>{{$person->medical}}
                <br /><strong>Dietary notes: </strong>{{$person->dietary}}   
                </span></div>
            <div class='col-md-4'><span><h2>Notes</h2>
                <strong>Notes: </strong>{{$person->notes}}
                <br /><strong>Room Preference: </strong>{{$person->roompreference}}
                </span></div>
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