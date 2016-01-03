@extends('template')
@section('content')
    

<div class="jumbotron text-left">
    <span><h2>Edit Person {{ isset($person->title) ? $person->title : null }} 
                    {{ isset($person->firstname) ? $person->firstname : null }} 
                    {{ isset($person->middlename) ? $person->middlename : null}} 
                    {{ $person->lastname}}{{isset($person->suffix) ? ', '.$person->suffix : null }}
                    {{ isset($person->nickname) ? "(&quot;$person->nickname&quot;)" : null }} </h2></span>

    {!! Form::open(['method' => 'PUT', 'route' => ['person.update', $person->id]]) !!}
    {!! Form::hidden('id', $person->id) !!}
    
    <div class='row'>
        <div class='col-md-8'>
            <span>
            <h2>Name</h2>
                <div class="form-group">
                    {!! Form::label('title', 'Title:', ['class' => 'col-md-1'])  !!}
                    {!! Form::text('title', $person->title, ['class' => 'col-md-1']) !!}
                    {!! Form::label('firstname', 'Firstname:', ['class' => 'col-md-1'])  !!}
                    {!! Form::text('firstname', $person->firstname, ['class' => 'col-md-1']) !!}
                    {!! Form::label('middlename', 'Middlename:', ['class' => 'col-md-1'])  !!}
                    {!! Form::text('middlename', $person->middlename, ['class' => 'col-md-1']) !!}
                    {!! Form::label('lastname', 'Lastname:', ['class' => 'col-md-1'])  !!}
                    {!! Form::text('lastname', $person->lastname, ['class' => 'col-md-1']) !!}
                    {!! Form::label('suffix', 'Suffix:', ['class' => 'col-md-1'])  !!}
                    {!! Form::text('suffix', $person->suffix, ['class' => 'col-md-1']) !!}
                </div>
            </span>
        </div>
    </div>
    <div class="clearfix"> </div>  
    <div class='row'>
        <div class='col-md-8'>
            <span>
            <h2>Address</h2>
                <div class="form-group">
                    {!! Form::label('address1', 'Address 1:', ['class' => 'col-md-1'])  !!}
                    {!! Form::text('address1', $person->address1, ['class' => 'col-md-1']) !!}
                    {!! Form::label('address2', 'Address 2:', ['class' => 'col-md-1'])  !!}
                    {!! Form::text('address2', $person->address2, ['class' => 'col-md-1']) !!}
                    {!! Form::label('city', 'City:', ['class' => 'col-md-1'])  !!}
                    {!! Form::text('city', $person->city, ['class' => 'col-md-1']) !!}
                    {!! Form::label('state', 'State:', ['class' => 'col-md-1'])  !!}
                    {!! Form::text('state', $person->state, ['class' => 'col-md-1']) !!}
                    {!! Form::label('zip', 'Zip:', ['class' => 'col-md-1'])  !!}
                    {!! Form::text('zip', $person->zip, ['class' => 'col-md-1']) !!}
                    {!! Form::label('country', 'Country:', ['class' => 'col-md-1'])  !!}
                    {!! Form::text('country', $person->country, ['class' => 'col-md-1']) !!}
                </div>
            </span>
        </div>
    </div>
    <div class="clearfix"> </div>
    <div class='row'>
        <div class='col-md-8'>
            <span>
            <h2>Emergency Contact Information</h2>
                <div class="form-group">
                    {!! Form::label('emergencycontactname', 'Emergency Contact (Name):', ['class' => 'col-md-1'])  !!}
                    {!! Form::text('emergencycontactname', $person->emergencycontactname, ['class' => 'col-md-1']) !!}
                    {!! Form::label('emergencycontactphone', 'Emergency Phone:', ['class' => 'col-md-1'])  !!}
                    {!! Form::text('emergencycontactphone', $person->emergencycontactphone, ['class' => 'col-md-1']) !!}
                    {!! Form::label('emergencycontactphone2', 'Emergency Phone 2:', ['class' => 'col-md-1'])  !!}
                    {!! Form::text('emergencycontactphone2', $person->emergencycontactphone2, ['class' => 'col-md-1']) !!}
                </div>
            </span>
        </div>
    </div>
    <div class="clearfix"> </div>
    <div class='row'>
        <div class='col-md-8'>
            <span>
            <h2>Phone Numbers</h2>
                <div class="form-group">
                    {!! Form::label('homephone', 'Home phone:', ['class' => 'col-md-1'])  !!}
                    {!! Form::text('homephone', $person->homephone, ['class' => 'col-md-1']) !!}
                    {!! Form::label('mobilephone', 'Mobile Phone:', ['class' => 'col-md-1'])  !!}
                    {!! Form::text('mobilephone', $person->mobilephone, ['class' => 'col-md-1']) !!}
                    {!! Form::label('workphone', 'Work Phone:', ['class' => 'col-md-1'])  !!}
                    {!! Form::text('workphone', $person->workphone, ['class' => 'col-md-1']) !!}
                    {!! Form::label('faxphone', 'Fax:', ['class' => 'col-md-1'])  !!}
                    {!! Form::text('faxphone', $person->faxphone, ['class' => 'col-md-1']) !!}
                </div>
            </span>
        </div>
    </div>
    <div class="clearfix"> </div>
    <div class='row'>
        <div class='col-md-8'>
            <span>
            <h2>Electronic communications</h2>
                <div class="form-group">
                    {!! Form::label('email', 'Email:', ['class' => 'col-md-1'])  !!}
                    {!! Form::text('email', $person->email, ['class' => 'col-md-1']) !!}
                    {!! Form::label('url', 'Webpage:', ['class' => 'col-md-1'])  !!}
                    {!! Form::text('url', $person->url, ['class' => 'col-md-1']) !!}
                </div>
            </span>
        </div>
    </div>
    <div class="clearfix"> </div>


    <div class='row'>
        <div class='col-md-8'>
            <span>
            <h2>Demographics</h2>
                <div class="form-group">
                    {!! Form::label('gender', 'Gender:', ['class' => 'col-md-1'])  !!}
                    {!! Form::text('gender', $person->gender, ['class' => 'col-md-1']) !!}
                    {!! Form::label('url', 'Ethnicity:', ['class' => 'col-md-1'])  !!}
                    {!! Form::text('url', $person->url, ['class' => 'col-md-1']) !!}
                    {!! Form::label('parish_id', 'Parish:', ['class' => 'col-md-1'])  !!}
                    {!! Form::text('parish_id', $person->parish_id, ['class' => 'col-md-1']) !!}
                    {!! Form::label('languages', 'Languages:', ['class' => 'col-md-1'])  !!}
                    {!! Form::text('languages', $person->languages, ['class' => 'col-md-1']) !!}
                </div>
            </span>
        </div>
    </div>
    <div class="clearfix"> </div>


    <div class='row'>
        <div class='col-md-8'>
            <span>
            <h2>Health Notes</h2>
                <div class="form-group">
                    {!! Form::label('medical', 'Medical Notes:', ['class' => 'col-md-1'])  !!}
                    {!! Form::text('medical', $person->medical, ['class' => 'col-md-1']) !!}
                    {!! Form::label('dietary', 'Dietary Notes:', ['class' => 'col-md-1'])  !!}
                    {!! Form::text('dietary', $person->dietary, ['class' => 'col-md-1']) !!}
                </div>
            </span>
        </div>
    </div>
    <div class="clearfix"> </div>


    <div class='row'>
        <div class='col-md-8'>
            <span>
            <h2>General Notes</h2>
                <div class="form-group">
                    {!! Form::label('notes', 'General Notes:', ['class' => 'col-md-1'])  !!}
                    {!! Form::text('notes', $person->notes, ['class' => 'col-md-1']) !!}
                    {!! Form::label('roompreference', 'Room Preference:', ['class' => 'col-md-1'])  !!}
                    {!! Form::text('roompreference', $person->roompreference, ['class' => 'col-md-1']) !!}
                </div>
            </span>
        </div>
    </div>
    <div class="clearfix"> </div>


    </section>

    <div class="form-group">
        {!! Form::image('img/save.png','btnSave',['class' => 'btn btn-primary']) !!}
    </div>
    {!! Form::close() !!}
</div>
@stop