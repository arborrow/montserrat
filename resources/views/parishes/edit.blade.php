@extends('template')
@section('content')

<div class="jumbotron text-left">
    <h1>Edit Parish: {!! $parish->name !!}</h1>
    {!! Form::open(['method' => 'PUT', 'route' => ['parish.update', $parish->id]]) !!}
    {!! Form::hidden('id', $parish->id) !!}
    <div class="form-group">
        {!! Form::label('diocese_id', 'Diocese:', ['class' => 'col-md-1'])  !!}
        {!! Form::select('diocese_id', $dioceses, $parish->diocese_id, ['class' => 'col-md-2']) !!}
    </div><div class="clearfix"> </div>
 <div class="form-group">
        {!! Form::label('pastor_id', 'Pastor:', ['class' => 'col-md-1'])  !!} 
        @if (empty($parish->pastor_id))
            {!! Form::select('pastor_id', $pastors, 0, ['class' => 'col-md-2']) !!}
        @else 
            {!! Form::select('pastor_id', $pastors, $parish->pastor_id, ['class' => 'col-md-2']) !!}
        @endIf
    </div><div class="clearfix"> </div>

    <div class="form-group">
        {!! Form::label('name', 'Name:', ['class' => 'col-md-1']) !!}
        {!! Form::text('name', $parish->name, ['class' => 'col-md-2']) !!}
    </div>
    <div class="clearfix"> </div>
    <div class="form-group">
        {!! Form::label('address1', 'Address1:', ['class' => 'col-md-1']) !!}
        {!! Form::text('address1', $parish->address1, ['class' => 'col-md-2']) !!}
    </div>
    <div class="clearfix"> </div>
    <div class="form-group">
        {!! Form::label('address2', 'Address2:', ['class' => 'col-md-1']) !!}
        {!! Form::text('address2', $parish->address2, ['class' => 'col-md-2']) !!}
    </div>
    <div class="clearfix"> </div>
    <div class="form-group">
        {!! Form::label('city', 'City:', ['class' => 'col-md-1']) !!}
        {!! Form::text('city', $parish->city, ['class' => 'col-md-2']) !!}
    </div>
    <div class="clearfix"> </div>
    <div class="form-group">
        {!! Form::label('state', 'State:', ['class' => 'col-md-1']) !!}
        {!! Form::text('state', $parish->state, ['class' => 'col-md-2']) !!}
    </div>
    <div class="clearfix"> </div>
    <div class="form-group">
        {!! Form::label('zip', 'Zip:', ['class' => 'col-md-1']) !!}
        {!! Form::text('zip', $parish->zip, ['class' => 'col-md-2']) !!}
    </div>
    <div class="clearfix"> </div>
    <div class="form-group">
        {!! Form::label('phone', 'Phone:', ['class' => 'col-md-1']) !!}
        {!! Form::text('phone', $parish->phone, ['class' => 'col-md-2']) !!}
    </div>
    <div class="clearfix"> </div>
    <div class="form-group">
        {!! Form::label('fax', 'Fax:', ['class' => 'col-md-1']) !!}
        {!! Form::text('fax', $parish->fax, ['class' => 'col-md-2']) !!}
    </div>
    <div class="clearfix"> </div>
    <div class="form-group">
        {!! Form::label('email', 'Email:', ['class' => 'col-md-1']) !!}
        {!! Form::text('email', $parish->email, ['class' => 'col-md-2']) !!}
    </div>
    <div class="clearfix"> </div>
    <div class="form-group">
        {!! Form::label('webpage', 'Webpage:', ['class' => 'col-md-1']) !!}
        {!! Form::text('webpage', $parish->webpage, ['class' => 'col-md-2']) !!}
    </div>
    <div class="clearfix"> </div>
    <div class="form-group">
        {!! Form::label('notes', 'Notes:', ['class' => 'col-md-1']) !!}
        {!! Form::textarea('notes', $parish->notes, ['class' => 'col-md-5', 'rows'=>'3']) !!}
    </div>
    <div class="clearfix"> </div>
    
    <div class="form-group">
        {!! Form::image('img/save.png','btnSave',['class' => 'btn btn-primary']) !!}
    </div>
    {!! Form::close() !!}
</div>
@stop