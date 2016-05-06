@extends('template')
@section('content')

    <section class="section-padding">
        <div class="jumbotron text-left">
            <h2><strong>Add A Registration</strong></h2>
        <?= Form::open() ?>
        <?= Form::label('auto', 'Find a retreatant: ') ?>
        <?= Form::text('auto', '', array('id' => 'auto'))?>
        
        <?= Form::label('response', 'Retreatant id: ') ?>
        <?= Form::text('response', '', array('id' =>'response', 'disabled' => 'disabled')) ?>
        <?= Form::close() ?>


            {!! Form::open(['url' => 'registration', 'method' => 'post', 'class' => 'form-horizontal panel']) !!}
           <div class="form-group">

                {!! Form::label('retreat_id', 'Retreat:', ['class' => 'col-md-2']) !!}
                {!! Form::select('retreat_id', $retreats, 0, ['class' => 'col-md-2']) !!}
                
            </div><div class="clearfix"> </div>
           <div class="form-group">

                {!! Form::label('retreatant_id', 'Retreatant:', ['class' => 'col-md-2']) !!}
                @if (isset($defaults['retreatant_id']))
                    {!! Form::select('retreatant_id', $retreatants, $defaults['retreatant_id'], ['class' => 'col-md-2']) !!}
                @else
                    {!! Form::select('retreatant_id', $retreatants, 0, ['class' => 'col-md-2']) !!}
                @endif
                
                
                
                
            </div><div class="clearfix"> </div>
            <div class="form-group">
                {!! Form::label('register', 'Registered:', ['class' => 'col-md-2']) !!}
                {!! Form::text('register', null, ['class'=>'col-md-2','data-provide'=>'datepicker']) !!}
            </div><div class="clearfix"> </div>
            <div class="form-group">
                {!! Form::label('confirmregister', 'Registration Confirmed:', ['class' => 'col-md-2']) !!}
                {!! Form::text('confirmregister', null, ['class'=>'col-md-2','data-provide'=>'datepicker']) !!}
            </div><div class="clearfix"> </div>
            <div class="form-group">
                {!! Form::label('confirmattend', 'Attendance Confirmed:', ['class' => 'col-md-2']) !!}
                {!! Form::text('confirmattend', null, ['class'=>'col-md-2','data-provide'=>'datepicker']) !!}
            </div><div class="clearfix"> </div>
            <div class="form-group">
                {!! Form::label('confirmattend', 'Attendance Confirmed:', ['class' => 'col-md-2']) !!}
                {!! Form::text('confirmattend', null, ['class'=>'col-md-2','data-provide'=>'datepicker']) !!}
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
                {!! Form::label('room_id', 'Room:', ['class' => 'col-md-2'])  !!}
                {!! Form::select('room_id', $rooms, 0, ['class' => 'col-md-2']) !!} 
            </div>
                    
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