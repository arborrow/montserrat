@extends('template')
@section('content')

<div class="jumbotron text-left">
    <h1>Edit Registration #{!! $registration->id !!}</h1>
    {!! Form::open(['method' => 'PUT', 'route' => ['registration.update', $registration->id]]) !!}
    {!! Form::hidden('id', $registration->id) !!}
            <div class="form-group">
     
                {!! Form::label('retreatant_id', 'Retreatant:', ['class' => 'col-md-2']) !!}
                {!! Form::select('retreatant_id', $retreatants, $registration->retreatant_id, ['class' => 'col-md-2']) !!}
                
                
            </div><div class="clearfix"> </div>
           <div class="form-group">

                {!! Form::label('retreat_id', 'Retreat:', ['class' => 'col-md-2']) !!}
                {!! Form::select('retreat_id', $retreats, $registration->retreat_id, ['class' => 'col-md-2']) !!}
                {!! Form::label('start', 'Retreat Dates: '.date('F d, Y', strtotime($registration->start)).' - '.date('F d, Y', strtotime($registration->end)), ['class' => 'col-md-6']) !!}
              
                
            </div><div class="clearfix"> </div>
            <div class="form-group">
                {!! Form::label('register', 'Registered:', ['class' => 'col-md-2']) !!}
                {!! Form::text('register', date('F d, Y', strtotime($registration->register)), ['class'=>'col-md-2','data-provide'=>'datepicker']) !!}
            </div><div class="clearfix"> </div>
            <div class="form-group">
                {!! Form::label('confirmregister', 'Registration Confirmed:', ['class' => 'col-md-2']) !!}
                @if ($registration->confirmregister == NULL)
                    {!! Form::text('confirmregister', NULL, ['class'=>'col-md-2','data-provide'=>'datepicker']) !!}
                @else
                    {!! Form::text('confirmregister', date('F d, Y', strtotime($registration->confirmregister)), ['class'=>'col-md-2','data-provide'=>'datepicker']) !!}
                @endif
                    
            </div><div class="clearfix"> </div>
            <div class="form-group">
                {!! Form::label('confirmattend', 'Attendance Confirmed:', ['class' => 'col-md-2']) !!}
                @if ($registration->confirmattend == NULL)
                    {!! Form::text('confirmattend', NULL, ['class'=>'col-md-2','data-provide'=>'datepicker']) !!}
                @else
                    {!! Form::text('confirmattend', date('F d, Y', strtotime($registration->confirmattend)), ['class'=>'col-md-2','data-provide'=>'datepicker']) !!}
                @endif
                
            </div><div class="clearfix"> </div>
            <div class="form-group">
                {!! Form::label('confirmedby', 'Confirmed by:', ['class' => 'col-md-2']) !!}
                {!! Form::text('confirmedby', $registration->confirmedby, ['class'=>'col-md-2']) !!}
            </div><div class="clearfix"> </div>
                        <div class="form-group">
                {!! Form::label('canceled_at', 'Canceled at:', ['class' => 'col-md-2']) !!}
                {!! Form::text('canceled_at', $registration->canceled_at, ['class'=>'col-md-2','data-provide'=>'datepicker']) !!}
            </div><div class="clearfix"> </div>
            <div class="form-group">
                {!! Form::label('arrived_at', 'Arrived at:', ['class' => 'col-md-2']) !!}
                {!! Form::text('arrived_at', $registration->arrived_at, ['class'=>'col-md-2','data-provide'=>'datepicker']) !!}
            </div><div class="clearfix"> </div>
            <div class="form-group">
                {!! Form::label('departed_at', 'Departed at:', ['class' => 'col-md-2']) !!}
                {!! Form::text('departed_at', $registration->departed_at, ['class'=>'col-md-2']) !!}
            </div><div class="clearfix"> </div>
            <div class="form-group">
                {!! Form::label('room_id', 'Room:', ['class' => 'col-md-2'])  !!}
                {!! Form::select('room_id', $rooms, $registration->room_id, ['class' => 'col-md-2']) !!} 
            </div><div class="clearfix"> </div>

            <div class="form-group">
                {!! Form::label('deposit', 'Deposit:', ['class' => 'col-md-2']) !!}
                {!! Form::text('deposit', $registration->deposit, ['class'=>'col-md-2']) !!}
            </div><div class="clearfix"> </div>
            
            <div class="form-group">
                {!! Form::label('notes', 'Notes:', ['class' => 'col-md-2']) !!}
                {!! Form::textarea('notes', $registration->notes, ['class'=>'col-md-5', 'rows'=>'3']) !!}
            </div><div class="clearfix"> </div>
     
    <div class="form-group">
        {!! Form::image('img/save.png','btnSave',['class' => 'btn btn-primary']) !!}
    </div>
    {!! Form::close() !!}
</div>
@stop