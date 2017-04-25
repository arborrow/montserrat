@extends('template')
@section('content')

<div class="jumbotron text-left">
    <h1>Edit Retreat {!! $retreat->idnumber !!}</h1>
    {!! Form::open(['method' => 'PUT', 'files'=>'true','route' => ['retreat.update', $retreat->id]]) !!}
    {!! Form::hidden('id', $retreat->id) !!}
    <div class="form-group">
        {!! Form::label('idnumber', 'ID#:', ['class' => 'col-md-2'])  !!}
        {!! Form::text('idnumber', $retreat->idnumber, ['class' => 'col-md-3']) !!}
    </div>
    <div class="clearfix"> </div>

    <div class="form-group">
        <span>
        {!! Form::label('start_date', 'Starts:', ['class' => 'col-md-2']) !!}
        {!! Form::text('start_date', date('F j, Y g:i A', strtotime($retreat->start_date)), ['id' => 'start_date', 'class' => 'col-md-3']) !!}
        </span>
    </div>
    <div class="form-group">
        <span>
        {!! Form::label('end_date', 'Ends:', ['class' => 'col-md-2']) !!}
        {!! Form::text('end_date', date('F j, Y g:i A', strtotime($retreat->end_date)), ['id' => 'end_date', 'class' => 'col-md-3']) !!}
        </span>
    </div>
    <div class="clearfix"> </div>

    <div class="form-group">
        {!! Form::label('title', 'Title:', ['class' => 'col-md-2']) !!}
        {!! Form::text('title', $retreat->title, ['class' => 'col-md-3']) !!}
<!--        {!! Form::label('attending', 'Attending:', ['class' => 'col-md-2']) !!}
        {!! Form::text('attending', $retreat->attending, ['class' => 'col-md-2']) !!} -->
    </div>
    <div class="clearfix"> </div>
    <div class="form-group">
        {!! Form::label('description', 'Description:', ['class' => 'col-md-2']) !!}
        {!! Form::textarea('description', $retreat->description, ['class' => 'col-md-3', 'rows'=>'3']) !!}
    </div>
    <div class="clearfix"> </div>
    <div class="form-group">    
        {!! Form::label('directors','Director(s):', ['class' => 'col-md-2'])  !!}
        {!! Form::select('directors[]', $d, 
            $retreat->retreatmasters->pluck('id')->toArray(),
            ['id'=>'directors','class' => 'col-md-3','multiple' => 'multiple','style'=>'font-size: inherit;']) !!}
    </div><div class="clearfix"> </div>
    
    <div class="form-group">
        {!! Form::label('innkeeper_id', 'Innkeeper:', ['class' => 'col-md-2']) !!}
        {!! Form::select('innkeeper_id', $i, $retreat->innkeeper_id, ['class' => 'col-md-3']) !!}
    </div><div class="clearfix"> </div>

    <div class="form-group">
        {!! Form::label('assistant_id', 'Assistant:', ['class' => 'col-md-2']) !!}
        {!! Form::select('assistant_id', $a, $retreat->assistant_id, ['class' => 'col-md-3']) !!}
    </div><div class="clearfix"> </div>
    
    <div class="form-group"> 
        {!! Form::label('captains', 'Captain(s):', ['class' => 'col-md-2']) !!}
        {!! Form::select('captains[]', $c,  
        $retreat->captains->pluck('id')->toArray(), 
        ['id'=>'captains','class' => 'col-md-3','multiple' => 'multiple','style'=>'font-size: inherit;']) !!}
    </div><div class="clearfix"> </div>
            
    <div class="form-group">
        {!! Form::label('event_type', 'Type: ', ['class' => 'col-md-2']) !!}
        {!! Form::select('event_type', $event_types, $retreat->event_type_id, ['class' => 'col-md-3']) !!}
    </div><div class="clearfix"> </div>
    <div class="form-group">
        {!! Form::label('is_active', 'Cancelled?:', ['class' => 'col-md-2'])  !!}
        {!! Form::select('is_active', $is_active, $retreat->is_active, ['class' => 'col-md-3']) !!}
    </div><div class="clearfix"> </div>
    <div class="form-group">
        {!! Form::label('contract', 'Contract (max 5M|pdf): ', ['class' => 'col-md-2'])  !!}
        {!! Form::file('contract',['class' => 'col-md-2']); !!}
    </div>
    <div class="clearfix"> </div>
    <div class="form-group">
        {!! Form::label('schedule', 'Schedule (max 5M|pdf): ', ['class' => 'col-md-2'])  !!}
        {!! Form::file('schedule',['class' => 'col-md-2']); !!}
    </div>
    <div class="clearfix"> </div>
    <div class="form-group">
        {!! Form::label('evaluations', 'Evaluations (max 10M|pdf): ', ['class' => 'col-md-2'])  !!}
        {!! Form::file('evaluations',['class' => 'col-md-2']); !!}
    </div>
    <div class="clearfix"> </div>
    <div class="form-group">
        {!! Form::label('group_photo', 'Group photo (max 10M): ', ['class' => 'col-md-2'])  !!}
        {!! Form::file('group_photo',['class' => 'col-md-2']); !!}
    </div>
    <div class="clearfix"> </div>
    
    <!--    
    <div class="form-group">
        {!! Form::label('type', 'Type:', ['class' => 'col-md-2']) !!}
        {!! Form::text('type', $retreat->type, ['class' => 'col-md-2']) !!}
        <div class='left-checkbox'>    {!! Form::label('silent', 'Silent:', ['class' => 'col-md-2']) !!}
        <label class="col-md-2" for="silent">Silent:  {!! Form::checkbox('silent', 1, $retreat->silent, ['class' => 'col-md-2']) !!}</label> </div> 
        {!! Form::label('amount', 'Donation:', ['class' => 'col-md-2']) !!} 
        {!! Form::text('amount', $retreat->amount, ['class' => 'col-md-2']) !!} 
    </div>
    <div class="clearfix"> </div>
    -->
    
    <!-- 
    <div class="form-group">
        {!! Form::label('year', 'Year:', ['class' => 'col-md-2']) !!}
        {!! Form::text('year', $retreat->year, ['class' => 'col-md-2']) !!}
    </div>
    <div class="clearfix"> </div>
    -->
    
    <div class="form-group">
        {!! Form::image('img/save.png','btnSave',['class' => 'btn btn-primary']) !!}
    </div>
    {!! Form::close() !!}
</div>
@stop