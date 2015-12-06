@extends('template')
@section('content')

    <section class="section-padding">
        <div class="jumbotron text-left">
            <h2><strong>Add A Registration</strong></h2>
            {!! Form::open(['url' => 'registration', 'method' => 'post', 'class' => 'form-horizontal panel']) !!}
           <div class="form-group">

                {!! Form::label('retreat_id', 'Retreat:', ['class' => 'col-md-1']) !!}
                {!! Form::select('retreat_id', $retreats, 0, ['class' => 'col-md-2']) !!}
                
            </div><div class="clearfix"> </div>
           <div class="form-group">

                {!! Form::label('retreatant_id', 'Retreatant:', ['class' => 'col-md-1']) !!}
                {!! Form::select('retreatant_id', $retreatants, 0, ['class' => 'col-md-2']) !!}
                
            </div><div class="clearfix"> </div>
            <div class="form-group">
                {!! Form::label('register', 'Date Registered:', ['class' => 'col-md-1']) !!}
                {!! Form::text('register', null, ['class'=>'col-md-2','data-provide'=>'datepicker']) !!}
            </div><div class="clearfix"> </div>
            <div class="form-group">
                {!! Form::label('confirmregister', 'Date Confirmation Sent:', ['class' => 'col-md-1']) !!}
                {!! Form::text('confirmregister', null, ['class'=>'col-md-2','data-provide'=>'datepicker']) !!}
            </div><div class="clearfix"> </div>
            <div class="form-group">
                {!! Form::label('confirmattend', 'Date Registration Confirmed:', ['class' => 'col-md-1']) !!}
                {!! Form::text('confirmattend', null, ['class'=>'col-md-2','data-provide'=>'datepicker']) !!}
            </div><div class="clearfix"> </div>
            <div class="form-group">
                {!! Form::label('confirmedby', 'Confirmed by:', ['class' => 'col-md-1']) !!}
                {!! Form::text('confirmedby', null, ['class'=>'col-md-2']) !!}
            </div><div class="clearfix"> </div>
            <div class="form-group">
                {!! Form::label('deposit', 'Deposit:', ['class' => 'col-md-1']) !!}
                {!! Form::text('deposit', '50.00', ['class'=>'col-md-2']) !!}
            </div><div class="clearfix"> </div>
            
            <div class="form-group">
                {!! Form::label('notes', 'Notes:', ['class' => 'col-md-1']) !!}
                {!! Form::textarea('notes', null, ['class'=>'col-md-5', 'rows'=>'3']) !!}
            </div><div class="clearfix"> </div>
            <div class="col-md-1"><div class="form-group">
                {!! Form::submit('Add Registration', ['class'=>'btn btn-primary']) !!}
            </div></div>
                {!! Form::close() !!}
        </div>
    </section>

@stop