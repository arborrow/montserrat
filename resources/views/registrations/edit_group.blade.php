@extends('template')
@section('content')

<div class="jumbotron text-left">
    <h1>Edit Registration #{!! $registration->id !!} for {!!$registration->retreatant->contact_link!!}</h1>
    {!! Form::open(['url' => 'registration/'.$registration->id.'/update_group','method' => 'POST', 'route' => ['registration.update_group', $registration->id]]) !!}
    {!! Form::hidden('id', $registration->id) !!}
        <div class="form-group">
                {!! Form::label('contact_id', 'Retreatant:', ['class' => 'col-md-2']) !!}
                {!! Form::select('contact_id', $retreatants, $registration->contact_id, ['class' => 'col-md-2']) !!}
        </div>
        <div class="clearfix"> </div>
    
           <div class="form-group">

                {!! Form::label('event_id', 'Retreat:', ['class' => 'col-md-2']) !!}
                {!! Form::select('event_id', $retreats, $registration->event_id, ['class' => 'col-md-3']) !!}
                {!! Form::label('start', 'Retreat Dates: '.date('M j, Y', strtotime($registration->retreat->start_date)).' - '.date('M j, Y', strtotime($registration->retreat->end_date)), ['class' => 'col-md-6']) !!}
              
                
            </div><div class="clearfix"> </div>
            <div class="form-group">
                {!! Form::label('register_date', 'Registered:', ['class' => 'col-md-2']) !!}
                {!! Form::text('register_date', $registration->register_date, ['class'=>'col-md-3','data-provide'=>'datepicker']) !!}
            </div><div class="clearfix"> </div>

   	    <div class="form-group">
                {!! Form::label('source', 'Registration from:', ['class' => 'col-md-2']) !!}
		{!! Form::select('source', $defaults['registration_source'], 'N/A', ['class' => 'col-md-3']) !!}
            </div><div class="clearfix"> </div>

	    <div class="form-group">
                {!! Form::label('registration_confirm_date', 'Registration Confirmed:', ['class' => 'col-md-2']) !!}
                @if ($registration->registration_confirm_date == NULL)
                    {!! Form::text('registration_confirm_date', NULL, ['class'=>'col-md-3','data-provide'=>'datepicker']) !!}
                @else
                    {!! Form::text('registration_confirm_date', $registration->registration_confirm_date, ['class'=>'col-md-3','data-provide'=>'datepicker']) !!}
                @endif
                    
            </div><div class="clearfix"> </div>
            </div><div class="clearfix"> </div>
            <div class="form-group">
                {!! Form::label('confirmed_by', 'Confirmed by:', ['class' => 'col-md-2']) !!}
                {!! Form::text('confirmed_by', $registration->confirmed_by, ['class'=>'col-md-3']) !!}
            </div><div class="clearfix"> </div>
                        <div class="form-group">
                {!! Form::label('canceled_at', 'Canceled at:', ['class' => 'col-md-2']) !!}
                {!! Form::text('canceled_at', $registration->canceled_at, ['class'=>'col-md-3','data-provide'=>'datepicker']) !!}
            </div><div class="clearfix"> </div>
            <div class="form-group">
                {!! Form::label('arrived_at', 'Arrived at:', ['class' => 'col-md-2']) !!}
                {!! Form::text('arrived_at', $registration->arrived_at, ['class'=>'col-md-3','data-provide'=>'datepicker']) !!}
            </div><div class="clearfix"> </div>
            <div class="form-group">
                {!! Form::label('departed_at', 'Departed at:', ['class' => 'col-md-2']) !!}
                {!! Form::text('departed_at', $registration->departed_at, ['class'=>'col-md-3']) !!}
            </div><div class="clearfix"> </div>
            <div class="form-group">
                {!! Form::label('room_id', 'Room:', ['class' => 'col-md-2'])  !!}
                {!! Form::select('room_id', $rooms, $registration->room_id, ['class' => 'col-md-3']) !!} 
            </div><div class="clearfix"> </div>

            <div class="form-group">
                {!! Form::label('deposit', 'Deposit:', ['class' => 'col-md-2']) !!}
                {!! Form::text('deposit', $registration->deposit, ['class'=>'col-md-3']) !!}
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
