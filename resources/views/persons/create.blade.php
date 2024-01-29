@extends('template')
@section('content')

<div class="row bg-cover">
    <div class="col-lg-12">
        <h2>Create Person</h2>
    </div>
    <div class="col-lg-12">
        {{ html()->form('POST', 'person')->acceptsFiles()->open() }}
        <div class="row">
            <div class="col-lg-12">
                <h3>Basic Information</h3>
            </div>
            <div class="col-lg-12">
                <div class="form-group">
                    <div class="row">
                        <div class="col-lg-2 col-md-3">
                            {{ html()->label('Title: ', 'prefix_id') }}
                            {{ html()->select('prefix_id', $prefixes, 0)->class('form-control') }}
                        </div>
                        <div class="col-lg-3 col-md-4">
                            {{ html()->label('First: ', 'first_name') }}
                            {{ html()->text('first_name')->required('')->class('form-control')->attribute('oninvalid', "this.setCustomValidity('First name required')") }}
                        </div>
                        <div class="col-lg-2 col-md-3">
                            {{ html()->label('Middle: ', 'middle_name') }}
                            {{ html()->text('middle_name')->class('form-control') }}
                        </div>
                        <div class="col-lg-3 col-md-4">
                            {{ html()->label('Last: ', 'last_name') }}
                            {{ html()->text('last_name')->required('')->class('form-control') }}
                        </div>
                        <div class="col-lg-2 col-md-3">
                            {{ html()->label('Suffix: ', 'suffix_id') }}
                            {{ html()->select('suffix_id', $suffixes, 0)->class('form-control') }}
                        </div>
                    </div>
                    <div class="row">
                    </div>
                    <div class="row">
                        <div class="col-lg-3 col-md-4">
                            {{ html()->label('Nickname: ', 'nick_name') }}
                            {{ html()->text('nick_name')->class('form-control') }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-2 col-md-3">
                            {{ html()->label('Contact type: ', 'contact_type') }}
                            {{ html()->select('contact_type', $contact_types, 1)->class('form-control') }}
                        </div>
                        <div class="col-lg-2 col-md-3">
                            {{ html()->label('Subcontact type: ', 'subcontact_type') }}
                            {{ html()->select('subcontact_type', $subcontact_types, 0)->class('form-control') }}
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-lg-3 col-md-4">
                            @can('create-avatar')
                            {{ html()->label('Picture (max 5M): ', 'avatar') }}
                            {{ html()->file('avatar')->class('form-control-file') }}
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
                        {{ html()->label('Name: ', 'emergency_contact_name') }}
                        {{ html()->text('emergency_contact_name')->class('form-control') }}
                    </div>
                    <div class="col-lg-3 col-md-6">
                        {{ html()->label('Relationship: ', 'emergency_contact_relationship') }}
                        {{ html()->text('emergency_contact_relationship')->class('form-control') }}
                    </div>
                    <div class="col-lg-3 col-md-6">
                        {{ html()->label('Phone: ', 'emergency_contact_phone') }}
                        {{ html()->text('emergency_contact_phone')->class('form-control') }}
                    </div>
                    <div class="col-lg-3 col-md-6">
                        {{ html()->label('Alt. Phone: ', 'emergency_contact_phone_alternate') }}
                        {{ html()->text('emergency_contact_phone_alternate')->class('form-control') }}
                    </div>
                </div>
            </div>
        </div>

        <hr>

        <div class="row">
            <div class="col-lg-3 col-md-4" id="contact_info">
                <h3>Contact Information</h3>

                {{ html()->label('Preferred communication method:', 'preferred_communication_method_id') }}
                {{ html()->select('preferred_communication_method_id', $preferred_communication_methods, 0)->class('form-control') }}
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
                            {{ html()->label('Gender:', 'gender_id') }}
                            {{ html()->select('gender_id', $genders, 0)->class('form-control') }}
                        </div>
                        <div class="col-lg-3 col-md-4">
                            {{ html()->label('Birth Date:', 'birth_date') }}
                            {{ html()->text('birth_date')->class('form-control flatpickr-date')->attribute('autocomplete', 'off') }}
                        </div>
                        <div class="col-lg-3 col-md-4">
                            {{ html()->label('Deceased Date:', 'deceased_date') }}
                            {{ html()->text('deceased_date')->class('form-control flatpickr-date') }}
                        </div>
                        <div class="col-lg-3 col-md-4">
                            <div class="form-check mt-4">
                                {{ html()->checkbox('is_deceased', false, 1)->class('form-check-input')->id('is_deceased') }}
                                {{ html()->label('Is Deceased', 'is_deceased')->class('form-check-label')->for('is_deceased') }}
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-2 col-md-3">
                            {{ html()->label('Ethnicity:', 'ethnicity_id') }}
                            {{ html()->select('ethnicity_id', $ethnicities, 'Unspecified')->class('form-control') }}
                        </div>
                        <div class="col-lg-2 col-md-3">
                            {{ html()->label('Religion:', 'religion_id') }}
                            {{ html()->select('religion_id', $religions, 1)->class('form-control') }}
                        </div>
                        <div class="col-lg-5 col-md-6">
                            {{ html()->label('Parish:', 'parish_id') }}
                            {{ html()->select('parish_id', $parish_list, 0)->class('form-control') }}
                        </div>
                        <div class="col-lg-3 col-md-4">
                            {{ html()->label('Occupation:', 'occupation_id') }}
                            {{ html()->select('occupation_id', $occupations, 0)->class('form-control') }}
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
                            {{ html()->label('Languages:', 'languages') }}
                            {{ html()->multiselect('languages[]', $languages, 45)->id('languages')->class('form-control select2') }}
                        </div>
                        <div class="col-lg-3 col-md-4 ml-2">
                            {{ html()->label('Preferred Language:', 'preferred_language_id') }}
                            {{ html()->select('preferred_language_id', $languages, 45)->class('form-control') }}
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
            <div class="col-lg-3 col-md-6 alert alert-info alert-important">
                {{ html()->label('Health Notes:', 'note_health') }}
                {{ html()->textarea('note_health')->class('form-control')->rows('3') }}
            </div>
            <div class="col-lg-3 col-md-6 alert alert-info alert-important">
                {{ html()->label('Dietary Notes:', 'note_dietary') }}
                {{ html()->textarea('note_dietary')->class('form-control')->rows('3') }}
            </div>
            <div class="col-lg-3 col-md-6">
                {{ html()->label('General Notes:', 'note_contact') }}
                {{ html()->textarea('note_contact')->class('form-control')->rows('3') }}
            </div>
            <div class="col-lg-3 col-md-6">
                {{ html()->label('Room Preference:', 'note_room_preference') }}
                {{ html()->textarea('note_room_preference')->class('form-control')->rows('3') }}
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3 col-md-4 mt-2">
                {{ html()->label('Referral sources:', 'referrals') }}
                {{ html()->multiselect('referrals[]', $referrals)->id('referrals')->class('form-control select2') }}
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
                    {{ html()->checkbox('is_retreatant', false, 1)->class('form-check-input') }}
                    {{ html()->label('Retreatant', 'is_retreatant')->class('form-check-label') }}
                </div>
            </div>
            <div class="col-lg-2 col-md-3">
                <div class="form-check">
                    {{ html()->checkbox('is_donor', false, 1)->class('form-check-input') }}
                    {{ html()->label('Donor', 'is_donor')->class('form-check-label') }}
                </div>
            </div>
            <div class="col-lg-2 col-md-3">
                <div class="form-check">
                    {{ html()->checkbox('is_steward', false, 1)->class('form-check-input') }}
                    {{ html()->label('Steward', 'is_steward')->class('form-check-label') }}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-2 col-md-3">
                <div class="form-check">
                    {{ html()->checkbox('is_ambassador', false, 1)->class('form-check-input') }}
                    {{ html()->label('Ambassador', 'is_ambassador')->class('form-check-label') }}
                </div>
            </div>
            <div class="col-lg-2 col-md-3">
                <div class="form-check">
                    {{ html()->checkbox('is_volunteer', false, 1)->class('form-check-input') }}
                    {{ html()->label('Volunteer', 'is_volunteer')->class('form-check-label') }}
                </div>
            </div>
            <div class="col-lg-2 col-md-3">
                <div class="form-check">
                    {{ html()->checkbox('is_board', false, 1)->class('form-check-input') }}
                    {{ html()->label('Board Member', 'is_board')->class('form-check-label') }}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-2 col-md-3">
                <div class="form-check">
                    {{ html()->checkbox('is_bishop', false, 1)->class('form-check-input') }}
                    {{ html()->label('Bishop', 'is_bishop')->class('form-check-label') }}
                </div>
            </div>
            <div class="col-lg-2 col-md-3">
                <div class="form-check">
                    {{ html()->checkbox('is_pastor', false, 1)->class('form-check-input') }}
                    {{ html()->label('Pastor', 'is_pastor')->class('form-check-label') }}
                </div>
            </div>
            <div class="col-lg-2 col-md-3">
                <div class="form-check">
                    {{ html()->checkbox('is_priest', false, 1)->class('form-check-input') }}
                    {{ html()->label('Priest', 'is_priest')->class('form-check-label') }}
                </div>
            </div>
            <div class="col-lg-2 col-md-3">
                <div class="form-check">
                    {{ html()->checkbox('is_deacon', false, 1)->class('form-check-input') }}
                    {{ html()->label('Deacon', 'is_deacon')->class('form-check-label') }}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-2 col-md-3">
                <div class="form-check">
                    {{ html()->checkbox('is_jesuit', false, 1)->class('form-check-input') }}
                    {{ html()->label('Jesuit', 'is_jesuit')->class('form-check-label') }}
                </div>
            </div>
            <div class="col-lg-2 col-md-3">
                <div class="form-check">
                    {{ html()->checkbox('is_provincial', false, 1)->class('form-check-input') }}
                    {{ html()->label('Provincial', 'is_provincial')->class('form-check-label') }}
                </div>
            </div>
            <div class="col-lg-2 col-md-3">
                <div class="form-check">
                    {{ html()->checkbox('is_superior', false, 1)->class('form-check-input') }}
                    {{ html()->label('Superior', 'is_superior')->class('form-check-label') }}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-2 col-md-3">
                <div class="form-check">
                    {{ html()->checkbox('is_staff', false, 1)->class('form-check-input') }}
                    {{ html()->label('Staff', 'is_staff')->class('form-check-label') }}
                </div>
            </div>
            <div class="col-lg-2 col-md-3">
                <div class="form-check">
                    {{ html()->checkbox('is_director', false, 1)->class('form-check-input') }}
                    {{ html()->label('Retreat Director', 'is_director')->class('form-check-label') }}
                </div>
            </div>
            <div class="col-lg-2 col-md-3">
                <div class="form-check">
                    {{ html()->checkbox('is_innkeeper', false, 1)->class('form-check-input') }}
                    {{ html()->label('Retreat Innkeeper', 'is_innkeeper')->class('form-check-label') }}
                </div>
            </div>
            <div class="col-lg-2 col-md-3">
                <div class="form-check">
                    {{ html()->checkbox('is_assistant', false, 1)->class('form-check-input') }}
                    {{ html()->label('Retreat Assistant', 'is_assistant')->class('form-check-label') }}
                </div>
            </div>
        </div>

    </div>

    <div class="row">
        <div class="col-lg-12 mt-5">
            {{ html()->submit('Add Person')->class('btn btn-light') }}
        </div>
    </div>
    {{ html()->form()->close() }}
</div>
</div>
@stop
