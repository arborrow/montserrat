@extends('template')
@section('content')
<div class="row bg-cover">
    <div class="col-12">
        <h1>Edit address: {!! $address->id !!}</h1>
    </div>
    <div class="col-12">
        <div class="row">
            <div class="col-12">
                <h2>Address details</h2>
            </div>
            <div class="form-group">

                {!! Form::open(['method' => 'PUT', 'route' => ['address.update', $address->id]]) !!}
                {!! Form::hidden('id', $address->id) !!}
                <div class="row">
                    <div class="col-12 col-md-4">
                        {!! Form::label('contact_id', 'Name of Contact:') !!}
                        {!! Form::select('contact_id', $contacts, $address->contact_id, ['class' => 'form-control', 'required']) !!}
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-md-4">
                        {!! Form::label('location_type_id', 'Location type')  !!}
                        {!! Form::select('location_type_id', $location_types, $address->location_type_id, ['class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-md-4">
                        {!! Form::label("street_address", "Address Line 1:") !!}
                        {!! Form::text("street_address", $address->street_address, ["class" => "form-control"]) !!}
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-md-4">
                        {!! Form::label("supplemental_address_1", "Address Line 2:") !!}
                        {!! Form::text("supplemental_address_1", $address->supplemental_address_1, ["class" => "form-control"]) !!}
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-md-4">
                        {!! Form::label("city", "City:") !!}
                        {!! Form::text("city", $address->city, ["class" => "form-control"]) !!}
                    </div>
                    <div class="col-12 col-md-4">
                        {!! Form::label("state_province_id", "State:") !!}
                        {!! Form::select("state_province_id", $states, $address->state_province_id, ["class" => "form-control"]) !!}
                    </div>
                    <div class="col-12 col-md-4">
                        {!! Form::label("postal_code", "Zip:") !!}
                        {!! Form::text("postal_code", $address->postal_code, ["class" => "form-control"]) !!}
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-md-4">
                        {!! Form::label("country_id", "Country:") !!}
                        {!! Form::select("country_id", $countries, $address->country_id, ["class" => "form-control"]) !!}
                    </div>
                </div>
                <div class="row">
                    <div class="form-group form-check">
                        {!! Form::checkbox("is_primary", 1, $address->is_primary,["class" => "form-check-input", "id" => "is_primary"]) !!}
                        {!! Form::label("is_primary", "Is primary", ["class" => "form-check-label", "id" => "is_primary"]) !!}
                    </div>
                </div>

                    <div class="row">
                        <div class="col-12 text-center">
                            {!! Form::image('images/save.png','btnSave',['class' => 'btn btn-outline-dark']) !!}
                        </div>
                    </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@stop
