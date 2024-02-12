@extends('template')
@section('content')

<div class="row bg-cover">
    <div class="col-lg-12">
        <h1>Create address</h1>
    </div>
    <div class="col-lg-12">
        {{ html()->form('POST', url('address'))->open() }}
            <div class="form-group">
                <div class="row">
                    <div class="col-lg-4 col-md-6">
                        {{ html()->label('Name of Contact:', 'contact_id') }}
                        @if (isset($defaults['contact_id']))
                            {{ html()->select('contact_id', $contacts, $defaults['contact_id'])->class('form-control')->required() }}
                        @else
                            {{ html()->select('contact_id', $contacts)->class('form-control')->required() }}
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4 col-md-6">
                        {{ html()->label('Location type', 'location_type_id') }}
                        {{ html()->select('location_type_id', $location_types, config('polanco.location_type.home'))->class('form-control') }}
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4 col-md-6">
                        {{ html()->label("Address Line 1:", "street_address") }}
                        {{ html()->text("street_address")->class("form-control") }}
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4 col-md-6">
                        {{ html()->label("Address Line 2:", "supplemental_address_1") }}
                        {{ html()->text("supplemental_address_1")->class("form-control") }}
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-3 col-md-4">
                        {{ html()->label("City:", "city") }}
                        {{ html()->text("city")->class("form-control") }}
                    </div>
                    <div class="col-lg-3 col-md-4">
                        {{ html()->label("State:", "state_province_id") }}
                        {{ html()->select("state_province_id", $states, "1042")->class("form-control") }}
                    </div>
                    <div class="col-lg-3 col-md-4">
                        {{ html()->label("Zip:", "postal_code") }}
                        {{ html()->text("postal_code")->class("form-control") }}
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-3 col-md-4">
                        {{ html()->label("Country:", "country_id") }}
                        {{ html()->select("country_id", $countries, config('polanco.country_id_usa'))->class("form-control") }}
                    </div>
                </div>
                <div class="row">
                    <div class="form-group form-check">
                        {{ html()->checkbox("is_primary", 0, 1)->class("form-check-input")->id("do_not_mail") }}
                        {{ html()->label("Is primary", "is_primary")->class("form-check-label")->id("do_not_mail") }}
                    </div>
                </div>
            </div>
            <div class="row text-center">
                <div class="col-lg-12">
                    {{ html()->submit('Add address')->class('btn btn-outline-dark') }}
                </div>
            </div>
        {{ html()->form()->close() }}
    </div>
</div>
@stop
