@extends('template')
@section('content')

<div class="row bg-cover">
    <div class="col-12 text-center">
        {!!$parish->avatar_large_link!!}
        <h1>
            Edit Parish: {{ $parish->organization_name }}
        </h1>
    </div>
    <div class="col-12">
        {!! Form::open(['method' => 'PUT', 'files'=>'true', 'route' => ['parish.update', $parish->id]]) !!}
        {!! Form::hidden('id', $parish->id) !!}
        <div class="form-group">
            <div class="row">
                <div class="col-12 col-md-4">
                    {!! Form::label('organization_name', 'Name:') !!}
                    {!! Form::text('organization_name', $parish->organization_name, ['class' => 'form-control']) !!}
                </div>
                <div class="col-12 col-md-4">
                    {!! Form::label('display_name', 'Display:') !!}
                    {!! Form::text('display_name', $parish->display_name, ['class' => 'form-control']) !!}
                </div>
                <div class="col-12 col-md-4">
                    {!! Form::label('sort_name', 'Sort:') !!}
                    {!! Form::text('sort_name', $parish->sort_name, ['class' => 'form-control']) !!}
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-md-4">
                    {!! Form::label('diocese_id', 'Diocese:')  !!}
                    {!! Form::select('diocese_id', $dioceses, $parish->diocese_id, ['class' => 'form-control']) !!}
                </div>
                <div class="col-12 col-md-4">
                    {!! Form::label('pastor_id', 'Pastor:')  !!}
                    @if (empty($parish->pastor->contact_b))
                        {!! Form::select('pastor_id', $pastors, 0, ['class' => 'form-control']) !!}
                    @else
                        {!! Form::select('pastor_id', $pastors, $parish->pastor->contact_b->id, ['class' => 'form-control']) !!}
                    @endIf
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-md-4">
                    {!! Form::label('street_address', 'Address:') !!}
                    {!! Form::text('street_address', $parish->address_primary_street, ['class' => 'form-control']) !!}
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-md-4">
                    {!! Form::label('city', 'City:') !!}
                    {!! Form::text('city', $parish->address_primary_city, ['class' => 'form-control']) !!}
                </div>
                <div class="col-12 col-md-4">
                    {!! Form::label('state_province_id', 'State:') !!}
                    {!! Form::select('state_province_id', $states, $parish->address_primary_state_id, ['class' => 'form-control']) !!}
                </div>
                <div class="col-12 col-md-4">
                    {!! Form::label('postal_code', 'Zip:') !!}
                    {!! Form::text('postal_code', $parish->address_primary_postal_code, ['class' => 'form-control']) !!}
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-md-4">
                    {!! Form::label('phone_main_phone', 'Phone:') !!}
                    @if (empty($parish->phone_main_phone_number))
                    {!! Form::text('phone_main_phone', NULL, ['class' => 'form-control']) !!}
                    @else
                    {!! Form::text('phone_main_phone', $parish->phone_main_phone_number, ['class' => 'form-control']) !!}
                    @endif
                </div>
                <div class="col-12 col-md-4">
                    {!! Form::label('phone_main_fax', 'Fax:') !!}
                    @if (empty($parish->phone_main_fax_number))
                    {!! Form::text('phone_main_fax', NULL, ['class' => 'form-control']) !!}
                    @else
                    {!! Form::text('phone_main_fax', $parish->phone_main_fax_number, ['class' => 'form-control']) !!}
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-md-4">
                    {!! Form::label('email_primary', 'Email:') !!}
                    {!! Form::text('email_primary', $parish->email_primary_text, ['class' => 'form-control']) !!}
                </div>
            </div>

            <div class="row">
                <div class="col-12 col-md-4">
                    {!! Form::label('parish_note', 'Parish note:') !!}
                    {!! Form::textarea('parish_note', $parish->note_parish_text, ['class' => 'form-control', 'rows' => 3]) !!}

                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    {!! Form::label('avatar', 'Picture (max 5M): ')  !!}
                    {!! Form::file('avatar'); !!}
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    {!! Form::label('attachment', 'Attachment (max 10M): ')  !!}
                    {!! Form::file('attachment'); !!}
                </div>
                <div class="col-12 col-md-4">
                    {!! Form::label('attachment_description', 'Description: (max 200)')  !!}
                    {!! Form::textarea('attachment_description', NULL, ['class' => 'form-control', 'rows' => 3]) !!}
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-12">
                    @include('parishes.update.urls')
                </div>
            </div>
            <div class="row text-center">
                <div class="col-12 mt-3">
                    {!! Form::image('images/save.png','btnSave',['class' => 'btn btn-outline-dark']) !!}
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>
@stop
