@extends('template')
@section('content')

<section class="section-padding">
    <div class="jumbotron text-left">
        <h2><strong>Create Person</strong></h2>
        {!! Form::open(['url' => 'person', 'files' => 'true', 'method' => 'post', 'class' => 'form-horizontal panel']) !!}

        <div class='row'>
            <div class='col-md-8'>
                <span>
                <h2>Name</h2>
                    <div class="form-group">
                        {!! Form::label('prefix_id', 'Title: ', ['class' => 'col-md-1'])  !!}
                        {!! Form::select('prefix_id', $prefixes, 0, ['class' => 'col-md-2']) !!}
                        <div class="clearfix"> </div>
                        {!! Form::label('first_name', 'First: ', ['class' => 'col-md-1'])  !!}
                        {!! Form::text('first_name', null, ['required'=>'', 'class' => 'col-md-2','oninvalid'=>"this.setCustomValidity('First name required')"]) !!}
                        {!! Form::label('middle_name', 'Middle: ', ['class' => 'col-md-1'])  !!}
                        {!! Form::text('middle_name', null, ['class' => 'col-md-2']) !!}
                        {!! Form::label('last_name', 'Last: ', ['class' => 'col-md-1'])  !!}
                        {!! Form::text('last_name', null, ['required'=>'','class' => 'col-md-2']) !!}
                        <div class="clearfix"> </div>
                        {!! Form::label('suffix_id', 'Suffix: ', ['class' => 'col-md-1'])  !!}
                        {!! Form::select('suffix_id', $suffixes, 0, ['class' => 'col-md-2']) !!}
                        <div class="clearfix"> </div>
                        {!! Form::label('nick_name', 'Nick: ', ['class' => 'col-md-1'])  !!}
                        {!! Form::text('nick_name', null, ['class' => 'col-md-2']) !!}
                        <div class="clearfix"> </div>
                        
                            {!! Form::label('contact_type', 'Contact type: ', ['class' => 'col-md-3'])  !!}
                            {!! Form::select('contact_type', $contact_types, 1, ['class' => 'col-md-2']) !!}
                        <div class="clearfix"> </div>
                            {!! Form::label('subcontact_type', 'Subcontact type: ', ['class' => 'col-md-3'])  !!}
                            {!! Form::select('subcontact_type', $subcontact_types, 0, ['class' => 'col-md-2']) !!}
                        <div class="clearfix"> </div>
                        @can('create-avatar')
                            {!! Form::label('avatar', 'Picture (max 5M): ', ['class' => 'col-md-3'])  !!}
                            {!! Form::file('avatar'); !!}
                        @endCan        
                    </div>
                        
                </span>
            </div>
        </div>
        <div class="clearfix"> </div>
        <div class='row'>
            <div class='col-md-8' style="background-color: lightcoral;">
                <span>
                    <h2>Emergency Contact Information</h2>
                    <div class="form-group">
                        {!! Form::label('emergency_contact_name', 'Name: ', ['class' => 'col-md-1'])  !!}
                        {!! Form::text('emergency_contact_name', null, ['class' => 'col-md-2']) !!}
                        {!! Form::label('emergency_contact_relationship', 'Relationship: ', ['class' => 'col-md-2'])  !!}
                        {!! Form::text('emergency_contact_relationship', null, ['class' => 'col-md-2']) !!}
                        <div class="clearfix"> </div>
                        {!! Form::label('emergency_contact_phone', 'Phone: ', ['class' => 'col-md-1'])  !!}
                        {!! Form::text('emergency_contact_phone', null, ['class' => 'col-md-2']) !!}
                        {!! Form::label('emergency_contact_phone_alternate', 'Alt. Phone: ', ['class' => 'col-md-2'])  !!}
                        {!! Form::text('emergency_contact_phone_alternate', null, ['class' => 'col-md-2']) !!}
                    </div>
                </span>
            </div>
        </div>
        <div class="clearfix"> </div>
        <div class='row'>
            <div class='col-md-12'>
                <span>
                    @include('persons.create.addresses')
                </span>
            </div>
        </div>
        <div class="clearfix"> </div>

        <div class='row'>
            <div class='col-md-8'>
                <span>
                    @include('persons.create.phones')
                </span>
            </div>
        </div>
        <div class="clearfix"> </div>


     <div class='row'>
            <div class='col-md-8'>
                <span>
                    @include('persons.create.emails')
                </span>
            </div>
        </div>
        <div class="clearfix"> </div>

     <div class='row'>
        <div class='col-md-8'>
            <span>
                @include('persons.create.urls')
            </span>
        </div>
    </div>
    <div class="clearfix"> </div>
       
        <div class='row'>
            <div class='col-md-8'>
                <span>
                    <h2>Demographics</h2>
                    <div class="form-group">
                        {!! Form::label('gender_id', 'Gender:', ['class' => 'col-md-2'])  !!}
                        {!! Form::select('gender_id', $genders, 0, ['class' => 'col-md-2']) !!}
                        <div class="clearfix"> </div>
                        {!! Form::label('birth_date', 'Birth Date:', ['class' => 'col-md-2']) !!}
                        {!! Form::text('birth_date', null, ['class'=>'col-md-2','data-provide'=>'datepicker']) !!}
                        <div class="clearfix"> </div>

                        
                    </div>
                    <div class="form-group">
                        {!! Form::label('religion_id', 'Religion:', ['class' => 'col-md-2'])  !!}
                        {!! Form::select('religion_id', $religions, 1, ['class' => 'col-md-2']) !!} 
                        {!! Form::label('occupation_id', 'Occupation:', ['class' => 'col-md-2'])  !!}
                        {!! Form::select('occupation_id', $occupations, 0, ['class' => 'col-md-3']) !!} 
                        <div class="clearfix"> </div>
                        
                        {!! Form::label('parish_id', 'Parish:', ['class' => 'col-md-2'])  !!}
                        {!! Form::select('parish_id', $parish_list, 0, ['class' => 'col-md-8']) !!} 
                        </div>
                    <div class="form-group">                        
                        {!! Form::label('ethnicity_id', 'Ethnicity:', ['class' => 'col-md-2'])  !!}
                        {!! Form::select('ethnicity_id', $ethnicities, 'Unspecified', ['class' => 'col-md-2']) !!}
                        <div class="clearfix"> </div>
                        {!! Form::label('languages', 'Languages:', ['class' => 'col-md-2'])  !!}
                        {!! Form::select('languages[]', $languages, 45, ['id' => 'languages', 'class' => 'form-control col-md-2','multiple' => 'multiple','style'=>'width: auto; font-size: inherit;']) !!}
                         <div class="clearfix"> </div>
                       
                        {!! Form::label('preferred_language_id', 'Preferred Language:', ['class' => 'col-md-2'])  !!}
                        {!! Form::select('preferred_language_id', $languages, 45, ['class' => 'col-md-3']) !!}
                        <div class="clearfix"> </div>
                       
                        {!! Form::label('referrals', 'Referrals:', ['class' => 'col-md-2'])  !!}
                        {!! Form::select('referrals[]', $referrals, NULL, ['id' => 'referrals', 'class' => 'form-control col-md-2','multiple' => 'multiple','style'=>'width: auto; font-size: inherit;']) !!}
                        
                    </div>
                    {!! Form::label('deceased_date', 'Deceased Date:', ['class' => 'col-md-3'])  !!}
                        {!! Form::text('deceased_date', null, ['class'=>'col-md-2','data-provide'=>'datepicker']) !!}
                        {!! Form::label('is_deceased', 'Is Deceased:', ['class' => 'col-md-2'])  !!}
                        {!! Form::checkbox('is_deceased', 1, false,['class' => 'col-md-1']) !!}
                        <div class="clearfix"> </div>

                </span>
            </div>
        </div>
        <div class="clearfix"> </div>

        <div class='row'>
            <div class='col-md-8'>
                <span>
                    <h2>Health Notes</h2>
                    <div class="form-group">
                        {!! Form::label('note_health', 'Health Notes:', ['class' => 'col-md-3'])  !!}
                        {!! Form::textarea('note_health', null, ['class' => 'col-md-3']) !!}
                        {!! Form::label('note_dietary', 'Dietary Notes:', ['class' => 'col-md-3'])  !!}
                        {!! Form::textarea('note_dietary', null, ['class' => 'col-md-3']) !!}
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
                        {!! Form::label('note_contact', 'General Notes:', ['class' => 'col-md-3'])  !!}
                        {!! Form::textarea('note_contact', null, ['class' => 'col-md-3']) !!}
                        {!! Form::label('note_room_preference', 'Room Preference:', ['class' => 'col-md-3'])  !!}
                        {!! Form::textarea('note_room_preference', null, ['class' => 'col-md-3']) !!}
                    </div>
                </span>
            </div>
        </div><div class="clearfix"> </div>
    
        <div class='row'>
            <div class='col-md-8'>
                <span>
                    <h2>Groups and Relationships</h2>
                    <div class="form-group">
                        {!! Form::label('is_donor', 'Donor:', ['class' => 'col-md-2'])  !!}
                        {!! Form::checkbox('is_donor', 1, true, ['class' => 'col-md-1']) !!}
                        {!! Form::label('is_steward', 'Steward:', ['class' => 'col-md-2'])  !!}
                        {!! Form::checkbox('is_steward', 1, false, ['class' => 'col-md-1']) !!}
                        {!! Form::label('is_volunteer', 'Volunteer:', ['class' => 'col-md-2'])  !!}
                        {!! Form::checkbox('is_volunteer', 1, false,['class' => 'col-md-1']) !!}
                                        </div>
                    <div class="form-group">
                        {!! Form::label('is_retreatant', 'Retreatant:', ['class' => 'col-md-2'])  !!}
                        {!! Form::checkbox('is_retreatant', 1, true,['class' => 'col-md-1']) !!}
                        {!! Form::label('is_captain', 'Captain:', ['class' => 'col-md-2'])  !!}
                        {!! Form::checkbox('is_captain', 1, false,['class' => 'col-md-1']) !!}
                        {!! Form::label('is_hlm2017', 'HLM 2017:', ['class' => 'col-md-2'])  !!}
                        {!! Form::checkbox('is_hlm2017', 1, false,['class' => 'col-md-1']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('is_bishop', 'Bishop:', ['class' => 'col-md-2'])  !!}
                        {!! Form::checkbox('is_bishop', 1, false,['class' => 'col-md-1']) !!}
                        {!! Form::label('is_priest', 'Priest:', ['class' => 'col-md-2'])  !!}
                        {!! Form::checkbox('is_priest', 1, false,['class' => 'col-md-1']) !!}
                        {!! Form::label('is_deacon', 'Deacon:', ['class' => 'col-md-2'])  !!}
                        {!! Form::checkbox('is_deacon', 1, false,['class' => 'col-md-1']) !!}
                        {!! Form::label('is_pastor', 'Pastor:', ['class' => 'col-md-2'])  !!}
                        {!! Form::checkbox('is_pastor', 1, false,['class' => 'col-md-1']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('is_jesuit', 'Jesuit:', ['class' => 'col-md-2'])  !!}
                        {!! Form::checkbox('is_jesuit', 1, false,['class' => 'col-md-1']) !!}
                        {!! Form::label('is_provincial', 'Provincial:', ['class' => 'col-md-2'])  !!}
                        {!! Form::checkbox('is_provincial', 1, false,['class' => 'col-md-1']) !!}
                        {!! Form::label('is_superior', 'Superior:', ['class' => 'col-md-2'])  !!}
                        {!! Form::checkbox('is_superior', 1, false,['class' => 'col-md-1']) !!}
                    </div>    
                    <div class="form-group">
                        {!! Form::label('is_board', 'Board Member:', ['class' => 'col-md-2'])  !!}
                        {!! Form::checkbox('is_board', 1, false,['class' => 'col-md-1']) !!}
                        {!! Form::label('is_formerboard', 'Former Board:', ['class' => 'col-md-2'])  !!}
                        {!! Form::checkbox('is_formerboard', 1, false,['class' => 'col-md-1']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('is_staff', 'Staff:', ['class' => 'col-md-2'])  !!}
                        {!! Form::checkbox('is_staff', 1, false,['class' => 'col-md-1']) !!}
                        {!! Form::label('is_director', 'Retreat Director:', ['class' => 'col-md-2'])  !!}
                        {!! Form::checkbox('is_director', 1, false,['class' => 'col-md-1']) !!}
                        {!! Form::label('is_innkeeper', 'Retreat Innkeeper:', ['class' => 'col-md-2'])  !!}
                        {!! Form::checkbox('is_innkeeper', 1, false,['class' => 'col-md-1']) !!}
                        {!! Form::label('is_assistant', 'Retreat Assistant:', ['class' => 'col-md-2'])  !!}
                        {!! Form::checkbox('is_assistant', 1, false,['class' => 'col-md-1']) !!}
                    </div>
                
                </span>
            </div>
        </div><div class="clearfix"> </div>
        
        <div class="col-md-1">
            <div class="form-group">
                {!! Form::submit('Add Person', ['class'=>'btn btn-default']) !!}
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</section>
@stop
