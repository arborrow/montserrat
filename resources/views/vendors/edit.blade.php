@extends('template')
@section('content')
<div class="row bg-cover">
    <div class="col-lg-12 text-center">
        {!!$vendor->avatar_large_link!!}
        <h1>Edit: {{ $vendor->organization_name }}</h1>
    </div>
    <div class="col-lg-12">
        {{ html()->form('PUT', route('vendor.update', [$vendor->id]))->acceptsFiles()->open() }}
        {{ html()->hidden('id', $vendor->id) }}
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
                            {{ html()->text('organization_name', $vendor->organization_name)->class('form-control') }}
                        </div>
                        <div class="col-lg-12 col-lg-4">
                            {{ html()->label('Display', 'display_name') }}
                            {{ html()->text('display_name', $vendor->display_name)->class('form-control') }}
                        </div>
                        <div class="col-lg-12 col-lg-4">
                            {{ html()->label('Sort', 'sort_name') }}
                            {{ html()->text('sort_name', $vendor->sort_name)->class('form-control') }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <h2>Address</h2>
                <div class="form-group">
                    <div class="row">
                        <div class="col-lg-12 col-lg-4">
                            {{ html()->label('Address', 'street_address') }}
                            {{ html()->text('street_address', $vendor->address_primary_street)->class('form-control') }}
                        </div>
                        <div class="col-lg-12 col-lg-4">
                            {{ html()->label('Address Line 2', 'supplemental_address_1') }}
                            {{ html()->text('supplemental_address_1', $vendor->address_primary_supplemental_address)->class('form-control') }}
                        </div>
                        <div class="col-lg-12 col-lg-4">
                            {{ html()->label('City', 'city') }}
                            {{ html()->text('city', $vendor->address_primary_city)->class('form-control') }}
                        </div>
                        <div class="col-lg-12 col-lg-4">
                            {{ html()->label('State', 'state_province_id') }}
                            {{ html()->select('state_province_id', $states, $vendor->address_primary_state_id)->class('form-control') }}
                        </div>
                        <div class="col-lg-12 col-lg-4">
                            {{ html()->label('Zip', 'postal_code') }}
                            {{ html()->text('postal_code', $vendor->address_primary_postal_code)->class('form-control') }}
                        </div>
                        <div class="col-lg-12 col-lg-4">
                            {{ html()->label('Country', 'country_id') }}
                            {{ html()->select('country_id', $countries, $vendor->address_primary_country_id)->class('form-control') }}
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
                            @if (empty($vendor->phone_primary))
                                {{ html()->text('phone_main_phone')->class('form-control') }}
                            @else
                                {{ html()->text('phone_main_phone', $vendor->phone_main_phone_number)->class('form-control') }}
                            @endif
                        </div>
                        <div class="col-lg-12 col-lg-4">
                            {{ html()->label('Fax', 'phone_main_fax') }}
                            @if (empty($vendor->phone_main_fax))
                                {{ html()->text('phone_main_fax')->class('form-control') }}
                            @else
                                {{ html()->text('phone_main_fax', $vendor->phone_main_fax_number)->class('form-control') }}
                            @endif
                        </div>
                        <div class="col-lg-12 col-lg-4">
                            {{ html()->label('Email', 'email_primary') }}
                            {{ html()->text('email_primary', $vendor->email_primary_text)->class('form-control') }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <h2>Websites</h2>
                <div class="col-lg-12">
                    @include('vendors.update.urls')
                </div>
            </div>
            <div class="col-lg-12">
                <h2>Other</h2>
                <div class="form-group">
                    <div class="row">
                        <div class="col-lg-12 col-lg-4">
                            {{ html()->label('Notes', 'note_vendor') }}
                            {{ html()->textarea('note_vendor', $vendor->note_vendor_text)->class('form-control')->rows('3') }}
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-lg-12">
                            {{ html()->label('Picture (max 5M)', 'avatar') }}
                            {{ html()->file('avatar') }}
                        </div>
                    </div>
                    <div class="row">
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
