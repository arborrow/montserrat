@extends('template')
@section('content')

    <section class="section-padding">
        <div class="jumbotron text-left">
            <h2><strong>Add A Registration</strong></h2>
        

            {!! Form::open(['url' => 'registration', 'method' => 'post', 'class' => 'form-horizontal panel']) !!}
           <div class="form-group">

                {!! Form::label('event_id', 'Retreat:', ['class' => 'col-md-2']) !!}
                {!! Form::select('event_id', $retreats, $defaults['retreat_id'], ['class' => 'col-md-2']) !!}
                
            </div><div class="clearfix"> </div>
           <div class="form-group">

                {!! Form::label('contact_id', 'Retreatant:', ['class' => 'col-md-2']) !!}
                @if (isset($defaults['contact_id']))
                    {!! Form::select('contact_id', $retreatants, $defaults['contact_id'], ['class' => 'col-md-2']) !!}
                @else
                    {!! Form::select('contact_id', $retreatants, 0, ['class' => 'col-md-2']) !!}
                @endif
                
                
                
                
            </div><div class="clearfix"> </div>
            <div class="form-group">
                {!! Form::label('register_date', 'Registered:', ['class' => 'col-md-2']) !!}
                {!! Form::text('register_date', $defaults['today'], ['class'=>'col-md-2','data-provide'=>'datepicker']) !!}
            </div><div class="clearfix"> </div>
            <div class="form-group">
                {!! Form::label('registration_confirm_date', 'Registration Confirmed:', ['class' => 'col-md-2']) !!}
                {!! Form::text('registration_confirm_date', null, ['class'=>'col-md-2','data-provide'=>'datepicker']) !!}
            </div><div class="clearfix"> </div>
            <div class="form-group">
                {!! Form::label('confirmed_by', 'Confirmed By:', ['class' => 'col-md-2']) !!}
                {!! Form::text('confirmed_by', null, ['class'=>'col-md-2']) !!}
            </div><div class="clearfix"> </div>
            <div class="form-group">
                {!! Form::label('canceled_at', 'Canceled at:', ['class' => 'col-md-2']) !!}
                {!! Form::text('canceled_at', null, ['class'=>'col-md-2','data-provide'=>'datepicker']) !!}
            </div><div class="clearfix"> </div>
            <div class="form-group">
                {!! Form::label('arrived_at', 'Arrived at:', ['class' => 'col-md-2']) !!}
                {!! Form::text('arrived_at', null, ['class'=>'col-md-2','data-provide'=>'datepicker']) !!}
            </div><div class="clearfix"> </div>
            <div class="form-group">
                {!! Form::label('departed_at', 'Departed at:', ['class' => 'col-md-2']) !!}
                {!! Form::text('departed_at', null, ['class'=>'col-md-2']) !!}
            </div><div class="clearfix"> </div>
             <div class="form-group"> 
                {!! Form::label('rooms', 'Room(s):', ['class' => 'col-md-2']) !!}
                {!! Form::select('rooms[]', $rooms, 0, ['class' => 'col-md-2','multiple' => 'multiple','style'=>'font-size: inherit;']) !!}
            </div><div class="clearfix"> </div>
            
            @if ($defaults['is_multi_registration'])
            <div class="form-group">
                {!! Form::label('num_registrants', 'Number of participants:', ['class' => 'col-md-2']) !!}
                {!! Form::selectRange('num_registrants', 0, 99, NULL, ['class'=>'col-md-2']) !!}
            </div><div class="clearfix"> </div>
                
            @endIf
                    
            <div class="form-group">
                {!! Form::label('deposit', 'Deposit:', ['class' => 'col-md-2']) !!}
                {!! Form::text('deposit', '50.00', ['class'=>'col-md-2']) !!}
            </div><div class="clearfix"> </div>
            
            <div class="form-group">
                {!! Form::label('notes', 'Notes:', ['class' => 'col-md-2']) !!}
                {!! Form::textarea('notes', null, ['class'=>'col-md-5', 'rows'=>'3']) !!}
            </div><div class="clearfix"> </div>
            <div class="col-md-1"><div class="form-group">
                {!! Form::submit('Add Registration', ['class'=>'btn btn-primary']) !!}
            </div></div>
                {!! Form::close() !!}
        </div>
    </section>
@stop