@extends('template')
@section('content')

<section class="section-padding">
    <div class="jumbotron text-left">
        <div class="panel panel-default">
            <div class="panel-heading">
                <span><h2>Touch point with 
                    {{ isset($touchpoint->person->firstname) ? $touchpoint->person->firstname : null }} 
                    {{ isset($touchpoint->person->lastname) ? $touchpoint->person->lastname : null}} 
                    {{ (!empty($touchpoint->person->nickname)) ? "(&quot;$touchpoint->person->nickname&quot;)" : null }}
                </span>                
            </div>
            
            <div class='row'>
                <div class='col-md-4'><span><h2>Touchpoint Details</h2>
                <strong>Date: </strong>{{$touchpoint->touched_at}}
                <br /><strong>Contacted by: </strong>{{$touchpoint->staff->lastname}}, {{$touchpoint->staff->lastname}}  
                <br /><strong>Type: </strong>{{$touchpoint->type}}     
                <br /><strong>Notes: </strong>{{$touchpoint->notes}}
                </span></div>
                <hr />
                <div class='col-md-4'><span><h2>Electronic Communications</h2>
                        <strong>Email: </strong><a href="mailto:{{$touchpoint->person->email}}">{{$touchpoint->person->email}}</a>
                        <br /><strong>URL: </strong><a href="{{$touchpoint->person->url}}" target="_blank">{{$touchpoint->person->url}}</a>   
                </span></div></div><div class="clearfix"> </div>

            <div class='row'><div class='col-md-4'><span><h2>Address</h2>
                <address>
                    <a href="http://maps.google.com/?q={{$touchpoint->person->address1}} {{ $touchpoint->person->address2}} {{ $touchpoint->person->city}} {{ $touchpoint->person->state}} {{ $touchpoint->person->zip}}" target="_blank">
                                
                    {{ $touchpoint->person->address1}}
                        @if (!empty($touchpoint->person->address2))
                            <br />{{$touchpoint->person->address2}}
                        @endif   
                        <br />{{$touchpoint->person->city}} {{$touchpoint->person->state}} {{ $touchpoint->person->zip}}</a> 
                <br />@if ($touchpoint->person->country='USA') @else {{$touchpoint->person->country}} @endif </address>
                    </span></div></div>

            <div class='row'>
                <div class='col-md-4'><span><h2>Phone Numbers</h2><strong>Home phone: </strong>{{$touchpoint->person->homephone}}
                <br /><strong>Work phone: </strong>{{$touchpoint->person->workphone}}   
                <br /><strong>Mobile phone: </strong>{{$touchpoint->person->mobilephone}}     
                <br /><strong>Fax: </strong>{{$touchpoint->person->faxphone}}
                </span></div>
                <div class='col-md-4'><span><h2>Electronic Communications</h2>
                        <strong>Email: </strong><a href="mailto:{{$touchpoint->person->email}}">{{$touchpoint->person->email}}</a>
                        <br /><strong>URL: </strong><a href="{{$touchpoint->person->url}}" target="_blank">{{$touchpoint->person->url}}</a>   
                </span></div></div><div class="clearfix"> </div>

            <div class='row'><span>
                <div class='col-md-8'<span><h2>Demographics:</h2>
                <strong>Gender: </strong>{{$touchpoint->person->gender}}  
                <br /><strong>DOB: </strong> 
                @if (isset($touchpoint->person->dob))
                    {{date('F d, Y', strtotime($touchpoint->person->dob))}}
                @else 
                    N/A
                @endif
                <br /><strong>Ethnicity: </strong>{{$touchpoint->person->ethnicity}}   
                <br /><strong>Parish: </strong>
                @if (isset($touchpoint->person->parish->id)) <a href="../parish/{{$touchpoint->person->parish->id}}">{{$touchpoint->person->parish->name}}</a> @endIf     
                <br /><strong>Languages: </strong>{{$touchpoint->person->languages}}</div></span> 
            </div><div class="clearfix"> </div>

            <div class='row'>

                <div class='col-md-4'>
                    <span><h2>Personal Notes</h2>
                        <strong>Notes: </strong>{{$touchpoint->person->notes}}<br />
                        <strong>Room Preference: </strong>{{$touchpoint->person->roompreference}}
                    </span>
                </div>
            
            </div><div class="clearfix"> </div>  
            <div class='row'>

                <div class='col-md-8'>
                    <span>
                        <h2>Roles</h2>
                        <div class="form-group">
                            {!! Form::label('is_donor', 'Donor:', ['class' => 'col-md-2'])  !!}
                            {!! Form::checkbox('is_donor', 1, $touchpoint->person->is_donor, ['class' => 'col-md-1']) !!}
                            {!! Form::label('is_retreatant', 'Retreatant:', ['class' => 'col-md-2'])  !!}
                            {!! Form::checkbox('is_retreatant', 1, $touchpoint->person->is_retreatant,['class' => 'col-md-1']) !!}
                            {!! Form::label('is_catholic', 'Catholic:', ['class' => 'col-md-2'])  !!}
                            {!! Form::checkbox('is_catholic', 1, $touchpoint->person->is_catholic,['class' => 'col-md-1']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('is_director', 'Retreat Director:', ['class' => 'col-md-2'])  !!}
                            {!! Form::checkbox('is_director', 1, $touchpoint->person->is_director,['class' => 'col-md-1']) !!}
                            {!! Form::label('is_innkeeper', 'Retreat Innkeeper:', ['class' => 'col-md-2'])  !!}
                            {!! Form::checkbox('is_innkeeper', 1, $touchpoint->person->is_innkeeper,['class' => 'col-md-1']) !!}
                             {!! Form::label('is_assistant', 'Retreat Assistant:', ['class' => 'col-md-2'])  !!}
                            {!! Form::checkbox('is_assistant', 1, $touchpoint->person->is_assistant,['class' => 'col-md-1']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('is_captain', 'Captain:', ['class' => 'col-md-2'])  !!}
                            {!! Form::checkbox('is_captain', 1, $touchpoint->person->is_captain,['class' => 'col-md-1']) !!}
                            {!! Form::label('is_volunteer', 'Volunteer:', ['class' => 'col-md-2'])  !!}
                            {!! Form::checkbox('is_volunteer', 1, $touchpoint->person->is_volunteer,['class' => 'col-md-1']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('is_staff', 'Staff:', ['class' => 'col-md-2'])  !!}
                            {!! Form::checkbox('is_staff', 1, $touchpoint->person->is_staff,['class' => 'col-md-1']) !!}
                            {!! Form::label('is_board', 'Board Member:', ['class' => 'col-md-2'])  !!}
                            {!! Form::checkbox('is_board', 1, $touchpoint->person->is_board,['class' => 'col-md-1']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('is_pastor', 'Pastor of Parish:', ['class' => 'col-md-2'])  !!}
                            {!! Form::checkbox('is_pastor', 1, $touchpoint->person->is_pastor,['class' => 'col-md-1']) !!}
                            {!! Form::label('is_bishop', 'Bishop:', ['class' => 'col-md-2'])  !!}
                            {!! Form::checkbox('is_bishop', 1, $touchpoint->person->is_bishop,['class' => 'col-md-1']) !!}
                        </div>    
                    </span>
                </div>
                <div class="clearfix"> </div>
            </div>
                   
            
            
        </div>
        <div class='row'>
            <div class='col-md-1'><a href="{{ action('TouchpointsController@edit', $touchpoint->id) }}" class="btn btn-info">{!! Html::image('img/edit.png', 'Edit',array('title'=>"Edit")) !!}</a></div>
            <div class='col-md-1'>{!! Form::open(['method' => 'DELETE', 'route' => ['touchpoint.destroy', $touchpoint->id]]) !!}
            {!! Form::image('img/delete.png','btnDelete',['class' => 'btn btn-danger','title'=>'Delete']) !!} 
            {!! Form::close() !!}</div><div class="clearfix"> </div>
        </div>
    </div>
</section>
@stop