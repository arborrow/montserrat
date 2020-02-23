@extends('template')
@section('content')

<div class="row bg-cover">
    <div class="col-12">
        <h1>Create address</h1>
    </div>
    <div class="col-12">
        {!! Form::open(['url'=>'address', 'method'=>'post']) !!}
            <div class="form-group">
                <div class="row">
                    <div class="col-12 col-md-4">
                        {!! Form::label('contact_id', 'Name of Contact:') !!}
                        @if (isset($defaults['contact_id']))
                            {!! Form::select('contact_id', $contacts, $defaults['contact_id'], ['class' => 'form-control', 'required']) !!}
                        @else
                            {!! Form::select('contact_id', $contacts, NULL, ['class' => 'form-control', 'required']) !!}
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-md-4">
                        {!! Form::label('location_type_id', 'Location type')  !!}
                        {!! Form::select('location_type_id', $location_types, config('polanco.location_type.home'), ['class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-md-4">
                        {!! Form::label("street_address", "Address Line 1:") !!}
                        {!! Form::text("street_address", null, ["class" => "form-control"]) !!}
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-md-4">
                        {!! Form::label("supplemental_address_1", "Address Line 2:") !!}
                        {!! Form::text("supplemental_address_1", null, ["class" => "form-control"]) !!}
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-md-4">
                        {!! Form::label("city", "City:") !!}
                        {!! Form::text("city", null, ["class" => "form-control"]) !!}
                    </div>
                    <div class="col-12 col-md-4">
                        {!! Form::label("state_province_id", "State:") !!}
                        {!! Form::select("state_province_id", $states, "1042", ["class" => "form-control"]) !!}
                    </div>
                    <div class="col-12 col-md-4">
                        {!! Form::label("postal_code", "Zip:") !!}
                        {!! Form::text("postal_code", null, ["class" => "form-control"]) !!}
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-md-4">
                        {!! Form::label("country_id", "Country:") !!}
                        {!! Form::select("country_id", $countries, config('polanco.country_id_usa'), ["class" => "form-control"]) !!}
                    </div>
                </div>
                <div class="row">
                    <div class="form-group form-check">
                        {!! Form::checkbox("is_primary", 1, 0,["class" => "form-check-input", "id" => "do_not_mail"]) !!}
                        {!! Form::label("is_primary", "Is primary", ["class" => "form-check-label", "id" => "do_not_mail"]) !!}
                    </div>
                </div>
            </div>
            <div class="row text-center">
                <div class="col-12">
                    {!! Form::submit('Add address', ['class'=>'btn btn-outline-dark']) !!}
                </div>
            </div>
        {!! Form::close() !!}
    </div>
</div>
@stop
