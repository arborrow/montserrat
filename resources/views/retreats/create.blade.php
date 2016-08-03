@extends('template')
@section('content')

    <section class="section-padding">
        <div class="jumbotron text-left">
            <h2><strong>Create Retreat</strong></h2>
            {!! Form::open(['url' => 'retreat', 'method' => 'post', 'class' => 'form-horizontal panel']) !!}
            <div class="form-group">
                {!! Form::label('idnumber', 'ID#: ', ['class' => 'col-md-1']) !!}
                {!! Form::text('idnumber', null, ['class' => 'col-md-1']) !!}
             
            </div><div class="clearfix"> </div>
            <div class="form-group">
                {!! Form::label('start_date', 'Starts: ', ['class' => 'col-md-1']) !!}
                {!! Form::text('start_date', null, ['id' => 'start_date', 'class' => 'col-md-2']) !!}
                <!-- {!! Form::input('date', 'start', date('Y-m-d'), ['class'=>'col-md-2']) !!} -->
                {!! Form::label('end_date', 'Ends: ', ['class' => 'col-md-1']) !!}
                {!! Form::text('end_date', null, ['id' => 'end_date', 'class' => 'col-md-2','data-provide'=>'datepicker']) !!}
                <!-- {!! Form::input('date', 'end', Carbon\Carbon::now()->addDays(3)->format('Y-m-d'), ['class'=>'col-md-2']) !!} -->
            </div><div class="clearfix"> </div>
            <div class="form-group">
                {!! Form::label('title', 'Title:', ['class' => 'col-md-1']) !!}
                {!! Form::text('title', null, ['class'=>'col-md-5']) !!}
<!--
                {!! Form::label('attending', 'Attending:', ['class' => 'col-md-1']) !!}
                {!! Form::text('attending', 0, ['class'=>'col-md-1']) !!}
-->
            </div><div class="clearfix"> </div>
            <div class="form-group">
                {!! Form::label('description', 'Description:', ['class' => 'col-md-1']) !!}
                {!! Form::textarea('description', null, ['class'=>'col-md-5', 'rows'=>'3']) !!}
            </div><div class="clearfix"> </div>
            <div class="form-group"> 
                {!! Form::label('directors', 'Director(s):', ['class' => 'col-md-1']) !!}
                {!! Form::select('directors[]', $d, 0, ['class' => 'form-control col-md-2','multiple' => 'multiple','style'=>'width: auto; font-size: inherit;']) !!}
            </div><div class="clearfix"> </div>
            <div class="form-group"> 
                {!! Form::label('innkeeper_id', 'Innkeeper:', ['class' => 'col-md-1']) !!}
                {!! Form::select('innkeeper_id', $i, 0, ['class' => 'col-md-2']) !!}
            </div><div class="clearfix"> </div>
            <div class="form-group"> 
                {!! Form::label('assistant_id', 'Assistant:', ['class' => 'col-md-1']) !!}
                {!! Form::select('assistant_id', $a, 0, ['class' => 'col-md-2']) !!}
            </div><div class="clearfix"> </div>
            <div class="form-group"> 
                {!! Form::label('captains', 'Captain(s):', ['class' => 'col-md-1']) !!}
                {!! Form::select('captains[]', $c, 0, ['class' => 'form-control col-md-2','multiple' => 'multiple','style'=>'width: auto; font-size: inherit;']) !!}
            </div><div class="clearfix"> </div>
            
            <div class="form-group">
                {!! Form::label('event_type', 'Type: ', ['class' => 'col-md-1']) !!}
                {!! Form::select('event_type', $event_types, EVENT_TYPE_WEEKEND, ['class' => 'col-md-2']) !!}
            </div><div class="clearfix"> </div>
    
<!--                
                {!! Form::select('type', [
                            'Unspecified' => 'Unspecified',
                            'Couples' => 'Couples',
                            'Men' => 'Men',
                            'Other' => 'Other',
                            'Open' => 'Open',
                            'Women' => 'Women',
                            ], 'Unspecified', ['class' => 'col-md-1','style' => 'width:auto;']) !!}
-->                        
<!--               <div class='left-checkbox'> {!! Form::label('silent', 'Silent:', ['class' => 'col-md-1']) !!}
                {!! Form::text('silent', 1, ['class'=>'col-md-1']) !!}</div>
                {!! Form::label('amount', 'Amount:', ['class' => 'col-md-1']) !!}
                {!! Form::text('amount', 390, ['class'=>'col-md-1']) !!}
            
            <div class="form-group">
                {!! Form::label('year', 'Year:', ['class' => 'col-md-1']) !!}
                {!! Form::text('year', date('Y'), ['class'=>'col-md-1']) !!}
            </div>
-->
            
            <div class="col-md-1"><div class="form-group">
                {!! Form::submit('Add Retreat', ['class'=>'btn btn-primary']) !!}
            </div></div>
                {!! Form::close() !!}
        </div>
    </section>

@stop