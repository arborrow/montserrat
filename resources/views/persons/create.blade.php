@extends('template')
@section('content')

<div class="row bg-cover">
    <div class="col-lg-12">
        <h2>Create Person</h2>
    </div>
    <div class="col-lg-12">
        {!! Form::open(['url' => 'person', 'files' => 'true', 'method' => 'post']) !!}
        <div class="row">
            <div class="col-lg-12">
                <h3>Basic Information</h3>
            </div>
            <div class="col-lg-12">
                <div class="form-group">
                    <div class="row">
                        <div class="col-lg-2 col-md-3">
                            {!! Form::label('prefix_id', 'Title: ') !!}
                            {!! Form::select('prefix_id', $prefixes, 0, ['class' => 'form-control']) !!}
                        </div>
                        <div class="col-lg-3 col-md-4">
                            {!! Form::label('first_name', 'First: ') !!}
                            {!! Form::text('first_name', null, ['required'=>'', 'class' =>
                            'form-control','oninvalid'=>"this.setCustomValidity('First name required')"]) !!}
                        </div>
                        <div class="col-lg-2 col-md-3">
                            {!! Form::label('middle_name', 'Middle: ') !!}
                            {!! Form::text('middle_name', null, ['class' => 'form-control']) !!}
                        </div>
                        <div class="col-lg-3 col-md-4">
                            {!! Form::label('last_name', 'Last: ') !!}
                            {!! Form::text('last_name', null, ['required'=>'','class' => 'form-control']) !!}
                        </div>
                        <div class="col-lg-2 col-md-3">
                            {!! Form::label('suffix_id', 'Suffix: ') !!}
                            {!! Form::select('suffix_id', $suffixes, 0, ['class' => 'form-control']) !!}
                        </div>
                    </div>
                    <div class="row">
                    </div>
                    <div class="row">
                        <div class="col-lg-3 col-md-4">
                            {!! Form::label('nick_name', 'Nickname: ') !!}
                            {!! Form::text('nick_name', null, ['class' => 'form-control']) !!}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-2 col-md-3">
                            {!! Form::label('contact_type', 'Contact type: ') !!}
                            {!! Form::select('contact_type', $contact_types, 1, ['class' => 'form-control']) !!}
                        </div>
                        <div class="col-lg-2 col-md-3">
                            {!! Form::label('subcontact_type', 'Subcontact type: ') !!}
                            {!! Form::select('subcontact_type', $subcontact_types, 0, ['class' => 'form-control']) !!}
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-lg-3 col-md-4">
                            @can('create-avatar')
                            {!! Form::label('avatar', 'Picture (max 5M): ') !!}
                            {!! Form::file('avatar', ['class' => 'form-control-file']); !!}
                            @endCan
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <hr>
        <div class="col-lg-12 alert alert-danger alert-important" id="safety_info">
            <h3>Emergency Contact Information</h3>
            <div class="form-group">
                <div class="row">
                    <div class="col-lg-3 col-md-6">
                        {!! Form::label('emergency_contact_name', 'Name: ') !!}
                        {!! Form::text('emergency_contact_name', null, ['class' => 'form-control']) !!}
                    </div>
                    <div class="col-lg-3 col-md-6">
                        {!! Form::label('emergency_contact_relationship', 'Relationship: ') !!}
                        {!! Form::text('emergency_contact_relationship', null, ['class' => 'form-control']) !!}
                    </div>
                    <div class="col-lg-3 col-md-6">
                        {!! Form::label('emergency_contact_phone', 'Phone: ') !!}
                        {!! Form::text('emergency_contact_phone', null, ['class' => 'form-control']) !!}
                    </div>
                    <div class="col-lg-3 col-md-6">
                        {!! Form::label('emergency_contact_phone_alternate', 'Alt. Phone: ') !!}
                        {!! Form::text('emergency_contact_phone_alternate', null, ['class' => 'form-control']) !!}
                    </div>
                </div>
            </div>
        </div>

        <hr>

        <div class="row">
            <div class="col-lg-3 col-md-4" id="contact_info">
                <h3>Contact Information</h3>

                {!! Form::label('preferred_communication_method_id', 'Preferred communication method:') !!}
                {!! Form::select('preferred_communication_method_id', $preferred_communication_methods, 0, ['class' => 'form-control']) !!}
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <h3>Addresses</h3>
            </div>
            <div class="col-lg-12">
                @include('persons.create.addresses')
            </div>
        </div>

        <hr>

        <div class="row">
            <div class="col-lg-12">
                <h3>Phone Numbers</h3>
            </div>
            <div class="col-lg-12">
                @include('persons.create.phones')
            </div>
        </div>

        <hr>

        <div class="row">
            <div class="col-lg-12">
                <h3>Email Addresses</h3>
            </div>
            <div class="col-lg-12">
                @include('persons.create.emails')
            </div>
        </div>

        <hr>

        <div class="row">
            <div class="col-lg-12">
                <h3>Websites (URLs)</h3>
            </div>
            <div class="col-lg-12">
                @include('persons.create.urls')
            </div>
        </div>

        <hr>

        <div class="row">
            <div class="col-lg-12">
                <h3>Demographics</h3>
            </div>
            <div class="col-lg-12">
                <div class="form-group">
                    <div class="row">
                        <div class="col-lg-2 col-md-4">
                            {!! Form::label('gender_id', 'Gender:') !!}
                            {!! Form::select('gender_id', $genders, 0, ['class' => 'form-control']) !!}
                        </div>
                        <div class="col-lg-3 col-md-4">
                            {!! Form::label('birth_date', 'Birth Date:') !!}
                            {!! Form::text('birth_date', null, ['class'=>'form-control flatpickr-date', 'autocomplete'
                            => 'off']) !!}
                        </div>
                        <div class="col-lg-3 col-md-4">
                            {!! Form::label('deceased_date', 'Deceased Date:') !!}
                            {!! Form::text('deceased_date', null, ['class'=>'form-control flatpickr-date']) !!}
                        </div>
                        <div class="col-lg-3 col-md-4">
                            <div class="form-check mt-4">
                                {!! Form::checkbox('is_deceased', 1, false,['class' => 'form-check-input', 'id' =>
                                'is_deceased']) !!}
                                {!! Form::label('is_deceased', 'Is Deceased', ['class' => 'form-check-label', 'for' =>
                                'is_deceased']) !!}
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-3 col-md-4">
                            {!! Form::label('ethnicity_id', 'Ethnicity:') !!}
                            {!! Form::select('ethnicity_id', $ethnicities, 'Unspecified', ['class' => 'form-control'])
                            !!}
                        </div>
                        <div class="col-lg-3 col-md-4">
                            {!! Form::label('religion_id', 'Religion:') !!}
                            {!! Form::select('religion_id', $religions, 1, ['class' => 'form-control']) !!}
                        </div>
                        <div class="col-lg-3 col-md-4">
                            {!! Form::label('parish_id', 'Parish:') !!}
                            {!! Form::select('parish_id', $parish_list, 0, ['class' => 'form-control']) !!}
                        </div>
                        <div class="col-lg-3 col-md-4">
                            {!! Form::label('occupation_id', 'Occupation:') !!}
                            {!! Form::select('occupation_id', $occupations, 0, ['class' => 'form-control']) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <hr>

        <div class="row">
            <div class="col-lg-12">
                <h3>Languages</h3>
            </div>
            <div class="col-lg-12">
                <div class="form-group">
                    <div class="row">
                        <div class="col-lg-3 col-md-4 mr-2">
                            {!! Form::label('languages', 'Languages:') !!}
                            {!! Form::select('languages[]', $languages, 45, ['id' => 'languages', 'class' =>
                            'form-control select2', 'multiple' => 'multiple']) !!}
                        </div>
                        <div class="col-lg-3 col-md-4 ml-2">
                            {!! Form::label('preferred_language_id', 'Preferred Language:') !!}
                            {!! Form::select('preferred_language_id', $languages, 45, ['class' => 'form-control']) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <hr>

        <div class="row">
            <div class="col-lg-12">
                <h3>Notes</h3>
            </div>
            <div class="col-lg-3 col-md-6">
                {!! Form::label('note_health', 'Health Notes:') !!}
                {!! Form::textarea('note_health', null, ['class' => 'form-control', 'rows' => '3']) !!}
            </div>
            <div class="col-lg-3 col-md-6">
                {!! Form::label('note_dietary', 'Dietary Notes:') !!}
                {!! Form::textarea('note_dietary', null, ['class' => 'form-control', 'rows' => '3']) !!}
            </div>
            <div class="col-lg-3 col-md-6">
                {!! Form::label('note_contact', 'General Notes:') !!}
                {!! Form::textarea('note_contact', null, ['class' => 'form-control', 'rows' => '3']) !!}
            </div>
            <div class="col-lg-3 col-md-6">
                {!! Form::label('note_room_preference', 'Room Preference:') !!}
                {!! Form::textarea('note_room_preference', null, ['class' => 'form-control', 'rows' => '3']) !!}
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3 col-md-4 mt-2">
                {!! Form::label('referrals', 'Referrals:') !!}
                {!! Form::select('referrals[]', $referrals, NULL, ['id' => 'referrals', 'class' =>
                'form-control select2', 'multiple' => 'multiple']) !!}
            </div>
        </div>


        <hr>

        <div class="row">
            <div class="col-lg-12">
                <h3>Groups and Relationships</h3>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-2 col-md-3">
                <div class="form-check">
                    {!! Form::checkbox('is_retreatant', 1, false,['class' => 'form-check-input']) !!}
                    {!! Form::label('is_retreatant', 'Retreatant', ['class' => 'form-check-label']) !!}
                </div>
            </div>
            <div class="col-lg-2 col-md-3">
                <div class="form-check">
                    {!! Form::checkbox('is_donor', 1, false, ['class' => 'form-check-input']) !!}
                    {!! Form::label('is_donor', 'Donor', ['class' => 'form-check-label']) !!}
                </div>
            </div>
            <div class="col-lg-2 col-md-3">
                <div class="form-check">
                    {!! Form::checkbox('is_steward', 1, false, ['class' => 'form-check-input']) !!}
                    {!! Form::label('is_steward', 'Steward', ['class' => 'form-check-label']) !!}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-2 col-md-3">
                <div class="form-check">
                    {!! Form::checkbox('is_ambassador', 1, false,['class' => 'form-check-input']) !!}
                    {!! Form::label('is_ambassador', 'Ambassador', ['class' => 'form-check-label']) !!}
                </div>
            </div>
            <div class="col-lg-2 col-md-3">
                <div class="form-check">
                    {!! Form::checkbox('is_volunteer', 1, false,['class' => 'form-check-input']) !!}
                    {!! Form::label('is_volunteer', 'Volunteer', ['class' => 'form-check-label']) !!}
                </div>
            </div>
            <div class="col-lg-2 col-md-3">
                <div class="form-check">
                    {!! Form::checkbox('is_board', 1, false,['class' => 'form-check-input']) !!}
                    {!! Form::label('is_board', 'Board Member', ['class' => 'form-check-label']) !!}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-2 col-md-3">
                <div class="form-check">
                    {!! Form::checkbox('is_bishop', 1, false,['class' => 'form-check-input']) !!}
                    {!! Form::label('is_bishop', 'Bishop', ['class' => 'form-check-label']) !!}
                </div>
            </div>
            <div class="col-lg-2 col-md-3">
                <div class="form-check">
                    {!! Form::checkbox('is_pastor', 1, false,['class' => 'form-check-input']) !!}
                    {!! Form::label('is_pastor', 'Pastor', ['class' => 'form-check-label']) !!}
                </div>
            </div>
            <div class="col-lg-2 col-md-3">
                <div class="form-check">
                    {!! Form::checkbox('is_priest', 1, false,['class' => 'form-check-input']) !!}
                    {!! Form::label('is_priest', 'Priest', ['class' => 'form-check-label']) !!}
                </div>
            </div>
            <div class="col-lg-2 col-md-3">
                <div class="form-check">
                    {!! Form::checkbox('is_deacon', 1, false,['class' => 'form-check-input']) !!}
                    {!! Form::label('is_deacon', 'Deacon', ['class' => 'form-check-label']) !!}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-2 col-md-3">
                <div class="form-check">
                    {!! Form::checkbox('is_jesuit', 1, false,['class' => 'form-check-input']) !!}
                    {!! Form::label('is_jesuit', 'Jesuit', ['class' => 'form-check-label']) !!}
                </div>
            </div>
            <div class="col-lg-2 col-md-3">
                <div class="form-check">
                    {!! Form::checkbox('is_provincial', 1, false,['class' => 'form-check-input']) !!}
                    {!! Form::label('is_provincial', 'Provincial', ['class' => 'form-check-label']) !!}
                </div>
            </div>
            <div class="col-lg-2 col-md-3">
                <div class="form-check">
                    {!! Form::checkbox('is_superior', 1, false,['class' => 'form-check-input']) !!}
                    {!! Form::label('is_superior', 'Superior', ['class' => 'form-check-label']) !!}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-2 col-md-3">
                <div class="form-check">
                    {!! Form::checkbox('is_staff', 1, false,['class' => 'form-check-input']) !!}
                    {!! Form::label('is_staff', 'Staff', ['class' => 'form-check-label']) !!}
                </div>
            </div>
            <div class="col-lg-2 col-md-3">
                <div class="form-check">
                    {!! Form::checkbox('is_director', 1, false,['class' => 'form-check-input']) !!}
                    {!! Form::label('is_director', 'Retreat Director', ['class' => 'form-check-label']) !!}
                </div>
            </div>
            <div class="col-lg-2 col-md-3">
                <div class="form-check">
                    {!! Form::checkbox('is_innkeeper', 1, false,['class' => 'form-check-input']) !!}
                    {!! Form::label('is_innkeeper', 'Retreat Innkeeper', ['class' => 'form-check-label']) !!}
                </div>
            </div>
            <div class="col-lg-2 col-md-3">
                <div class="form-check">
                    {!! Form::checkbox('is_assistant', 1, false,['class' => 'form-check-input']) !!}
                    {!! Form::label('is_assistant', 'Retreat Assistant', ['class' => 'form-check-label']) !!}
                </div>
            </div>
        </div>

    </div>

    <div class="row">
        <div class="col-lg-12 mt-5">
            {!! Form::submit('Add Person', ['class'=>'btn btn-light']) !!}
        </div>
    </div>
    {!! Form::close() !!}
</div>
</div>
@stop
