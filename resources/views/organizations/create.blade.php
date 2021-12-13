@extends('template')
@section('content')

<div class="row bg-cover">
    <div class="col-lg-12">
        <h1>Add an Organization</h1>
    </div>
    <div class="col-lg-12">
        {!! Form::open(['url' => 'organization', 'method' => 'post']) !!}
            <div class="form-group">
                <div class="row">
                    <div class="col-lg-12 col-lg-4">
                        {!! Form::label('subcontact_type', 'Type') !!}
                        {!! Form::select('subcontact_type', $subcontact_types, 0, ['class' => 'form-control']) !!}
                    </div>
                    <div class="col-lg-12 col-lg-4">
                        {!! Form::label('organization_name', 'Name') !!}
                        {!! Form::text('organization_name', null, ['class'=>'form-control']) !!}
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 col-lg-4">
                        {!! Form::label('street_address', 'Address Line 1') !!}
                        {!! Form::text('street_address', null, ['class'=>'form-control']) !!}
                    </div>
                    <div class="col-lg-12 col-lg-4">
                        {!! Form::label('supplemental_address_1', 'Address Line 2') !!}
                        {!! Form::text('supplemental_address_1', null, ['class'=>'form-control']) !!}
                    </div>
                    <div class="col-lg-12 col-lg-4">
                        {!! Form::label('city', 'City') !!}
                        {!! Form::text('city', null, ['class'=>'form-control']) !!}
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 col-lg-4">
                        {!! Form::label('state_province_id', 'State') !!}
                        {!! Form::select('state_province_id', $states, $defaults['state_province_id'], ['class' => 'form-control']) !!}
                    </div>
                    <div class="col-lg-12 col-lg-4">
                        {!! Form::label('postal_code', 'Zip') !!}
                        {!! Form::text('postal_code', null, ['class'=>'form-control']) !!}
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 col-lg-4">
                        {!! Form::label('phone_main_phone', 'Phone') !!}
                        {!! Form::text('phone_main_phone', null, ['class'=>'form-control']) !!}
                    </div>
                    <div class="col-lg-12 col-lg-4">
                        {!! Form::label('phone_main_fax', 'Fax') !!}
                        {!! Form::text('phone_main_fax', null, ['class'=>'form-control']) !!}
                    </div>
                    <div class="col-lg-12 col-lg-4">
                        {!! Form::label('email_main', 'Email') !!}
                        {!! Form::text('email_main', null, ['class'=>'form-control']) !!}
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 col-lg-4">
                        {!! Form::label('note', 'Notes') !!}
                        {!! Form::textarea('note', null, ['class'=>'form-control', 'rows'=>'3']) !!}
                    </div>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-lg-12">
                    <h5>Websites</h5>
                </div>
                <div class="col-lg-12">
                    @include('organizations.create.urls')
                </div>
            </div>
            <div class="row text-center">
                <div class="col-lg-12">
                    {!! Form::submit('Add Organization', ['class'=>'btn btn-outline-dark']) !!}
                </div>
            </div>
        {!! Form::close() !!}
    </div>
</div>
@stop