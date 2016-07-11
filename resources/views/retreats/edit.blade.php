@extends('template')
@section('content')

<div class="jumbotron text-left">
    <h1>Edit Retreat {!! $retreat->idnumber !!}</h1>
    {!! Form::open(['method' => 'PUT', 'route' => ['retreat.update', $retreat->id]]) !!}
    {!! Form::hidden('id', $retreat->id) !!}
    <div class="form-group">
        {!! Form::label('idnumber', 'ID#:', ['class' => 'col-md-1'])  !!}
        {!! Form::text('idnumber', $retreat->idnumber, ['class' => 'col-md-1']) !!}
    </div><div class="clearfix"> </div>
    
    <div class="form-group">
        {!! Form::label('start_date', 'Starts:', ['class' => 'col-md-1']) !!}
        {!! Form::text('start_date', date('m/d/Y', strtotime($retreat->start_date)), ['id' => 'start_date', 'class' => 'col-md-2']) !!}
        <!--{!! Form::text('start', $retreat->start, ['class' => 'col-md-2']) !!} -->
        {!! Form::label('end_date', 'Ends:', ['class' => 'col-md-1']) !!}
        {!! Form::text('end_date', date('m/d/Y', strtotime($retreat->end_date)), ['id' => 'end_date', 'class' => 'col-md-2']) !!}
        <!--{!! Form::text('end', $retreat->end, ['class' => 'col-md-2']) !!} -->
    </div>
    <div class="clearfix"> </div>

    <div class="form-group">
        {!! Form::label('title', 'Title:', ['class' => 'col-md-1']) !!}
        {!! Form::text('title', $retreat->title, ['class' => 'col-md-5']) !!}
<!--        {!! Form::label('attending', 'Attending:', ['class' => 'col-md-1']) !!}
        {!! Form::text('attending', $retreat->attending, ['class' => 'col-md-1']) !!} -->
    </div>
    <div class="clearfix"> </div>
    <div class="form-group">
        {!! Form::label('description', 'Description:', ['class' => 'col-md-1']) !!}
        {!! Form::textarea('description', $retreat->description, ['class' => 'col-md-5', 'rows'=>'3']) !!}
    </div>
    <div class="clearfix"> </div>
    <div class="form-group">    
        {!! Form::label('directors','Director(s):', ['class' => 'col-md-1'])  !!}
        {!! Form::select('directors[]', $d, 
            $retreat->retreatmasters->lists('id')->toArray(),
            ['class' => 'form-control col-md-2','multiple' => 'multiple','style'=>'width: auto; font-size: inherit;']) !!}
    </div><div class="clearfix"> </div>
    
    <div class="form-group">
        {!! Form::label('innkeeper_id', 'Innkeeper:', ['class' => 'col-md-1']) !!}
        {!! Form::select('innkeeper_id', $i, $retreat->innkeeper_id, ['class' => 'col-md-2']) !!}
    </div><div class="clearfix"> </div>

    <div class="form-group">
        {!! Form::label('assistant_id', 'Assistant:', ['class' => 'col-md-1']) !!}
        {!! Form::select('assistant_id', $a, $retreat->assistant_id, ['class' => 'col-md-2']) !!}
    </div><div class="clearfix"> </div>
    
    <div class="form-group">
        {!! Form::label('event_type', 'Type: ', ['class' => 'col-md-1']) !!}
        {!! Form::select('event_type', $event_types, $retreat->event_type_id, ['class' => 'col-md-2']) !!}
    </div><div class="clearfix"> </div>
    <!--    
    <div class="form-group">
        {!! Form::label('type', 'Type:', ['class' => 'col-md-1']) !!}
        {!! Form::text('type', $retreat->type, ['class' => 'col-md-1']) !!}
        <div class='left-checkbox'>    {!! Form::label('silent', 'Silent:', ['class' => 'col-md-1']) !!}
        <label class="col-md-1" for="silent">Silent:  {!! Form::checkbox('silent', 1, $retreat->silent, ['class' => 'col-md-1']) !!}</label> </div> 
        {!! Form::label('amount', 'Donation:', ['class' => 'col-md-1']) !!} 
        {!! Form::text('amount', $retreat->amount, ['class' => 'col-md-1']) !!} 
    </div>
    <div class="clearfix"> </div>
    -->
    
    <!-- 
    <div class="form-group">
        {!! Form::label('year', 'Year:', ['class' => 'col-md-1']) !!}
        {!! Form::text('year', $retreat->year, ['class' => 'col-md-1']) !!}
    </div>
    <div class="clearfix"> </div>
    -->
    
    <div class="form-group">
        {!! Form::image('img/save.png','btnSave',['class' => 'btn btn-primary']) !!}
    </div>
    {!! Form::close() !!}
</div>
@stop