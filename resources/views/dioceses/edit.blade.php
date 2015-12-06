@extends('template')
@section('content')

<div class="jumbotron text-left">
    <h1>Edit Diocese: {!! $diocese->name !!}</h1>
    {!! Form::open(['method' => 'PUT', 'route' => ['diocese.update', $diocese->id]]) !!}
    {!! Form::hidden('id', $diocese->id) !!}
    
    <div class="form-group">
        {!! Form::label('bishop_id', 'Bishop:', ['class' => 'col-md-1'])  !!}
        {!! Form::select('bishop_id', $bishops, $diocese->bishop_id, ['class' => 'col-md-2']) !!}
    </div><div class="clearfix"> </div>

    <div class="form-group">
        {!! Form::label('name', 'Name:', ['class' => 'col-md-1']) !!}
        {!! Form::text('name', $diocese->name, ['class' => 'col-md-2']) !!}
    </div>
    <div class="clearfix"> </div>
    <div class="form-group">
        {!! Form::label('address1', 'Address1:', ['class' => 'col-md-1']) !!}
        {!! Form::text('address1', $diocese->address1, ['class' => 'col-md-2']) !!}
    </div>
    <div class="clearfix"> </div>
    <div class="form-group">
        {!! Form::label('address2', 'Address2:', ['class' => 'col-md-1']) !!}
        {!! Form::text('address2', $diocese->address2, ['class' => 'col-md-2']) !!}
    </div>
    <div class="clearfix"> </div>
    <div class="form-group">
        {!! Form::label('city', 'City:', ['class' => 'col-md-1']) !!}
        {!! Form::text('city', $diocese->city, ['class' => 'col-md-2']) !!}
    </div>
    <div class="clearfix"> </div>
    <div class="form-group">
        {!! Form::label('state', 'State:', ['class' => 'col-md-1']) !!}
        {!! Form::text('state', $diocese->state, ['class' => 'col-md-2']) !!}
    </div>
    <div class="clearfix"> </div>
    <div class="form-group">
        {!! Form::label('zip', 'Zip:', ['class' => 'col-md-1']) !!}
        {!! Form::text('zip', $diocese->zip, ['class' => 'col-md-2']) !!}
    </div>
    <div class="clearfix"> </div>
    <div class="form-group">
        {!! Form::label('phone', 'Phone:', ['class' => 'col-md-1']) !!}
        {!! Form::text('phone', $diocese->phone, ['class' => 'col-md-2']) !!}
    </div>
    <div class="clearfix"> </div>
    <div class="form-group">
        {!! Form::label('fax', 'Fax:', ['class' => 'col-md-1']) !!}
        {!! Form::text('fax', $diocese->fax, ['class' => 'col-md-2']) !!}
    </div>
    <div class="clearfix"> </div>
    <div class="form-group">
        {!! Form::label('email', 'Email:', ['class' => 'col-md-1']) !!}
        {!! Form::text('email', $diocese->email, ['class' => 'col-md-2']) !!}
    </div>
    <div class="clearfix"> </div>
    <div class="form-group">
        {!! Form::label('webpage', 'Webpage:', ['class' => 'col-md-1']) !!}
        {!! Form::text('webpage', $diocese->webpage, ['class' => 'col-md-2']) !!}
    </div>
    <div class="clearfix"> </div>
    <div class="form-group">
        {!! Form::label('notes', 'Notes:', ['class' => 'col-md-1']) !!}
        {!! Form::textarea('notes', $diocese->notes, ['class' => 'col-md-5', 'rows'=>'3']) !!}
    </div>
    <div class="clearfix"> </div>
    
    <div class="form-group">
        {!! Form::image('img/save.png','btnSave',['class' => 'btn btn-primary']) !!}
    </div>
    {!! Form::close() !!}
</div>
@stop