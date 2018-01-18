@extends('template')
@section('content')

    <section class="section-padding">
        <div class="jumbotron text-left">
            <h2><strong>Create Retreat</strong></h2>
            {!! Form::open(['url' => 'retreat', 'method' => 'post', 'class' => 'form-horizontal panel']) !!}
            <div class="form-group">
                {!! Form::label('idnumber', 'ID#: ', ['class' => 'col-md-2']) !!}
                {!! Form::text('idnumber', null, ['class' => 'col-md-3']) !!}
             
            </div><div class="clearfix"> </div>
            
            <div class="form-group">
                {!! Form::label('start_date', 'Starts: ', ['class' => 'col-md-2']) !!}
                {!! Form::text('start_date', null, ['id' => 'start_date', 'class' => 'col-md-3']) !!}
                <!-- {!! Form::input('date', 'start', date('Y-m-d'), ['class'=>'col-md-2']) !!} -->
            
            </div>
            <div class='form-group'>
                {!! Form::label('end_date', 'Ends: ', ['class' => 'col-md-2']) !!}
                {!! Form::text('end_date', null, ['id' => 'end_date', 'class' => 'col-md-3']) !!}
            </div><div class="clearfix"> </div>
            <div class="form-group">
                {!! Form::label('title', 'Title:', ['class' => 'col-md-2']) !!}
                {!! Form::text('title', null, ['class'=>'col-md-3']) !!}
            </div><div class="clearfix"> </div>
            <div class="form-group">
                {!! Form::label('description', 'Description:', ['class' => 'col-md-2']) !!}
                {!! Form::textarea('description', null, ['class'=>'col-md-3', 'rows'=>'3']) !!}
            </div><div class="clearfix"> </div>
            <div class="form-group"> 
                {!! Form::label('directors', 'Director(s):', ['class' => 'col-md-2']) !!}
                {!! Form::select('directors[]', $d, 0, ['id'=>'directors','class' => 'col-md-3','multiple' => 'multiple','style'=>'font-size: inherit;']) !!}
            </div><div class="clearfix"> </div>
            <div class="form-group"> 
                {!! Form::label('innkeeper_id', 'Innkeeper:', ['class' => 'col-md-2']) !!}
                {!! Form::select('innkeeper_id', $i, 0, ['class' => 'col-md-3']) !!}
            </div><div class="clearfix"> </div>
            <div class="form-group"> 
                {!! Form::label('assistant_id', 'Assistant:', ['class' => 'col-md-2']) !!}
                {!! Form::select('assistant_id', $a, 0, ['class' => 'col-md-3']) !!}
            </div><div class="clearfix"> </div>
            <div class="form-group"> 
                {!! Form::label('captains', 'Captain(s):', ['class' => 'col-md-2']) !!}
                {!! Form::select('captains[]', $c, 0, ['id'=>'captains','class' => 'col-md-3','multiple' => 'multiple','style'=>'font-size: inherit;']) !!}
            </div><div class="clearfix"> </div>
            
            <div class="form-group">
                {!! Form::label('event_type', 'Type: ', ['class' => 'col-md-2']) !!}
                {!! Form::select('event_type', $event_types, config('polanco.event_type.ignatian'), ['class' => 'col-md-3']) !!}
            </div><div class="clearfix"> </div>
            <!-- # it doesn't make much sense to have this when creating it
            <div class="form-group">
                    {!! Form::label('is_active', 'Cancelled?:', ['class' => 'col-md-2'])  !!}
                    {!! Form::checkbox('is_active', 1, false, ['class' => 'col-md-1']) !!}
            </div><div class="clearfix"> </div>
            -->
<!--                
                {!! Form::select('type', [
                            'Unspecified' => 'Unspecified',
                            'Couples' => 'Couples',
                            'Men' => 'Men',
                            'Other' => 'Other',
                            'Open' => 'Open',
                            'Women' => 'Women',
                            ], 'Unspecified', ['class' => 'col-md-2','style' => 'width:auto;']) !!}
-->                        
<!--               <div class='left-checkbox'> {!! Form::label('silent', 'Silent:', ['class' => 'col-md-2']) !!}
                {!! Form::text('silent', 1, ['class'=>'col-md-2']) !!}</div>
                {!! Form::label('amount', 'Amount:', ['class' => 'col-md-2']) !!}
                {!! Form::text('amount', 390, ['class'=>'col-md-2']) !!}
            
            <div class="form-group">
                {!! Form::label('year', 'Year:', ['class' => 'col-md-2']) !!}
                {!! Form::text('year', date('Y'), ['class'=>'col-md-2']) !!}
            </div>
-->
            
            <div class="col-md-2"><div class="form-group">
                {!! Form::submit('Add Retreat', ['class'=>'btn btn-primary']) !!}
            </div></div><div class="clearfix"> </div>
                {!! Form::close() !!}
        </div>
    </section>

@stop