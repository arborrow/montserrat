@extends('template')
@section('content')
    

<div class="jumbotron text-left">
    <span><h2>Edit Retreatant {{ isset($retreatant->title) ? $retreatant->title : null }} 
                    {{ isset($retreatant->firstname) ? $retreatant->firstname : null }} 
                    {{ isset($retreatant->middlename) ? $retreatant->middlename : null}} 
                    {{ $retreatant->lastname}}{{isset($retreatant->suffix) ? ', '.$retreatant->suffix : null }}
                    {{ isset($retreatant->nickname) ? "(&quot;$retreatant->nickname&quot;)" : null }} </h2></span>

    {!! Form::open(['method' => 'PUT', 'route' => ['retreatant.update', $retreatant->id]]) !!}
    {!! Form::hidden('id', $retreatant->id) !!}
    
    <div class='row'>
        <div class='col-md-8'>
            <span>
            <h2>Name</h2>
                <div class="form-group">
                    {!! Form::label('title', 'Title:', ['class' => 'col-md-1'])  !!}
                    {!! Form::text('title', $retreatant->title, ['class' => 'col-md-1']) !!}
                    {!! Form::label('firstname', 'Firstname:', ['class' => 'col-md-1'])  !!}
                    {!! Form::text('firstname', $retreatant->firstname, ['class' => 'col-md-1']) !!}
                    {!! Form::label('middlename', 'Middlename:', ['class' => 'col-md-1'])  !!}
                    {!! Form::text('middlename', $retreatant->middlename, ['class' => 'col-md-1']) !!}
                    {!! Form::label('lastname', 'Lastname:', ['class' => 'col-md-1'])  !!}
                    {!! Form::text('lastname', $retreatant->lastname, ['class' => 'col-md-1']) !!}
                    {!! Form::label('suffix', 'Suffix:', ['class' => 'col-md-1'])  !!}
                    {!! Form::text('suffix', $retreatant->suffix, ['class' => 'col-md-1']) !!}
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
                    {!! Form::text('address1', $retreatant->address1, ['class' => 'col-md-1']) !!}
                    {!! Form::label('address2', 'Address 2:', ['class' => 'col-md-1'])  !!}
                    {!! Form::text('address2', $retreatant->address2, ['class' => 'col-md-1']) !!}
                    {!! Form::label('city', 'City:', ['class' => 'col-md-1'])  !!}
                    {!! Form::text('city', $retreatant->city, ['class' => 'col-md-1']) !!}
                    {!! Form::label('state', 'State:', ['class' => 'col-md-1'])  !!}
                    {!! Form::text('state', $retreatant->state, ['class' => 'col-md-1']) !!}
                    {!! Form::label('zip', 'Zip:', ['class' => 'col-md-1'])  !!}
                    {!! Form::text('zip', $retreatant->zip, ['class' => 'col-md-1']) !!}
                    {!! Form::label('country', 'Country:', ['class' => 'col-md-1'])  !!}
                    {!! Form::text('country', $retreatant->country, ['class' => 'col-md-1']) !!}
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
                    {!! Form::text('emergencycontactname', $retreatant->emergencycontactname, ['class' => 'col-md-1']) !!}
                    {!! Form::label('emergencycontactphone', 'Emergency Phone:', ['class' => 'col-md-1'])  !!}
                    {!! Form::text('emergencycontactphone', $retreatant->emergencycontactphone, ['class' => 'col-md-1']) !!}
                    {!! Form::label('emergencycontactphone2', 'Emergency Phone 2:', ['class' => 'col-md-1'])  !!}
                    {!! Form::text('emergencycontactphone2', $retreatant->emergencycontactphone2, ['class' => 'col-md-1']) !!}
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
                    {!! Form::text('homephone', $retreatant->homephone, ['class' => 'col-md-1']) !!}
                    {!! Form::label('mobilephone', 'Mobile Phone:', ['class' => 'col-md-1'])  !!}
                    {!! Form::text('mobilephone', $retreatant->mobilephone, ['class' => 'col-md-1']) !!}
                    {!! Form::label('workphone', 'Work Phone:', ['class' => 'col-md-1'])  !!}
                    {!! Form::text('workphone', $retreatant->workphone, ['class' => 'col-md-1']) !!}
                    {!! Form::label('faxphone', 'Fax:', ['class' => 'col-md-1'])  !!}
                    {!! Form::text('faxphone', $retreatant->faxphone, ['class' => 'col-md-1']) !!}
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
                    {!! Form::text('email', $retreatant->email, ['class' => 'col-md-1']) !!}
                    {!! Form::label('url', 'Webpage:', ['class' => 'col-md-1'])  !!}
                    {!! Form::text('url', $retreatant->url, ['class' => 'col-md-1']) !!}
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
                    {!! Form::text('gender', $retreatant->gender, ['class' => 'col-md-1']) !!}
                    {!! Form::label('url', 'Ethnicity:', ['class' => 'col-md-1'])  !!}
                    {!! Form::text('url', $retreatant->url, ['class' => 'col-md-1']) !!}
                    {!! Form::label('parish_id', 'Parish:', ['class' => 'col-md-1'])  !!}
                    {!! Form::text('parish_id', $retreatant->parish_id, ['class' => 'col-md-1']) !!}
                    {!! Form::label('languages', 'Languages:', ['class' => 'col-md-1'])  !!}
                    {!! Form::text('languages', $retreatant->languages, ['class' => 'col-md-1']) !!}
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
                    {!! Form::text('medical', $retreatant->medical, ['class' => 'col-md-1']) !!}
                    {!! Form::label('dietary', 'Dietary Notes:', ['class' => 'col-md-1'])  !!}
                    {!! Form::text('dietary', $retreatant->dietary, ['class' => 'col-md-1']) !!}
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
                    {!! Form::text('notes', $retreatant->notes, ['class' => 'col-md-1']) !!}
                    {!! Form::label('roompreference', 'Room Preference:', ['class' => 'col-md-1'])  !!}
                    {!! Form::text('roompreference', $retreatant->roompreference, ['class' => 'col-md-1']) !!}
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