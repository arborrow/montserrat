@extends('template')
@section('content')
<div class="row bg-cover">
    <div class="col-lg-12 text-center">
        {!!$vendor->avatar_large_link!!}
        <h1>Edit: {{ $vendor->organization_name }}</h1>
    </div>
    <div class="col-lg-12">
        {!! Form::open(['method' => 'PUT', 'files'=>'true', 'route' => ['vendor.update', $vendor->id]]) !!}
        {!! Form::hidden('id', $vendor->id) !!}
        <div class="row text-center">
            <div class="col-lg-12">
                {!! Form::image('images/save.png','btnSave',['class' => 'btn btn-outline-dark']) !!}
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <h2>Basic Information</h2>
                <div class="form-group">
                    <div class="row">
                        <div class="col-lg-12 col-lg-4">
                            {!! Form::label('organization_name', 'Name') !!}
                            {!! Form::text('organization_name', $vendor->organization_name, ['class' => 'form-control']) !!}
                        </div>
                        <div class="col-lg-12 col-lg-4">
                            {!! Form::label('display_name', 'Display') !!}
                            {!! Form::text('display_name', $vendor->display_name, ['class' => 'form-control']) !!}
                        </div>
                        <div class="col-lg-12 col-lg-4">
                            {!! Form::label('sort_name', 'Sort') !!}
                            {!! Form::text('sort_name', $vendor->sort_name, ['class' => 'form-control']) !!}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <h2>Address</h2>
                <div class="form-group">
                    <div class="row">
                        <div class="col-lg-12 col-lg-4">
                            {!! Form::label('street_address', 'Address') !!}
                            {!! Form::text('street_address', $vendor->address_primary_street, ['class' => 'form-control']) !!}
                        </div>
                        <div class="col-lg-12 col-lg-4">
                            {!! Form::label('supplemental_address_1', 'Address Line 2') !!}
                            {!! Form::text('supplemental_address_1', $vendor->address_primary_supplemental_address, ['class' => 'form-control']) !!}
                        </div>
                        <div class="col-lg-12 col-lg-4">
                            {!! Form::label('city', 'City') !!}
                            {!! Form::text('city', $vendor->address_primary_city, ['class' => 'form-control']) !!}
                        </div>
                        <div class="col-lg-12 col-lg-4">
                            {!! Form::label('state_province_id', 'State') !!}
                            {!! Form::select('state_province_id', $states, $vendor->address_primary_state_id, ['class' => 'form-control']) !!}
                        </div>
                        <div class="col-lg-12 col-lg-4">
                            {!! Form::label('postal_code', 'Zip') !!}
                            {!! Form::text('postal_code', $vendor->address_primary_postal_code, ['class' => 'form-control']) !!}
                        </div>
                        <div class="col-lg-12 col-lg-4">
                            {!! Form::label('country_id', 'Country') !!}
                            {!! Form::select('country_id', $countries, $vendor->address_primary_country_id, ['class' => 'form-control']) !!}
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <h2>Contact Information</h2>
                <div class="form-group">
                    <div class="row">
                        <div class="col-lg-12 col-lg-4">
                            {!! Form::label('phone_main_phone', 'Phone') !!}
                            @if (empty($vendor->phone_primary))
                                {!! Form::text('phone_main_phone', NULL, ['class' => 'form-control']) !!}
                            @else
                                {!! Form::text('phone_main_phone', $vendor->phone_main_phone_number, ['class' => 'form-control']) !!}
                            @endif
                        </div>
                        <div class="col-lg-12 col-lg-4">
                            {!! Form::label('phone_main_fax', 'Fax') !!}
                            @if (empty($vendor->phone_main_fax))
                                {!! Form::text('phone_main_fax', NULL, ['class' => 'form-control']) !!}
                            @else
                                {!! Form::text('phone_main_fax', $vendor->phone_main_fax_number, ['class' => 'form-control']) !!}
                            @endif
                        </div>
                        <div class="col-lg-12 col-lg-4">
                            {!! Form::label('email_primary', 'Email') !!}
                            {!! Form::text('email_primary', $vendor->email_primary_text, ['class' => 'form-control']) !!}
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
                            {!! Form::label('note_vendor', 'Notes') !!}
                            {!! Form::textarea('note_vendor', $vendor->note_vendor_text, ['class'=>'form-control', 'rows'=>'3']) !!}
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-lg-12">
                            {!! Form::label('avatar', 'Picture (max 5M)') !!}
                            {!! Form::file('avatar'); !!}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            {!! Form::label('attachment', 'Attachment (max 10M): ', ['class' => ''])  !!}
                            {!! Form::file('attachment'); !!}
                        </div>
                        <div class="col-lg-6">
                            {!! Form::label('attachment_description', 'Attachment Description (max 200)')  !!}
                            {!! Form::text('attachment_description', NULL, ['class' => 'form-control']) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row text-center">
            <div class="col-lg-12">
                {!! Form::image('images/save.png','btnSave',['class' => 'btn btn-outline-dark']) !!}
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>
@stop
