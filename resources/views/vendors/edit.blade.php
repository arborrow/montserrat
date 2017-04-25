@extends('template')
@section('content')

<div class="jumbotron text-left">
    <h1>Edit Vendor: {!! $vendor->organization_name !!}</h1>
    {!! Form::open(['method' => 'PUT', 'files'=>'true', 'route' => ['vendor.update', $vendor->id]]) !!}
    {!! Form::hidden('id', $vendor->id) !!}
    
    <div class="form-group">
        {!! Form::label('organization_name', 'Name:', ['class' => 'col-md-1']) !!}
        {!! Form::text('organization_name', $vendor->organization_name, ['class' => 'col-md-2']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('display_name', 'Display:', ['class' => 'col-md-1']) !!}
        {!! Form::text('display_name', $vendor->display_name, ['class' => 'col-md-2']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('sort_name', 'Sort:', ['class' => 'col-md-1']) !!}
        {!! Form::text('sort_name', $vendor->sort_name, ['class' => 'col-md-2']) !!}
    </div>
    <div class="clearfix"> </div>
    <div class="form-group">
        {!! Form::label('street_address', 'Address:', ['class' => 'col-md-1']) !!}
        {!! Form::text('street_address', $vendor->address_primary_street, ['class' => 'col-md-2']) !!}
    </div>
    <div class="clearfix"> </div>
    <div class="clearfix"> </div>
    <div class="form-group">
        {!! Form::label('city', 'City:', ['class' => 'col-md-1']) !!}
        {!! Form::text('city', $vendor->address_primary_city, ['class' => 'col-md-2']) !!}
    </div>
    <div class="clearfix"> </div>
    <div class="form-group">
        {!! Form::label('state_province_id', 'State:', ['class' => 'col-md-1']) !!}
        {!! Form::select('state_province_id', $states, $vendor->address_primary_state, ['class' => 'col-md-2']) !!}
            
    </div>
    <div class="clearfix"> </div>
    <div class="form-group">
        {!! Form::label('postal_code', 'Zip:', ['class' => 'col-md-1']) !!}
        {!! Form::text('postal_code', $vendor->address_primary_postal_code, ['class' => 'col-md-2']) !!}
    </div>
    <div class="clearfix"> </div>
    <div class="form-group">
        {!! Form::label('phone_main_phone', 'Phone:', ['class' => 'col-md-1']) !!}
        @if (empty($vendor->phone_primary))
        {!! Form::text('phone_main_phone', NULL, ['class' => 'col-md-2']) !!}
        @else
        {!! Form::text('phone_main_phone', $vendor->phone_primary->phone, ['class' => 'col-md-2']) !!}
        @endif
    </div>
    <div class="clearfix"> </div>
    <div class="form-group">
        
        {!! Form::label('phone_main_fax', 'Fax:', ['class' => 'col-md-1']) !!}
        @if (empty($vendor->phone_main_fax))
        {!! Form::text('phone_main_fax', NULL, ['class' => 'col-md-2']) !!}
        @else
        {!! Form::text('phone_main_fax', $vendor->phone_main_fax->phone, ['class' => 'col-md-2']) !!}
        @endif
    </div>
    <div class="clearfix"> </div>
    <div class="form-group">
        {!! Form::label('email_primary', 'Email:', ['class' => 'col-md-1']) !!}
        {!! Form::text('email_primary', $vendor->email_primary->email, ['class' => 'col-md-2']) !!}
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
        @include('vendors.update.urls')
    </div>
    <div class="clearfix"> </div>
    
    <!-- commenting out notes - adding notes should be done when showing the record similar to touchpoints
    // TODO: figure out how to edit and delete notes
    <div class="form-group">
        {!! Form::label('notes', 'Notes:', ['class' => 'col-md-1']) !!}
        {!! Form::textarea('notes', $vendor->notes, ['class' => 'col-md-5', 'rows'=>'3']) !!}
    </div>
    <div class="clearfix"> </div>
    -->
    <div class="form-group">
        {!! Form::image('img/save.png','btnSave',['class' => 'btn btn-primary']) !!}
    </div>
    {!! Form::close() !!}
</div>
@stop