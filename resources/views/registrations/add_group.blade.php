@extends('template')
@section('content')

    <section class="section-padding">
        <div class="jumbotron text-left">
            <h2><strong>Add A Registration</strong></h2>
        

            {!! Form::open(['url' => 'registration/add_group', 'method' => 'post', 'class' => 'form-horizontal panel']) !!}
           <div class="form-group">

                {!! Form::label('event_id', 'Retreat:', ['class' => 'col-md-2']) !!}
                {!! Form::select('event_id', $retreats, $defaults['retreat_id'], ['class' => 'col-md-2']) !!}
                
            </div><div class="clearfix"> </div>
           <div class="form-group">

                {!! Form::label('group_id', 'Group:', ['class' => 'col-md-2']) !!}
                {!! Form::select('group_id', $groups, $defaults['group_id'], ['class' => 'col-md-2']) !!}
                
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
                {!! Form::label('deposit', 'Deposit:', ['class' => 'col-md-2']) !!}
                {!! Form::text('deposit', '0.00', ['class'=>'col-md-2']) !!}
            </div><div class="clearfix"> </div>
            
            <div class="form-group">
                {!! Form::label('notes', 'Notes:', ['class' => 'col-md-2']) !!}
                {!! Form::textarea('notes', null, ['class'=>'col-md-5', 'rows'=>'3']) !!}
            </div><div class="clearfix"> </div>
            <div class="col-md-1"><div class="form-group">
                {!! Form::submit('Add Group Registration', ['class'=>'btn btn-primary']) !!}
            </div></div>
                {!! Form::close() !!}
        </div>
    </section>
@stop