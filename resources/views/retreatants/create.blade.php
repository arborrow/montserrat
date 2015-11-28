@extends('template')
@section('content')

<section class="section-padding">
    <div class="jumbotron text-left">
        <h2><strong>Create Retreatant</strong></h2>
        {!! Form::open(['url' => 'retreatant', 'method' => 'post', 'class' => 'form-horizontal panel']) !!}

        <div class='row'>
            <div class='col-md-8'>
                <span>
                <h2>Name</h2>
                    <div class="form-group">
                        {!! Form::label('title', 'Title: ', ['class' => 'col-md-1'])  !!}
                        {!! Form::text('title1', null, ['class' => 'col-md-1']) !!}
                        {!! Form::label('firstname', 'First: ', ['class' => 'col-md-1'])  !!}
                        {!! Form::text('firstname', null, ['class' => 'col-md-2']) !!}
                        {!! Form::label('middlename', 'Middle: ', ['class' => 'col-md-1'])  !!}
                        {!! Form::text('middlename', null, ['class' => 'col-md-2']) !!}
                        {!! Form::label('lastname', 'Last: ', ['class' => 'col-md-1'])  !!}
                        {!! Form::text('lastname', null, ['class' => 'col-md-2']) !!}
 <div class="clearfix"> </div>
                        {!! Form::label('suffix', 'Suffix: ', ['class' => 'col-md-1'])  !!}
                        {!! Form::text('suffix', null, ['class' => 'col-md-1']) !!}
                        {!! Form::label('nickname', 'Nickname: ', ['class' => 'col-md-2'])  !!}
                        {!! Form::text('nickname', null, ['class' => 'col-md-2']) !!}
                    </div>
                </span>
            </div>
        </div>
        <div class="clearfix"> </div>

        <div class='row'>
            <div class='col-md-12'>
                <span>
                <h2>Address</h2>
                    
                        <div class='row'>
                            {!! Form::label('address1', 'Address 1:', ['class' => 'col-md-1'])  !!}
                            {!! Form::text('address1', null, ['class' => 'col-md-3']) !!}
                        </div>
                        <div class='row'>
                            {!! Form::label('address2', 'Address 2:', ['class' => 'col-md-1'])  !!}
                            {!! Form::text('address2', null, ['class' => 'col-md-2']) !!}
                        </div>
                        <div class='row'>
                            {!! Form::label('city', 'City:', ['class' => 'col-md-1'])  !!}
                            {!! Form::text('city', null, ['class' => 'col-md-2']) !!}
                            {!! Form::label('state', 'State:', ['class' => 'col-md-1'])  !!}
                            {!! Form::text('state', 'TX', ['class' => 'col-md-1']) !!}
                            {!! Form::label('zip', 'Zip:', ['class' => 'col-md-1'])  !!}
                            {!! Form::text('zip', null, ['class' => 'col-md-1']) !!}
                        </div>
                        <div class='row'>
                            {!! Form::label('country', 'Country:', ['class' => 'col-md-1'])  !!}
                            {!! Form::text('country', 'USA', ['class' => 'col-md-1']) !!}
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
                        {!! Form::label('emergencycontactname', 'Name: ', ['class' => 'col-md-1'])  !!}
                        {!! Form::text('emergencycontactname', null, ['class' => 'col-md-2']) !!}
                        {!! Form::label('emergencycontactphone', 'Phone: ', ['class' => 'col-md-1'])  !!}
                        {!! Form::text('emergencycontactphone', null, ['class' => 'col-md-2']) !!}
                        {!! Form::label('emergencycontactphone2', 'Alternate Phone: ', ['class' => 'col-md-2'])  !!}
                        {!! Form::text('emergencycontactphone2', null, ['class' => 'col-md-2']) !!}
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
                        {!! Form::text('homephone', null, ['class' => 'col-md-2']) !!}
                        {!! Form::label('mobilephone', 'Mobile:', ['class' => 'col-md-1'])  !!}
                        {!! Form::text('mobilephone', null, ['class' => 'col-md-2']) !!}
                        {!! Form::label('workphone', 'Work:', ['class' => 'col-md-1'])  !!}
                        {!! Form::text('workphone', null, ['class' => 'col-md-2']) !!}
                        {!! Form::label('faxphone', 'Fax:', ['class' => 'col-md-1'])  !!}
                        {!! Form::text('faxphone', null, ['class' => 'col-md-2']) !!}
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
                        {!! Form::text('email', null, ['class' => 'col-md-3']) !!}
                        {!! Form::label('url', 'Webpage:', ['class' => 'col-md-1'])  !!}
                        {!! Form::text('url', null, ['class' => 'col-md-3']) !!}
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
                        {!! Form::text('gender', null, ['class' => 'col-md-1']) !!}
                        {!! Form::label('ethnicity', 'Ethnicity:', ['class' => 'col-md-1'])  !!}
                        {!! Form::text('ethnicity', 'Caucasian', ['class' => 'col-md-3']) !!}
                        {!! Form::label('parish_id', 'Parish:', ['class' => 'col-md-1'])  !!}
                        {!! Form::text('parish_id', null, ['class' => 'col-md-1']) !!}
                        {!! Form::label('languages', 'Languages:', ['class' => 'col-md-1'])  !!}
                        {!! Form::text('languages', 'English', ['class' => 'col-md-3']) !!}
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
                        {!! Form::textarea('medical', null, ['class' => 'col-md-3']) !!}
                        {!! Form::label('dietary', 'Dietary Notes:', ['class' => 'col-md-2'])  !!}
                        {!! Form::textarea('dietary', null, ['class' => 'col-md-3']) !!}
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
                        {!! Form::textarea('notes', null, ['class' => 'col-md-3']) !!}
                        {!! Form::label('roompreference', 'Room Preference:', ['class' => 'col-md-2'])  !!}
                        {!! Form::textarea('roompreference', null, ['class' => 'col-md-3']) !!}
                    </div>
                </span>
            </div>
        </div><div class="clearfix"> </div>
    
        <div class="col-md-1">
            <div class="form-group">
                {!! Form::submit('Create Retreatant', ['class'=>'btn btn-primary']) !!}
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</section>
@stop