@extends('template')
@section('content')

<div class="row bg-cover">
    <div class="col-lg-12 text-center">
        {!!$person->avatar_large_link!!}
        <h2>Edit: {{ $person->full_name }}</h2>
    </div>
    <div class="col-lg-12 text-center">
        @if ($person->is_board_member) <span><a href={{ action([\App\Http\Controllers\PersonController::class, 'boardmembers']) }}>{!! Html::image('images/board.png', 'Board Members Group',array('title'=>"Board Members Group",'class' => 'btn btn-outline-dark')) !!}</a></span> @endIf
        @if ($person->is_ambassador) <span><a href={{ action([\App\Http\Controllers\PersonController::class, 'ambassadors']) }}>{!! Html::image('images/ambassador.png', 'Ambassador Group',array('title'=>"Ambassadors Group",'class' => 'btn btn-outline-dark')) !!}</a></span> @endIf
        @if ($person->is_staff) <span><a href={{ action([\App\Http\Controllers\PersonController::class, 'staff']) }}>{!! Html::image('images/employee.png', 'Staff Group',array('title'=>"Employees Group",'class' => 'btn btn-outline-dark')) !!}</a></span> @endIf
        @if ($person->is_steward) <span><a href={{ action([\App\Http\Controllers\PersonController::class, 'stewards']) }}>{!! Html::image('images/steward.png', 'Steward Group',array('title'=>"Stewards Group",'class' => 'btn btn-outline-dark')) !!}</a></span> @endIf
        @if ($person->is_volunteer) <span><a href={{ action([\App\Http\Controllers\PersonController::class, 'volunteers']) }}>{!! Html::image('images/volunteer.png', 'Volunteers Group',array('title'=>"Volunteers Group",'class' => 'btn btn-outline-dark')) !!}</a></span> @endIf
        @if ($person->is_retreat_director) <span><a href={{ action([\App\Http\Controllers\PersonController::class, 'directors']) }}>{!! Html::image('images/director.png', 'Retreat Directors Group',array('title'=>"Directors Group",'class' => 'btn btn-outline-dark')) !!}</a></span> @endIf
        @if ($person->is_retreat_innkeeper) <span><a href={{ action([\App\Http\Controllers\PersonController::class, 'innkeepers']) }}>{!! Html::image('images/innkeeper.png', 'Retreat Innkeepers Group',array('title'=>"Innkeepers Group",'class' => 'btn btn-outline-dark')) !!}</a></span> @endIf
        @if ($person->is_retreat_assistant) <span><a href={{ action([\App\Http\Controllers\PersonController::class, 'assistants']) }}>{!! Html::image('images/assistant.png', 'Retreat Assistants Group',array('title'=>"Assistants Group",'class' => 'btn btn-outline-dark')) !!}</a></span> @endIf
        @if ($person->is_bishop) <span><a href={{ action([\App\Http\Controllers\PersonController::class, 'bishops']) }}>{!! Html::image('images/bishop.png', 'Bishops Group',array('title'=>"Bishop Group",'class' => 'btn btn-outline-dark')) !!}</a></span> @endIf
        @if ($person->is_pastor) <span><a href={{ action([\App\Http\Controllers\PersonController::class, 'pastors']) }}>{!! Html::image('images/pastor.png', 'Pastors Group',array('title'=>"Pastors Group",'class' => 'btn btn-outline-dark')) !!}</a></span> @endIf
        @if ($person->is_priest) <span><a href={{ action([\App\Http\Controllers\PersonController::class, 'priests']) }}>{!! Html::image('images/priest.png', 'Priests Group',array('title'=>"Priests Group",'class' => 'btn btn-outline-dark')) !!}</a></span> @endIf
        @if ($person->is_deacon) <span><a href={{ action([\App\Http\Controllers\PersonController::class, 'deacons']) }}>{!! Html::image('images/deacon.png', 'Deacons Group',array('title'=>"Deacons Group",'class' => 'btn btn-outline-dark')) !!}</a></span> @endIf
        @if ($person->is_provincial) <span><a href={{ action([\App\Http\Controllers\PersonController::class, 'provincials']) }}>{!! Html::image('images/provincial.png', 'Provincials Group',array('title'=>"Provincials Group",'class' => 'btn btn-outline-dark')) !!}</a></span> @endIf
        @if ($person->is_superior) <span><a href={{ action([\App\Http\Controllers\PersonController::class, 'superiors']) }}>{!! Html::image('images/superior.png', 'Superiors Group',array('title'=>"Superiors Group",'class' => 'btn btn-outline-dark')) !!}</a></span> @endIf
        @if ($person->is_jesuit) <span><a href={{ action([\App\Http\Controllers\PersonController::class, 'jesuits']) }}>{!! Html::image('images/jesuit.png', 'Jesuits Group',array('title'=>"Jesuits Group",'class' => 'btn btn-outline-dark')) !!}</a></span> @endIf
    </div>
    <div class="col-lg-12">
        {!! Form::open(['method' => 'PUT', 'files'=>'true', 'route' => ['person.update', $person->id]]) !!}
            {!! Form::hidden('id', $person->id) !!}
            <div class="row text-center">
                <div class="col-lg-12 mt-2 mb-3">
                    {!! Form::image('images/save.png','btnSave',['class' => 'btn btn-outline-dark']) !!}
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 text-center my-2">
                {!! Html::link('#emergency_contact','Emergency contact',array('class' => 'btn btn-outline-dark')) !!}
                {!! Html::link('#addresses','Addresses',array('class' => 'btn btn-outline-dark')) !!}
                {!! Html::link('#phones','Phones',array('class' => 'btn btn-outline-dark')) !!}
                {!! Html::link('#emails','Emails',array('class' => 'btn btn-outline-dark')) !!}
                {!! Html::link('#websites','Websites',array('class' => 'btn btn-outline-dark')) !!}
                {!! Html::link('#demographics','Demographics',array('class' => 'btn btn-outline-dark')) !!}
                {!! Html::link('#languages','Languages',array('class' => 'btn btn-outline-dark')) !!}
                {!! Html::link('#notes','Notes',array('class' => 'btn btn-outline-dark')) !!}
                {!! Html::link('#attachments','Attachments',array('class' => 'btn btn-outline-dark')) !!}
                {!! Html::link('#groups','Groups',array('class' => 'btn btn-outline-dark')) !!}
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12 col-lg-6" id="basic_info">
                    <h3>Basic Information</h3>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-lg-2 col-md-3">
                                {!! Form::label('prefix_id', 'Title:')  !!}
                                {!! Form::select('prefix_id', $prefixes, $person->prefix_id, ['class' => 'form-control']) !!}
                            </div>
                            <div class="col-lg-2 col-md-3">
                                {!! Form::label('first_name', 'First:')  !!}
                                {!! Form::text('first_name', $person->first_name, ['class' => 'form-control']) !!}
                            </div>
                            <div class="col-lg-2 col-md-3">
                                {!! Form::label('middle_name', 'Middle:')  !!}
                                {!! Form::text('middle_name', $person->middle_name, ['class' => 'form-control']) !!}
                            </div>
                            <div class="col-lg-2 col-md-3">
                                {!! Form::label('last_name', 'Last:')  !!}
                                {!! Form::text('last_name', $person->last_name, ['class' => 'form-control']) !!}
                            </div>
                            <div class="col-lg-2 col-md-3">
                                {!! Form::label('suffix_id', 'Suffix:')  !!}
                                {!! Form::select('suffix_id', $suffixes, $person->suffix_id, ['class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3 col-md-6">
                                {!! Form::label('display_name', 'Display name: ')  !!}
                                {!! Form::text('display_name', $person->display_name, ['class' => 'form-control']) !!}
                            </div>
                            <div class="col-lg-3 col-md-6">
                                {!! Form::label('sort_name', 'Sort name: ')  !!}
                                {!! Form::text('sort_name', $person->sort_name, ['class' => 'form-control']) !!}
                            </div>
                            <div class="col-lg-3 col-md-6">
                                {!! Form::label('agc_household_name', 'AGC Household: ')  !!}
                                {!! Form::text('agc_household_name', $person->agc_household_name, ['class' => 'form-control']) !!}
                            </div>
                            <div class="col-lg-3 col-md-6">
                                {!! Form::label('nick_name', 'Nickname: ')  !!}
                                {!! Form::text('nick_name', $person->nick_name, ['class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-2 col-md-3">
                                {!! Form::label('contact_type', 'Contact type: ')  !!}
                                {!! Form::select('contact_type', $contact_types, $person->contact_type, ['class' => 'form-control']) !!}
                            </div>
                            <div class="col-lg-2 col-md-3">
                                {!! Form::label('subcontact_type', 'Subcontact type: ')  !!}
                                {!! Form::select('subcontact_type', $subcontact_types, $person->subcontact_type, ['class' => 'form-control']) !!}
                            </div>
                        </div>

                        <hr>

                        @can('create-avatar')
                            <div class="row">
                                <div class="col-lg-3 col-md-4">
                                    {!! Form::label('avatar', 'Upload Avatar:') !!}
                                    {!! Form::file('avatar',['class' => 'form-control-file']) !!}
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
                                {!! Form::label('emergency_contact_name', 'Name: ')  !!}
                                {!! Form::text('emergency_contact_name', $person->emergency_contact_name, ['class' => 'form-control']) !!}
                            </div>
                            <div class="col-lg-3 col-md-6">
                                {!! Form::label('emergency_contact_relationship', 'Relationship: ')  !!}
                                {!! Form::text('emergency_contact_relationship', $person->emergency_contact_relationship, ['class' => 'form-control']) !!}
                            </div>
                            <div class="col-lg-3 col-md-6">
                                {!! Form::label('emergency_contact_phone', 'Phone: ')  !!}
                                {!! Form::text('emergency_contact_phone', $person->emergency_contact_phone, ['class' => 'form-control']) !!}
                            </div>
                            <div class="col-lg-3 col-md-6">
                                {!! Form::label('emergency_contact_phone_alternate', 'Alt. Phone: ')  !!}
                                {!! Form::text('emergency_contact_phone_alternate', $person->emergency_contact_phone_alternate, ['class' => 'form-control']) !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <hr>

            <div class="row">
                <div class="col-lg-3 col-md-4" id="contact_info">
                    <h3>Contact Information</h3>

                    {!! Form::label('preferred_communication_method_id', 'Preferred communication method:') !!}
                    {!! Form::select('preferred_communication_method_id', $preferred_communication_methods, $person->preferred_communication_method, ['class' => 'form-control']) !!}
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
                                {!! Form::label('gender_id', 'Gender:')  !!}
                                {!! Form::select('gender_id', $genders, $person->gender_id, ['class' => 'form-control']) !!}
                            </div>
                            <div class="col-lg-3 col-md-4">
                                {!! Form::label('birth_date', 'Birth Date:') !!}
                                {!! Form::date('birth_date', $person->birth_date, ['class'=>'form-control bg-white flatpickr-date']) !!}
                            </div>
                            <div class="col-lg-3 col-md-4">
                                {!! Form::label('deceased_date', 'Deceased Date:')  !!}
                                {!! Form::date('deceased_date', $person->deceased_date, ['class'=>'form-control bg-white flatpickr-date']) !!}
                            </div>

                            <div class="col-lg-3 col-md-4">
                                <div class="form-check mt-4">
                                    {!! Form::checkbox('is_deceased', 1, $person->is_deceased,['class' => 'form-check-input', 'id' =>
                                    'is_deceased']) !!}
                                    {!! Form::label('is_deceased', 'Is Deceased', ['class' => 'form-check-label', 'for' =>
                                    'is_deceased']) !!}
                                </div>
                            </div>

                        </div>


                        <div class="row">
                            <div class="col-lg-2 col-md-3">
                                {!! Form::label('ethnicity_id', 'Ethnicity:')  !!}
                                {!! Form::select('ethnicity_id', $ethnicities, $person->ethnicity_id, ['class' => 'form-control']) !!}
                            </div>
                            <div class="col-lg-2 col-md-3">
                                {!! Form::label('religion_id', 'Religion:')  !!}
                                {!! Form::select('religion_id', $religions, $person->religion_id, ['class' => 'form-control']) !!}
                            </div>
                            <div class="col-lg-5 col-md-6">
                                {!! Form::label('parish_id', 'Parish:')  !!}
                                {!! Form::select('parish_id', $parish_list, $person->parish_id, ['class' => 'form-control']) !!}
                            </div>
                            <div class="col-lg-3 col-md-4">
                                {!! Form::label('occupation_id', 'Occupation:')  !!}
                                {!! Form::select('occupation_id', $occupations, $person->occupation_id, ['class' => 'form-control']) !!}
                            </div>
                        </div>

                        <hr>

                        <div class="row">
                            <div class="col-lg-3 col-md-4 mr-2" id="languages">
                                {!! Form::label('languages', 'Languages:') !!}
                                {!! Form::select('languages[]', $languages, $person->languages->pluck('id')->toArray(), ['id'=>'languages', 'class' => 'form-control select2', 'multiple' => 'multiple']) !!}
                            </div>
                            <div class="col-lg-3 col-md-4 ml-2">
                                {!! Form::label('preferred_language_id', 'Preferred Language:')  !!}
                                @if (empty($person->preferred_language_id))
                                    {!! Form::select('preferred_language_id', $languages, 0, ['class' => 'form-control']) !!}
                                @else
                                    {!! Form::select('preferred_language_id', $languages, $person->preferred_language_id, ['class' => 'form-control']) !!}
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
                                {!! Form::label('note_health', 'Health Notes:')  !!}
                                {!! Form::textarea('note_health', $person->note_health, ['class' => 'form-control','rows'=>'3']) !!}
                            </div>
                            <div class="col-lg-3 col-md-6 alert alert-info alert-important">
                                {!! Form::label('note_dietary', 'Dietary Notes:')  !!}
                                {!! Form::textarea('note_dietary', $person->note_dietary, ['class' => 'form-control','rows'=>'3']) !!}
                            </div>
                            <div class="col-lg-3 col-md-6">
                                {!! Form::label('note_contact', 'General Notes:')  !!}
                                {!! Form::textarea('note_contact', $person->note_contact, ['class' => 'form-control','rows'=>'3']) !!}
                            </div>
                            <div class="col-lg-3 col-md-6">
                                {!! Form::label('note_room_preference', 'Room Preference:')  !!}
                                {!! Form::textarea('note_room_preference', $person->note_room_preference, ['class' => 'form-control','rows'=>'3']) !!}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3 col-md-4 mt-2">
                                {!! Form::label('referrals', 'Referral sources:') !!}
                                {!! Form::select('referrals[]', $referrals, $person->referrals->pluck('id')->toArray(), ['id'=>'referrals', 'class' => 'form-control select2','multiple' => 'multiple']) !!}
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
                                {!! Form::label('attachment', 'Attachment (max 10M): ')  !!}
                                {!! Form::file('attachment',['class' => 'form-control']); !!}
                            </div>
                            <div class="col-lg-3 col-md-6">
                                {!! Form::label('attachment_description', 'Description: (max 200)')  !!}
                                {!! Form::text('attachment_description', NULL, ['class' => 'form-control']) !!}
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
                        {!! Form::checkbox('is_retreatant', 1, $person->is_retreatant,['class' => 'form-check-input']) !!}
                        {!! Form::label('is_retreatant', 'Retreatant', ['class' => 'form-check-label']) !!}
                    </div>
                </div>
                <div class="col-lg-2 col-md-3">
                    <div class="form-check">
                        {!! Form::checkbox('is_donor', 1, $person->is_donor, ['class' => 'form-check-input']) !!}
                        {!! Form::label('is_donor', 'Donor', ['class' => 'form-check-label'])  !!}
                    </div>
                </div>
                <div class="col-lg-2 col-md-3">
                    <div class="form-check">
                        {!! Form::checkbox('is_steward', 1, $person->is_steward, ['class' => 'form-check-input']) !!}
                        {!! Form::label('is_steward', 'Steward', ['class' => 'form-check-label'])  !!}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-2 col-md-3">
                    <div class="form-check">
                        {!! Form::checkbox('is_ambassador', 1, $person->is_ambassador,['class' => 'form-check-input']) !!}
                        {!! Form::label('is_ambassador', 'Ambassador', ['class' => 'form-check-label']) !!}
                    </div>
                </div>
                <div class="col-lg-2 col-md-3">
                    <div class="form-check">
                        {!! Form::checkbox('is_volunteer', 1, $person->is_volunteer,['class' => 'form-check-input']) !!}
                        {!! Form::label('is_volunteer', 'Volunteer', ['class' => 'form-check-label'])  !!}
                    </div>
                </div>
                <div class="col-lg-2 col-md-3">
                    <div class="form-check">
                        {!! Form::checkbox('is_board', 1, $person->is_board_member,['class' => 'form-check-input']) !!}
                        {!! Form::label('is_board', 'Board Member', ['class' => 'form-check-label'])  !!}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-2 col-md-3">
                    <div class="form-check">
                        {!! Form::checkbox('is_bishop', 1, $person->is_bishop,['class' => 'form-check-input']) !!}
                        {!! Form::label('is_bishop', 'Bishop', ['class' => 'form-check-label']) !!}
                    </div>
                </div>
                <div class="col-lg-2 col-md-3">
                    <div class="form-check">
                        {!! Form::checkbox('is_pastor', 1, $person->is_pastor,['class' => 'form-check-input']) !!}
                        {!! Form::label('is_pastor', 'Pastor', ['class' => 'form-check-label'])  !!}
                    </div>
                </div>
                <div class="col-lg-2 col-md-3">
                    <div class="form-check">
                        {!! Form::checkbox('is_priest', 1, $person->is_priest,['class' => 'form-check-input']) !!}
                        {!! Form::label('is_priest', 'Priest', ['class' => 'form-check-label'])  !!}
                    </div>
                </div>
                <div class="col-lg-2 col-md-3">
                    <div class="form-check">
                        {!! Form::checkbox('is_deacon', 1, $person->is_deacon,['class' => 'form-check-input']) !!}
                        {!! Form::label('is_deacon', 'Deacon', ['class' => 'form-check-label'])  !!}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-2 col-md-3">
                    <div class="form-check">
                        {!! Form::checkbox('is_jesuit', 1, $person->is_jesuit,['class' => 'form-check-input']) !!}
                        {!! Form::label('is_jesuit', 'Jesuit', ['class' => 'form-check-label']) !!}
                    </div>
                </div>
                <div class="col-lg-2 col-md-3">
                    <div class="form-check">
                        {!! Form::checkbox('is_provincial', 1, $person->is_provincial,['class' => 'form-check-input']) !!}
                        {!! Form::label('is_provincial', 'Provincial', ['class' => 'form-check-label']) !!}
                    </div>
                </div>
                <div class="col-lg-2 col-md-3">
                    <div class="form-check">
                        {!! Form::checkbox('is_superior', 1, $person->is_superior,['class' => 'form-check-input']) !!}
                        {!! Form::label('is_superior', 'Superior', ['class' => 'form-check-label']) !!}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-2 col-md-3">
                    <div class="form-check">
                        {!! Form::checkbox('is_staff', 1, $person->is_staff,['class' => 'form-check-input']) !!}
                        {!! Form::label('is_staff', 'Staff', ['class' => 'form-check-label'])  !!}
                    </div>
                </div>
                <div class="col-lg-2 col-md-3">
                    <div class="form-check">
                        {!! Form::checkbox('is_director', 1, $person->is_retreat_director,['class' => 'form-check-input']) !!}
                        {!! Form::label('is_director', 'Retreat Director', ['class' => 'form-check-label'])  !!}
                    </div>
                </div>
                <div class="col-lg-2 col-md-3">
                    <div class="form-check">
                        {!! Form::checkbox('is_innkeeper', 1, $person->is_retreat_innkeeper,['class' => 'form-check-input']) !!}
                        {!! Form::label('is_innkeeper', 'Retreat Innkeeper', ['class' => 'form-check-label'])  !!}
                    </div>
                </div>
                <div class="col-lg-2 col-md-3">
                    <div class="form-check">
                        {!! Form::checkbox('is_assistant', 1, $person->is_retreat_assistant,['class' => 'form-check-input']) !!}
                        {!! Form::label('is_assistant', 'Retreat Assistant', ['class' => 'form-check-label'])  !!}
                    </div>
                </div>
            </div>

            </div>
            <div class="row text-center" id="commands">
                <div class="col-lg-12 mt-2 mb-3">
                    {!! Form::image('images/save.png','btnSave',['class' => 'btn btn-outline-dark']) !!}
                </div>
            </div>
        {!! Form::close() !!}
    </div>
</div>
@stop
