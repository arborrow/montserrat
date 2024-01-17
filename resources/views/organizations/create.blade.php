@extends('template')
@section('content')

<div class="row bg-cover">
    <div class="col-lg-12">
        <h1>Add an Organization</h1>
    </div>
    <div class="col-lg-12">
        {{ html()->form('POST', 'organization')->open() }}
            <div class="form-group">
                <div class="row">
                    <div class="col-lg-12 col-lg-4">
                        {{ html()->label('Type', 'subcontact_type') }}
                        {{ html()->select('subcontact_type', $subcontact_types, 0)->class('form-control') }}
                    </div>
                    <div class="col-lg-12 col-lg-4">
                        {{ html()->label('Name', 'organization_name') }}
                        {{ html()->text('organization_name')->class('form-control') }}
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 col-lg-4">
                        {{ html()->label('Address Line 1', 'street_address') }}
                        {{ html()->text('street_address')->class('form-control') }}
                    </div>
                    <div class="col-lg-12 col-lg-4">
                        {{ html()->label('Address Line 2', 'supplemental_address_1') }}
                        {{ html()->text('supplemental_address_1')->class('form-control') }}
                    </div>
                    <div class="col-lg-12 col-lg-4">
                        {{ html()->label('City', 'city') }}
                        {{ html()->text('city')->class('form-control') }}
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 col-lg-4">
                        {{ html()->label('State', 'state_province_id') }}
                        {{ html()->select('state_province_id', $states, $defaults['state_province_id'])->class('form-control') }}
                    </div>
                    <div class="col-lg-12 col-lg-4">
                        {{ html()->label('Zip', 'postal_code') }}
                        {{ html()->text('postal_code')->class('form-control') }}
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 col-lg-4">
                        {{ html()->label('Phone', 'phone_main_phone') }}
                        {{ html()->text('phone_main_phone')->class('form-control') }}
                    </div>
                    <div class="col-lg-12 col-lg-4">
                        {{ html()->label('Fax', 'phone_main_fax') }}
                        {{ html()->text('phone_main_fax')->class('form-control') }}
                    </div>
                    <div class="col-lg-12 col-lg-4">
                        {{ html()->label('Email', 'email_main') }}
                        {{ html()->text('email_main')->class('form-control') }}
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 col-lg-4">
                        {{ html()->label('Notes', 'note') }}
                        {{ html()->textarea('note')->class('form-control')->rows('3') }}
                    </div>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-lg-12">
                    <h5>Websites</h5>
                </div>
                <div class="col-lg-12">
                    @include('organizations.create.urls')
                </div>
            </div>
            <div class="row text-center">
                <div class="col-lg-12">
                    {{ html()->submit('Add Organization')->class('btn btn-outline-dark') }}
                </div>
            </div>
        {{ html()->form()->close() }}
    </div>
</div>
@stop