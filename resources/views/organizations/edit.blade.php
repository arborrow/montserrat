@extends('template')
@section('content')

<div class="bg-cover row">
    <div class="col-12 text-center">
        {!!$organization->avatar_large_link!!}
        <h1>Edit: {{ $organization->organization_name }}</h1>
    </div>
    <div class="col-12">
        {!! Form::open(['method' => 'PUT', 'files'=>'true', 'route' => ['organization.update', $organization->id]]) !!}
        {!! Form::hidden('id', $organization->id) !!}
        <div class="row text-center">
            <div class="col-12">
                {!! Form::image('images/save.png','btnSave',['class' => 'btn btn-outline-dark']) !!}
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <h2>Basic Information</h2>
                <div class="form-group">
                    <div class="row">
                        <div class="col-12 col-lg-4">
                            {!! Form::label('organization_name', 'Name') !!}
                            {!! Form::text('organization_name', $organization->organization_name, ['class' => 'form-control']) !!}
                        </div>
                        <div class="col-12 col-lg-4">
                            {!! Form::label('subcontact_type', 'Subcontact type')  !!}
                            {!! Form::select('subcontact_type', $subcontact_types, $organization->subcontact_type, ['class' => 'form-control']) !!}
                        </div>
                        <div class="col-12 col-lg-4">
                            {!! Form::label('display_name', 'Display Name') !!}
                            {!! Form::text('display_name', $organization->display_name, ['class' => 'form-control']) !!}
                        </div>
                        <div class="col-12 col-lg-4">
                            {!! Form::label('sort_name', 'Sort Name') !!}
                            {!! Form::text('sort_name', $organization->sort_name, ['class' => 'form-control']) !!}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <h2>Address</h2>
                <div class="form-group">
                    <div class="row">
                        <div class="col-12 col-lg-6">
                            {!! Form::label('street_address', 'Address Line 1') !!}
                            {!! Form::text('street_address', $organization->address_primary_street, ['class' => 'form-control']) !!}
                        </div>
                        <div class="col-12 col-lg-6">
                            {!! Form::label('supplemental_address_1', 'Address Line 2') !!}
                            {!! Form::text('supplemental_address_1', $organization->address_primary_supplemental_address, ['class' => 'form-control']) !!}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-lg-4">
                            {!! Form::label('city', 'City') !!}
                            {!! Form::text('city', $organization->address_primary_city, ['class' => 'form-control']) !!}
                        </div>
                        <div class="col-12 col-lg-4">
                            {!! Form::label('state_province_id', 'State') !!}
                            {!! Form::select('state_province_id', $states, $organization->address_primary_state_id, ['class' => 'form-control']) !!}
                        </div>
                        <div class="col-12 col-lg-4">
                            {!! Form::label('postal_code', 'Zip') !!}
                            {!! Form::text('postal_code', $organization->address_primary_postal_code, ['class' => 'form-control']) !!}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <h2>Contact Information</h2>
                <div class="form-group">
                    <div class="row">
                        <div class="col-12 col-lg-4">
                            {!! Form::label('phone_main_phone', 'Phone') !!}
                            {!! Form::text('phone_main_phone', $organization->phone_main_phone_number, ['class' => 'form-control']) !!}
                        </div>
                        <div class="col-12 col-lg-4">
                            {!! Form::label('phone_main_fax', 'Fax') !!}
                            {!! Form::text('phone_main_fax', $organization->phone_main_fax_number, ['class' => 'form-control']) !!}
                        </div>
                        <div class="col-12 col-lg-4">
                            {!! Form::label('email_primary', 'Email:', ['class' => 'col-md-2']) !!}
                            @if (isset($organization->email_primary))
                                {!! Form::text('email_primary', $organization->email_primary_text, ['class' => 'form-control']) !!}
                            @else
                                {!! Form::text('email_primary', NULL, ['class' => 'form-control']) !!}
                            @endIf
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <h2>Websites</h2>
                <div class="col-12">
                    @include('organizations.update.urls')
                </div>
            </div>
            <div class="col-12">
                <h2>Other</h2>
                <div class="form-group">
                    <div class="row">
                        <div class="col-12 col-lg-4">
                            {!! Form::label('note', 'Notes') !!}
                            {!! Form::textarea('note', $organization->note_organization_text, ['class'=>'form-control', 'rows'=>'3']) !!}
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-12">
                            {!! Form::label('avatar', 'Picture (max 5M)') !!}
                            {!! Form::file('avatar'); !!}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            {!! Form::label('attachment', 'Attachment (max 10M): ', ['class' => ''])  !!}
                            {!! Form::file('attachment'); !!}
                        </div>
                        <div class="col-6">
                            {!! Form::label('attachment_description', 'Attachment Description (max 200)')  !!}
                            {!! Form::text('attachment_description', NULL, ['class' => 'form-control']) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row text-center">
            <div class="col-12">
                {!! Form::image('images/save.png','btnSave',['class' => 'btn btn-outline-dark']) !!}
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>
@stop
