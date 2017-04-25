@extends('template')
@section('content')

<div class="jumbotron text-left">
    <h1>Edit Organization: {{ $organization->name }}</h1>
    {!! Form::open(['method' => 'PUT', 'files'=>'true', 'route' => ['organization.update', $organization->id]]) !!}
    {!! Form::hidden('id', $organization->id) !!}
    
    <div class="form-group">
        {!! Form::label('organization_name', 'Name:', ['class' => 'col-md-2']) !!}
        {!! Form::text('organization_name', $organization->organization_name, ['class' => 'col-md-4']) !!}
    </div><div class="clearfix"> </div>

    <div class="form-group">
        {!! Form::label('subcontact_type', 'Subcontact type: ', ['class' => 'col-md-2'])  !!}
        {!! Form::select('subcontact_type', $subcontact_types, $organization->subcontact_type, ['class' => 'col-md-2']) !!}
    </div><div class="clearfix"> </div>
    
    <div class="form-group">
        {!! Form::label('display_name', 'Display Name:', ['class' => 'col-md-2']) !!}
        {!! Form::text('display_name', $organization->display_name, ['class' => 'col-md-4']) !!}
    </div><div class="clearfix"> </div>
    <div class="form-group">
        {!! Form::label('sort_name', 'Sort Name:', ['class' => 'col-md-2']) !!}
        {!! Form::text('sort_name', $organization->sort_name, ['class' => 'col-md-4']) !!}
    </div>
    <div class="clearfix"> </div>
    <div class="form-group">
        {!! Form::label('street_address', 'Street 1:', ['class' => 'col-md-2']) !!}
        @if (isset($organization->address_primary))
            {!! Form::text('street_address', $organization->address_primary->street_address, ['class' => 'col-md-4']) !!}
        @else
            {!! Form::text('street_address', NULL, ['class' => 'col-md-4']) !!}
        @endIf
    </div>
    <div class="clearfix"> </div>
    <div class="form-group">
        {!! Form::label('supplemental_address_1', 'Street 2:', ['class' => 'col-md-2']) !!}
        @if (isset($organization->address_primary))
            {!! Form::text('supplemental_address_1', $organization->address_primary->supplemental_address_1, ['class' => 'col-md-4']) !!}
        @else 
            {!! Form::text('supplemental_address_1', NULL, ['class' => 'col-md-4']) !!}
        @endIf
    </div>
    <div class="clearfix"> </div>
    <div class="form-group">
        {!! Form::label('city', 'City:', ['class' => 'col-md-2']) !!}
        @if (isset($organization->address_primary))
            {!! Form::text('city', $organization->address_primary->city, ['class' => 'col-md-2']) !!}
        @else
            {!! Form::text('city', NULL, ['class' => 'col-md-2']) !!}
        @endIf
    </div>
    <div class="clearfix"> </div>
    <div class="form-group">
        {!! Form::label('state_province_id', 'State:', ['class' => 'col-md-2']) !!}
        @if (isset($organization->address_primary))
            {!! Form::select('state_province_id', $states, $organization->address_primary->state_province_id, ['class' => 'col-md-2']) !!}
        @else 
            {!! Form::select('state_province_id', $states, 1042, ['class' => 'col-md-2']) !!}
        @endIf    
    </div>
    <div class="clearfix"> </div>
    <div class="form-group">
        {!! Form::label('postal_code', 'Zip:', ['class' => 'col-md-2']) !!}
        @if (isset($organization->address_primary))
            {!! Form::text('postal_code', $organization->address_primary->postal_code, ['class' => 'col-md-2']) !!}
        @else
            {!! Form::text('postal_code', NULL, ['class' => 'col-md-2']) !!}
        @endIf
    </div>
    <div class="clearfix"> </div>
    <div class="form-group">
        {!! Form::label('phone_main_phone', 'Phone:', ['class' => 'col-md-2']) !!}
        @if (isset($organization->phone_main_phone->phone))
            {!! Form::text('phone_main_phone', $organization->phone_main_phone->phone, ['class' => 'col-md-2']) !!}
        @else
            {!! Form::text('phone_main_phone', NULL, ['class' => 'col-md-2']) !!}
        @endif    
    </div>
    <div class="clearfix"> </div>
    <div class="form-group">
        {!! Form::label('phone_main_fax', 'Fax:', ['class' => 'col-md-2']) !!}
        @if (isset($organization->phone_main_fax->phone))
            {!! Form::text('phone_main_fax', $organization->phone_main_fax->phone, ['class' => 'col-md-2']) !!}
        @else
            {!! Form::text('phone_main_fax', NULL, ['class' => 'col-md-2']) !!}
        @endif
        
    </div>
    <div class="clearfix"> </div>
    <div class="form-group">
        {!! Form::label('email_primary', 'Email:', ['class' => 'col-md-2']) !!}
        @if (isset($organization->email_primary))
            {!! Form::text('email_primary', $organization->email_primary->email, ['class' => 'col-md-3']) !!}
        @else 
            {!! Form::text('email_primary', NULL, ['class' => 'col-md-3']) !!}
        @endIf
    </div>
    <div class="clearfix"> </div>
    <div class="form-group">
       {!! Form::label('note', 'Notes:', ['class' => 'col-md-2']) !!}
        @if (isset($organization->note_organization_text)) 
            {!! Form::textarea('note', $organization->note_organization_text, ['class'=>'col-md-5', 'rows'=>'3']) !!}
        @else
            {!! Form::textarea('note', $organization->note_organization_text, ['class'=>'col-md-5', 'rows'=>'3']) !!}
        @endIf
    </div>        
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
        @include('organizations.update.urls')
    </div>
    <div class="clearfix"> </div>
    
    
    <!-- removing notes for now
    <div class="form-group">
        {!! Form::label('notes', 'Notes:', ['class' => 'col-md-1']) !!}
        {!! Form::textarea('notes', $organization->notes, ['class' => 'col-md-5', 'rows'=>'3']) !!}
    </div>
    <div class="clearfix"> </div>
    -->
    <div class="form-group">
        {!! Form::image('img/save.png','btnSave',['class' => 'btn btn-primary']) !!}
    </div>
    {!! Form::close() !!}
</div>
@stop