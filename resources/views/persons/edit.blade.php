@extends('template')
@section('content')

<div class="row bg-cover">
    <div class="col-lg-12 text-center">
        {!!$person->avatar_large_link!!}
        <h2>Edit: {{ $person->full_name }}</h2>
    </div>
    <div class="col-lg-12 text-center">
        @if ($person->is_board_member) <span><a href={{ action([\App\Http\Controllers\PersonController::class, 'boardmembers']) }}>{{ html()->img(asset('images/board.png'), 'Board Members Group')->attribute('title', "Board Members Group")->class('btn btn-outline-dark') }}</a></span> @endIf
        @if ($person->is_ambassador) <span><a href={{ action([\App\Http\Controllers\PersonController::class, 'ambassadors']) }}>{{ html()->img(asset('images/ambassador.png'), 'Ambassador Group')->attribute('title', "Ambassadors Group")->class('btn btn-outline-dark') }}</a></span> @endIf
        @if ($person->is_staff) <span><a href={{ action([\App\Http\Controllers\PersonController::class, 'staff']) }}>{{ html()->img(asset('images/employee.png'), 'Staff Group')->attribute('title', "Employees Group")->class('btn btn-outline-dark') }}</a></span> @endIf
        @if ($person->is_steward) <span><a href={{ action([\App\Http\Controllers\PersonController::class, 'stewards']) }}>{{ html()->img(asset('images/steward.png'), 'Steward Group')->attribute('title', "Stewards Group")->class('btn btn-outline-dark') }}</a></span> @endIf
        @if ($person->is_volunteer) <span><a href={{ action([\App\Http\Controllers\PersonController::class, 'volunteers']) }}>{{ html()->img(asset('images/volunteer.png'), 'Volunteers Group')->attribute('title', "Volunteers Group")->class('btn btn-outline-dark') }}</a></span> @endIf
        @if ($person->is_retreat_director) <span><a href={{ action([\App\Http\Controllers\PersonController::class, 'directors']) }}>{{ html()->img(asset('images/director.png'), 'Retreat Directors Group')->attribute('title', "Directors Group")->class('btn btn-outline-dark') }}</a></span> @endIf
        @if ($person->is_retreat_innkeeper) <span><a href={{ action([\App\Http\Controllers\PersonController::class, 'innkeepers']) }}>{{ html()->img(asset('images/innkeeper.png'), 'Retreat Innkeepers Group')->attribute('title', "Innkeepers Group")->class('btn btn-outline-dark') }}</a></span> @endIf
        @if ($person->is_retreat_assistant) <span><a href={{ action([\App\Http\Controllers\PersonController::class, 'assistants']) }}>{{ html()->img(asset('images/assistant.png'), 'Retreat Assistants Group')->attribute('title', "Assistants Group")->class('btn btn-outline-dark') }}</a></span> @endIf
        @if ($person->is_bishop) <span><a href={{ action([\App\Http\Controllers\PersonController::class, 'bishops']) }}>{{ html()->img(asset('images/bishop.png'), 'Bishops Group')->attribute('title', "Bishop Group")->class('btn btn-outline-dark') }}</a></span> @endIf
        @if ($person->is_pastor) <span><a href={{ action([\App\Http\Controllers\PersonController::class, 'pastors']) }}>{{ html()->img(asset('images/pastor.png'), 'Pastors Group')->attribute('title', "Pastors Group")->class('btn btn-outline-dark') }}</a></span> @endIf
        @if ($person->is_priest) <span><a href={{ action([\App\Http\Controllers\PersonController::class, 'priests']) }}>{{ html()->img(asset('images/priest.png'), 'Priests Group')->attribute('title', "Priests Group")->class('btn btn-outline-dark') }}</a></span> @endIf
        @if ($person->is_deacon) <span><a href={{ action([\App\Http\Controllers\PersonController::class, 'deacons']) }}>{{ html()->img(asset('images/deacon.png'), 'Deacons Group')->attribute('title', "Deacons Group")->class('btn btn-outline-dark') }}</a></span> @endIf
        @if ($person->is_provincial) <span><a href={{ action([\App\Http\Controllers\PersonController::class, 'provincials']) }}>{{ html()->img(asset('images/provincial.png'), 'Provincials Group')->attribute('title', "Provincials Group")->class('btn btn-outline-dark') }}</a></span> @endIf
        @if ($person->is_superior) <span><a href={{ action([\App\Http\Controllers\PersonController::class, 'superiors']) }}>{{ html()->img(asset('images/superior.png'), 'Superiors Group')->attribute('title', "Superiors Group")->class('btn btn-outline-dark') }}</a></span> @endIf
        @if ($person->is_jesuit) <span><a href={{ action([\App\Http\Controllers\PersonController::class, 'jesuits']) }}>{{ html()->img(asset('images/jesuit.png'), 'Jesuits Group')->attribute('title', "Jesuits Group")->class('btn btn-outline-dark') }}</a></span> @endIf
    </div>
    <div class="col-lg-12">
        {{ html()->form('PUT', route('person.update', [$person->id]))->acceptsFiles()->open() }}
            {{ html()->hidden('id', $person->id) }}
            <div class="row text-center">
                <div class="col-lg-12 mt-2 mb-3">
                    {{ html()->input('image', 'btnSave')->class('btn btn-outline-dark')->attribute('src', asset('images/save.png')) }}
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 text-center my-2">
                {{ html()->a(url('#emergency_contact'), 'Emergency contact')->class('btn btn-outline-dark') }}
                {{ html()->a(url('#addresses'), 'Addresses')->class('btn btn-outline-dark') }}
                {{ html()->a(url('#phones'), 'Phones')->class('btn btn-outline-dark') }}
                {{ html()->a(url('#emails'), 'Emails')->class('btn btn-outline-dark') }}
                {{ html()->a(url('#websites'), 'Websites')->class('btn btn-outline-dark') }}
                {{ html()->a(url('#demographics'), 'Demographics')->class('btn btn-outline-dark') }}
                {{ html()->a(url('#languages'), 'Languages')->class('btn btn-outline-dark') }}
                {{ html()->a(url('#notes'), 'Notes')->class('btn btn-outline-dark') }}
                {{ html()->a(url('#attachments'), 'Attachments')->class('btn btn-outline-dark') }}
                {{ html()->a(url('#groups'), 'Groups')->class('btn btn-outline-dark') }}
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12 col-lg-6" id="basic_info">
                    <h3>Basic Information</h3>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-lg-2 col-md-3">
                                {{ html()->label('Title:', 'prefix_id') }}
                                {{ html()->select('prefix_id', $prefixes, $person->prefix_id)->class('form-control') }}
                            </div>
                            <div class="col-lg-2 col-md-3">
                                {{ html()->label('First:', 'first_name') }}
                                {{ html()->text('first_name', $person->first_name)->class('form-control') }}
                            </div>
                            <div class="col-lg-2 col-md-3">
                                {{ html()->label('Middle:', 'middle_name') }}
                                {{ html()->text('middle_name', $person->middle_name)->class('form-control') }}
                            </div>
                            <div class="col-lg-2 col-md-3">
                                {{ html()->label('Last:', 'last_name') }}
                                {{ html()->text('last_name', $person->last_name)->class('form-control') }}
                            </div>
                            <div class="col-lg-2 col-md-3">
                                {{ html()->label('Suffix:', 'suffix_id') }}
                                {{ html()->select('suffix_id', $suffixes, $person->suffix_id)->class('form-control') }}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3 col-md-6">
                                {{ html()->label('Display name: ', 'display_name') }}
                                {{ html()->text('display_name', $person->display_name)->class('form-control') }}
                            </div>
                            <div class="col-lg-3 col-md-6">
                                {{ html()->label('Sort name: ', 'sort_name') }}
                                {{ html()->text('sort_name', $person->sort_name)->class('form-control') }}
                            </div>
                            <div class="col-lg-3 col-md-6">
                                {{ html()->label('AGC Household: ', 'agc_household_name') }}
                                {{ html()->text('agc_household_name', $person->agc_household_name)->class('form-control') }}
                            </div>
                            <div class="col-lg-3 col-md-6">
                                {{ html()->label('Nickname: ', 'nick_name') }}
                                {{ html()->text('nick_name', $person->nick_name)->class('form-control') }}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-2 col-md-3">
                                {{ html()->label('Contact type: ', 'contact_type') }}
                                {{ html()->select('contact_type', $contact_types, $person->contact_type)->class('form-control') }}
                            </div>
                            <div class="col-lg-2 col-md-3">
                                {{ html()->label('Subcontact type: ', 'subcontact_type') }}
                                {{ html()->select('subcontact_type', $subcontact_types, $person->subcontact_type)->class('form-control') }}
                            </div>
                        </div>

                        <hr>

                        @can('create-avatar')
                            <div class="row">
                                <div class="col-lg-3 col-md-4">
                                    {{ html()->label('Upload Avatar:', 'avatar') }}
                                    {{ html()->file('avatar')->class('form-control-file') }}
                                </div>
                            </div>
                            <hr>
                        @endCan
                    </div>
                </div>
                <div class="col-lg-12 alert alert-danger alert-important" id="emergency_contact">
                    <h3>Emergency Contact Information</h3>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-lg-3 col-md-6">
                                {{ html()->label('Name: ', 'emergency_contact_name') }}
                                {{ html()->text('emergency_contact_name', $person->emergency_contact_name)->class('form-control') }}
                            </div>
                            <div class="col-lg-3 col-md-6">
                                {{ html()->label('Relationship: ', 'emergency_contact_relationship') }}
                                {{ html()->text('emergency_contact_relationship', $person->emergency_contact_relationship)->class('form-control') }}
                            </div>
                            <div class="col-lg-3 col-md-6">
                                {{ html()->label('Phone: ', 'emergency_contact_phone') }}
                                {{ html()->text('emergency_contact_phone', $person->emergency_contact_phone)->class('form-control') }}
                            </div>
                            <div class="col-lg-3 col-md-6">
                                {{ html()->label('Alt. Phone: ', 'emergency_contact_phone_alternate') }}
                                {{ html()->text('emergency_contact_phone_alternate', $person->emergency_contact_phone_alternate)->class('form-control') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <hr>

            <div class="row">
                <div class="col-lg-3 col-md-4" id="contact_info">
                    <h3>Contact Information</h3>

                    {{ html()->label('Preferred communication method:', 'preferred_communication_method_id') }}
                    {{ html()->select('preferred_communication_method_id', $preferred_communication_methods, $person->preferred_communication_method)->class('form-control') }}
                </div>
            </div>

            <hr>

            <div class="row">
                <div class="col-lg-12" id="addresses">
                    <h3>Addresses</h3>
                </div>
                <div class="col-lg-12">
                    @include('persons.update.addresses')
                </div>
            </div>

            <hr>

            <div class="row">
                <div class="col-lg-12" id="phones">
                    <h3>Phone Numbers</h3>
                </div>
                <div class="col-lg-12">
                    @include('persons.update.phones')
                </div>
            </div>

            <hr>

            <div class="row">
                <div class="col-lg-12" id="emails">
                    <h3>Email Addresses</h3>
                </div>
                <div class="col-lg-12">
                    @include('persons.update.emails')
                </div>
            </div>

            <hr>

            <div class="row">
                <div class="col-lg-12" id="websites">
                    <h3>Websites (URLs)</h3>
                </div>
                <div class="col-lg-12">
                    @include('persons.update.urls')
                </div>
            </div>

            <hr>


            <div class="row">
                <div class="col-lg-12" id="demographics">
                    <h3>Demographics</h3>
                </div>
                <div class="col-lg-12">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-lg-2 col-md-4">
                                {{ html()->label('Gender:', 'gender_id') }}
                                {{ html()->select('gender_id', $genders, $person->gender_id)->class('form-control') }}
                            </div>
                            <div class="col-lg-3 col-md-4">
                                {{ html()->label('Birth Date:', 'birth_date') }}
                                {{ html()->date('birth_date', $person->birth_date)->class('form-control bg-white flatpickr-date') }}
                            </div>
                            <div class="col-lg-3 col-md-4">
                                {{ html()->label('Deceased Date:', 'deceased_date') }}
                                {{ html()->date('deceased_date', $person->deceased_date)->class('form-control bg-white flatpickr-date') }}
                            </div>

                            <div class="col-lg-3 col-md-4">
                                <div class="form-check mt-4">
                                    {{ html()->checkbox('is_deceased', $person->is_deceased, 1)->class('form-check-input')->id('is_deceased') }}
                                    {{ html()->label('Is Deceased', 'is_deceased')->class('form-check-label')->for('is_deceased') }}
                                </div>
                            </div>

                        </div>


                        <div class="row">
                            <div class="col-lg-2 col-md-3">
                                {{ html()->label('Ethnicity:', 'ethnicity_id') }}
                                {{ html()->select('ethnicity_id', $ethnicities, $person->ethnicity_id)->class('form-control') }}
                            </div>
                            <div class="col-lg-2 col-md-3">
                                {{ html()->label('Religion:', 'religion_id') }}
                                {{ html()->select('religion_id', $religions, $person->religion_id)->class('form-control') }}
                            </div>
                            <div class="col-lg-5 col-md-6">
                                {{ html()->label('Parish:', 'parish_id') }}
                                {{ html()->select('parish_id', $parish_list, $person->parish_id)->class('form-control') }}
                            </div>
                            <div class="col-lg-3 col-md-4">
                                {{ html()->label('Occupation:', 'occupation_id') }}
                                {{ html()->select('occupation_id', $occupations, $person->occupation_id)->class('form-control') }}
                            </div>
                        </div>

                        <hr>

                        <div class="row">
                            <div class="col-lg-3 col-md-4 mr-2" id="languages">
                                {{ html()->label('Languages:', 'languages') }}
                                {{ html()->multiselect('languages[]', $languages, $person->languages->pluck('id')->toArray())->id('languages')->class('form-control select2') }}
                            </div>
                            <div class="col-lg-3 col-md-4 ml-2">
                                {{ html()->label('Preferred Language:', 'preferred_language_id') }}
                                @if (empty($person->preferred_language_id))
                                    {{ html()->select('preferred_language_id', $languages, 0)->class('form-control') }}
                                @else
                                    {{ html()->select('preferred_language_id', $languages, $person->preferred_language_id)->class('form-control') }}
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <hr>

            <div class="row">
                <div class="col-lg-12 col-lg-6" id="notes">
                    <h3>Notes</h3>
                        <div class="row">
                            <div class="col-lg-3 col-md-6 alert alert-info alert-important">
                                {{ html()->label('Health Notes:', 'note_health') }}
                                {{ html()->textarea('note_health', $person->note_health)->class('form-control')->rows('3') }}
                            </div>
                            <div class="col-lg-3 col-md-6 alert alert-info alert-important">
                                {{ html()->label('Dietary Notes:', 'note_dietary') }}
                                {{ html()->textarea('note_dietary', $person->note_dietary)->class('form-control')->rows('3') }}
                            </div>
                            <div class="col-lg-3 col-md-6">
                                {{ html()->label('General Notes:', 'note_contact') }}
                                {{ html()->textarea('note_contact', $person->note_contact)->class('form-control')->rows('3') }}
                            </div>
                            <div class="col-lg-3 col-md-6">
                                {{ html()->label('Room Preference:', 'note_room_preference') }}
                                {{ html()->textarea('note_room_preference', $person->note_room_preference)->class('form-control')->rows('3') }}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3 col-md-4 mt-2">
                                {{ html()->label('Referral sources:', 'referrals') }}
                                {{ html()->multiselect('referrals[]', $referrals, $person->referrals->pluck('id')->toArray())->id('referrals')->class('form-control select2') }}
                            </div>
                        </div>

                </div>
            </div>

            <hr>

            <div class="row">

                @can('create-attachment')
                <div class="col-lg-12" id="attachments">
                    <h3>Attachments</h3>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-lg-3 col-md-6">
                                {{ html()->label('Attachment (max 10M): ', 'attachment') }}
                                {{ html()->file('attachment')->class('form-control') }}
                            </div>
                            <div class="col-lg-3 col-md-6">
                                {{ html()->label('Description: (max 200)', 'attachment_description') }}
                                {{ html()->text('attachment_description')->class('form-control') }}
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                @endCan
            </div>

            <hr>
            
            <div class="row">
                <div class="col-lg-12" id="groups">
                    <h3>Groups and Relationships</h3>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-2 col-md-3">
                    <div class="form-check">
                        {{ html()->checkbox('is_retreatant', $person->is_retreatant, 1)->class('form-check-input') }}
                        {{ html()->label('Retreatant', 'is_retreatant')->class('form-check-label') }}
                    </div>
                </div>
                <div class="col-lg-2 col-md-3">
                    <div class="form-check">
                        {{ html()->checkbox('is_donor', $person->is_donor, 1)->class('form-check-input') }}
                        {{ html()->label('Donor', 'is_donor')->class('form-check-label') }}
                    </div>
                </div>
                <div class="col-lg-2 col-md-3">
                    <div class="form-check">
                        {{ html()->checkbox('is_steward', $person->is_steward, 1)->class('form-check-input') }}
                        {{ html()->label('Steward', 'is_steward')->class('form-check-label') }}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-2 col-md-3">
                    <div class="form-check">
                        {{ html()->checkbox('is_ambassador', $person->is_ambassador, 1)->class('form-check-input') }}
                        {{ html()->label('Ambassador', 'is_ambassador')->class('form-check-label') }}
                    </div>
                </div>
                <div class="col-lg-2 col-md-3">
                    <div class="form-check">
                        {{ html()->checkbox('is_volunteer', $person->is_volunteer, 1)->class('form-check-input') }}
                        {{ html()->label('Volunteer', 'is_volunteer')->class('form-check-label') }}
                    </div>
                </div>
                <div class="col-lg-2 col-md-3">
                    <div class="form-check">
                        {{ html()->checkbox('is_board', $person->is_board_member, 1)->class('form-check-input') }}
                        {{ html()->label('Board Member', 'is_board')->class('form-check-label') }}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-2 col-md-3">
                    <div class="form-check">
                        {{ html()->checkbox('is_bishop', $person->is_bishop, 1)->class('form-check-input') }}
                        {{ html()->label('Bishop', 'is_bishop')->class('form-check-label') }}
                    </div>
                </div>
                <div class="col-lg-2 col-md-3">
                    <div class="form-check">
                        {{ html()->checkbox('is_pastor', $person->is_pastor, 1)->class('form-check-input') }}
                        {{ html()->label('Pastor', 'is_pastor')->class('form-check-label') }}
                    </div>
                </div>
                <div class="col-lg-2 col-md-3">
                    <div class="form-check">
                        {{ html()->checkbox('is_priest', $person->is_priest, 1)->class('form-check-input') }}
                        {{ html()->label('Priest', 'is_priest')->class('form-check-label') }}
                    </div>
                </div>
                <div class="col-lg-2 col-md-3">
                    <div class="form-check">
                        {{ html()->checkbox('is_deacon', $person->is_deacon, 1)->class('form-check-input') }}
                        {{ html()->label('Deacon', 'is_deacon')->class('form-check-label') }}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-2 col-md-3">
                    <div class="form-check">
                        {{ html()->checkbox('is_jesuit', $person->is_jesuit, 1)->class('form-check-input') }}
                        {{ html()->label('Jesuit', 'is_jesuit')->class('form-check-label') }}
                    </div>
                </div>
                <div class="col-lg-2 col-md-3">
                    <div class="form-check">
                        {{ html()->checkbox('is_provincial', $person->is_provincial, 1)->class('form-check-input') }}
                        {{ html()->label('Provincial', 'is_provincial')->class('form-check-label') }}
                    </div>
                </div>
                <div class="col-lg-2 col-md-3">
                    <div class="form-check">
                        {{ html()->checkbox('is_superior', $person->is_superior, 1)->class('form-check-input') }}
                        {{ html()->label('Superior', 'is_superior')->class('form-check-label') }}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-2 col-md-3">
                    <div class="form-check">
                        {{ html()->checkbox('is_staff', $person->is_staff, 1)->class('form-check-input') }}
                        {{ html()->label('Staff', 'is_staff')->class('form-check-label') }}
                    </div>
                </div>
                <div class="col-lg-2 col-md-3">
                    <div class="form-check">
                        {{ html()->checkbox('is_director', $person->is_retreat_director, 1)->class('form-check-input') }}
                        {{ html()->label('Retreat Director', 'is_director')->class('form-check-label') }}
                    </div>
                </div>
                <div class="col-lg-2 col-md-3">
                    <div class="form-check">
                        {{ html()->checkbox('is_innkeeper', $person->is_retreat_innkeeper, 1)->class('form-check-input') }}
                        {{ html()->label('Retreat Innkeeper', 'is_innkeeper')->class('form-check-label') }}
                    </div>
                </div>
                <div class="col-lg-2 col-md-3">
                    <div class="form-check">
                        {{ html()->checkbox('is_assistant', $person->is_retreat_assistant, 1)->class('form-check-input') }}
                        {{ html()->label('Retreat Assistant', 'is_assistant')->class('form-check-label') }}
                    </div>
                </div>
            </div>

            </div>
            <div class="row text-center" id="commands">
                <div class="col-lg-12 mt-2 mb-3">
                    {{ html()->input('image', 'btnSave')->class('btn btn-outline-dark')->attribute('src', asset('images/save.png')) }}
                </div>
            </div>
        {{ html()->form()->close() }}
    </div>
</div>
@stop
