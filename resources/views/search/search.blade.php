@extends('template')
@section('content')

<div>
<div class="jumbotron text-left">
    <div class="panel panel-default">

        <div class='panel-heading'>
            <h1><strong>Search Contacts</strong></h1>
        </div>

        {{ html()->form('GET', 'results')->open() }}

        <div class="panel-body">
            <div class='panel-heading'>
                <h2>
                    <span>Name</span>
                    <span>{{ html()->input('image', 'search')->class('btn btn-outline-dark pull-right')->attribute('src', asset('images/submit.png')) }}</span>
                </h2>
            </div>
            <div class="panel-body">
                <div class="form-group">
                    {{ html()->label('Title:', 'prefix_id')->class('control-label col-sm-3') }}
                    <div class="col-sm-8">
                        {{ html()->select('prefix_id', $prefixes)->class('form-control') }}
                    </div>

                </div>
                <div class="form-group">
                    {{ html()->label('First:', 'first_name')->class('control-label col-sm-3') }}
                    <div class="col-sm-8">
                        {{ html()->text('first_name')->class('form-control') }}
                    </div>
                </div>
                <div class="form-group">
                    {{ html()->label('Middle:', 'middle_name')->class('control-label col-sm-3') }}
                    <div class="col-sm-8">
                        {{ html()->text('middle_name')->class('form-control') }}
                    </div>
                </div>
                <div class="form-group">
                    {{ html()->label('Last:', 'last_name')->class('control-label col-sm-3') }}
                    <div class="col-sm-8">
                    {{ html()->text('last_name')->class('form-control') }}
                    </div>
                </div>
                <div class="form-group">
                    {{ html()->label('Suffix:', 'suffix_id')->class('control-label col-sm-3') }}
                    <div class="col-sm-8">
                    {{ html()->select('suffix_id', $suffixes)->class('form-control') }}
                    </div>
                </div>
                <div class="form-group">
                    {{ html()->label('Nickname: ', 'nick_name')->class('control-label col-sm-3') }}
                    <div class="col-sm-8">
                    {{ html()->text('nick_name')->class('form-control') }}
                    </div>
                </div>
                <div class="form-group">
                    {{ html()->label('Display name: ', 'display_name')->class('control-label col-sm-3') }}
                    <div class="col-sm-8">
                    {{ html()->text('display_name')->class('form-control') }}
                    </div>
                </div>
                <div class="form-group">
                    {{ html()->label('Sort name: ', 'sort_name')->class('control-label col-sm-3') }}
                    <div class="col-sm-8">
                    {{ html()->text('sort_name')->class('form-control') }}
                    </div>
                </div>
                <div class="form-group">
                    {{ html()->label('Contact type: ', 'contact_type')->class('control-label col-sm-3') }}
                    <div class="col-sm-8">
                    {{ html()->select('contact_type', $contact_types, 0)->class('form-control') }}
                    </div>
                </div>
                <div class="form-group">
                    {{ html()->label('Subcontact type: ', 'subcontact_type')->class('control-label col-sm-3') }}
                    <div class="col-sm-8">
                    {{ html()->select('subcontact_type', $subcontact_types, 0)->class('form-control') }}
                    </div>
                </div>
                <div class="form-group">
                    {{ html()->label('Has avatar?:', 'has_avatar')->class('control-label col-sm-3') }}
                    <div class="col-sm-8">
                    {{ html()->checkbox('has_avatar', 0, 1)->class('') }}
                    </div>
                </div>
                <div class="form-group">
                    {{ html()->label('Has attachment(s)?:', 'has_attachment')->class('control-label col-sm-3') }}
                    <div class="col-sm-8">
                    {{ html()->checkbox('has_attachment', 0, 1)->class('') }}
                    </div>
                </div>
                <div class="form-group">
                    <div class="clearfix"> </div>
                    {{ html()->label('Description: (max 200)', 'attachment_description')->class('control-label col-sm-3') }}
                    <div class="col-sm-8">
                    {{ html()->text('attachment_description')->class('form-control') }}
                    </div>
                </div>
                <div class="form-group">
                    {{ html()->label('Phone:', 'phone')->class('control-label col-sm-3') }}
                    <div class="col-sm-8">
                        {{ html()->text('phone')->class('form-control') }}
                    </div>
                </div>
                <div class="form-group">
                    {{ html()->label('Do not phone:', 'do_not_phone')->class('control-label col-sm-3') }}
                    <div class="col-sm-8">
                        {{ html()->select('do_not_phone', array(null => 'N/A', '1' => 'Yes', '0' => 'No')) }}
                    </div>
                </div>
                <div class="form-group">
                    {{ html()->label('Do not SMS:', 'do_not_sms')->class('control-label col-sm-3') }}
                    <div class="col-sm-8">
                        {{ html()->select('do_not_sms', array(null => 'N/A', '1' => 'Yes', '0' => 'No')) }}
                    </div>
                </div>

                <div class="form-group">
                    {{ html()->label('Email:', 'email')->class('control-label col-sm-3') }}
                    <div class="col-sm-8">
                        {{ html()->text('email')->class('form-control') }}
                    </div>
                </div>
                <div class="form-group">
                    {{ html()->label('Do not email:', 'do_not_email')->class('control-label col-sm-3') }}
                    <div class="col-sm-8">
                        {{ html()->select('do_not_email', array(null => 'N/A', '1' => 'Yes', '0' => 'No')) }}
                    </div>
                </div>
                <div class="form-group">
                    {{ html()->label('Address:', 'street_address')->class('control-label col-sm-3') }}
                    <div class="col-sm-8">
                        {{ html()->text('street_address')->class('form-control') }}
                    </div>
                </div>
                <div class="form-group">
                    {{ html()->label('City:', 'city')->class('control-label col-sm-3') }}
                    <div class="col-sm-8">
                        {{ html()->text('city')->class('form-control') }}
                    </div>
                </div>
                <div class="form-group">
                    {{ html()->label('State:', 'state_province_id')->class('control-label col-sm-3') }}
                    <div class="col-sm-8">
                        {{ html()->select('state_province_id', $states)->class('form-control') }}
                    </div>
                </div>
                <div class="form-group">
                    {{ html()->label('Zip:', 'postal_code')->class('control-label col-sm-3') }}
                    <div class="col-sm-8">
                        {{ html()->text('postal_code')->class('form-control') }}
                    </div>
                </div>
                <div class="form-group">
                    {{ html()->label('Country:', 'country_id')->class('control-label col-sm-3') }}
                    <div class="col-sm-8">
                        {{ html()->select('country_id', $countries)->class('form-control') }}
                    </div>
                </div>
                <div class="form-group">
                    {{ html()->label('Do not mail:', 'do_not_mail')->class('control-label col-sm-3') }}
                    <div class="col-sm-8">
                        {{ html()->select('do_not_mail', array(null => 'N/A', '1' => 'Yes', '0' => 'No')) }}
                    </div>
                </div>

                <div class="form-group">
                    {{ html()->label('Website:', 'url')->class('control-label col-sm-3') }}
                    <div class="col-sm-8">
                        {{ html()->text('url')->class('form-control') }}
                    </div>
                </div>
            </div>
            <div class='panel-heading' style="background-color: lightcoral;"><h2>Emergency Contact Information</h2></div>
            <div class="panel-body" style="background-color: lightcoral;">
                <div class="form-group">
                    {{ html()->label('Name: ', 'emergency_contact_name')->class('control-label col-sm-3') }}
                    <div class="col-sm-8">
                        {{ html()->text('emergency_contact_name')->class('form-control') }}
                    </div>
                </div>
                <div class="form-group">
                    {{ html()->label('Relationship: ', 'emergency_contact_relationship')->class('control-label col-sm-3') }}
                    <div class="col-sm-8">
                        {{ html()->text('emergency_contact_relationship')->class('form-control') }}
                    </div>
                </div>
                <div class="form-group">
                    {{ html()->label('Phone: ', 'emergency_contact_phone')->class('control-label col-sm-3') }}
                    <div class="col-sm-8">
                        {{ html()->text('emergency_contact_phone')->class('form-control') }}
                    </div>
                </div>
            </div>
            <div class='panel-heading'><h2>Demographics</h2></div>
            <div class="panel-body">
               <div class="form-group">
                    {{ html()->label('Gender:', 'gender_id')->class('control-label col-sm-3') }}
                    <div class="col-sm-8">
                        {{ html()->select('gender_id', $genders, 0)->class('form-control') }}
                    </div>
                </div>
                <div class="form-group">
                    {{ html()->label('Birth Date:', 'birth_date')->class('control-label col-sm-3') }}
                    <div class="col-sm-8">
                        {{ html()->text('birth_date')->class('form-control flatpickr-date') }}
                    </div>
                </div>
                <div class="form-group">
                    {{ html()->label('Religion:', 'religion_id')->class('control-label col-sm-3') }}
                    <div class="col-sm-8">
                        {{ html()->select('religion_id', $religions, 0)->class('form-control') }}
                    </div>
                </div>
                <div class="form-group">
                    {{ html()->label('Occupation:', 'occupation_id')->class('control-label col-sm-3') }}
                    <div class="col-sm-8">
                        {{ html()->select('occupation_id', $occupations, 0)->class('form-control') }}
                    </div>
                </div>
                <div class="form-group">
                    {{ html()->label('Parish:', 'parish_id')->class('control-label col-sm-3') }}
                    <div class="col-sm-8">
                        {{ html()->select('parish_id', $parish_list, 0)->class('form-control') }}
                    </div>
                </div>
                <div class="form-group">
                    {{ html()->label('Ethnicity:', 'ethnicity_id')->class('control-label col-sm-3') }}
                    <div class="col-sm-8">
                        {{ html()->select('ethnicity_id', $ethnicities, 0)->class('form-control') }}
                    </div>
                </div>
                <div class="form-group">
                    {{ html()->label('Languages:', 'languages')->class('control-label col-sm-3') }}
                    <div class="col-sm-8">
                        {{ html()->multiselect('languages[]', $languages)->id('languages')->class('form-control')->style('width: auto; font-size: inherit;') }}
                    </div>
                </div>
                <div class="form-group">
                    {{ html()->label('Preferred Language:', 'preferred_language_id')->class('control-label col-sm-3') }}
                    <div class="col-sm-8">
                        {{ html()->select('preferred_language_id', $languages, 0)->class('form-control') }}
                    </div>
                </div>
                <div class="form-group">
                    {{ html()->label('Referral source(s):', 'referrals')->class('control-label col-sm-3') }}
                    <div class="col-sm-8">
                        {{ html()->multiselect('referrals[]', $referrals)->id('referrals')->class('form-control')->style('width: auto; font-size: inherit;') }}
                    </div>
                </div>
                <div class="form-group">
                    {{ html()->label('Deceased Date:', 'deceased_date')->class('control-label col-sm-3') }}
                    <div class="col-sm-8">
                        {{ html()->text('deceased_date')->class('form-control flatpickr-date') }}
                    </div>
                </div>
                <div class="form-group">
                    {{ html()->label('Is Deceased:', 'is_deceased')->class('control-label col-sm-3') }}
                    <div class="col-sm-8">
                        {{ html()->checkbox('is_deceased', NULL, 1)->class('') }}
                    </div>
                </div>
            </div>
            <div class='panel-heading'><h2>Health Notes</h2></div>
            <div class="panel-body">
                <div class="form-group">
                    {{ html()->label('Health Notes:', 'note_health')->class('control-label col-sm-3') }}
                    <div class="col-sm-8">
                        {{ html()->text('note_health')->class('form-control') }}
                    </div>
                </div>
                <div class="form-group">
                    {{ html()->label('Dietary Notes:', 'note_dietary')->class('control-label col-sm-3') }}
                    <div class="col-sm-8">
                        {{ html()->text('note_dietary')->class('form-control') }}
                    </div>
                </div>
            </div>
            <div class='panel-heading'><h2>General Notes</h2></div>
            <div class="panel-body">
                <div class="form-group">
                    {{ html()->label('General Notes:', 'note_general')->class('control-label col-sm-3') }}
                    <div class="col-sm-8">
                        {{ html()->text('note_general')->class('form-control') }}
                    </div>
                </div>
                <div class="form-group">
                    {{ html()->label('Room Preference:', 'note_room_preference')->class('control-label col-sm-3') }}
                    <div class="col-sm-8">
                        {{ html()->text('note_room_preference')->class('form-control') }}
                    </div>
                </div>
            </div>
            <div class='panel-heading'><h2>Touchpoints</h2></div>
            <div class="form-group">
                    <div class="clearfix"> </div>
                        {{ html()->label('Note: ', 'touchpoint_notes')->class('control-label col-sm-3') }}
                    <div class="col-sm-8">
                        {{ html()->text('touchpoint_notes')->class('form-control') }}
                    </div>
                </div>
            <div class="form-group">
                    <div class="clearfix"> </div>
                        {{ html()->label('Touched at: ', 'touched_at')->class('control-label col-sm-3') }}
                    <div class="col-sm-8">
                        {{ html()->text('touched_at')->class('form-control flatpickr-date bg-white') }}
                    </div>
                </div>
            <div class='panel-heading'><h2>Groups and Relationships</h2></div>
            <div class="panel-body">
                <div class="form-group">
                    {{ html()->label('Groups:', 'groups')->class('control-label col-sm-3') }}
                    <div class="col-sm-8">
                        {{ html()->multiselect('groups[]', $groups)->id('groups')->class('form-control')->style('width: auto; font-size: inherit;') }}
                    </div>
                </div>
            </div>
        </div>

   </div>
    {{ html()->form()->close() }}
</div>


@stop
