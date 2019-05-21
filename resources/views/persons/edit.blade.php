@extends('template')
@section('content')

<div class="row bg-cover">
    <div class="col-12 text-center">
        {!!$person->avatar_large_link!!}
        <h1>Edit: {{ $person->full_name }}</h1>
    </div>
    <div class="col-12 text-center">
        @if ($person->is_board_member) <span><a href={{ action('PersonController@boardmembers') }}>{!! Html::image('/images/board.png', 'Board Members Group',array('title'=>"Board Members Group",'class' => 'btn btn-outline-dark')) !!}</a></span> @endIf
        @if ($person->is_captain) <span><a href={{ action('PersonController@captains') }}>{!! Html::image('/images/captain.png', 'Captains Group',array('title'=>"Captains Group",'class' => 'btn btn-outline-dark')) !!}</a></span> @endIf
        @if ($person->is_staff) <span><a href={{ action('PersonController@staff') }}>{!! Html::image('/images/employee.png', 'Staff Group',array('title'=>"Employees Group",'class' => 'btn btn-outline-dark')) !!}</a></span> @endIf
        @if ($person->is_steward) <span><a href={{ action('PersonController@stewards') }}>{!! Html::image('/images/steward.png', 'Steward Group',array('title'=>"Stewards Group",'class' => 'btn btn-outline-dark')) !!}</a></span> @endIf
        @if ($person->is_volunteer) <span><a href={{ action('PersonController@volunteers') }}>{!! Html::image('/images/volunteer.png', 'Volunteers Group',array('title'=>"Volunteers Group",'class' => 'btn btn-outline-dark')) !!}</a></span> @endIf
        @if ($person->is_retreat_director) <span><a href={{ action('PersonController@directors') }}>{!! Html::image('/images/director.png', 'Retreat Directors Group',array('title'=>"Directors Group",'class' => 'btn btn-outline-dark')) !!}</a></span> @endIf
        @if ($person->is_retreat_innkeeper) <span><a href={{ action('PersonController@innkeepers') }}>{!! Html::image('/images/innkeeper.png', 'Retreat Innkeepers Group',array('title'=>"Innkeepers Group",'class' => 'btn btn-outline-dark')) !!}</a></span> @endIf
        @if ($person->is_retreat_assistant) <span><a href={{ action('PersonController@assistants') }}>{!! Html::image('/images/assistant.png', 'Retreat Assistants Group',array('title'=>"Assistants Group",'class' => 'btn btn-outline-dark')) !!}</a></span> @endIf
        @if ($person->is_bishop) <span><a href={{ action('PersonController@bishops') }}>{!! Html::image('/images/bishop.png', 'Bishops Group',array('title'=>"Bishop Group",'class' => 'btn btn-outline-dark')) !!}</a></span> @endIf
        @if ($person->is_pastor) <span><a href={{ action('PersonController@pastors') }}>{!! Html::image('/images/pastor.png', 'Pastors Group',array('title'=>"Pastors Group",'class' => 'btn btn-outline-dark')) !!}</a></span> @endIf
        @if ($person->is_priest) <span><a href={{ action('PersonController@priests') }}>{!! Html::image('/images/priest.png', 'Priests Group',array('title'=>"Priests Group",'class' => 'btn btn-outline-dark')) !!}</a></span> @endIf
        @if ($person->is_deacon) <span><a href={{ action('PersonController@deacons') }}>{!! Html::image('/images/deacon.png', 'Deacons Group',array('title'=>"Deacons Group",'class' => 'btn btn-outline-dark')) !!}</a></span> @endIf
        @if ($person->is_provincial) <span><a href={{ action('PersonController@provincials') }}>{!! Html::image('/images/provincial.png', 'Provincials Group',array('title'=>"Provincials Group",'class' => 'btn btn-outline-dark')) !!}</a></span> @endIf
        @if ($person->is_superior) <span><a href={{ action('PersonController@superiors') }}>{!! Html::image('/images/superior.png', 'Superiors Group',array('title'=>"Superiors Group",'class' => 'btn btn-outline-dark')) !!}</a></span> @endIf
        @if ($person->is_jesuit) <span><a href={{ action('PersonController@jesuits') }}>{!! Html::image('/images/jesuit.png', 'Jesuits Group',array('title'=>"Jesuits Group",'class' => 'btn btn-outline-dark')) !!}</a></span> @endIf 
    </div>
    <div class="col-12">
        {!! Form::open(['method' => 'PUT', 'files'=>'true', 'route' => ['person.update', $person->id]]) !!}
            {!! Form::hidden('id', $person->id) !!}
            <div class="row text-center">
                <div class="col-12 mt-2 mb-3">
                    {!! Form::image('/images/save.png','btnSave',['class' => 'btn btn-outline-dark']) !!}
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-lg-6">
                    <h2>Basic Information</h2>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-4">
                                {!! Form::label('prefix_id', 'Title:')  !!}
                                {!! Form::select('prefix_id', $prefixes, $person->prefix_id, ['class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-4">
                                {!! Form::label('first_name', 'First:')  !!}
                                {!! Form::text('first_name', $person->first_name, ['class' => 'form-control']) !!}
                            </div>
                            <div class="col-4">
                                {!! Form::label('middle_name', 'Middle:')  !!}
                                {!! Form::text('middle_name', $person->middle_name, ['class' => 'form-control']) !!}
                            </div>
                            <div class="col-4">
                                {!! Form::label('last_name', 'Last:')  !!}
                                {!! Form::text('last_name', $person->last_name, ['class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-4">
                                {!! Form::label('suffix_id', 'Suffix:')  !!}
                                {!! Form::select('suffix_id', $suffixes, $person->suffix_id, ['class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-4">
                                {!! Form::label('nick_name', 'Nickname: ')  !!}
                                {!! Form::text('nick_name', $person->nick_name, ['class' => 'form-control']) !!}
                            </div>
                            <div class="col-4">
                                {!! Form::label('display_name', 'Display name: ')  !!}
                                {!! Form::text('display_name', $person->display_name, ['class' => 'form-control']) !!}
                            </div>
                            <div class="col-4">
                                {!! Form::label('sort_name', 'Sort name: ')  !!}
                                {!! Form::text('sort_name', $person->sort_name, ['class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-4">
                                {!! Form::label('agc_household_name', 'AGC Household: ')  !!}
                                {!! Form::text('agc_household_name', $person->agc_household_name, ['class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-4">
                                {!! Form::label('contact_type', 'Contact type: ')  !!}
                                {!! Form::select('contact_type', $contact_types, $person->contact_type, ['class' => 'form-control']) !!}
                            </div>
                            <div class="col-4">
                                {!! Form::label('subcontact_type', 'Subcontact type: ')  !!}
                                {!! Form::select('subcontact_type', $subcontact_types, $person->subcontact_type, ['class' => 'form-control']) !!}
                            </div>
                        </div>
                        @can('create-avatar')
                        <div class="row">
                            <div class="col-12">
                                {!! Form::label('avatar', 'Upload Avatar:') !!}
                                {!! Form::file('avatar',['class' => 'form-control-file']) !!}
                            </div>
                        </div>
                        @endCan
                    </div>
                </div>
                <div class="col-12 col-lg-6 alert alert-danger">
                    <h2>Emergency Contact Information</h2>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-4">
                                {!! Form::label('emergency_contact_name', 'Name: ')  !!}
                                {!! Form::text('emergency_contact_name', $person->emergency_contact_name, ['class' => 'form-control']) !!}
                            </div>
                            <div class="col-4">
                                {!! Form::label('emergency_contact_relationship', 'Relationship: ')  !!}
                                {!! Form::text('emergency_contact_relationship', $person->emergency_contact_relationship, ['class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-4">
                                {!! Form::label('emergency_contact_phone', 'Phone: ')  !!}
                                {!! Form::text('emergency_contact_phone', $person->emergency_contact_phone, ['class' => 'form-control']) !!}
                            </div>
                            <div class="col-4">
                                {!! Form::label('emergency_contact_phone_alternate', 'Alt. Phone: ')  !!}
                                {!! Form::text('emergency_contact_phone_alternate', $person->emergency_contact_phone_alternate, ['class' => 'form-control']) !!}
                            </div>
                        </div>
                    </div>
                    <h2>Health and Dietary Information</h2>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-12">
                                {!! Form::label('note_health', 'Health Notes:')  !!}
                                {!! Form::textarea('note_health', $person->note_health, ['class' => 'form-control','rows'=>'3']) !!}
                            </div>
                            <div class="col-12">
                                {!! Form::label('note_dietary', 'Dietary Notes:')  !!}
                                {!! Form::textarea('note_dietary', $person->note_dietary, ['class' => 'form-control','rows'=>'3']) !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-lg-6">
                    <h2>Contact Information</h2>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-12">
                                <h3>Phone Numbers</h3>
                            </div>
                            <div class="col-12">
                                @include('persons.update.phones')
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <h3>Emails</h3>
                            </div>
                            <div class="col-12">
                                @include('persons.update.emails')
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <h3>Websites</h3>
                            </div>
                            <div class="col-12">
                                @include('persons.update.urls')
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <h3>Addresses</h3>
                            </div>
                            <div class="col-12">
                                @include('persons.update.addresses')
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-6">
                    <h2>Demographics</h2>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-12 col-lg-6">
                                {!! Form::label('gender_id', 'Gender:')  !!}
                                {!! Form::select('gender_id', $genders, $person->gender_id, ['class' => 'form-control']) !!}
                            </div>
                            <div class="col-12 col-lg-6">
                                {!! Form::label('birth_date', 'Birth Date:') !!}
                                {!! Form::text('birth_date', $person->birth_date, ['class'=>'form-control bg-white flatpickr-date']) !!}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-lg-6">
                                {!! Form::label('religion_id', 'Religion:')  !!}
                                {!! Form::select('religion_id', $religions, $person->religion_id, ['class' => 'form-control']) !!} 
                            </div>
                            <div class="col-12 col-lg-6">
                                {!! Form::label('occupation_id', 'Occupation:')  !!}
                                {!! Form::select('occupation_id', $occupations, $person->occupation_id, ['class' => 'form-control']) !!} 
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-lg-6">
                                {!! Form::label('parish_id', 'Parish:')  !!}
                                {!! Form::select('parish_id', $parish_list, $person->parish_id, ['class' => 'form-control']) !!} 
                            </div>
                            <div class="col-12 col-lg-6">
                                {!! Form::label('ethnicity_id', 'Ethnicity:')  !!}
                                {!! Form::select('ethnicity_id', $ethnicities, $person->ethnicity_id, ['class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                {!! Form::label('languages', 'Languages:') !!}
                                {!! Form::select('languages[]', $languages, $person->languages->pluck('id')->toArray(), ['id'=>'languages', 'class' => 'form-control select2', 'multiple' => 'multiple']) !!}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                {!! Form::label('preferred_language_id', 'Preferred Language:')  !!}
                                {!! Form::select('preferred_language_id', $languages, $person->preferred_language_id, ['class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                {!! Form::label('referrals', 'Referral sources:') !!}
                                {!! Form::select('referrals[]', $referrals, $person->referrals->pluck('id')->toArray(), ['id'=>'referrals', 'class' => 'form-control select2','multiple' => 'multiple']) !!}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-lg-6">
                                {!! Form::label('is_deceased', 'Is Deceased:')  !!}
                                {!! Form::checkbox('is_deceased', 1, $person->is_deceased, ['class' => 'form-control']) !!}
                            </div>
                            <div class="col-12 col-lg-6">
                                {!! Form::label('deceased_date', 'Deceased Date:')  !!}
                                {!! Form::text('deceased_date', $person->deceased_date, ['class'=>'form-control bg-white flatpickr-date']) !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-lg-6">
                    <h2>Notes</h2>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-12">
                                {!! Form::label('note_contact', 'General Notes:')  !!}
                                {!! Form::textarea('note_contact', $person->note_contact, ['class' => 'form-control','rows'=>'3']) !!}
                            </div>
                            <div class="col-12">
                                {!! Form::label('note_room_preference', 'Room Preference:')  !!}
                                {!! Form::textarea('note_room_preference', $person->note_room_preference, ['class' => 'form-control','rows'=>'3']) !!}
                            </div>
                        </div>
                    </div>
                </div>
                @can('create-attachment')
                <div class="col-12 col-lg-6">
                    <h2>Attachments</h2>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-12">
                                {!! Form::label('attachment', 'Attachment (max 10M): ')  !!}
                                {!! Form::file('attachment',['class' => 'form-control']); !!}
                            </div>
                            <div class="col-12">
                                {!! Form::label('attachment_description', 'Description: (max 200)')  !!}
                                {!! Form::text('attachment_description', NULL, ['class' => 'form-control']) !!}
                            </div>
                        </div>
                    </div>
                </div>
                @endCan
            </div>
            <div class="row">
                <div class="col-12">
                    <h2>Groups and Relationships</h2>
                </div>
                <div class="col-4 col-md-2">
                    <div class="form-check">
                        {!! Form::checkbox('is_donor', 1, $person->is_donor, ['class' => 'form-check-input']) !!}
                        {!! Form::label('is_donor', 'Donor:', ['class' => 'form-check-label'])  !!}
                    </div>
                </div>
                <div class="col-4 col-md-2">
                    <div class="form-check">
                        {!! Form::checkbox('is_steward', 1, $person->is_steward, ['class' => 'form-check-input']) !!}
                        {!! Form::label('is_steward', 'Steward:', ['class' => 'form-check-label'])  !!}
                    </div>
                </div>
                <div class="col-4 col-md-2">
                    <div class="form-check">
                        {!! Form::checkbox('is_volunteer', 1, $person->is_volunteer,['class' => 'form-check-input']) !!}
                        {!! Form::label('is_volunteer', 'Volunteer:', ['class' => 'form-check-label'])  !!}
                    </div>
                </div>
                <div class="col-4 col-md-2">
                    <div class="form-check">
                        {!! Form::checkbox('is_retreatant', 1, $person->is_retreatant,['class' => 'form-check-input']) !!}
                        {!! Form::label('is_retreatant', 'Retreatant', ['class' => 'form-check-label']) !!}
                    </div>
                </div>
                <div class="col-4 col-md-2">
                    <div class="form-check">
                        {!! Form::checkbox('is_captain', 1, $person->is_captain,['class' => 'form-check-input']) !!}
                        {!! Form::label('is_captain', 'Captain', ['class' => 'form-check-label']) !!}
                    </div>
                </div>
                <div class="col-4 col-md-2">
                    <div class="form-check">
                        {!! Form::checkbox('is_hlm2017', 1, $person->is_hlm2017,['class' => 'form-check-input']) !!}
                        {!! Form::label('is_hlm2017', 'HLM 2017', ['class' => 'form-check-label']) !!}
                    </div>
                </div>
                <div class="col-4 col-md-2">
                    <div class="form-check">
                        {!! Form::checkbox('is_bishop', 1, $person->is_bishop,['class' => 'form-check-input']) !!}   
                        {!! Form::label('is_bishop', 'Bishop', ['class' => 'form-check-label']) !!}
                    </div>
                </div>
                <div class="col-4 col-md-2">
                    <div class="form-check">
                        {!! Form::checkbox('is_priest', 1, $person->is_priest,['class' => 'form-check-input']) !!}
                        {!! Form::label('is_priest', 'Priest', ['class' => 'form-check-label'])  !!}
                    </div>
                </div>
                <div class="col-4 col-md-2">
                    <div class="form-check">
                        {!! Form::checkbox('is_deacon', 1, $person->is_deacon,['class' => 'form-check-input']) !!}
                        {!! Form::label('is_deacon', 'Deacon', ['class' => 'form-check-label'])  !!}
                    </div>
                </div>
                <div class="col-4 col-md-2">
                    <div class="form-check">
                        {!! Form::checkbox('is_pastor', 1, $person->is_pastor,['class' => 'form-check-input']) !!}
                        {!! Form::label('is_pastor', 'Pastor', ['class' => 'form-check-label'])  !!}
                    </div>
                </div>
                <div class="col-4 col-md-2">
                    <div class="form-check">
                        {!! Form::checkbox('is_jesuit', 1, $person->is_jesuit,['class' => 'form-check-input']) !!}  
                        {!! Form::label('is_jesuit', 'Jesuit', ['class' => 'form-check-label']) !!}
                    </div>
                </div>
                <div class="col-4 col-md-2">
                    <div class="form-check">
                        {!! Form::checkbox('is_provincial', 1, $person->is_provincial,['class' => 'form-check-input']) !!}
                        {!! Form::label('is_provincial', 'Provincial', ['class' => 'form-check-label']) !!}
                    </div>
                </div>
                <div class="col-4 col-md-2">
                    <div class="form-check">
                        {!! Form::checkbox('is_superior', 1, $person->is_superior,['class' => 'form-check-input']) !!}
                        {!! Form::label('is_superior', 'Superior', ['class' => 'form-check-label']) !!}
                    </div>
                </div>
                <div class="col-4 col-md-2">
                    <div class="form-check">
                        {!! Form::checkbox('is_board', 1, $person->is_board_member,['class' => 'form-check-input']) !!}
                        {!! Form::label('is_board', 'Board Member', ['class' => 'form-check-label'])  !!}
                    </div>
                </div>
                <div class="col-4 col-md-2">
                    <div class="form-check">
                        {!! Form::checkbox('is_formerboard', 1, $person->is_former_board_member,['class' => 'form-check-input', 'disabled']) !!}
                        {!! Form::label('is_formerboard', 'Former Board', ['class' => 'form-check-label']) !!}
                    </div>
                </div>
                <div class="col-4 col-md-2">
                    <div class="form-check">
                        {!! Form::checkbox('is_staff', 1, $person->is_staff,['class' => 'form-check-input']) !!}
                        {!! Form::label('is_staff', 'Staff', ['class' => 'form-check-label'])  !!}
                    </div>
                </div>
                <div class="col-4 col-md-2">
                    <div class="form-check">
                        {!! Form::checkbox('is_director', 1, $person->is_retreat_director,['class' => 'form-check-input']) !!} 
                        {!! Form::label('is_director', 'Retreat Director', ['class' => 'form-check-label'])  !!}
                    </div>
                </div>
                <div class="col-4 col-md-2">
                    <div class="form-check">
                        {!! Form::checkbox('is_innkeeper', 1, $person->is_retreat_innkeeper,['class' => 'form-check-input']) !!} 
                        {!! Form::label('is_innkeeper', 'Retreat Innkeeper', ['class' => 'form-check-label'])  !!}
                    </div>
                </div>
                <div class="col-4 col-md-2">
                    <div class="form-check">
                        {!! Form::checkbox('is_assistant', 1, $person->is_retreat_assistant,['class' => 'form-check-input']) !!}
                        {!! Form::label('is_assistant', 'Retreat Assistant', ['class' => 'form-check-label'])  !!}
                    </div>
                </div>
            </div>
            <div class="row text-center">
                <div class="col-12 mt-2 mb-3">
                    {!! Form::image('/images/save.png','btnSave',['class' => 'btn btn-outline-dark']) !!}
                </div>
            </div>
        {!! Form::close() !!}
    </div>
</div>
@stop
