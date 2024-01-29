@extends('template')
@section('content')
<div class="row bg-cover">
    <div class="col-lg-12">
        <h1>Edit address: {!! $address->id !!}</h1>
    </div>
    <div class="col-lg-12">
        <div class="row">
            <div class="col-lg-12">
                <h2>Address details</h2>
            </div>
            <div class="form-group">

                {{ html()->form('PUT', route('address.update', [$address->id]))->open() }}
                {{ html()->hidden('id', $address->id) }}
                <div class="row">
                    <div class="col-lg-4 col-md-6">
                        {{ html()->label('Name of Contact:', 'contact_id') }}
                        {{ html()->select('contact_id', $contacts, $address->contact_id)->class('form-control')->required() }}
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4 col-md-6">
                        {{ html()->label('Location type', 'location_type_id') }}
                        {{ html()->select('location_type_id', $location_types, $address->location_type_id)->class('form-control') }}
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4 col-md-6">
                        {{ html()->label("Address Line 1:", "street_address") }}
                        {{ html()->text("street_address", $address->street_address)->class("form-control") }}
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4 col-md-6">
                        {{ html()->label("Address Line 2:", "supplemental_address_1") }}
                        {{ html()->text("supplemental_address_1", $address->supplemental_address_1)->class("form-control") }}
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4 col-md-6">
                        {{ html()->label("City:", "city") }}
                        {{ html()->text("city", $address->city)->class("form-control") }}
                    </div>
                    <div class="col-lg-4 col-md-6">
                        {{ html()->label("State:", "state_province_id") }}
                        {{ html()->select("state_province_id", $states, $address->state_province_id)->class("form-control") }}
                    </div>
                    <div class="col-lg-4 col-md-6">
                        {{ html()->label("Zip:", "postal_code") }}
                        {{ html()->text("postal_code", $address->postal_code)->class("form-control") }}
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4 col-md-6">
                        {{ html()->label("Country:", "country_id") }}
                        {{ html()->select("country_id", $countries, $address->country_id)->class("form-control") }}
                    </div>
                </div>
                <div class="row">
                    <div class="form-group form-check">
                        {{ html()->checkbox("is_primary", $address->is_primary, 1)->class("form-check-input")->id("is_primary") }}
                        {{ html()->label("Is primary", "is_primary")->class("form-check-label")->id("is_primary") }}
                    </div>
                </div>

                    <div class="row">
                        <div class="col-lg-12 text-center">
                            {{ html()->input('image', 'btnSave')->class('btn btn-outline-dark')->attribute('src', asset('images/save.png')) }}
                        </div>
                    </div>
                {{ html()->form()->close() }}
            </div>
        </div>
    </div>
</div>
@stop
