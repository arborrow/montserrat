@extends('template')
@section('content')
    

<div class="jumbotron text-left">
    <span><h2><strong>Edit Person: {{ isset($person->title) ? $person->title : null }} 
                    {{ isset($person->firstname) ? $person->firstname : null }} 
                    {{ isset($person->middlename) ? $person->middlename : null}} 
                    {{ $person->lastname}}{{isset($person->suffix) ? ', '.$person->suffix : null }}
                    {{ isset($person->nickname) ? "(&quot;$person->nickname&quot;)" : null }}</strong></h2></span>

    {!! Form::open(['method' => 'PUT', 'route' => ['person.update', $person->id]]) !!}
    {!! Form::hidden('id', $person->id) !!}
    
    <div class='row'>
        <div class='col-md-8'>
            <span>
            <h2>Name</h2>
                <div class="form-group">
                    {!! Form::label('title', 'Title:', ['class' => 'col-md-1'])  !!}
                    {!! Form::text('title', $person->title, ['class' => 'col-md-2']) !!}
                    {!! Form::label('firstname', 'First:', ['class' => 'col-md-1'])  !!}
                    {!! Form::text('firstname', $person->firstname, ['class' => 'col-md-2']) !!}
                    {!! Form::label('middlename', 'Middle:', ['class' => 'col-md-1'])  !!}
                    {!! Form::text('middlename', $person->middlename, ['class' => 'col-md-2']) !!}
                    {!! Form::label('lastname', 'Last:', ['class' => 'col-md-1'])  !!}
                    {!! Form::text('lastname', $person->lastname, ['class' => 'col-md-2']) !!}
                <div class="clearfix"> </div>
                    {!! Form::label('suffix', 'Suffix:', ['class' => 'col-md-1'])  !!}
                    {!! Form::text('suffix', $person->suffix, ['class' => 'col-md-1']) !!}
                    {!! Form::label('nickname', 'Nickname: ', ['class' => 'col-md-2'])  !!}
                    {!! Form::text('nickname', null, ['class' => 'col-md-2']) !!}
                    
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
                    <div class='row'>
                        {!! Form::label('address1', 'Address 1:', ['class' => 'col-md-2'])  !!}
                        {!! Form::text('address1', $person->address1, ['class' => 'col-md-4']) !!}
                    </div>
                    <div class='row'>
                        {!! Form::label('address2', 'Address 2:', ['class' => 'col-md-2'])  !!}
                        {!! Form::text('address2', $person->address2, ['class' => 'col-md-4']) !!}
                    </div>
                    <div class='row'>
                        {!! Form::label('city', 'City:', ['class' => 'col-md-2'])  !!}
                        {!! Form::text('city', $person->city, ['class' => 'col-md-2']) !!}
                        {!! Form::label('state', 'State:', ['class' => 'col-md-1'])  !!}
                        {!! Form::text('state', $person->state, ['class' => 'col-md-1']) !!}
                        {!! Form::label('zip', 'Zip:', ['class' => 'col-md-1'])  !!}
                        {!! Form::text('zip', $person->zip, ['class' => 'col-md-1']) !!}
                        {!! Form::label('country', 'Country:', ['class' => 'col-md-1'])  !!}
                        {!! Form::text('country', $person->country, ['class' => 'col-md-1']) !!}
                    </div>  
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
                    {!! Form::label('emergencycontactname', 'Name:', ['class' => 'col-md-1'])  !!}
                    {!! Form::text('emergencycontactname', $person->emergencycontactname, ['class' => 'col-md-2']) !!}
                    {!! Form::label('emergencycontactphone', 'Phone:', ['class' => 'col-md-1'])  !!}
                    {!! Form::text('emergencycontactphone', $person->emergencycontactphone, ['class' => 'col-md-2']) !!}
                    {!! Form::label('emergencycontactphone2', 'Alternate Phone:', ['class' => 'col-md-2'])  !!}
                    {!! Form::text('emergencycontactphone2', $person->emergencycontactphone2, ['class' => 'col-md-2']) !!}
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
                    {!! Form::label('homephone', 'Home:', ['class' => 'col-md-1'])  !!}
                    {!! Form::text('homephone', $person->homephone, ['class' => 'col-md-2']) !!}
                    {!! Form::label('mobilephone', 'Mobile:', ['class' => 'col-md-1'])  !!}
                    {!! Form::text('mobilephone', $person->mobilephone, ['class' => 'col-md-2']) !!}
                    {!! Form::label('workphone', 'Work:', ['class' => 'col-md-1'])  !!}
                    {!! Form::text('workphone', $person->workphone, ['class' => 'col-md-2']) !!}
                    {!! Form::label('faxphone', 'Fax:', ['class' => 'col-md-1'])  !!}
                    {!! Form::text('faxphone', $person->faxphone, ['class' => 'col-md-2']) !!}
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
                    {!! Form::text('email', $person->email, ['class' => 'col-md-3']) !!}
                    {!! Form::label('url', 'Webpage:', ['class' => 'col-md-1'])  !!}
                    {!! Form::text('url', $person->url, ['class' => 'col-md-3']) !!}
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
                    {!! Form::text('url', $person->url, ['class' => 'col-md-3']) !!}
                    {!! Form::label('parish_id', 'Parish:', ['class' => 'col-md-1'])  !!}
                    {!! Form::text('parish_id', $person->parish_id, ['class' => 'col-md-1']) !!}
                    {!! Form::label('languages', 'Languages:', ['class' => 'col-md-1'])  !!}
                    {!! Form::text('languages', $person->languages, ['class' => 'col-md-3']) !!}
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
                    {!! Form::label('medical', 'Medical Notes:', ['class' => 'col-md-2'])  !!}
                    {!! Form::textarea('medical', $person->medical, ['class' => 'col-md-3']) !!}
                    {!! Form::label('dietary', 'Dietary Notes:', ['class' => 'col-md-2'])  !!}
                    {!! Form::textarea('dietary', $person->dietary, ['class' => 'col-md-3']) !!}
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
                    {!! Form::label('notes', 'General Notes:', ['class' => 'col-md-2'])  !!}
                    {!! Form::textarea('notes', $person->notes, ['class' => 'col-md-3']) !!}
                    {!! Form::label('roompreference', 'Room Preference:', ['class' => 'col-md-2'])  !!}
                    {!! Form::textarea('roompreference', $person->roompreference, ['class' => 'col-md-3']) !!}
                </div>
            </span>
        </div>
    </div>
    <div class="clearfix"> </div>

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
        </div><div class="clearfix"> </div>
       
    </section>

    <div class="form-group">
        {!! Form::image('img/save.png','btnSave',['class' => 'btn btn-primary']) !!}
    </div>
    {!! Form::close() !!}
</div>
@stop