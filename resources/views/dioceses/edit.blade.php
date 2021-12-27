@extends('template')
@section('content')

<div class="row bg-cover">
    <div class="col-lg-12 text-center">
        {!!$diocese->avatar_large_link!!}
        <h1>Edit: {{ $diocese->full_name }}</h1>
    </div>
    <div class="col-lg-12">
        {!! Form::open(['method' => 'PUT', 'files'=>'true', 'route' => ['diocese.update', $diocese->id]]) !!}
            {!! Form::hidden('id', $diocese->id) !!}
            <div class="row text-center">
                <div class="col-lg-12 mt-2 mb-3">
                    {!! Form::image('images/save.png','btnSave',['class' => 'btn btn-outline-dark']) !!}
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <h2>Basic Information</h2>
                </div>
                <div class="col-lg-12">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-lg-12 col-md-4">
                                {!! Form::label('bishop_id', 'Bishop')  !!}
                                {!! Form::select('bishop_id', $bishops, $diocese->bishop_id, ['class' => 'form-control']) !!}
                            </div>
                            <div class="col-lg-12 col-md-4">
                                {!! Form::label('organization_name', 'Name') !!}
                                {!! Form::text('organization_name', $diocese->organization_name, ['class' => 'form-control']) !!}
                            </div>
                            <div class="col-lg-12 col-md-4">
                                {!! Form::label('display_name', 'Display') !!}
                                {!! Form::text('display_name', $diocese->display_name, ['class' => 'form-control']) !!}
                            </div>
                            <div class="col-lg-12 col-md-4">
                                {!! Form::label('sort_name', 'Sort') !!}
                                {!! Form::text('sort_name', $diocese->sort_name, ['class' => 'form-control']) !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <h2>Address</h2>
                </div>
                <div class="col-lg-12">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-lg-12 col-md-6">
                                {!! Form::label('street_address', 'Address Line 1') !!}
                                {!! Form::text('street_address', $diocese->address_primary_street, ['class' => 'form-control']) !!}
                            </div>
                            <div class="col-lg-12 col-md-6">
                                {!! Form::label('supplemental_address_1', 'Address Line 2') !!}
                                {!! Form::text('supplemental_address_1', $diocese->address_primary_supplemental_address, ['class' => 'form-control']) !!}
                            </div>
                            <div class="col-lg-12 col-md-3">
                                {!! Form::label('city', 'City') !!}
                                {!! Form::text('city', $diocese->address_primary_city, ['class' => 'form-control']) !!}
                            </div>
                            <div class="col-lg-12 col-md-3">
                                {!! Form::label('state_province_id', 'State') !!}
                                {!! Form::select('state_province_id', $states, $diocese->address_primary_state_id, ['class' => 'form-control']) !!}
                            </div>
                            <div class="col-lg-12 col-md-3">
                                {!! Form::label('postal_code', 'Zip') !!}
                                {!! Form::text('postal_code', $diocese->address_primary_postal_code, ['class' => 'form-control']) !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <h2>Contact Information</h2>
                </div>
                <div class="col-lg-12">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-lg-12 col-md-4">
                                {!! Form::label('phone_main_phone', 'Phone') !!}
                                {!! Form::text('phone_main_phone', $diocese->phone_main_phone_number, ['class' => 'form-control']) !!}
                            </div>
                            <div class="col-lg-12 col-md-4">
                                {!! Form::label('phone_main_fax', 'Fax') !!}
                                {!! Form::text('phone_main_fax', $diocese->phone_main_fax_number, ['class' => 'form-control']) !!}
                            </div>
                            <div class="col-lg-12 col-md-4">
                                {!! Form::label('email_primary', 'Email') !!}
                                {!! Form::text('email_primary', $diocese->email_primary_text, ['class' => 'form-control']) !!}
                            </div>
                            <div class="col-lg-12 col-md-4">
                                {!! Form::label('diocese_note', 'Note:') !!}
                                {!! Form::textarea('diocese_note', $diocese->note_diocese_text, ['class' => 'form-control', 'rows' => 3]) !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <h2>Websites</h2>
                </div>
                <div class="col-lg-12">
                    @include('dioceses.update.urls')
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <h2>Other</h2>
                </div>
                <div class="col-lg-12">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="col-lg-12">
                                        {!! Form::label('avatar', 'Picture (max 5M)') !!}
                                        {!! Form::file('avatar'); !!}
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="col-lg-12">
                                        {!! Form::label('attachment', 'Attachment (max 10M): ', ['class' => ''])  !!}
                                        {!! Form::file('attachment',['class' => '']); !!}
                                    </div>
                                    <div class="col-lg-6">
                                        {!! Form::label('attachment_description', 'Attachment Description (max 200)')  !!}
                                        {!! Form::text('attachment_description', NULL, ['class' => 'form-control']) !!}
                                    </div>
                                </div>
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
