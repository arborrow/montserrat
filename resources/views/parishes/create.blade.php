@extends('template')
@section('content')
<div class="row bg-cover">
    <div class="col-lg-12">
        <h2>Add a Parish</h2>
    </div>
    <div class="col-lg-12">
        {{ html()->form('POST', url('parish'))->open() }}
            <div class="form-group">
                <div class="row">
                    <div class="col-lg-4">
                        {{ html()->label('Diocese:', 'diocese_id') }}
                        {{ html()->select('diocese_id', $dioceses, 0)->class('form-control') }}
                    </div>
                    <div class="col-lg-4">
                        {{ html()->label('Pastor:', 'pastor_id') }}
                        {{ html()->select('pastor_id', $pastors, 0)->class('form-control') }}
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4">
                        {{ html()->label('Name:', 'organization_name') }}
                        {{ html()->text('organization_name')->class('form-control') }}
                    </div>
                    <div class="col-lg-4">
                        {{ html()->label('Address Line 1:', 'street_address') }}
                        {{ html()->text('street_address')->class('form-control') }}
                    </div>
                    <div class="col-lg-4">
                        {{ html()->label('Address Line 2:', 'supplemental_address_1') }}
                        {{ html()->text('supplemental_address_1')->class('form-control') }}
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4">
                        {{ html()->label('City:', 'city') }}
                        {{ html()->text('city')->class('form-control') }}
                    </div>
                    <div class="col-lg-4">
                        {{ html()->label('State:', 'state_province_id') }}
                        {{ html()->select('state_province_id', $states, $defaults['state_province_id'])->class('form-control') }}
                    </div>
                    <div class="col-lg-4">
                        {{ html()->label('Zip:', 'postal_code') }}
                        {{ html()->text('postal_code')->class('form-control') }}
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4">
                        {{ html()->label('Country:', 'country_id') }}
                        {{ html()->select('country_id', $countries, $defaults['country_id'])->class('form-control') }}
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4">
                        {{ html()->label('Phone:', 'phone_main_phone') }}
                        {{ html()->text('phone_main_phone')->class('form-control') }}
                    </div>
                    <div class="col-lg-4">
                        {{ html()->label('Fax:', 'phone_main_fax') }}
                        {{ html()->text('phone_main_fax')->class('form-control') }}
                    </div>
                    <div class="col-lg-4">
                        {{ html()->label('Email:', 'email_main') }}
                        {{ html()->text('email_main')->class('form-control') }}
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4">
                        {{ html()->label('Note:', 'parish_note') }}
                        {{ html()->textarea('parish_note')->class('form-control')->rows('3') }}
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-lg-12">
                        <h3>Websites (URLs)</h3>
                    </div>
                    <div class="col-lg-12">
                        @include('parishes.create.urls')
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4">
                        {{ html()->submit('Add Parish')->class('btn btn-light') }}
                    </div>
                </div>
            </div>
        {{ html()->form()->close() }}
    </div>
</div>
@stop
