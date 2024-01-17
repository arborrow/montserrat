@extends('template')
@section('content')

<div class="bg-cover row">
    <div class="col-lg-12 text-center">
        {!!$organization->avatar_large_link!!}
        <h1>Edit: {{ $organization->organization_name }}</h1>
    </div>
    <div class="col-lg-12">
        {{ html()->form('PUT', route('organization.update', [$organization->id]))->acceptsFiles()->open() }}
        {{ html()->hidden('id', $organization->id) }}
        <div class="row text-center">
            <div class="col-lg-12">
                {{ html()->input('image', 'btnSave')->class('btn btn-outline-dark')->attribute('src', asset('images/save.png')) }}
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <h2>Basic Information</h2>
                <div class="form-group">
                    <div class="row">
                        <div class="col-lg-12 col-lg-4">
                            {{ html()->label('Name', 'organization_name') }}
                            {{ html()->text('organization_name', $organization->organization_name)->class('form-control') }}
                        </div>
                        <div class="col-lg-12 col-lg-4">
                            {{ html()->label('Subcontact type', 'subcontact_type') }}
                            {{ html()->select('subcontact_type', $subcontact_types, $organization->subcontact_type)->class('form-control') }}
                        </div>
                        <div class="col-lg-12 col-lg-4">
                            {{ html()->label('Display Name', 'display_name') }}
                            {{ html()->text('display_name', $organization->display_name)->class('form-control') }}
                        </div>
                        <div class="col-lg-12 col-lg-4">
                            {{ html()->label('Sort Name', 'sort_name') }}
                            {{ html()->text('sort_name', $organization->sort_name)->class('form-control') }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <h2>Address</h2>
                <div class="form-group">
                    <div class="row">
                        <div class="col-lg-12 col-lg-6">
                            {{ html()->label('Address Line 1', 'street_address') }}
                            {{ html()->text('street_address', $organization->address_primary_street)->class('form-control') }}
                        </div>
                        <div class="col-lg-12 col-lg-6">
                            {{ html()->label('Address Line 2', 'supplemental_address_1') }}
                            {{ html()->text('supplemental_address_1', $organization->address_primary_supplemental_address)->class('form-control') }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-lg-4">
                            {{ html()->label('City', 'city') }}
                            {{ html()->text('city', $organization->address_primary_city)->class('form-control') }}
                        </div>
                        <div class="col-lg-12 col-lg-4">
                            {{ html()->label('State', 'state_province_id') }}
                            {{ html()->select('state_province_id', $states, $organization->address_primary_state_id)->class('form-control') }}
                        </div>
                        <div class="col-lg-12 col-lg-4">
                            {{ html()->label('Zip', 'postal_code') }}
                            {{ html()->text('postal_code', $organization->address_primary_postal_code)->class('form-control') }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <h2>Contact Information</h2>
                <div class="form-group">
                    <div class="row">
                        <div class="col-lg-12 col-lg-4">
                            {{ html()->label('Phone', 'phone_main_phone') }}
                            {{ html()->text('phone_main_phone', $organization->phone_main_phone_number)->class('form-control') }}
                        </div>
                        <div class="col-lg-12 col-lg-4">
                            {{ html()->label('Fax', 'phone_main_fax') }}
                            {{ html()->text('phone_main_fax', $organization->phone_main_fax_number)->class('form-control') }}
                        </div>
                        <div class="col-lg-12 col-lg-4">
                            {{ html()->label('Email:', 'email_primary')->class('col-md-2') }}
                            @if (isset($organization->email_primary))
                                {{ html()->text('email_primary', $organization->email_primary_text)->class('form-control') }}
                            @else
                                {{ html()->text('email_primary')->class('form-control') }}
                            @endIf
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <h2>Websites</h2>
                <div class="col-lg-12">
                    @include('organizations.update.urls')
                </div>
            </div>
            <div class="col-lg-12">
                <h2>Other</h2>
                <div class="form-group">
                    <div class="row">
                        <div class="col-lg-12 col-lg-4">
                            {{ html()->label('Notes', 'note') }}
                            {{ html()->textarea('note', $organization->note_organization_text)->class('form-control')->rows('3') }}
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-lg-12">
                            {{ html()->label('Picture (max 5M)', 'avatar') }}
                            {{ html()->file('avatar') }}
                        </div>
                    </div>
                    @if ($organization->id == env('SELF_CONTACT_ID'))
                        <div class="row mt-3">
                            <div class="col-lg-12">
                                {{ html()->label('Signature (max 5M)', 'signature') }}
                                {{ html()->file('signature') }}
                            </div>
                        </div>
                    @endIf
                    <div class="row mt-3">
                        <div class="col-lg-12">
                            {{ html()->label('Attachment (max 10M): ', 'attachment')->class('') }}
                            {{ html()->file('attachment') }}
                        </div>
                        <div class="col-lg-6">
                            {{ html()->label('Attachment Description (max 200)', 'attachment_description') }}
                            {{ html()->text('attachment_description')->class('form-control') }}
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
