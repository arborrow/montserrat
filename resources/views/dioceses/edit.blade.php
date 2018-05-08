@extends('template')
@section('content')

<div class="jumbotron text-left">
    <h1>Edit Diocese: {!! $diocese->name !!}</h1>
    {!! Form::open(['method' => 'PUT', 'files'=>'true', 'route' => ['diocese.update', $diocese->id]]) !!}
    {!! Form::hidden('id', $diocese->id) !!}
    
    <div class="form-group">
        {!! Form::label('bishop_id', 'Bishop:', ['class' => 'col-md-1'])  !!}
        {!! Form::select('bishop_id', $bishops, $diocese->bishop_id, ['class' => 'col-md-2']) !!}
    </div><div class="clearfix"> </div>
    <div class="form-group">
        {!! Form::label('organization_name', 'Name:', ['class' => 'col-md-1']) !!}
        {!! Form::text('organization_name', $diocese->organization_name, ['class' => 'col-md-2']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('display_name', 'Display:', ['class' => 'col-md-1']) !!}
        {!! Form::text('display_name', $diocese->display_name, ['class' => 'col-md-2']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('sort_name', 'Sort:', ['class' => 'col-md-1']) !!}
        {!! Form::text('sort_name', $diocese->sort_name, ['class' => 'col-md-2']) !!}
    </div>
    <div class="clearfix"> </div>
    <div class="form-group">
        {!! Form::label('street_address', 'Address1:', ['class' => 'col-md-1']) !!}
        {!! Form::text('street_address', $diocese->address_primary->street_address, ['class' => 'col-md-2']) !!}
    </div>
    <div class="clearfix"> </div>
    <div class="form-group">
        {!! Form::label('supplemental_address_1', 'Address2:', ['class' => 'col-md-1']) !!}
        {!! Form::text('supplemental_address_1', $diocese->address_primary->supplemental_address_1, ['class' => 'col-md-2']) !!}
    </div>
    <div class="clearfix"> </div>
    <div class="form-group">
        {!! Form::label('city', 'City:', ['class' => 'col-md-1']) !!}
        {!! Form::text('city', $diocese->address_primary->city, ['class' => 'col-md-2']) !!}
    </div>
    <div class="clearfix"> </div>
    <div class="form-group">
        {!! Form::label('state_province_id', 'State:', ['class' => 'col-md-1']) !!}
        {!! Form::select('state_province_id', $states, $diocese->address_primary->state_province_id, ['class' => 'col-md-2']) !!}
            
    </div>
    <div class="clearfix"> </div>
    <div class="form-group">
        {!! Form::label('postal_code', 'Zip:', ['class' => 'col-md-1']) !!}
        {!! Form::text('postal_code', $diocese->address_primary->postal_code, ['class' => 'col-md-2']) !!}
    </div>
    <div class="clearfix"> </div>
    <div class="form-group">
        {!! Form::label('phone_main_phone', 'Phone:', ['class' => 'col-md-1']) !!}
        {!! Form::text('phone_main_phone', $diocese->phone_primary->phone, ['class' => 'col-md-2']) !!}
    </div>
    <div class="clearfix"> </div>
    <div class="form-group">
        {!! Form::label('phone_main_fax', 'Fax:', ['class' => 'col-md-1']) !!}
        @if (isset($diocese->phone_main_fax->phone))
            {!! Form::text('phone_main_fax', $diocese->phone_main_fax->phone, ['class' => 'col-md-2']) !!}
        @else
            {!! Form::text('phone_main_fax', NULL, ['class' => 'col-md-2']) !!}
        @endif
        
    </div>
    <div class="clearfix"> </div>
    <div class="form-group">
        {!! Form::label('email_primary', 'Email:', ['class' => 'col-md-1']) !!}
        {!! Form::text('email_primary', $diocese->email_primary_text, ['class' => 'col-md-2']) !!}
    </div>
    <div class="clearfix"> </div>
    <div class="clearfix"> </div>
    <div class="form-group">
    
        {!! Form::label('avatar', 'Picture (max 5M): ', ['class' => 'col-md-2'])  !!}
        {!! Form::file('avatar',['class' => 'col-md-2']); !!}
    </div>
    <div class="clearfix"> </div>
    <div class="form-group">

        {!! Form::label('attachment', 'Attachment (max 10M): ', ['class' => 'col-md-2'])  !!}
        {!! Form::file('attachment',['class' => 'col-md-2']); !!}
        {!! Form::label('attachment_description', 'Description: (max 200)', ['class' => 'col-md-2'])  !!}
        {!! Form::text('attachment_description', NULL, ['class' => 'col-md-3']) !!}
    </div>
    <div class="clearfix"> </div>
    <div class='form-group'>
        @include('dioceses.update.urls')
    </div>
    <div class="clearfix"> </div>
    
    <!-- removing notes for now
    <div class="form-group">
        {!! Form::label('notes', 'Notes:', ['class' => 'col-md-1']) !!}
        {!! Form::textarea('notes', $diocese->notes, ['class' => 'col-md-5', 'rows'=>'3']) !!}
    </div>
    <div class="clearfix"> </div>
    -->
    <div class="form-group">
        {!! Form::image('img/save.png','btnSave',['class' => 'btn btn-primary']) !!}
    </div>
    {!! Form::close() !!}
</div>
@stop