@extends('template')
@section('content')

<section class="section-padding">
    <div class="jumbotron text-left">
        <h2><strong>Create Person</strong></h2>
        {!! Form::open(['url' => 'contact', 'method' => 'post', 'class' => 'form-horizontal panel']) !!}

        <div class='row'>
            <div class='col-md-8'>
                <span>
                <h2>Name</h2>
                    <div class="form-group">
                        {!! Form::label('title', 'Title: ', ['class' => 'col-md-1'])  !!}
                        {!! Form::text('title', null, ['class' => 'col-md-1']) !!}
                        {!! Form::label('first_name', 'First: ', ['class' => 'col-md-1'])  !!}
                        {!! Form::text('first_name', null, ['class' => 'col-md-2']) !!}
                        {!! Form::label('middle_name', 'Middle: ', ['class' => 'col-md-1'])  !!}
                        {!! Form::text('middle_name', null, ['class' => 'col-md-2']) !!}
                        {!! Form::label('last_name', 'Last: ', ['class' => 'col-md-1'])  !!}
                        {!! Form::text('last_name', null, ['class' => 'col-md-2']) !!}
 <div class="clearfix"> </div>
                        {!! Form::label('suffix_id', 'Suffix: ', ['class' => 'col-md-1'])  !!}
                        {!! Form::text('suffix_id', null, ['class' => 'col-md-1']) !!}
                        {!! Form::label('nick_name', 'Nickname: ', ['class' => 'col-md-2'])  !!}
                        {!! Form::text('nick_name', null, ['class' => 'col-md-2']) !!}
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
            <div class='col-md-12'>
                <span>
                    @include('contacts.create.addresses')
                </span>
            </div>
        </div>
        <div class="clearfix"> </div>

        <div class='row'>
            <div class='col-md-8'>
                <span>
                    @include('contacts.create.phones')
                </span>
            </div>
        </div>
        <div class="clearfix"> </div>


     <div class='row'>
            <div class='col-md-8'>
                <span>
                    @include('contacts.create.emails')
                </span>
            </div>
        </div>
        <div class="clearfix"> </div>

     <div class='row'>
            <div class='col-md-8'>
                <span>
                    @include('contacts.create.urls')
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
                        {!! Form::select('gender', [
                            'Female' => 'Female',
                            'Male' => 'Male',
                            'Other' => 'Other',
                            'Unspecified' => 'Unspecified',
                            ], 'Unspecified', ['class' => 'col-md-2']) !!}
                        {!! Form::label('dob', 'DOB:', ['class' => 'col-md-1']) !!}
                        {!! Form::text('dob', null, ['class'=>'col-md-2','data-provide'=>'datepicker']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('parish_id', 'Parish:', ['class' => 'col-md-1'])  !!}
                        {!! Form::select('parish_id', $parishes, 0, ['class' => 'col-md-8']) !!} 
                    </div>
                    <div class="form-group">                        
                        {!! Form::label('ethnicity', 'Ethnicity:', ['class' => 'col-md-1'])  !!}
                        {!! Form::select('ethnicity', $ethnicities, 'Unspecified', ['class' => 'col-md-2']) !!}
                        {!! Form::label('languages', 'Languages:', ['class' => 'col-md-2'])  !!}
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
    
        <div class='row'>
            <div class='col-md-8'>
                <span>
                    <h2>Roles</h2>
                    <div class="form-group">
                        {!! Form::label('is_donor', 'Donor:', ['class' => 'col-md-2'])  !!}
                        {!! Form::checkbox('is_donor', 1, true, ['class' => 'col-md-1']) !!}
                        {!! Form::label('is_retreatant', 'Retreatant:', ['class' => 'col-md-2'])  !!}
                        {!! Form::checkbox('is_retreatant', 1, true,['class' => 'col-md-1']) !!}
                        {!! Form::label('is_catholic', 'Catholic:', ['class' => 'col-md-2'])  !!}
                        {!! Form::checkbox('is_catholic', 1, true,['class' => 'col-md-1']) !!}
                        {!! Form::label('is_deceased', 'Deceased:', ['class' => 'col-md-2'])  !!}
                        {!! Form::checkbox('is_deceased', 1, false,['class' => 'col-md-1']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('is_director', 'Retreat Director:', ['class' => 'col-md-2'])  !!}
                        {!! Form::checkbox('is_director', 1, false,['class' => 'col-md-1']) !!}
                        {!! Form::label('is_innkeeper', 'Retreat Innkeeper:', ['class' => 'col-md-2'])  !!}
                        {!! Form::checkbox('is_innkeeper', 1, false,['class' => 'col-md-1']) !!}
                         {!! Form::label('is_assistant', 'Retreat Assistant:', ['class' => 'col-md-2'])  !!}
                        {!! Form::checkbox('is_assistant', 1, false,['class' => 'col-md-1']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('is_captain', 'Captain:', ['class' => 'col-md-2'])  !!}
                        {!! Form::checkbox('is_captain', 1, false,['class' => 'col-md-1']) !!}
                        {!! Form::label('is_volunteer', 'Volunteer:', ['class' => 'col-md-2'])  !!}
                        {!! Form::checkbox('is_volunteer', 1, false,['class' => 'col-md-1']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('is_staff', 'Staff:', ['class' => 'col-md-2'])  !!}
                        {!! Form::checkbox('is_staff', 1, false,['class' => 'col-md-1']) !!}
                        {!! Form::label('is_board', 'Board Member:', ['class' => 'col-md-2'])  !!}
                        {!! Form::checkbox('is_board', 1, false,['class' => 'col-md-1']) !!}
                        {!! Form::label('is_formerboard', 'Former Board:', ['class' => 'col-md-2'])  !!}
                        {!! Form::checkbox('is_formerboard', 1, false,['class' => 'col-md-1']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('is_jesuit', 'Jesuit:', ['class' => 'col-md-2'])  !!}
                        {!! Form::checkbox('is_jesuit', 1, false,['class' => 'col-md-1']) !!}
                        {!! Form::label('is_pastor', 'Pastor of Parish:', ['class' => 'col-md-2'])  !!}
                        {!! Form::checkbox('is_pastor', 1, false,['class' => 'col-md-1']) !!}
                        {!! Form::label('is_bishop', 'Bishop:', ['class' => 'col-md-2'])  !!}
                        {!! Form::checkbox('is_bishop', 1, false,['class' => 'col-md-1']) !!}
                    </div>    
                </span>
            </div>
        </div><div class="clearfix"> </div>
        
        <div class="col-md-1">
            <div class="form-group">
                {!! Form::submit('Add Person', ['class'=>'btn btn-primary']) !!}
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</section>
@stop