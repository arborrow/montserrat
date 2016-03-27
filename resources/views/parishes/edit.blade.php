@extends('template')
@section('content')

<div class="jumbotron text-left">
    <h1>Edit Parish: {!! $parish->organization_name !!}</h1>
    {!! Form::open(['method' => 'PUT', 'route' => ['parish.update', $parish->id]]) !!}
    {!! Form::hidden('id', $parish->id) !!}
    <div class="form-group">
        {!! Form::label('diocese_id', 'Diocese:', ['class' => 'col-md-1'])  !!}
        {!! Form::select('diocese_id', $dioceses, $parish->diocese->contact_a->id, ['class' => 'col-md-2']) !!}
    </div><div class="clearfix"> </div>
 <div class="form-group">
        {!! Form::label('pastor_id', 'Pastor:', ['class' => 'col-md-1'])  !!} 
        @if (empty($parish->pastor->contact_b))
            {!! Form::select('pastor_id', $pastors, 0, ['class' => 'col-md-2']) !!}
        @else 
            {!! Form::select('pastor_id', $pastors, $parish->pastor->contact_b->id, ['class' => 'col-md-2']) !!}
        @endIf
    </div><div class="clearfix"> </div>

    <div class="form-group">
        {!! Form::label('organization_name', 'Name:', ['class' => 'col-md-1']) !!}
        {!! Form::text('organization_name', $parish->organization_name, ['class' => 'col-md-2']) !!}
    </div>
    <div class="clearfix"> </div>
    <div class="form-group">
        {!! Form::label('street_address', 'Address1:', ['class' => 'col-md-1']) !!}
        {!! Form::text('street_address', $parish->primary_address->street_address, ['class' => 'col-md-2']) !!}
    </div>
    <div class="clearfix"> </div>
    <div class="form-group">
        {!! Form::label('supplemental_address_1', 'Address2:', ['class' => 'col-md-1']) !!}
        {!! Form::text('supplemental_address_1', $parish->primary_address->supplemental_address_1, ['class' => 'col-md-2']) !!}
    </div>
    <div class="clearfix"> </div>
    <div class="form-group">
        {!! Form::label('city', 'City:', ['class' => 'col-md-1']) !!}
        {!! Form::text('city', $parish->primary_address->city, ['class' => 'col-md-2']) !!}
    </div>
    <div class="clearfix"> </div>
    <div class="form-group">
        {!! Form::label('state_province_id', 'State:', ['class' => 'col-md-1']) !!}
        {!! Form::select('state_province_id', $states, $parish->primary_address->state->id, ['class' => 'col-md-2']) !!}
            
    </div>
    <div class="clearfix"> </div>
    <div class="form-group">
        {!! Form::label('postal_code', 'Zip:', ['class' => 'col-md-1']) !!}
        {!! Form::text('postal_code', $parish->primary_address->postal_code, ['class' => 'col-md-2']) !!}
    </div>
    <div class="clearfix"> </div>
    <div class="form-group">
        {!! Form::label('phone_main_phone', 'Phone:', ['class' => 'col-md-1']) !!}
        @if (empty($parish->primary_phone))
        {!! Form::text('phone_main_phone', NULL, ['class' => 'col-md-2']) !!}
        @else
        {!! Form::text('phone_main_phone', $parish->primary_phone->phone, ['class' => 'col-md-2']) !!}
        @endif
    </div>
    <div class="clearfix"> </div>
    <div class="form-group">
        
        {!! Form::label('phone_main_fax', 'Fax:', ['class' => 'col-md-1']) !!}
        @if (empty($parish->website_main))
        {!! Form::text('phone_main_fax', NULL, ['class' => 'col-md-2']) !!}
        @else
        {!! Form::text('phone_main_fax', $parish->phone_main_fax->phone, ['class' => 'col-md-2']) !!}
        @endif
    </div>
    <div class="clearfix"> </div>
    <div class="form-group">
        {!! Form::label('primary_email', 'Email:', ['class' => 'col-md-1']) !!}
        {!! Form::text('primary_email', $parish->primary_email->email, ['class' => 'col-md-2']) !!}
    </div>
    <div class="clearfix"> </div>
    <div class="form-group">
        {!! Form::label('website_main', 'Webpage:', ['class' => 'col-md-1']) !!}
        @if (empty($parish->website_main))
        {!! Form::text('website_main', NULL, ['class' => 'col-md-2']) !!}
        @else
        {!! Form::text('website_main', $parish->website_main->url, ['class' => 'col-md-2']) !!}
        @endif
    </div>
    <div class="clearfix"> </div>
    <!-- commenting out notes - adding notes should be done when showing the record similar to touchpoints
    // TODO: figure out how to edit and delete notes
    <div class="form-group">
        {!! Form::label('notes', 'Notes:', ['class' => 'col-md-1']) !!}
        {!! Form::textarea('notes', $parish->notes, ['class' => 'col-md-5', 'rows'=>'3']) !!}
    </div>
    <div class="clearfix"> </div>
    -->
    <div class="form-group">
        {!! Form::image('img/save.png','btnSave',['class' => 'btn btn-primary']) !!}
    </div>
    {!! Form::close() !!}
</div>
@stop