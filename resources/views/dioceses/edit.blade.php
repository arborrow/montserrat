@extends('template')
@section('content')

<div class="row bg-cover">
    <div class="col-lg-12 text-center">
        {!!$diocese->avatar_large_link!!}
        <h1>Edit: {{ $diocese->full_name }}</h1>
    </div>
    <div class="col-lg-12">
        {{ html()->form('PUT', route('diocese.update', [$diocese->id]))->acceptsFiles()->open() }}
            {{ html()->hidden('id', $diocese->id) }}
            <div class="row text-center">
                <div class="col-lg-12 mt-2 mb-3">
                    {{ html()->input('image', 'btnSave')->class('btn btn-outline-dark')->attribute('src', asset('images/save.png')) }}
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <h2>Basic Information</h2>
                </div>
                <div class="col-lg-12">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-lg-3 col-md-4">
                                {{ html()->label('Bishop', 'bishop_id') }}
                                {{ html()->select('bishop_id', $bishops, $diocese->bishop_id)->class('form-control') }}
                            </div>
                            <div class="col-lg-3 col-md-4">
                                {{ html()->label('Name', 'organization_name') }}
                                {{ html()->text('organization_name', $diocese->organization_name)->class('form-control') }}
                            </div>
                            <div class="col-lg-3 col-md-4">
                                {{ html()->label('Display', 'display_name') }}
                                {{ html()->text('display_name', $diocese->display_name)->class('form-control') }}
                            </div>
                            <div class="col-lg-3 col-md-4">
                                {{ html()->label('Sort', 'sort_name') }}
                                {{ html()->text('sort_name', $diocese->sort_name)->class('form-control') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <h2>Address</h2>
                </div>
                <div class="col-lg-12">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-lg-12 col-md-6">
                                {{ html()->label('Address Line 1', 'street_address') }}
                                {{ html()->text('street_address', $diocese->address_primary_street)->class('form-control') }}
                            </div>
                            <div class="col-lg-12 col-md-6">
                                {{ html()->label('Address Line 2', 'supplemental_address_1') }}
                                {{ html()->text('supplemental_address_1', $diocese->address_primary_supplemental_address)->class('form-control') }}
                            </div>
                            <div class="col-lg-12 col-md-3">
                                {{ html()->label('City', 'city') }}
                                {{ html()->text('city', $diocese->address_primary_city)->class('form-control') }}
                            </div>
                            <div class="col-lg-12 col-md-3">
                                {{ html()->label('State', 'state_province_id') }}
                                {{ html()->select('state_province_id', $states, $diocese->address_primary_state_id)->class('form-control') }}
                            </div>
                            <div class="col-lg-12 col-md-3">
                                {{ html()->label('Zip', 'postal_code') }}
                                {{ html()->text('postal_code', $diocese->address_primary_postal_code)->class('form-control') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <h2>Contact Information</h2>
                </div>
                <div class="col-lg-12">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-lg-3 col-md-4">
                                {{ html()->label('Phone', 'phone_main_phone') }}
                                {{ html()->text('phone_main_phone', $diocese->phone_main_phone_number)->class('form-control') }}
                            </div>
                            <div class="col-lg-3 col-md-4">
                                {{ html()->label('Fax', 'phone_main_fax') }}
                                {{ html()->text('phone_main_fax', $diocese->phone_main_fax_number)->class('form-control') }}
                            </div>
                            <div class="col-lg-3 col-md-4">
                                {{ html()->label('Email', 'email_primary') }}
                                {{ html()->text('email_primary', $diocese->email_primary_text)->class('form-control') }}
                            </div>
                            <div class="col-lg-3 col-md-4">
                                {{ html()->label('Note:', 'diocese_note') }}
                                {{ html()->textarea('diocese_note', $diocese->note_diocese_text)->class('form-control')->rows(3) }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <h2>Websites</h2>
                </div>
                <div class="col-lg-12">
                    @include('dioceses.update.urls')
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <h2>Other</h2>
                </div>
                <div class="col-lg-12">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="col-lg-12">
                                        {{ html()->label('Picture (max 5M)', 'avatar') }}
                                        {{ html()->file('avatar') }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="col-lg-12">
                                        {{ html()->label('Attachment (max 10M): ', 'attachment')->class('') }}
                                        {{ html()->file('attachment')->class('') }}
                                    </div>
                                    <div class="col-lg-6">
                                        {{ html()->label('Attachment Description (max 200)', 'attachment_description') }}
                                        {{ html()->text('attachment_description')->class('form-control') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row text-center">
                <div class="col-lg-12">
                    {{ html()->input('image', 'btnSave')->class('btn btn-outline-dark')->attribute('src', asset('images/save.png')) }}
                </div>
            </div>
        {{ html()->form()->close() }}
    </div>
</div>
@stop
