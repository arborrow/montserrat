@extends('template')
@section('content')
    

<div class="jumbotron text-left">
    <div class="panel panel-default">
        
        <div class='panel-heading'>
                        <h1><strong>Search Contacts</strong></h1>
        </div>
       
        {!! Form::open(['method' => 'GET', 'route' => ['results']]) !!}

        <div class='row'>
            <div class='col-md-12'>
                <div class='panel-heading'>
                    {!! Form::image('img/submit.png','btnSave',['class' => 'btn btn-default']) !!}
                    <h2>Name</h2>
                </div>
                <div class="form-group">
                    {!! Form::label('prefix_id', 'Title:', ['class' => 'col-md-1'])  !!}
                    {!! Form::select('prefix_id', $prefixes, NULL, ['class' => 'col-md-2']) !!}
                    <div class="clearfix"> </div>

                    {!! Form::label('first_name', 'First:', ['class' => 'col-md-1'])  !!}
                    {!! Form::text('first_name', NULL, ['class' => 'col-md-2']) !!}
                    {!! Form::label('middle_name', 'Middle:', ['class' => 'col-md-2'])  !!}
                    {!! Form::text('middle_name', NULL, ['class' => 'col-md-2']) !!}
                    {!! Form::label('last_name', 'Last:', ['class' => 'col-md-1'])  !!}
                    {!! Form::text('last_name', NULL, ['class' => 'col-md-2']) !!}
                    <div class="clearfix"> </div>
                    {!! Form::label('suffix_id', 'Suffix:', ['class' => 'col-md-1'])  !!}
                    {!! Form::select('suffix_id', $suffixes, NULL, ['class' => 'col-md-2']) !!}

                    {!! Form::label('nick_name', 'Nickname: ', ['class' => 'col-md-2'])  !!}
                    {!! Form::text('nick_name', NULL, ['class' => 'col-md-3']) !!}
                    <div class="clearfix"> </div>
                    {!! Form::label('display_name', 'Display name: ', ['class' => 'col-md-2'])  !!}
                    {!! Form::text('display_name', NULL, ['class' => 'col-md-3']) !!}
                    {!! Form::label('sort_name', 'Sort name: ', ['class' => 'col-md-2'])  !!}
                    {!! Form::text('sort_name', NULL, ['class' => 'col-md-3']) !!}

                    <div class="clearfix"> </div>
                    {!! Form::label('contact_type', 'Contact type: ', ['class' => 'col-md-2'])  !!}
                    {!! Form::select('contact_type', $contact_types, 0, ['class' => 'col-md-2']) !!}

                    {!! Form::label('subcontact_type', 'Subcontact type: ', ['class' => 'col-md-2'])  !!}
                    {!! Form::select('subcontact_type', $subcontact_types, 0, ['class' => 'col-md-2']) !!}
                    <div class="clearfix"> </div>

                    {!! Form::label('has_avatar', 'Has avatar?:', ['class' => 'col-md-2'])  !!}
                    {!! Form::checkbox('has_avatar', 1, 0,['class' => 'col-md-1']) !!}
                    
                <div class="clearfix"> </div>
                
                    {!! Form::label('has_attachment', 'Has attachment(s)?:', ['class' => 'col-md-2'])  !!}
                    {!! Form::checkbox('has_attachment', 1, 0,['class' => 'col-md-1']) !!}
                
                    {!! Form::label('attachment_description', 'Description: (max 200)', ['class' => 'col-md-2'])  !!}
                    {!! Form::text('attachment_description', NULL, ['class' => 'col-md-3']) !!}

                </div>
            </div>
        </div>
        <div class="clearfix"> </div> 
        <div class="row">
            {!! Form::label('phone', 'Phone:', ['class' => 'col-md-1'])  !!}
            {!! Form::text('phone', NULL, ['class' => 'col-md-2']) !!}
            {!! Form::label('email', 'Email:', ['class' => 'col-md-1'])  !!}
            {!! Form::text('email', NULL, ['class' => 'col-md-3']) !!}
        </div>
            <div class="clearfix"> </div> 
        <div class="row">
            {!! Form::label('street_address', 'Address:', ['class' => 'col-md-1'])  !!}
            {!! Form::text('street_address', NULL, ['class' => 'col-md-3']) !!}
            {!! Form::label('city', 'City:', ['class' => 'col-md-2'])  !!}
            {!! Form::text('city', NULL, ['class' => 'col-md-3']) !!}
            <div class="clearfix"> </div>                       
            {!! Form::label('state_province_id', 'State:', ['class' => 'col-md-1'])  !!}
            {!! Form::select('state_province_id', $states, NULL, ['class' => 'col-md-2']) !!}
            {!! Form::label('postal_code', 'Zip:', ['class' => 'col-md-1'])  !!}
            {!! Form::text('postal_code', NULL, ['class' => 'col-md-2']) !!}
            <div class="clearfix"> </div>                                 
            {!! Form::label('url', 'Website:', ['class' => 'col-md-1'])  !!}
            {!! Form::text('url', NULL, ['class' => 'col-md-3']) !!}
                       
                
        </div>

        <div class='row'>
            <div class='col-md-8'>
                <div class='panel-heading' style="background-color: lightcoral;"><h2>Emergency Contact Information</h2></div>
                <div class="panel-body" style="background-color: lightcoral;">
                    {!! Form::label('emergency_contact_name', 'Name: ', ['class' => 'col-md-1'])  !!}
                    {!! Form::text('emergency_contact_name', NULL, ['class' => 'col-md-2']) !!}
                    
                    {!! Form::label('emergency_contact_relationship', 'Relationship: ', ['class' => 'col-md-2'])  !!}
                    {!! Form::text('emergency_contact_relationship', NULL, ['class' => 'col-md-2']) !!}
                    {!! Form::label('emergency_contact_phone', 'Phone: ', ['class' => 'col-md-1'])  !!}
                    {!! Form::text('emergency_contact_phone', NULL, ['class' => 'col-md-2']) !!}

                </div>
            </div>
        </div>
        <div class="clearfix"> </div>


        <div class='row'>
            <div class='col-md-8'>
                <div class='panel-heading'><h2>Demographics</h2></div>
                    <div class="form-group">
                        {!! Form::label('gender_id', 'Gender:', ['class' => 'col-md-2'])  !!}
                        {!! Form::select('gender_id', $genders, 0, ['class' => 'col-md-2']) !!}
                        <div class="clearfix"> </div>
                        {!! Form::label('birth_date', 'Birth Date:', ['class' => 'col-md-2']) !!}
                        {!! Form::text('birth_date', NULL, ['class'=>'col-md-2','data-provide'=>'datepicker']) !!}
                        <div class="clearfix"> </div>


                    </div>
                    <div class="form-group">
                        {!! Form::label('religion_id', 'Religion:', ['class' => 'col-md-2'])  !!}
                        {!! Form::select('religion_id', $religions, 0, ['class' => 'col-md-2']) !!} 
                        <div class="clearfix"> </div>
                        {!! Form::label('occupation_id', 'Occupation:', ['class' => 'col-md-2'])  !!}
                        {!! Form::select('occupation_id', $occupations, 0, ['class' => 'col-md-3']) !!} 
                        <div class="clearfix"> </div>

                        {!! Form::label('parish_id', 'Parish:', ['class' => 'col-md-2'])  !!}
                        {!! Form::select('parish_id', $parish_list, 0, ['class' => 'col-md-8']) !!} 
                        <div class="clearfix"> </div>
                    </div>
                    <div class="form-group">                        
                        {!! Form::label('ethnicity_id', 'Ethnicity:', ['class' => 'col-md-2'])  !!}
                        {!! Form::select('ethnicity_id', $ethnicities, 0, ['class' => 'col-md-2']) !!}
                        <div class="clearfix"> </div>
                        {!! Form::label('languages', 'Languages:', ['class' => 'col-md-2'])  !!}
                        {!! Form::select('languages[]', $languages, NULL, ['id'=>'languages','class' => 'form-control col-md-4','multiple' => 'multiple','style'=>'width: auto; font-size: inherit;']) !!}
                        <div class="clearfix"> </div>
                    
                        {!! Form::label('preferred_language_id', 'Preferred Language:', ['class' => 'col-md-2'])  !!}
                        {!! Form::select('preferred_language_id', $languages, 0, ['class' => 'col-md-3']) !!}
                        <div class="clearfix"> </div>
                        {!! Form::label('referrals', 'Referral source(s):', ['class' => 'col-md-2'])  !!}
                        {!! Form::select('referrals[]', $referrals, NULL, ['id'=>'referrals','class' => 'form-control col-md-4','multiple' => 'multiple','style'=>'width: auto; font-size: inherit;']) !!}
                        
                    </div>
                <div class="clearfix"> </div>
                    <div class="form-group">                        
                        {!! Form::label('deceased_date', 'Deceased Date:', ['class' => 'col-md-2'])  !!}
                        {!! Form::text('deceased_date', NULL, ['class'=>'col-md-2','data-provide'=>'datepicker']) !!}
                        {!! Form::label('is_deceased', 'Is Deceased:', ['class' => 'col-md-2'])  !!}
                        {!! Form::checkbox('is_deceased', 1, NULL, ['class' => 'col-md-1']) !!}
                        <div class="clearfix"> </div>
                    </div>
            </div>
            <div class="clearfix"> </div>

        </div>
        <div class="clearfix"> </div>

        <div class='row'>
            <div class='col-md-8'>
                <div class='panel-heading'><h2>Health Notes</h2></div>
                    <div class="form-group">
                        {!! Form::label('note_health', 'Health Notes:', ['class' => 'col-md-2'])  !!}
                        {!! Form::text('note_health', NULL, ['class' => 'col-md-3']) !!}
                        {!! Form::label('note_dietary', 'Dietary Notes:', ['class' => 'col-md-2'])  !!}
                        {!! Form::text('note_dietary', NULL, ['class' => 'col-md-3']) !!}
                    </div>
                </div>
        </div>
        <div class="clearfix"> </div>


        <div class='row'>
            <div class='col-md-8'>
                <span>
                    <div class='panel-heading'><h2>General Notes</h2></div>
                    <div class="form-group">
                        {!! Form::label('note_general', 'General Notes:', ['class' => 'col-md-2'])  !!}
                        {!! Form::text('note_general', NULL, ['class' => 'col-md-3']) !!}
                        {!! Form::label('note_room_preference', 'Room Preference:', ['class' => 'col-md-2'])  !!}
                        {!! Form::text('note_room_preference', NULL, ['class' => 'col-md-3']) !!}
                    </div>
                </span>
            </div>
        </div>
        <div class="clearfix"> </div>

        <div class='row'>
            <div class='col-md-8'>
                <span>
                    <div class='panel-heading'><h2>Groups and Relationships</h2></div>
                    <div class="form-group">
                        {!! Form::label('groups', 'Groups:', ['class' => 'col-md-2'])  !!}
                        {!! Form::select('groups[]', $groups, NULL, ['id'=>'groups','class' => 'form-control col-md-4','multiple' => 'multiple','style'=>'width: auto; font-size: inherit;']) !!}
                    </div>
                </span>
            </div>
        </div>

        
{{--
        <div class='row'>
                <div class='col-md-8'>
                    <div class='panel-heading'><h2>Groups and Relationships</h2></div>
                        <div class="form-group">
                            {!! Form::label('is_donor', 'Donor:', ['class' => 'col-md-2'])  !!}
                            {!! Form::checkbox('is_donor', 1, NULL, ['class' => 'col-md-1']) !!}
                            {!! Form::label('is_steward', 'Steward:', ['class' => 'col-md-2'])  !!}
                            {!! Form::checkbox('is_steward', 1, NULL, ['class' => 'col-md-1']) !!}
                            {!! Form::label('is_volunteer', 'Volunteer:', ['class' => 'col-md-2'])  !!}
                            {!! Form::checkbox('is_volunteer', 1, NULL,['class' => 'col-md-1']) !!}
                        </div><div class="clearfix"> </div>
                        <div class="form-group">
                            {!! Form::label('is_retreatant', 'Retreatant:', ['class' => 'col-md-2'])  !!}
                            {!! Form::checkbox('is_retreatant', 1, 0,['class' => 'col-md-1']) !!}
                            {!! Form::label('is_captain', 'Captain:', ['class' => 'col-md-2'])  !!}
                            {!! Form::checkbox('is_captain', 1, 0,['class' => 'col-md-1']) !!}
                        </div><div class="clearfix"> </div>

                        <div class="form-group">
                            {!! Form::label('is_bishop', 'Bishop:', ['class' => 'col-md-2'])  !!}
                            {!! Form::checkbox('is_bishop', 1, 0,['class' => 'col-md-1']) !!}
                            {!! Form::label('is_priest', 'Priest:', ['class' => 'col-md-2'])  !!}
                            {!! Form::checkbox('is_priest', 1, 0,['class' => 'col-md-1']) !!}
                            {!! Form::label('is_deacon', 'Deacon:', ['class' => 'col-md-2'])  !!}
                            {!! Form::checkbox('is_deacon', 1, 0,['class' => 'col-md-1']) !!}
                            {!! Form::label('is_pastor', 'Pastor:', ['class' => 'col-md-2'])  !!}
                            {!! Form::checkbox('is_pastor', 1, 0,['class' => 'col-md-1']) !!}
                        </div><div class="clearfix"> </div>

                        <div class="form-group">
                            {!! Form::label('is_jesuit', 'Jesuit:', ['class' => 'col-md-2'])  !!}
                            {!! Form::checkbox('is_jesuit', 1, 0,['class' => 'col-md-1']) !!}
                            {!! Form::label('is_provincial', 'Provincial:', ['class' => 'col-md-2'])  !!}
                            {!! Form::checkbox('is_provincial', 1, 0,['class' => 'col-md-1']) !!}
                            {!! Form::label('is_superior', 'Superior:', ['class' => 'col-md-2'])  !!}
                            {!! Form::checkbox('is_superior', 1, 0,['class' => 'col-md-1']) !!}
                        </div><div class="clearfix"> </div>

                        <div class="form-group">
                            {!! Form::label('is_board', 'Board Member:', ['class' => 'col-md-2'])  !!}
                            {!! Form::checkbox('is_board', 1, 0,['class' => 'col-md-1']) !!}
                            {!! Form::label('is_formerboard', 'Former Board:', ['class' => 'col-md-2'])  !!}
                            {!! Form::checkbox('is_formerboard', 1, 0,['class' => 'col-md-1','disabled']) !!}
                        </div><div class="clearfix"> </div>

                        <div class="form-group">
                            {!! Form::label('is_staff', 'Staff:', ['class' => 'col-md-2'])  !!}
                            {!! Form::checkbox('is_staff', 1, 0,['class' => 'col-md-1']) !!}
                            {!! Form::label('is_director', 'Retreat Director:', ['class' => 'col-md-2'])  !!}
                            {!! Form::checkbox('is_director', 1, 0,['class' => 'col-md-1']) !!}
                            {!! Form::label('is_innkeeper', 'Retreat Innkeeper:', ['class' => 'col-md-2'])  !!}
                            {!! Form::checkbox('is_innkeeper', 1, 0,['class' => 'col-md-1']) !!}
                            {!! Form::label('is_assistant', 'Retreat Assistant:', ['class' => 'col-md-2'])  !!}
                            {!! Form::checkbox('is_assistant', 1, 0,['class' => 'col-md-1']) !!}
                        </div><div class="clearfix"> </div>

                </div>
        </div>
        <div class="clearfix"> </div>
 
--}}
   </div>
    <div class="form-group">
        {!! Form::image('img/save.png','btnSave',['class' => 'btn btn-default']) !!}
    </div>
    {!! Form::close() !!}
</div>
@stop