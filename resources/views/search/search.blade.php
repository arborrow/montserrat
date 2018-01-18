@extends('template')
@section('content')
    
<div>
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
                    {!! Form::label('prefix_id', 'Title:', ['class' => ''])  !!}
                    {!! Form::select('prefix_id', $prefixes, NULL, ['class' => 'form-control']) !!}
                    <!-- <div class="clearfix"> </div> -->

                    {!! Form::label('first_name', 'First:', ['class' => ''])  !!}
                    {!! Form::text('first_name', NULL, ['class' => 'form-control']) !!}
                    {!! Form::label('middle_name', 'Middle:', ['class' => ''])  !!}
                    {!! Form::text('middle_name', NULL, ['class' => 'form-control']) !!}
                    {!! Form::label('last_name', 'Last:', ['class' => ''])  !!}
                    {!! Form::text('last_name', NULL, ['class' => 'form-control']) !!}
                    <!-- <div class="clearfix"> </div> -->

                    {!! Form::label('suffix_id', 'Suffix:', ['class' => ''])  !!}
                    {!! Form::select('suffix_id', $suffixes, NULL, ['class' => 'form-control']) !!}

                    {!! Form::label('nick_name', 'Nickname: ', ['class' => ''])  !!}
                    {!! Form::text('nick_name', NULL, ['class' => 'form-control']) !!}
                    <!-- <div class="clearfix"> </div> -->
                    {!! Form::label('display_name', 'Display name: ', ['class' => ''])  !!}
                    {!! Form::text('display_name', NULL, ['class' => 'form-control']) !!}
                    {!! Form::label('sort_name', 'Sort name: ', ['class' => ''])  !!}
                    {!! Form::text('sort_name', NULL, ['class' => 'form-control']) !!}

                    <!-- <div class="clearfix"> </div> -->
                    {!! Form::label('contact_type', 'Contact type: ', ['class' => ''])  !!}
                    {!! Form::select('contact_type', $contact_types, 0, ['class' => 'form-control']) !!}

                    {!! Form::label('subcontact_type', 'Subcontact type: ', ['class' => ''])  !!}
                    {!! Form::select('subcontact_type', $subcontact_types, 0, ['class' => 'form-control']) !!}
                    <!-- <div class="clearfix"> </div> -->

                    {!! Form::label('has_avatar', 'Has avatar?:', ['class' => ''])  !!}
                    {!! Form::checkbox('has_avatar', 1, 0,['class' => '']) !!}
                    
                    <div class="clearfix"> </div>
                
                    {!! Form::label('has_attachment', 'Has attachment(s)?:', ['class' => ''])  !!}
                    {!! Form::checkbox('has_attachment', 1, 0,['class' => '']) !!}
                
                    <div class="clearfix"> </div>
                    {!! Form::label('attachment_description', 'Description: (max 200)', ['class' => ''])  !!}
                    {!! Form::text('attachment_description', NULL, ['class' => 'form-control']) !!}

                </div>
            </div>
        </div>
        <!-- <div class="clearfix"> </div>  -->
        <div class="row">
            <div class="col-md-12">
                {!! Form::label('phone', 'Phone:', ['class' => ''])  !!}
                {!! Form::text('phone', NULL, ['class' => 'form-control']) !!}
                {!! Form::label('email', 'Email:', ['class' => ''])  !!}
                {!! Form::text('email', NULL, ['class' => 'form-control']) !!}
            </div>   
        </div>
            <!-- <div class="clearfix"> </div>  -->
        <div class="row">
            <div class="col-md-12">
                {!! Form::label('street_address', 'Address:', ['class' => ''])  !!}
                {!! Form::text('street_address', NULL, ['class' => 'form-control']) !!}
                {!! Form::label('city', 'City:', ['class' => ''])  !!}
                {!! Form::text('city', NULL, ['class' => 'form-control']) !!}
                <div class="clearfix"> </div>                       
                {!! Form::label('state_province_id', 'State:', ['class' => ''])  !!}
                {!! Form::select('state_province_id', $states, NULL, ['class' => 'form-control']) !!}
                {!! Form::label('postal_code', 'Zip:', ['class' => ''])  !!}
                {!! Form::text('postal_code', NULL, ['class' => 'form-control']) !!}
                <div class="clearfix"> </div>                                 
                {!! Form::label('url', 'Website:', ['class' => ''])  !!}
                {!! Form::text('url', NULL, ['class' => 'form-control']) !!}
            </div>    
        </div>

        <div class='row'>
            <div class='col-md-12'>
                <div class='panel-heading' style="background-color: lightcoral;"><h2>Emergency Contact Information</h2></div>
                <div class="panel-body" style="background-color: lightcoral;">
                    {!! Form::label('emergency_contact_name', 'Name: ', ['class' => ''])  !!}
                    {!! Form::text('emergency_contact_name', NULL, ['class' => 'form-control']) !!}
                    
                    {!! Form::label('emergency_contact_relationship', 'Relationship: ', ['class' => ''])  !!}
                    {!! Form::text('emergency_contact_relationship', NULL, ['class' => 'form-control']) !!}
                    {!! Form::label('emergency_contact_phone', 'Phone: ', ['class' => ''])  !!}
                    {!! Form::text('emergency_contact_phone', NULL, ['class' => 'form-control']) !!}

                </div>
            </div>
        </div>
        <div class="clearfix"> </div>


        <div class='row'>
            <div class='col-md-12'>
                <div class='panel-heading'><h2>Demographics</h2></div>
                    <div class="form-group">
                        {!! Form::label('gender_id', 'Gender:', ['class' => ''])  !!}
                        {!! Form::select('gender_id', $genders, 0, ['class' => 'form-control']) !!}
                        <div class="clearfix"> </div>
                        {!! Form::label('birth_date', 'Birth Date:', ['class' => '']) !!}
                        {!! Form::text('birth_date', NULL, ['class'=>'form-control','data-provide'=>'datepicker']) !!}
                        <div class="clearfix"> </div>


                    </div>
                    <div class="form-group">
                        {!! Form::label('religion_id', 'Religion:', ['class' => ''])  !!}
                        {!! Form::select('religion_id', $religions, 0, ['class' => 'form-control']) !!} 
                        <div class="clearfix"> </div>
                        {!! Form::label('occupation_id', 'Occupation:', ['class' => ''])  !!}
                        {!! Form::select('occupation_id', $occupations, 0, ['class' => 'form-control']) !!} 
                        <div class="clearfix"> </div>

                        {!! Form::label('parish_id', 'Parish:', ['class' => ''])  !!}
                        {!! Form::select('parish_id', $parish_list, 0, ['class' => 'form-control']) !!} 
                        <div class="clearfix"> </div>
                    </div>
                    <div class="form-group">                        
                        {!! Form::label('ethnicity_id', 'Ethnicity:', ['class' => ''])  !!}
                        {!! Form::select('ethnicity_id', $ethnicities, 0, ['class' => 'form-control']) !!}
                        <div class="clearfix"> </div>
                        {!! Form::label('languages', 'Languages:', ['class' => ''])  !!}
                        {!! Form::select('languages[]', $languages, NULL, ['id'=>'languages','class' => 'form-control','multiple' => 'multiple','style'=>'width: auto; font-size: inherit;']) !!}
                        <div class="clearfix"> </div>
                    
                        {!! Form::label('preferred_language_id', 'Preferred Language:', ['class' => ''])  !!}
                        {!! Form::select('preferred_language_id', $languages, 0, ['class' => 'form-control']) !!}
                        <div class="clearfix"> </div>
                        {!! Form::label('referrals', 'Referral source(s):', ['class' => ''])  !!}
                        {!! Form::select('referrals[]', $referrals, NULL, ['id'=>'referrals','class' => 'form-control','multiple' => 'multiple','style'=>'width: auto; font-size: inherit;']) !!}
                        
                    </div>
                <div class="clearfix"> </div>
                    <div class="form-group">                        
                        {!! Form::label('deceased_date', 'Deceased Date:', ['class' => ''])  !!}
                        {!! Form::text('deceased_date', NULL, ['class'=>'form-control','data-provide'=>'datepicker']) !!}
                        {!! Form::label('is_deceased', 'Is Deceased:', ['class' => ''])  !!}
                        {!! Form::checkbox('is_deceased', 1, NULL, ['class' => '']) !!}
                        <div class="clearfix"> </div>
                    </div>
            </div>
            <div class="clearfix"> </div>

        </div>
        <div class="clearfix"> </div>

        <div class='row'>
            <div class='col-md-12'>
                <div class='panel-heading'><h2>Health Notes</h2></div>
                    <div class="form-group">
                        {!! Form::label('note_health', 'Health Notes:', ['class' => ''])  !!}
                        {!! Form::text('note_health', NULL, ['class' => 'form-control']) !!}
                        {!! Form::label('note_dietary', 'Dietary Notes:', ['class' => ''])  !!}
                        {!! Form::text('note_dietary', NULL, ['class' => 'form-control']) !!}
                    </div>
                </div>
        </div>
        <div class="clearfix"> </div>


        <div class='row'>
            <div class='col-md-12'>
                <span>
                    <div class='panel-heading'><h2>General Notes</h2></div>
                    <div class="form-group">
                        {!! Form::label('note_general', 'General Notes:', ['class' => ''])  !!}
                        {!! Form::text('note_general', NULL, ['class' => 'form-control']) !!}
                        {!! Form::label('note_room_preference', 'Room Preference:', ['class' => ''])  !!}
                        {!! Form::text('note_room_preference', NULL, ['class' => 'form-control']) !!}
                    </div>
                </span>
            </div>
        </div>
        <div class="clearfix"> </div>

        <div class='row'>
            <div class='col-md-12'>
                <span>
                    <div class='panel-heading'><h2>Groups and Relationships</h2></div>
                    <div class="form-group">
                        {!! Form::label('groups', 'Groups:', ['class' => ''])  !!}
                        {!! Form::select('groups[]', $groups, NULL, ['id'=>'groups','class' => 'form-control','multiple' => 'multiple','style'=>'width: auto; font-size: inherit;']) !!}
                    </div>
                </span>
            </div>
        </div>

        
{{--
        <div class='row'>
                <div class='col-md-8'>
                    <div class='panel-heading'><h2>Groups and Relationships</h2></div>
                        <div class="form-group">
                            {!! Form::label('is_donor', 'Donor:', ['class' => ''])  !!}
                            {!! Form::checkbox('is_donor', 1, NULL, ['class' => 'col-md-1']) !!}
                            {!! Form::label('is_steward', 'Steward:', ['class' => ''])  !!}
                            {!! Form::checkbox('is_steward', 1, NULL, ['class' => 'col-md-1']) !!}
                            {!! Form::label('is_volunteer', 'Volunteer:', ['class' => ''])  !!}
                            {!! Form::checkbox('is_volunteer', 1, NULL,['class' => 'col-md-1']) !!}
                        </div><div class="clearfix"> </div>
                        <div class="form-group">
                            {!! Form::label('is_retreatant', 'Retreatant:', ['class' => ''])  !!}
                            {!! Form::checkbox('is_retreatant', 1, 0,['class' => 'col-md-1']) !!}
                            {!! Form::label('is_captain', 'Captain:', ['class' => ''])  !!}
                            {!! Form::checkbox('is_captain', 1, 0,['class' => 'col-md-1']) !!}
                        </div><div class="clearfix"> </div>

                        <div class="form-group">
                            {!! Form::label('is_bishop', 'Bishop:', ['class' => ''])  !!}
                            {!! Form::checkbox('is_bishop', 1, 0,['class' => 'col-md-1']) !!}
                            {!! Form::label('is_priest', 'Priest:', ['class' => ''])  !!}
                            {!! Form::checkbox('is_priest', 1, 0,['class' => 'col-md-1']) !!}
                            {!! Form::label('is_deacon', 'Deacon:', ['class' => ''])  !!}
                            {!! Form::checkbox('is_deacon', 1, 0,['class' => 'col-md-1']) !!}
                            {!! Form::label('is_pastor', 'Pastor:', ['class' => ''])  !!}
                            {!! Form::checkbox('is_pastor', 1, 0,['class' => 'col-md-1']) !!}
                        </div><div class="clearfix"> </div>

                        <div class="form-group">
                            {!! Form::label('is_jesuit', 'Jesuit:', ['class' => ''])  !!}
                            {!! Form::checkbox('is_jesuit', 1, 0,['class' => 'col-md-1']) !!}
                            {!! Form::label('is_provincial', 'Provincial:', ['class' => ''])  !!}
                            {!! Form::checkbox('is_provincial', 1, 0,['class' => 'col-md-1']) !!}
                            {!! Form::label('is_superior', 'Superior:', ['class' => ''])  !!}
                            {!! Form::checkbox('is_superior', 1, 0,['class' => 'col-md-1']) !!}
                        </div><div class="clearfix"> </div>

                        <div class="form-group">
                            {!! Form::label('is_board', 'Board Member:', ['class' => ''])  !!}
                            {!! Form::checkbox('is_board', 1, 0,['class' => 'col-md-1']) !!}
                            {!! Form::label('is_formerboard', 'Former Board:', ['class' => ''])  !!}
                            {!! Form::checkbox('is_formerboard', 1, 0,['class' => 'col-md-1','disabled']) !!}
                        </div><div class="clearfix"> </div>

                        <div class="form-group">
                            {!! Form::label('is_staff', 'Staff:', ['class' => ''])  !!}
                            {!! Form::checkbox('is_staff', 1, 0,['class' => 'col-md-1']) !!}
                            {!! Form::label('is_director', 'Retreat Director:', ['class' => ''])  !!}
                            {!! Form::checkbox('is_director', 1, 0,['class' => 'col-md-1']) !!}
                            {!! Form::label('is_innkeeper', 'Retreat Innkeeper:', ['class' => ''])  !!}
                            {!! Form::checkbox('is_innkeeper', 1, 0,['class' => 'col-md-1']) !!}
                            {!! Form::label('is_assistant', 'Retreat Assistant:', ['class' => ''])  !!}
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