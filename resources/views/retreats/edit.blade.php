@extends('template')
@section('content')

<div class="jumbotron text-left">
    <h1>Edit Retreat {!! $retreat->idnumber !!}</h1>
    {!! Form::open(['method' => 'PUT', 'route' => ['retreat.update', $retreat->id]]) !!}
    {!! Form::hidden('id', $retreat->id) !!}
    <div class="form-group">
        {!! Form::label('idnumber', 'ID Number:', ['class' => 'col-md-1'])  !!}
        {!! Form::text('idnumber', $retreat->idnumber, ['class' => 'col-md-1']) !!}
    </div><div class="clearfix"> </div>
    
    <div class="form-group">
        {!! Form::label('start', 'Starts:', ['class' => 'col-md-1']) !!}
        {!! Form::text('start', $retreat->start, ['id' => 'startdate', 'class' => 'col-md-2']) !!}
        <!--{!! Form::text('start', $retreat->start, ['class' => 'col-md-2']) !!} -->
        {!! Form::label('end', 'Ends:', ['class' => 'col-md-1']) !!}
        {!! Form::text('end', $retreat->end, ['id' => 'enddate', 'class' => 'col-md-2']) !!}
        <!--{!! Form::text('end', $retreat->end, ['class' => 'col-md-2']) !!} -->
    </div>
    <div class="clearfix"> </div>

    <div class="form-group">
        {!! Form::label('title', 'Title:', ['class' => 'col-md-1']) !!}
        {!! Form::text('title', $retreat->title, ['class' => 'col-md-2']) !!}
        {!! Form::label('attending', 'Attending:', ['class' => 'col-md-1']) !!}
        {!! Form::text('attending', $retreat->attending, ['class' => 'col-md-1']) !!}
    </div>
    <div class="clearfix"> </div>
    <div class="form-group">
        {!! Form::label('description', 'Description:', ['class' => 'col-md-1']) !!}
        {!! Form::textarea('body', $retreat->desription, ['class' => 'col-md-5', 'rows'=>'3']) !!}
    </div>
    <div class="clearfix"> </div>
    <div class="form-group">
        {!! Form::label('directorid', 'Director:', ['class' => 'col-md-1']) !!}
        {!! Form::select('directorid', $d, $retreat->directorid, ['class' => 'col-md-2']) !!}
        {!! Form::label('innkeeperid', 'Innkeeper:', ['class' => 'col-md-1']) !!}
        {!! Form::select('innkeeperid', $i, $retreat->innkeeperid, ['class' => 'col-md-2']) !!}
        {!! Form::label('assistantid', 'Assistant:', ['class' => 'col-md-1']) !!}
        {!! Form::select('assistantid', $a, $retreat->assistantid, ['class' => 'col-md-2']) !!}


    </div>
    <div class="clearfix"> </div>
    <div class="form-group">
        {!! Form::label('type', 'Type:', ['class' => 'col-md-1']) !!}
        {!! Form::text('type', $retreat->type, ['class' => 'col-md-1']) !!}
    <!--<div class='left-checkbox'>    {!! Form::label('silent', 'Silent:', ['class' => 'col-md-1']) !!} -->
    <label class="col-md-1" for="silent">Silent:  {!! Form::checkbox('silent', 1, $retreat->silent, ['class' => 'col-md-1']) !!}</label> <!--</div>-->
        {!! Form::label('amount', 'Donation:', ['class' => 'col-md-1']) !!}
        {!! Form::text('amount', $retreat->amount, ['class' => 'col-md-1']) !!}
    </div>
    <div class="clearfix"> </div>
    <div class="form-group">
        {!! Form::label('year', 'Year:', ['class' => 'col-md-1']) !!}
        {!! Form::text('year', $retreat->year, ['class' => 'col-md-1']) !!}
    </div>
    <div class="clearfix"> </div>
    
    <div class="form-group">
        {!! Form::image('img/save.png','btnSave',['class' => 'btn btn-primary']) !!}
    </div>
    {!! Form::close() !!}
</div>
@stop