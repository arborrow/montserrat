@extends('template')
@section('content')

<div class="row bg-cover">
    <div class="col-lg-12 text-center">
        {!!$parish->avatar_large_link!!}
        <h1>
            Edit Parish: {{ $parish->organization_name }}
        </h1>
    </div>
    <div class="col-lg-12">
        {{ html()->form('PUT', route('parish.update', [$parish->id]))->acceptsFiles()->open() }}
        {{ html()->hidden('id', $parish->id) }}
        <div class="form-group">
            <div class="row">
                <div class="col-lg-3 col-md-4">
                    {{ html()->label('Name:', 'organization_name') }}
                    {{ html()->text('organization_name', $parish->organization_name)->class('form-control') }}
                </div>
                <div class="col-lg-3 col-md-4">
                    {{ html()->label('Display:', 'display_name') }}
                    {{ html()->text('display_name', $parish->display_name)->class('form-control') }}
                </div>
                <div class="col-lg-3 col-md-4">
                    {{ html()->label('Sort:', 'sort_name') }}
                    {{ html()->text('sort_name', $parish->sort_name)->class('form-control') }}
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3 col-md-4">
                    {{ html()->label('Diocese:', 'diocese_id') }}
                    {{ html()->select('diocese_id', $dioceses, $parish->diocese_id)->class('form-control') }}
                </div>
                <div class="col-lg-3 col-md-4">
                    {{ html()->label('Pastor:', 'pastor_id') }}
                    @if (empty($parish->pastor->contact_b))
                        {{ html()->select('pastor_id', $pastors, 0)->class('form-control') }}
                    @else
                        {{ html()->select('pastor_id', $pastors, $parish->pastor->contact_b->id)->class('form-control') }}
                    @endIf
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3 col-md-4">
                    {{ html()->label('Address:', 'street_address') }}
                    {{ html()->text('street_address', $parish->address_primary_street)->class('form-control') }}
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3 col-md-4">
                    {{ html()->label('City:', 'city') }}
                    {{ html()->text('city', $parish->address_primary_city)->class('form-control') }}
                </div>
                <div class="col-lg-3 col-md-4">
                    {{ html()->label('State:', 'state_province_id') }}
                    {{ html()->select('state_province_id', $states, $parish->address_primary_state_id)->class('form-control') }}
                </div>
                <div class="col-lg-3 col-md-4">
                    {{ html()->label('Zip:', 'postal_code') }}
                    {{ html()->text('postal_code', $parish->address_primary_postal_code)->class('form-control') }}
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3 col-md-4">
                    {{ html()->label('Phone:', 'phone_main_phone') }}
                    @if (empty($parish->phone_main_phone_number))
                    {{ html()->text('phone_main_phone')->class('form-control') }}
                    @else
                    {{ html()->text('phone_main_phone', $parish->phone_main_phone_number)->class('form-control') }}
                    @endif
                </div>
                <div class="col-lg-3 col-md-4">
                    {{ html()->label('Fax:', 'phone_main_fax') }}
                    @if (empty($parish->phone_main_fax_number))
                    {{ html()->text('phone_main_fax')->class('form-control') }}
                    @else
                    {{ html()->text('phone_main_fax', $parish->phone_main_fax_number)->class('form-control') }}
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3 col-md-4">
                    {{ html()->label('Email:', 'email_primary') }}
                    {{ html()->text('email_primary', $parish->email_primary_text)->class('form-control') }}
                </div>
            </div>

            <div class="row">
                <div class="col-lg-3 col-md-4">
                    {{ html()->label('Parish note:', 'parish_note') }}
                    {{ html()->textarea('parish_note', $parish->note_parish_text)->class('form-control')->rows(3) }}

                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    {{ html()->label('Picture (max 5M): ', 'avatar') }}
                    {{ html()->file('avatar') }}
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    {{ html()->label('Attachment (max 10M): ', 'attachment') }}
                    {{ html()->file('attachment') }}
                </div>
                <div class="col-lg-3 col-md-4">
                    {{ html()->label('Description: (max 200)', 'attachment_description') }}
                    {{ html()->textarea('attachment_description')->class('form-control')->rows(3) }}
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-lg-12">
                    @include('parishes.update.urls')
                </div>
            </div>
            <div class="row text-center">
                <div class="col-lg-12 mt-3">
                    {{ html()->input('image', 'btnSave')->class('btn btn-outline-dark')->attribute('src', asset('images/save.png')) }}
                </div>
            </div>
        </div>
        {{ html()->form()->close() }}
    </div>
</div>
@stop
